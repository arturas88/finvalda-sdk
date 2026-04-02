<?php

declare(strict_types=1);

namespace Finvalda\Validation\Rules;

/**
 * Validates numeric value constraints.
 */
final class NumericRange implements Rule
{
    public function __construct(
        private readonly int|float|null $min = null,
        private readonly int|float|null $max = null,
        private readonly ?string $message = null,
    ) {}

    public function validate(string $field, mixed $value, array $data): ?string
    {
        if ($value === null || $value === '') {
            return null; // Don't validate empty values, use Required for that
        }

        if (! is_numeric($value)) {
            return $this->message ?? "The {$field} field must be a number.";
        }

        $numericValue = (float) $value;

        if ($this->min !== null && $numericValue < $this->min) {
            return $this->message ?? "The {$field} field must be at least {$this->min}.";
        }

        if ($this->max !== null && $numericValue > $this->max) {
            return $this->message ?? "The {$field} field must not exceed {$this->max}.";
        }

        return null;
    }

    public static function min(int|float $min): self
    {
        return new self(min: $min);
    }

    public static function max(int|float $max): self
    {
        return new self(max: $max);
    }

    public static function between(int|float $min, int|float $max): self
    {
        return new self(min: $min, max: $max);
    }

    public static function positive(): self
    {
        return new self(min: 0);
    }

    public static function positiveNonZero(): self
    {
        return new self(min: 0.01);
    }
}
