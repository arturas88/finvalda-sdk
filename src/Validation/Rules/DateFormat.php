<?php

declare(strict_types=1);

namespace Finvalda\Validation\Rules;

use DateTimeInterface;

/**
 * Validates date format.
 */
final class DateFormat implements Rule
{
    public function __construct(
        private readonly string $format = 'Y-m-d',
        private readonly ?string $message = null,
    ) {}

    public function validate(string $field, mixed $value, array $data): ?string
    {
        if ($value === null || $value === '') {
            return null; // Don't validate empty values, use Required for that
        }

        // DateTime objects are always valid
        if ($value instanceof DateTimeInterface) {
            return null;
        }

        if (! is_string($value)) {
            return $this->message ?? "The {$field} field must be a date.";
        }

        $parsed = \DateTime::createFromFormat($this->format, $value);

        if ($parsed === false || $parsed->format($this->format) !== $value) {
            return $this->message ?? "The {$field} field must be a valid date in {$this->format} format.";
        }

        return null;
    }

    public static function ymd(): self
    {
        return new self('Y-m-d');
    }

    public static function datetime(): self
    {
        return new self('Y-m-d H:i:s');
    }
}
