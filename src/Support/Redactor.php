<?php

declare(strict_types=1);

namespace Finvalda\Support;

/**
 * Substitutes credential values in data destined for logs, exception messages,
 * or recordings. The wire request is never affected.
 */
final class Redactor
{
    /**
     * Header, query, and body keys whose values are substituted.
     */
    public const KEYS = ['Password', 'ConnString', 'sPassword'];

    public const MASK = '***';

    /**
     * Shell variable placeholders, one per credential key. sPassword gets its
     * own name because it is a different secret from the connection password —
     * it is the looked-up user's password in References::user() (GetFvsUser),
     * which travels as a GET query parameter.
     */
    public const PLACEHOLDERS = [
        'Password' => '$FVS_PASSWORD',
        'ConnString' => '$FVS_CONN_STRING',
        'sPassword' => '$FVS_SPASSWORD',
    ];

    /**
     * Mask credential values. Top-level keys only.
     *
     * @param  array<string, mixed>  $values
     * @return array<string, mixed>
     */
    public static function apply(array $values): array
    {
        return self::substitute($values, fn (string $key): string => self::MASK);
    }

    /**
     * Replace credential values with shell variable placeholders, so rendered
     * output stays runnable without printing the secret. Top-level keys only.
     *
     * @param  array<string, mixed>  $values
     * @return array<string, mixed>
     */
    public static function applyPlaceholders(array $values): array
    {
        return self::substitute($values, fn (string $key): string => self::PLACEHOLDERS[$key]);
    }

    /**
     * Real credential values found under KEYS in the given sources (headers,
     * query params, a decoded JSON body), mapped to their replacement text —
     * the mask unless a $replacement is given. Used to scrub free text such as
     * exception messages, where a credential appears by value, not by key.
     *
     * Each value is registered together with the encoded forms it can appear in
     * downstream: Guzzle embeds the percent-encoded query string in its
     * exception messages, and a JSON response body carries the JSON-escaped
     * form. Without those, a password holding any character outside the
     * unreserved set survives (recoverable with one `urldecode()`).
     *
     * Longest values first, so replacing one that is a prefix of another cannot
     * leave a fragment behind. Empty values are skipped so nothing ever
     * replaces ''.
     *
     * @param  list<array<array-key, mixed>>  $sources
     * @param  (callable(string): string)|null  $replacement  Maps a credential key to its replacement text
     * @return array<string, string>
     */
    public static function secrets(array $sources, ?callable $replacement = null): array
    {
        $secrets = [];

        foreach (self::KEYS as $key) {
            foreach ($sources as $source) {
                $value = $source[$key] ?? null;

                if (! is_string($value) || $value === '') {
                    continue;
                }

                $text = $replacement !== null ? $replacement($key) : self::MASK;

                foreach (self::encodedVariants($value) as $variant) {
                    $secrets[$variant] = $text;
                }
            }
        }

        uksort($secrets, fn (string $a, string $b): int => strlen($b) <=> strlen($a));

        return $secrets;
    }

    /**
     * Replace every secret value (see secrets()) in a free-text string.
     *
     * @param  array<string, string>  $secrets
     */
    public static function scrub(?string $value, array $secrets): ?string
    {
        if ($value === null || $secrets === []) {
            return $value;
        }

        return str_replace(array_keys($secrets), array_values($secrets), $value);
    }

    /**
     * A credential value plus every encoded form it can reach a recorded field
     * in: percent-encoded (`rawurlencode` and `urlencode` differ for spaces —
     * `%20` vs `+`) and JSON-escaped, both with PHP's default escaping and with
     * slashes and unicode left alone, since the server chooses its own flags.
     * Duplicates and empty results are dropped.
     *
     * @return list<string>
     */
    private static function encodedVariants(string $value): array
    {
        $variants = [$value, rawurlencode($value), urlencode($value)];

        foreach ([0, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE] as $flags) {
            $encoded = json_encode($value, $flags);

            // Strip the surrounding quotes json_encode adds; substr, not trim(),
            // so a value whose escaped form ends in \" keeps its backslash.
            if (is_string($encoded) && strlen($encoded) > 2) {
                $variants[] = substr($encoded, 1, -1);
            }
        }

        return array_values(array_unique(array_filter($variants, fn (string $v): bool => $v !== '')));
    }

    /**
     * @param  array<string, mixed>  $values
     * @param  callable(string): string  $replacement
     * @return array<string, mixed>
     */
    private static function substitute(array $values, callable $replacement): array
    {
        foreach (self::KEYS as $key) {
            if (array_key_exists($key, $values)) {
                $values[$key] = $replacement($key);
            }
        }

        return $values;
    }
}
