<?php

declare(strict_types=1);

namespace Finvalda;

use Finvalda\Debug\Diagnostics;
use Finvalda\Enums\AccessResult;
use Finvalda\Enums\CredentialMode;
use Finvalda\Exceptions\AccessDeniedException;
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Exceptions\HttpException;
use Finvalda\Exceptions\NetworkException;
use Finvalda\Exceptions\ServerException;
use Finvalda\Recording\Exchange;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;
use Finvalda\Retry\RetryHandler;
use Finvalda\Support\BodyTruncator;
use Finvalda\Support\FilePayloadElider;
use Finvalda\Support\OutboundNumericNormalizer;
use Finvalda\Support\Redactor;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\UriResolver;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;

final class HttpClient
{
    /**
     * Maximum number of bytes of a request/response body kept in a recorded
     * Exchange. Recording is bounded by exchange count as well, but a `Reports`
     * endpoint answers with a PDF, and the Laravel binding is long-lived — so
     * without a per-body cap a worker would retain `record_limit` whole bodies.
     */
    private const MAX_RECORDED_BODY_BYTES = BodyTruncator::MAX_BYTES;

    /**
     * How much of an undecodable response body an exception message quotes.
     */
    private const ERROR_SNIPPET_BYTES = 200;

    private ClientInterface $client;

    private OutboundNumericNormalizer $normalizer;

    private Diagnostics $diagnostics;

    /**
     * @param FinvaldaConfig $config SDK configuration
     * @param ClientInterface|null $client Optional Guzzle client instance (for testing or custom middleware).
     *                                     Requests go to absolute URLs built from the config's base URL, with
     *                                     the config's timeout and http options, so an injected client needs
     *                                     no base_uri of its own.
     */
    public function __construct(
        private readonly FinvaldaConfig $config,
        ?ClientInterface $client = null,
    ) {
        $this->client = $client ?? new Client();
        $this->diagnostics = new Diagnostics($this->config->logger);
        $this->normalizer = new OutboundNumericNormalizer(
            enabled: $this->config->normalizeFloats,
            precision: $this->config->floatPrecision,
        );

        if ($this->config->record) {
            $this->diagnostics->startRecording(
                $this->config->recordLimit,
                $this->config->recordCredentials,
            );
        }
    }

    /**
     * A retry handler bound to the diagnostics logger as it stands right now.
     * Built fresh per retried request rather than cached, so it always reflects
     * the current logger — shared, via Diagnostics, with every sibling created
     * through withCompanyId().
     */
    private function retryHandler(): ?RetryHandler
    {
        return $this->config->retry !== null
            ? new RetryHandler($this->config->retry, $this->diagnostics->logger())
            : null;
    }

    /**
     * The configuration this transport was built from.
     */
    public function getConfig(): FinvaldaConfig
    {
        return $this->config;
    }

    /**
     * A transport bound to another company — or, with null, to Finvalda's
     * default company, which omits the CompanyID header.
     *
     * Shares this transport's Guzzle client and diagnostics (logger and
     * recorder), so a company-scoped call still shows up in this client's
     * recordings(), and switching logging or recording on or off later reaches
     * both. Safe with a caller-supplied client: since headers are built per
     * request, company identity does not live in the transport.
     */
    public function withCompanyId(?string $companyId): self
    {
        $copy = new self($this->config->withCompanyId($companyId), $this->client);
        $copy->diagnostics = $this->diagnostics;

        return $copy;
    }

    /**
     * Set the logger instance for request/response logging.
     */
    public function setLogger(?LoggerInterface $logger): void
    {
        $this->diagnostics->setLogger($logger);
    }

    /**
     * Start recording request/response exchanges in memory. Replaces any
     * exchanges recorded so far.
     *
     * @param  int  $limit  Maximum exchanges kept; the oldest are dropped first
     * @param  CredentialMode  $credentials  How credential values appear in recordings
     */
    public function record(int $limit = 20, CredentialMode $credentials = CredentialMode::Masked): void
    {
        $this->diagnostics->startRecording($limit, $credentials);
    }

    /**
     * Stop recording and drop the recorded exchanges.
     */
    public function stopRecording(): void
    {
        $this->diagnostics->stopRecording();
    }

    /**
     * Recorded exchanges, oldest first. Empty when recording is off.
     *
     * @return list<Exchange>
     */
    public function recordings(): array
    {
        return $this->diagnostics->recorder()?->all() ?? [];
    }

    public function lastRecording(): ?Exchange
    {
        return $this->diagnostics->recorder()?->last();
    }

    /**
     * A read. Retried under the configured RetryPolicy.
     */
    public function get(string $endpoint, array $params = []): Response
    {
        return $this->send('GET', $endpoint, ['query' => $this->cleanParams($params)], true, $this->parseResponse(...));
    }

    /**
     * A read sent as POST with query params. Retried under the configured
     * RetryPolicy — never route a write through here.
     */
    public function post(string $endpoint, array $params = [], ?string $body = null): Response
    {
        $options = ['query' => $this->cleanParams($params)];

        if ($body !== null) {
            $options['body'] = $body;
        }

        return $this->send('POST', $endpoint, $options, true, $this->parseResponse(...));
    }

    /**
     * A read with a JSON body (GetDescriptions, GetOperations…). Retried under
     * the configured RetryPolicy — never route a write through here.
     */
    public function postJson(string $endpoint, array $data): Response
    {
        return $this->send('POST', $endpoint, ['json' => $data], true, $this->parseResponse(...));
    }

    /**
     * A write with a flat JSON body. Never retried: a timeout after the request
     * went out may mean the server already committed it.
     */
    public function postOperationJson(string $endpoint, array $data): OperationResult
    {
        return $this->send('POST', $endpoint, ['json' => $data], false, $this->parseOperationResult(...));
    }

    /**
     * A write with the `{ItemClassName, xmlstring}` envelope. Never retried: a
     * timeout after the request went out may mean the server already committed it.
     */
    public function postOperation(string $endpoint, array $params = [], ?string $body = null): OperationResult
    {
        $data = $this->cleanParams($params);

        if ($body !== null) {
            $data['xmlstring'] = $body;
        }

        return $this->send('POST', $endpoint, ['json' => $data], false, $this->parseOperationResult(...));
    }

    /**
     * Encode SDK-owned outbound data using the configured numeric normalization.
     *
     * @throws \JsonException
     */
    public function encodeJson(mixed $data): string
    {
        return $this->withShortestFloatEncoding(
            fn (): string => json_encode($this->normalizer->normalize($data), JSON_THROW_ON_ERROR),
        );
    }

    /**
     * Run an encoding step with serialize_precision forced to -1 so floats
     * serialize as their shortest round-trippable form (e.g. 21.49, not
     * 21.489999999999998...) regardless of the host's php.ini. Rounding alone
     * does not suffice: a host that sets serialize_precision high expands every
     * non-terminating binary fraction back into its full decimal.
     *
     * @template TReturn
     *
     * @param  callable(): TReturn  $encode
     * @return TReturn
     */
    private function withShortestFloatEncoding(callable $encode): mixed
    {
        $previous = ini_get('serialize_precision');
        ini_set('serialize_precision', '-1');

        try {
            return $encode();
        } finally {
            ini_set('serialize_precision', $previous);
        }
    }

    /**
     * Send one call — retried when $retryable and a policy is configured — and
     * parse its body. Every failure leaves as an SDK exception with credential
     * values scrubbed from its message.
     *
     * @template T
     *
     * @param  array<string, mixed>  $options
     * @param  callable(array<array-key, mixed>): T  $parse
     * @return T
     *
     * @throws FinvaldaException
     */
    private function send(string $method, string $endpoint, array $options, bool $retryable, callable $parse): mixed
    {
        if (isset($options['json'])) {
            $options['json'] = $this->normalizer->normalize($options['json']);
        }

        $options = array_merge($this->config->httpOptions, ['timeout' => $this->config->timeout], $options);

        // Auth headers travel with every request rather than sitting in the
        // Guzzle client's defaults: a caller-supplied ClientInterface would
        // otherwise send none, and the recordings below would report headers
        // that never went out. They win over any headers in http_options.
        $options['headers'] = array_merge($options['headers'] ?? [], $this->buildHeaders());

        $uri = $this->uri($endpoint);
        $requestId = bin2hex(random_bytes(8));

        // Credential values that can surface in an exception message: Guzzle
        // embeds the request URI (so a query sPassword) in its messages. Headers
        // never appear there, and scrubbing the connection password by value
        // would mangle every message that happens to contain its characters.
        $secrets = Redactor::secrets([$options['query'] ?? [], $options['json'] ?? []]);
        $attempt = 0;

        $doRequest = function () use ($method, $endpoint, $uri, $options, $requestId, $secrets, &$attempt): array {
            $attempt++;
            $startTime = microtime(true);

            $this->logRequest($method, $endpoint, $options, $requestId);

            try {
                $response = $this->client->request($method, $uri, $options);
            } catch (GuzzleException $e) {
                $this->recordFailure($method, $uri, $options, $e, microtime(true) - $startTime, $attempt, $requestId);

                throw $this->wrapGuzzleException($e, $secrets);
            }

            $body = (string) $response->getBody();
            $duration = microtime(true) - $startTime;

            $this->logResponse($method, $endpoint, $response->getStatusCode(), $duration, $body, $requestId);

            $this->diagnostics->recorder()?->record(new Exchange(
                method: $method,
                url: $this->recordedUrl($uri, $options),
                headers: $options['headers'],
                body: $this->truncateForRecording($this->recordedBody($options)),
                statusCode: $response->getStatusCode(),
                reasonPhrase: $response->getReasonPhrase(),
                responseHeaders: $response->getHeaders(),
                responseBody: $this->truncateForRecording($body),
                durationMs: $duration * 1000,
                attempt: $attempt,
                requestId: $requestId,
            ));

            return [$response->getStatusCode(), $body];
        };

        $retryHandler = $retryable ? $this->retryHandler() : null;

        [$status, $body] = $this->withShortestFloatEncoding(
            fn (): array => $retryHandler !== null ? $retryHandler->execute($doRequest) : $doRequest(),
        );

        return $parse($this->decodeBody($body, $status, $secrets));
    }

    /**
     * The absolute URL for an endpoint, resolved the way Guzzle resolves a
     * relative URI against a base_uri — a leading-slash endpoint replaces the
     * base path instead of appending to it.
     */
    private function uri(string $endpoint): UriInterface
    {
        return UriResolver::resolve(
            Utils::uriFor(rtrim($this->config->baseUrl, '/') . '/'),
            Utils::uriFor($endpoint),
        );
    }

    /**
     * Record a failed attempt. Captures the response when the failure carried
     * one (4xx/5xx), otherwise just the transport error.
     *
     * @param  array<string, mixed>  $options
     */
    private function recordFailure(
        string $method,
        UriInterface $uri,
        array $options,
        GuzzleException $e,
        float $duration,
        int $attempt,
        string $requestId,
    ): void {
        $recorder = $this->diagnostics->recorder();

        if ($recorder === null) {
            return;
        }

        $response = $e instanceof RequestException ? $e->getResponse() : null;

        $recorder->record(new Exchange(
            method: $method,
            url: $this->recordedUrl($uri, $options),
            headers: $options['headers'],
            body: $this->truncateForRecording($this->recordedBody($options)),
            statusCode: $response?->getStatusCode(),
            reasonPhrase: $response?->getReasonPhrase(),
            responseHeaders: $response?->getHeaders() ?? [],
            responseBody: $response !== null
                ? $this->truncateForRecording((string) $response->getBody())
                : null,
            durationMs: $duration * 1000,
            error: $e->getMessage(),
            attempt: $attempt,
            requestId: $requestId,
        ));
    }

    /**
     * Reproduces the URL Guzzle actually requests: the query encoding Guzzle
     * applies to its `query` option (`http_build_query(..., PHP_QUERY_RFC3986)`
     * — spaces become `%20`, not `+`).
     *
     * @param  array<string, mixed>  $options
     */
    private function recordedUrl(UriInterface $uri, array $options): string
    {
        $query = $options['query'] ?? [];

        if (is_array($query) && $query !== []) {
            $uri = $uri->withQuery(http_build_query($query, '', '&', PHP_QUERY_RFC3986));
        }

        return (string) $uri;
    }

    /**
     * The request body as handed to Guzzle. JSON is encoded with default flags
     * to match Guzzle's own encoding of the `json` option.
     *
     * @param  array<string, mixed>  $options
     */
    private function recordedBody(array $options): ?string
    {
        if (isset($options['body']) && is_string($options['body'])) {
            return $options['body'];
        }

        if (isset($options['json'])) {
            return json_encode($options['json']) ?: null;
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $options
     */
    private function logRequest(string $method, string $endpoint, array $options, string $requestId): void
    {
        $logger = $this->diagnostics->logger();

        if ($logger === null) {
            return;
        }

        $logger->debug('Finvalda API request', [
            'request_id' => $requestId,
            'method' => $method,
            'endpoint' => $endpoint,
            // Query params only: a JSON payload is already logged once, elided
            // and capped, as `body`.
            'params' => Redactor::apply($options['query'] ?? []),
            'body' => $this->truncateForLog($this->recordedBody($options)),
            'company' => $this->config->companyId,
        ]);
    }

    private function logResponse(
        string $method,
        string $endpoint,
        int $statusCode,
        float $duration,
        string $body,
        string $requestId,
    ): void {
        $logger = $this->diagnostics->logger();

        if ($logger === null) {
            return;
        }

        $logger->debug('Finvalda API response', [
            'request_id' => $requestId,
            'method' => $method,
            'endpoint' => $endpoint,
            'status_code' => $statusCode,
            'duration_ms' => round($duration * 1000, 2),
            'body' => $this->truncateForLog($body),
            'company' => $this->config->companyId,
        ]);
    }

    private function truncateForLog(?string $body): ?string
    {
        // Elide first, truncate second: once a 58 KB payload is a marker the
        // truncator has nothing left to do, which is the point.
        if (! $this->config->logFileContents) {
            $body = FilePayloadElider::apply($body);
        }

        return BodyTruncator::truncate($body, $this->config->logBodyBytes);
    }

    private function truncateForRecording(?string $body): ?string
    {
        return BodyTruncator::truncate($body, self::MAX_RECORDED_BODY_BYTES);
    }

    /**
     * Decode a response body into an array. Bodies are normally JSON, but
     * some endpoints (e.g. GetFvsUser on certain server versions) ignore the
     * Accept header and return XML — fall back to XML parsing for those.
     *
     * @param  array<string, string>  $secrets
     *
     * @throws FinvaldaException
     */
    private function decodeBody(string $body, int $status, array $secrets): array
    {
        $decoded = json_decode($body, true);

        if (is_array($decoded)) {
            return $decoded;
        }

        $reason = json_last_error() === JSON_ERROR_NONE ? 'not a JSON object' : json_last_error_msg();

        if (str_starts_with(ltrim($body), '<')) {
            $decoded = $this->decodeXmlBody($body);

            if ($decoded !== null) {
                return $decoded;
            }
        }

        $snippet = BodyTruncator::truncate(Redactor::scrub($body, $secrets), self::ERROR_SNIPPET_BYTES);

        throw new FinvaldaException("Invalid response from Finvalda (HTTP {$status}, {$reason}): {$snippet}");
    }

    private function decodeXmlBody(string $body): ?array
    {
        $previous = libxml_use_internal_errors(true);
        $xml = simplexml_load_string($body);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if ($xml === false) {
            return null;
        }

        $decoded = json_decode(json_encode($xml) ?: 'null', true);

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * The server's error text, under whichever key this endpoint uses. XML-
     * decoded empty elements (`<sError/>`) arrive as empty arrays, not strings.
     *
     * @param  array<array-key, mixed>  $decoded
     */
    private function errorMessage(array $decoded): ?string
    {
        foreach (['sError', 'error'] as $key) {
            $value = $decoded[$key] ?? null;

            if (is_string($value) && $value !== '') {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param  array<array-key, mixed>  $decoded
     */
    private function parseResponse(array $decoded): Response
    {
        $accessResult = AccessResult::tryFrom($decoded['AccessResult'] ?? '') ?? AccessResult::Fail;
        $error = $this->errorMessage($decoded);

        if ($accessResult === AccessResult::AccessDenied) {
            throw new AccessDeniedException($error ?? 'Access denied');
        }

        $data = $decoded;
        unset($data['AccessResult'], $data['error'], $data['sError']);

        // Extract items from common response shapes
        $items = $data['items'] ?? $data['Table'] ?? $data;

        // Unwrap single-key responses where value is a sequential list
        // (e.g. {"Paslaugos": [...]}, {"Prekes": [...]}, {"Klientai": [...]})
        if (is_array($items) && count($items) === 1) {
            $first = reset($items);
            if (is_array($first) && array_is_list($first)) {
                $items = $first;
            }
        }

        return new Response(
            accessResult: $accessResult,
            data: is_array($items) ? $items : [],
            error: $error,
            raw: $decoded,
        );
    }

    /**
     * @param  array<array-key, mixed>  $decoded
     */
    private function parseOperationResult(array $decoded): OperationResult
    {
        $accessResult = AccessResult::tryFrom($decoded['AccessResult'] ?? '') ?? AccessResult::Fail;
        $errorMessage = $this->errorMessage($decoded);

        if ($accessResult === AccessResult::AccessDenied) {
            throw new AccessDeniedException($errorMessage ?? 'Access denied');
        }

        if ($accessResult === AccessResult::Fail) {
            return new OperationResult(
                success: false,
                error: $errorMessage ?? 'Unknown error (AccessResult: Fail)',
                errorCode: (int) ($decoded['nResult'] ?? $decoded['result'] ?? -1),
            );
        }

        $resultCode = $decoded['nResult'] ?? $decoded['result'] ?? -1;

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

        if ($errorMessage !== null && str_contains($errorMessage, '<OP_DUOMENYS>')) {
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

    /**
     * Convert a Guzzle exception to the matching SDK exception, with every
     * credential value scrubbed from the message. Guzzle's exception is not
     * chained: its own message embeds the unscrubbed request URI.
     *
     * @param  array<string, string>  $secrets
     */
    private function wrapGuzzleException(GuzzleException $e, array $secrets): FinvaldaException
    {
        $message = (string) Redactor::scrub($e->getMessage(), $secrets);

        // Connection/network errors (DNS failure, timeout, connection refused)
        if ($e instanceof ConnectException) {
            return new NetworkException('Network error: ' . $message);
        }

        // HTTP errors with response. The status is the exception code, so callers
        // can react to it — e.g. a 404 on an action endpoint means this server
        // build does not expose that endpoint.
        if ($e instanceof RequestException && $e->hasResponse()) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();

            return $statusCode >= 500
                ? new ServerException("Server error ({$statusCode}): {$message}", $response)
                : new HttpException("HTTP request failed: {$message}", $response);
        }

        // Default fallback (no HTTP response, e.g. malformed request)
        return new FinvaldaException('HTTP request failed: ' . $message);
    }
}
