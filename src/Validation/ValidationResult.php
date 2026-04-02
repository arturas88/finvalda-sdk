<?php

declare(strict_types=1);

namespace Finvalda\Validation;

/**
 * Result of validation containing errors if any.
 */
final class ValidationResult
{
    /**
     * @param  array<string, array<string>>  $errors  Errors keyed by field name
     */
    public function __construct(
        public readonly array $errors = [],
    ) {}

    /**
     * Check if validation passed (no errors).
     */
    public function passes(): bool
    {
        return empty($this->errors);
    }

    /**
     * Check if validation failed (has errors).
     */
    public function fails(): bool
    {
        return ! $this->passes();
    }

    /**
     * Get errors for a specific field.
     *
     * @return array<string>
     */
    public function getErrors(string $field): array
    {
        return $this->errors[$field] ?? [];
    }

    /**
     * Get the first error for a specific field.
     */
    public function first(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }

    /**
     * Get all error messages as a flat array.
     *
     * @return array<string>
     */
    public function allErrors(): array
    {
        $messages = [];
        foreach ($this->errors as $fieldErrors) {
            foreach ($fieldErrors as $error) {
                $messages[] = $error;
            }
        }

        return $messages;
    }

    /**
     * Get all fields that have errors.
     *
     * @return array<string>
     */
    public function errorFields(): array
    {
        return array_keys($this->errors);
    }

    /**
     * Get error count.
     */
    public function errorCount(): int
    {
        return count($this->allErrors());
    }

    /**
     * Convert to array.
     *
     * @return array<string, array<string>>
     */
    public function toArray(): array
    {
        return $this->errors;
    }
}
