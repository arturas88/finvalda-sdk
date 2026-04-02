<?php

declare(strict_types=1);

namespace Finvalda\Validation\Rules;

/**
 * Validates that a field is present and not empty.
 */
final class Required implements Rule
{
    public function __construct(
        private readonly ?string $message = null,
    ) {}

    public function validate(string $field, mixed $value, array $data): ?string
    {
        if ($value === null || $value === '' || $value === []) {
            return $this->message ?? "The {$field} field is required.";
        }

        return null;
    }
}
