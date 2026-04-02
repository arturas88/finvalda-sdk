<?php

declare(strict_types=1);

namespace Finvalda\Validation;

use Finvalda\Exceptions\ValidationException;
use Finvalda\Validation\Rules\Rule;

/**
 * Data validator for API requests.
 *
 * Usage:
 * ```php
 * $validator = new Validator([
 *     'sKodas' => [new Required(), StringLength::max(50)],
 *     'sPavadinimas' => [new Required(), StringLength::max(200)],
 *     'dKaina' => [NumericRange::positive()],
 * ]);
 *
 * $result = $validator->validate($data);
 * if ($result->fails()) {
 *     throw new ValidationException('Validation failed', $result);
 * }
 * ```
 */
final class Validator
{
    /**
     * @param  array<string, array<Rule>>  $rules  Rules keyed by field name
     */
    public function __construct(
        private readonly array $rules = [],
    ) {}

    /**
     * Validate the given data against the rules.
     *
     * @param  array<string, mixed>  $data
     */
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        foreach ($this->rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                $error = $rule->validate($field, $value, $data);
                if ($error !== null) {
                    $errors[$field] ??= [];
                    $errors[$field][] = $error;
                }
            }
        }

        return new ValidationResult($errors);
    }

    /**
     * Validate and throw exception if validation fails.
     *
     * @param  array<string, mixed>  $data
     *
     * @throws ValidationException
     */
    public function validateOrFail(array $data): void
    {
        $result = $this->validate($data);

        if ($result->fails()) {
            throw ValidationException::withResult('Validation failed', $result);
        }
    }

    /**
     * Create a validator with the given rules.
     *
     * @param  array<string, array<Rule>>  $rules
     */
    public static function make(array $rules): self
    {
        return new self($rules);
    }

    /**
     * Quick validation helper.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, array<Rule>>  $rules
     */
    public static function check(array $data, array $rules): ValidationResult
    {
        return (new self($rules))->validate($data);
    }
}
