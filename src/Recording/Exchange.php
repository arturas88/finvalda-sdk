<?php

declare(strict_types=1);

namespace Finvalda\Recording;

use Finvalda\Enums\CredentialMode;
use Finvalda\Support\Redactor;
use Stringable;

/**
 * One recorded request attempt and its outcome.
 *
 * Renders itself either as readable HTTP text (default, pretty-printed JSON
 * with the embedded xmlstring payload expanded) or as a curl command.
 */
final class Exchange implements Stringable
{
    private const PRETTY_FLAGS = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

    /**
     * @param  array<string, string>  $headers  Request headers, credentials already masked unless captured deliberately
     * @param  array<array<string>>  $responseHeaders
     * @param  string|null  $error  Transport error message, or the exception message for an HTTP error status
     * @param  int  $attempt  1-based retry attempt number
     * @param  string|null  $requestId  Shared by every attempt of one call, and by its log lines
     */
    public function __construct(
        public readonly string $method,
        public readonly string $url,
        public readonly array $headers,
        public readonly ?string $body,
        public readonly ?int $statusCode,
        public readonly ?string $reasonPhrase,
        public readonly array $responseHeaders,
        public readonly ?string $responseBody,
        public readonly float $durationMs,
        public readonly ?string $error = null,
        public readonly int $attempt = 1,
        public readonly ?string $requestId = null,
    ) {}

    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Readable HTTP text: request line, headers, pretty body, status, pretty
     * response body.
     */
    public function toString(): string
    {
        $lines = ["{$this->method} {$this->url}"];

        foreach ($this->headers as $name => $value) {
            $lines[] = "{$name}: {$value}";
        }

        if ($this->body !== null && $this->body !== '') {
            $lines[] = '';
            $lines[] = $this->prettyBody($this->body);
        }

        $lines[] = '';
        $lines[] = $this->statusLine();

        if ($this->responseBody !== null && $this->responseBody !== '') {
            $lines[] = $this->prettyBody($this->responseBody);
        }

        return implode("\n", $lines);
    }

    /**
     * @return array{
     *     request: array{method: string, url: string, headers: array<string, string>, body: string|null},
     *     response: array{status_code: int|null, headers: array<array<string>>, body: string|null, duration_ms: float, error: string|null},
     *     attempt: int,
     *     request_id: string|null
     * }
     */
    public function toArray(): array
    {
        return [
            'request' => [
                'method' => $this->method,
                'url' => $this->url,
                'headers' => $this->headers,
                'body' => $this->body,
            ],
            'response' => [
                'status_code' => $this->statusCode,
                'headers' => $this->responseHeaders,
                'body' => $this->responseBody,
                'duration_ms' => round($this->durationMs, 2),
                'error' => $this->error,
            ],
            'attempt' => $this->attempt,
            'request_id' => $this->requestId,
        ];
    }

    /**
     * A curl command reproducing this request. The body is byte-exact (not
     * pretty-printed); masked credentials must be substituted before running it.
     */
    public function toCurl(): string
    {
        $parts = ["curl -X {$this->method} " . $this->quote($this->url)];

        $headers = $this->headers;

        if ($this->body !== null && $this->body !== '' && ! isset($headers['Content-Type'])) {
            // Guzzle sets this for JSON bodies; buildHeaders() does not.
            $headers['Content-Type'] = 'application/json';
        }

        foreach ($headers as $name => $value) {
            $parts[] = '  -H ' . $this->quote("{$name}: {$value}");
        }

        if ($this->body !== null && $this->body !== '') {
            $parts[] = '  -d ' . $this->quote($this->body);
        }

        return implode(" \\\n", $parts);
    }

    /**
     * A copy whose headers, URL query, and JSON body carry credential values
     * substituted per the given mode. The URL and body are returned unchanged
     * when they carry no credentials.
     *
     * Fields that are not structured — the transport/HTTP error message, the
     * response body, and response header values — are scrubbed by value: the
     * real credential values are collected from this (still unsubstituted)
     * object and replaced with the same text the mode uses. Guzzle embeds the
     * request URI in its exception messages, so `error` would otherwise carry a
     * verbatim `sPassword` query value; a server echoing a credential back
     * would leak it the same way.
     */
    public function withCredentials(CredentialMode $mode): self
    {
        if ($mode === CredentialMode::Real) {
            return $this;
        }

        /** @var array<string, string> $headers */
        $headers = $this->substitute($this->headers, $mode);

        $secrets = $this->credentialValues($mode);

        return new self(
            method: $this->method,
            url: $this->substituteQuery($this->url, $mode),
            headers: $headers,
            body: $this->scrub($this->substituteBody($this->body, $mode), $secrets),
            statusCode: $this->statusCode,
            reasonPhrase: $this->reasonPhrase,
            responseHeaders: $this->scrubHeaders($this->responseHeaders, $secrets),
            responseBody: $this->scrub($this->responseBody, $secrets),
            durationMs: $this->durationMs,
            error: $this->scrub($this->error, $secrets),
            attempt: $this->attempt,
            requestId: $this->requestId,
        );
    }

    /**
     * Real credential values carried by this exchange, mapped to their
     * replacement text under the given mode. Collected from the request
     * headers, the URL query, and a JSON request body — the three places the
     * SDK puts a credential. See Redactor::secrets() for the encoded forms
     * each value is registered under.
     *
     * @return array<string, string>
     */
    private function credentialValues(CredentialMode $mode): array
    {
        $sources = [$this->headers];

        $query = parse_url($this->url, PHP_URL_QUERY);

        if (is_string($query) && $query !== '') {
            $params = [];
            parse_str($query, $params);
            $sources[] = $params;
        }

        if ($this->body !== null) {
            $decoded = json_decode($this->body, true);

            if (is_array($decoded)) {
                $sources[] = $decoded;
            }
        }

        return Redactor::secrets($sources, fn (string $key): string => $this->replacementFor($key, $mode));
    }

    /**
     * @param  array<string, string>  $secrets
     */
    private function scrub(?string $value, array $secrets): ?string
    {
        return Redactor::scrub($value, $secrets);
    }

    /**
     * @param  array<array<string>>  $headers
     * @param  array<string, string>  $secrets
     * @return array<array<string>>
     */
    private function scrubHeaders(array $headers, array $secrets): array
    {
        if ($secrets === []) {
            return $headers;
        }

        return array_map(
            fn (array $values): array => array_map(
                fn (string $value): string => (string) $this->scrub($value, $secrets),
                $values,
            ),
            $headers,
        );
    }

    /**
     * @param  array<array-key, mixed>  $values
     * @return array<array-key, mixed>
     */
    private function substitute(array $values, CredentialMode $mode): array
    {
        return $mode === CredentialMode::Env
            ? Redactor::applyPlaceholders($values)
            : Redactor::apply($values);
    }

    /**
     * Substitute credential values in the query string, rebuilt so a
     * substituted value stays literal: `***` remains readable and
     * `$FVS_SPASSWORD` remains shell-expandable, neither becoming
     * `%2A%2A%2A` / `%24FVS_SPASSWORD`. Non-credential parameters are
     * re-encoded exactly as HttpClient::recordedUrl() encodes them
     * (RFC 3986, matching Guzzle), so they stay byte-identical to the wire.
     */
    private function substituteQuery(string $url, CredentialMode $mode): string
    {
        $query = parse_url($url, PHP_URL_QUERY);

        if (! is_string($query) || $query === '') {
            return $url;
        }

        $params = [];
        parse_str($query, $params);
        $substituted = $this->substitute($params, $mode);

        if ($substituted === $params) {
            return $url;
        }

        $offset = (int) strpos($url, '?');

        return substr_replace($url, $this->buildQuery($substituted), $offset + 1, strlen($query));
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private function buildQuery(array $params): string
    {
        $pairs = [];

        foreach ($params as $key => $value) {
            if (is_string($value) && in_array((string) $key, Redactor::KEYS, true)) {
                // Already substituted: emit the mask/placeholder verbatim.
                $pairs[] = rawurlencode((string) $key) . '=' . $value;

                continue;
            }

            // Handles scalars, arrays, and empty values exactly as Guzzle would.
            $pair = http_build_query([$key => $value], '', '&', PHP_QUERY_RFC3986);

            if ($pair !== '') {
                $pairs[] = $pair;
            }
        }

        return implode('&', $pairs);
    }

    private function replacementFor(string $key, CredentialMode $mode): string
    {
        return $mode === CredentialMode::Env
            ? Redactor::PLACEHOLDERS[$key]
            : Redactor::MASK;
    }

    private function substituteBody(?string $body, CredentialMode $mode): ?string
    {
        if ($body === null) {
            return null;
        }

        $decoded = json_decode($body, true);

        if (! is_array($decoded)) {
            return $body;
        }

        $substituted = $this->substitute($decoded, $mode);

        if ($substituted === $decoded) {
            return $body;
        }

        return json_encode($substituted) ?: $body;
    }

    /**
     * Quote a value for a POSIX shell. Literal chunks are single-quoted and
     * $FVS_* placeholders double-quoted, then concatenated, so a placeholder
     * expands even when it sits inside a JSON body:
     * '{"sPassword":"'"$FVS_SPASSWORD"'"}'
     */
    private function quote(string $value): string
    {
        $parts = preg_split(
            '/(\$FVS_[A-Z_]+)/',
            $value,
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY,
        );

        if ($parts === false || $parts === []) {
            return $this->singleQuote($value);
        }

        $quoted = '';

        foreach ($parts as $part) {
            $quoted .= str_starts_with($part, '$FVS_')
                ? '"' . $part . '"'
                : $this->singleQuote($part);
        }

        return $quoted;
    }

    private function singleQuote(string $value): string
    {
        return "'" . str_replace("'", "'\\''", $value) . "'";
    }

    private function statusLine(): string
    {
        $duration = round($this->durationMs, 1);

        if ($this->statusCode === null) {
            return "--- ERROR: {$this->error} ({$duration} ms) ---";
        }

        $status = trim("{$this->statusCode} {$this->reasonPhrase}");

        return "--- {$status} ({$duration} ms) ---";
    }

    /**
     * Pretty-print a JSON body, expanding an embedded JSON payload carried in
     * the API's xmlstring field. Non-JSON bodies (the server answers XML on
     * some endpoints) pass through verbatim.
     */
    private function prettyBody(string $body): string
    {
        $decoded = json_decode($body, true);

        if (! is_array($decoded)) {
            return $body;
        }

        if (isset($decoded['xmlstring']) && is_string($decoded['xmlstring'])) {
            $payload = json_decode($decoded['xmlstring'], true);

            if (is_array($payload)) {
                $decoded['xmlstring'] = $payload;
            }
        }

        return json_encode($decoded, self::PRETTY_FLAGS) ?: $body;
    }
}
