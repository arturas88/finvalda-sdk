<?php

declare(strict_types=1);

namespace Finvalda\Exceptions;

/**
 * Thrown before a request is sent when a builder or line DTO is given input the
 * spec does not accept — a field the target envelope does not define, a value
 * out of range, or a missing required value.
 */
class ValidationException extends FinvaldaException {}
