<?php

declare(strict_types=1);

namespace Finvalda\Exceptions;

use Finvalda\Validation\ValidationResult;
use Throwable;

class ValidationException extends FinvaldaException
{
    private ?ValidationResult $validationResult = null;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Create a ValidationException with a ValidationResult.
     */
    public static function withResult(
        string $message,
        ValidationResult $result,
        int $code = 0,
        ?Throwable $previous = null,
    ): self {
        $exception = new self($message, $code, $previous);
        $exception->validationResult = $result;

        return $exception;
    }

    /**
     * Get the validation result.
     */
    public function getValidationResult(): ?ValidationResult
    {
        return $this->validationResult;
    }

    /**
     * Get all validation errors.
     *
     * @return array<string, array<string>>
     */
    public function getErrors(): array
    {
        return $this->validationResult?->toArray() ?? [];
    }

    /**
     * Get all error messages as a flat array.
     *
     * @return array<string>
     */
    public function getAllErrors(): array
    {
        return $this->validationResult?->allErrors() ?? [];
    }
}
