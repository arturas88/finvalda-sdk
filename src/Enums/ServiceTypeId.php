<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Service `tipas` discriminators for typesAndTags() / allTypesAndTags().
 *
 * These values match the `tipas` column on the dictionary rows returned by
 * GetPaslauguRusisPozymius — they filter the response, they are NOT sent as a
 * request parameter (the server ignores the legacy `nID`). Note the
 * non-sequential numbering (18 for Type, 15/16/17 for the tags).
 *
 * Servers may define other `tipas` values without a case here; pass those as a
 * raw int. Tag groups with no configured rows return an empty collection (normal).
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
