<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Responses\Response;

/**
 * Stock and inventory balance operations.
 */
final class Stock extends Resource
{
    /**
     * Get current stock balances. Calls GetEinamiejiLikuciai.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function balances(
        ?string $productCode = null,
        ?string $warehouseCode = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetEinamiejiLikuciai', [
            'sPrekesKodas' => $productCode,
            'sSandelioKodas' => $warehouseCode,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get extended stock balances with additional fields. Calls GetEinamiejiLikuciaiExt.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function balancesExtended(
        ?string $productCode = null,
        ?string $warehouseCode = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetEinamiejiLikuciaiExt', [
            'sPrekesKodas' => $productCode,
            'sSandelioKodas' => $warehouseCode,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get extended stock balances including prices. Calls GetEinamiejiLikuciaiExtSuKainom.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @param  bool|null  $includeZeroQuantity  Whether to include items with zero stock
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function balancesWithPrices(
        ?string $productCode = null,
        ?string $warehouseCode = null,
        ?bool $includeZeroQuantity = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetEinamiejiLikuciaiExtSuKainom', [
            'sPrekesKodas' => $productCode,
            'sSandelioKodas' => $warehouseCode,
            'bNuliniaiLikuciai' => $includeZeroQuantity !== null ? ($includeZeroQuantity ? 'true' : 'false') : null,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get stock balances grouped by warehouse group. Calls GetEinamiejiLikuciaiGrp.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseGroupCode  Filter by warehouse group code
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function balancesByGroup(
        ?string $productCode = null,
        ?string $warehouseGroupCode = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetEinamiejiLikuciaiGrp', [
            'sPrekesKodas' => $productCode,
            'sSandelioGrupesKodas' => $warehouseGroupCode,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get ordered products (pending purchase orders). Calls GetUzsakytasPrekes.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @return Response
     */
    public function orderedProducts(
        ?string $productCode = null,
        ?string $warehouseCode = null,
    ): Response {
        return $this->http->get('GetUzsakytasPrekes', [
            'sPrekesKodas' => $productCode,
            'sSandelioKodas' => $warehouseCode,
        ]);
    }
}
