<?php

declare(strict_types=1);

namespace Finvalda\Exceptions;

/**
 * A write was refused because the country code (e.g. a client card's
 * sValstybeKodas) does not exist in Finvalda: "Country 'IQ' not found!".
 *
 * The web service cannot create countries; they are maintained in Finvalda by
 * hand, so the fix is to ask the accountant to add $countryCode. Finvalda uses
 * ISO codes (GR, not the VAT prefix EL).
 */
class MissingCountryException extends OperationFailedException
{
    public function __construct(
        string $message,
        int $errorCode,
        public readonly string $countryCode,
        ?string $journal = null,
        ?int $number = null,
    ) {
        parent::__construct($message, $errorCode, $journal, $number);
    }
}
