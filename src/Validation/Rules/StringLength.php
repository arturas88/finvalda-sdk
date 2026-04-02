<?php

declare(strict_types=1);

namespace Finvalda\Validation\Rules;

/**
 * Validates string length constraints.
 */
final class StringLength implements Rule
{
    public function __construct(
        private readonly ?int $min = null,
        private readonly ?int $max = null,
        private readonly ?string $message = null,
    ) {}

    public function validate(string $field, mixed $value, array $data): ?string
    {
        if ($value === null || $value === '') {
            return null; // Don't validate empty values, use Required for that
        }

        if (! is_string($value)) {
            return $this->message ?? "The {$field} field must be a string.";
        }

        $length = mb_strlen($value);

        if ($this->min !== null && $length < $this->min) {
            return $this->message ?? "The {$field} field must be at least {$this->min} characters.";
        }

        if ($this->max !== null && $length > $this->max) {
            return $this->message ?? "The {$field} field must not exceed {$this->max} characters.";
        }

        return null;
    }

    public static function min(int $min): self
    {
        return new self(min: $min);
    }

    public static function max(int $max): self
    {
        return new self(max: $max);
    }

    public static function between(int $min, int $max): self
    {
        return new self(min: $min, max: $max);
    }

    public static function exact(int $length): self
    {
        return new self(min: $length, max: $length);
    }
}
