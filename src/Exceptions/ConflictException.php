<?php

declare(strict_types=1);

namespace Finvalda\Exceptions;

/**
 * Thrown when an operation conflicts with existing state (duplicate code, locked operation).
 */
class ConflictException extends FinvaldaException {}
