<?php

declare(strict_types=1);

namespace Finvalda;

use Finvalda\Enums\Language;
use InvalidArgumentException;

final class FinvaldaConfig
{
    public function __construct(
        public readonly string $baseUrl,
        public readonly string $username,
        public readonly string $password,
        public readonly ?string $connString = null,
        public readonly ?string $companyId = null,
        public readonly Language $language = Language::Lithuanian,
        public readonly bool $removeEmptyStringTags = false,
        public readonly bool $removeZeroNumberTags = false,
        public readonly bool $removeNewLines = false,
        public readonly int $timeout = 30,
    ) {
        if ($this->baseUrl === '') {
            throw new InvalidArgumentException('Finvalda base URL is required');
        }

        if ($this->username === '') {
            throw new InvalidArgumentException('Finvalda username is required');
        }

        if ($this->password === '') {
            throw new InvalidArgumentException('Finvalda password is required');
        }
    }
}
