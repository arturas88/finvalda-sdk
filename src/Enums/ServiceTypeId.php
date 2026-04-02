<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Service type and tag identifiers for typesAndTags() method.
 */
enum ServiceTypeId: int
{
    case Type = 18;
    case Tag1 = 15;
    case Tag2 = 16;
    case Tag3 = 17;

    public function label(): string
    {
        return match ($this) {
            self::Type => 'Service Type',
            self::Tag1 => 'Tag 1',
            self::Tag2 => 'Tag 2',
            self::Tag3 => 'Tag 3',
        };
    }
}
