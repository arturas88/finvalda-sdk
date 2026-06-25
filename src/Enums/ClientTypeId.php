<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Client `tipas` discriminators for typesAndTags() / allTypesAndTags().
 *
 * These values match the `tipas` column on the dictionary rows returned by
 * GetKlientuRusisPozymius — they filter the response, they are NOT sent as a
 * request parameter (the server ignores the legacy `nID`). Note the
 * non-sequential numbering (22 for Type, 12/13/14 for the tags).
 *
 * Servers may define other `tipas` values without a case here; pass those as a
 * raw int. Tag groups with no configured rows return an empty collection (normal).
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
