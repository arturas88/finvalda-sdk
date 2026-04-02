<?php

declare(strict_types=1);

namespace Finvalda\Validation\Rules;

/**
 * Interface for validation rules.
 */
interface Rule
{
    /**
     * Validate the given value.
     *
     * @param  string  $field  The field name being validated
     * @param  mixed  $value  The value to validate
     * @param  array<string, mixed>  $data  All data being validated (for cross-field validation)
     * @return string|null  Error message if validation fails, null if passes
     */
    public function validate(string $field, mixed $value, array $data): ?string;
}
