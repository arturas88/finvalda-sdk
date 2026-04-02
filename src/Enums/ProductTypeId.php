<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Product type and tag identifiers for typesAndTags() method.
 */
enum ProductTypeId: int
{
    case Type = 0;
    case Tag1 = 1;
    case Tag2 = 2;
    case Tag3 = 3;
    case Tag4 = 4;
    case Tag5 = 5;
    case Tag6 = 6;
    case Tag9 = 9;
    case Tag10 = 10;
    case Tag11 = 11;

    public function label(): string
    {
        return match ($this) {
            self::Type => 'Product Type',
            self::Tag1 => 'Tag 1',
            self::Tag2 => 'Tag 2',
            self::Tag3 => 'Tag 3',
            self::Tag4 => 'Tag 4',
            self::Tag5 => 'Tag 5',
            self::Tag6 => 'Tag 6',
            self::Tag9 => 'Tag 9',
            self::Tag10 => 'Tag 10',
            self::Tag11 => 'Tag 11',
        };
    }
}
