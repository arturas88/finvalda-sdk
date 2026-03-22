<?php

declare(strict_types=1);

namespace Finvalda;

use Finvalda\Enums\AccessResult;
use Finvalda\Exceptions\AccessDeniedException;
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

final class HttpClient
{
    private ClientInterface $client;

    /**
     * @param FinvaldaConfig $config SDK configuration
     * @param ClientInterface|null $client Optional Guzzle client instance (for testing or custom configuration)
     */
    public function __construct(
        private readonly FinvaldaConfig $config,
        ?ClientInterface $client = null,
    ) {
        $this->client = $client ?? new Client([
            'base_uri' => rtrim($this->config->baseUrl, '/') . '/',
            'timeout' => $this->config->timeout,
            'headers' => $this->buildHeaders(),
        ]);
    }

    public function get(string $endpoint, array $params = []): Response
    {
        return $this->request('GET', $endpoint, ['query' => $this->cleanParams($params)]);
    }

    public function post(string $endpoint, array $params = [], ?string $body = null): Response
    {
        $options = ['query' => $this->cleanParams($params)];

        if ($body !== null) {
            $options['body'] = $body;
        }

        return $this->request('POST', $endpoint, $options);
    }

    public function postJson(string $endpoint, array $data): Response
    {
        return $this->request('POST', $endpoint, [
            'json' => $data,
        ]);
    }

    public function postOperation(string $endpoint, array $params = [], ?string $body = null): OperationResult
    {
        try {
            $response = $this->sendRequest('POST', $endpoint, [
                'query' => $this->cleanParams($params),
                'body' => $body ?? '',
            ]);

            return $this->parseOperationResult($response);
        } catch (GuzzleException $e) {
            throw new FinvaldaException('HTTP request failed: ' . $e->getMessage(), 0, $e);
        }
    }

    public function getRaw(string $endpoint, array $params = []): string
    {
        try {
            return $this->sendRequest('GET', $endpoint, [
                'query' => $this->cleanParams($params),
            ]);
        } catch (GuzzleException $e) {
            throw new FinvaldaException('HTTP request failed: ' . $e->getMessage(), 0, $e);
        }
    }

    private function request(string $method, string $endpoint, array $options): Response
    {
        try {
            $body = $this->sendRequest($method, $endpoint, $options);

            return $this->parseResponse($body);
        } catch (GuzzleException $e) {
            throw new FinvaldaException('HTTP request failed: ' . $e->getMessage(), 0, $e);
        }
    }

    private function sendRequest(string $method, string $endpoint, array $options): string
    {
        $response = $this->client->request($method, $endpoint, $options);

        return (string) $response->getBody();
    }

    private function parseResponse(string $body): Response
    {
        $decoded = json_decode($body, true);

        if (! is_array($decoded)) {
            throw new FinvaldaException('Invalid JSON response: ' . json_last_error_msg());
        }

        $accessResult = AccessResult::tryFrom($decoded['AccessResult'] ?? '') ?? AccessResult::Fail;
        $error = $decoded['error'] ?? $decoded['sError'] ?? null;

        if ($accessResult === AccessResult::AccessDenied) {
            throw new AccessDeniedException($error ?? 'Access denied');
        }

        $data = $decoded;
        unset($data['AccessResult'], $data['error'], $data['sError']);

        // Extract items from common response shapes
        $items = $data['items'] ?? $data['Table'] ?? $data;

        return new Response(
            accessResult: $accessResult,
            data: is_array($items) ? $items : [],
            error: $error,
            raw: $decoded,
        );
    }

    private function parseOperationResult(string $body): OperationResult
    {
        $decoded = json_decode($body, true);

        if (! is_array($decoded)) {
            throw new FinvaldaException('Invalid JSON response: ' . json_last_error_msg());
        }

        $accessResult = AccessResult::tryFrom($decoded['AccessResult'] ?? '') ?? AccessResult::Fail;

        if ($accessResult === AccessResult::AccessDenied) {
            throw new AccessDeniedException('Access denied');
        }

        $resultCode = $decoded['nResult'] ?? $decoded['result'] ?? -1;
        $errorMessage = $decoded['sError'] ?? $decoded['error'] ?? null;

        if ((int) $resultCode !== 0) {
            return new OperationResult(
                success: false,
                error: $errorMessage,
                errorCode: (int) $resultCode,
            );
        }

        // Parse operation details from sError XML on success
        $series = null;
        $document = null;
        $journal = null;
        $number = null;

        if ($errorMessage && str_contains($errorMessage, '<OP_DUOMENYS>')) {
            $xml = @simplexml_load_string($errorMessage);
            if ($xml !== false) {
                $series = (string) ($xml->SERIJA ?? '');
                $document = (string) ($xml->DOKUMENTAS ?? '');
                $journal = (string) ($xml->ZURNALAS ?? '');
                $number = isset($xml->NUMERIS) ? (int) (string) $xml->NUMERIS : null;
            }
        }

        return new OperationResult(
            success: true,
            series: $series,
            document: $document,
            journal: $journal,
            number: $number,
        );
    }

    private function buildHeaders(): array
    {
        $headers = [
            'UserName' => $this->config->username,
            'Password' => $this->config->password,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Language' => (string) $this->config->language->value,
        ];

        if ($this->config->connString !== null) {
            $headers['ConnString'] = $this->config->connString;
        }

        if ($this->config->companyId !== null) {
            $headers['CompanyID'] = $this->config->companyId;
        }

        if ($this->config->removeEmptyStringTags) {
            $headers['RemoveEmptyStringTags'] = 'true';
        }

        if ($this->config->removeZeroNumberTags) {
            $headers['RemoveZeroNumberTags'] = 'true';
        }

        if ($this->config->removeNewLines) {
            $headers['RemoveNewLines'] = 'true';
        }

        return $headers;
    }

    /**
     * Remove null values from parameters. Empty strings are preserved
     * as the API may distinguish between "no value" and "empty string".
     */
    private function cleanParams(array $params): array
    {
        return array_filter($params, fn ($value) => $value !== null);
    }
}
