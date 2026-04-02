<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Client type and tag identifiers for typesAndTags() method.
 */
enum ClientTypeId: int
{
    case Type = 22;
    case Tag1 = 12;
    case Tag2 = 13;
    case Tag3 = 14;

    public function label(): string
    {
        return match ($this) {
            self::Type => 'Client Type',
            self::Tag1 => 'Tag 1',
            self::Tag2 => 'Tag 2',
            self::Tag3 => 'Tag 3',
        };
    }
}
