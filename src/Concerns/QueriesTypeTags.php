<?php

declare(strict_types=1);

namespace Finvalda\Concerns;

use Finvalda\Collections\TypeTagCollection;

/**
 * Shared logic for the type/tag dictionary endpoints
 * (GetPrekiuRusisPozymius, GetKlientuRusisPozymius, GetPaslauguRusisPozymius).
 *
 * Each endpoint returns the FULL dictionary (all types and all tag groups) in a
 * single call. The legacy `nID` request parameter is IGNORED by the server, so
 * the SDK does not send it and instead discriminates rows client-side by their
 * `tipas` column. The full dataset is fetched once and cached on the resource
 * instance, so filtered + grouped reads never fan out into multiple round-trips.
 */
trait QueriesTypeTags
{
    private ?TypeTagCollection $typeTagsCache = null;

    /**
     * Fetch (and cache) the full type/tag dictionary for the given endpoint.
     *
     * No `nID` is sent: the server returns every type and tag group regardless,
     * and the value would be ignored anyway.
     */
    private function fetchTypeTags(string $endpoint): TypeTagCollection
    {
        if ($this->typeTagsCache === null) {
            $response = $this->http->get($endpoint);

            $this->typeTagsCache = $response->successful()
                ? TypeTagCollection::fromArray($response->data)
                : new TypeTagCollection();
        }

        return $this->typeTagsCache;
    }
}
