<?php

declare(strict_types=1);

namespace Finvalda\Exceptions;

/**
 * Thrown when network/connection errors occur (timeout, connection refused, DNS failure).
 */
class NetworkException extends FinvaldaException {}
