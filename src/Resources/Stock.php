<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\Enums\Language;
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Responses\Response;
use InvalidArgumentException;

/**
 * Stock and inventory balance operations.
 */
final class Stock extends Resource
{
    /**
     * GetPrekesIstorija reports the operation kind as a localised name in
     * op_rusis_pav. The spec documents the column but never enumerates its
     * values — these two are observed against a live Finvalda, not specified.
     * The numeric op_tipid column would be language-independent, but its
     * values are not documented either, so the labels stay — and only under
     * Language::Lithuanian.
     */
    private const OP_KIND_PURCHASE = 'Pirkimai';

    private const OP_KIND_SALE = 'Pardavimai';

    /**
     * Get current stock balances. Calls GetEinamiejiLikuciai.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function balances(
        ?string $productCode = null,
        ?string $warehouseCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetEinamiejiLikuciai', [
            'sPrekesKodas' => $productCode,
            'sSandelioKodas' => $warehouseCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get extended stock balances with additional fields. Calls GetEinamiejiLikuciaiExt.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function balancesExtended(
        ?string $productCode = null,
        ?string $warehouseCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetEinamiejiLikuciaiExt', [
            'sPrekesKodas' => $productCode,
            'sSandelioKodas' => $warehouseCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get extended stock balances including prices. Calls GetEinamiejiLikuciaiExtSuKainom.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @param  bool|null  $includeZeroQuantity  Whether to include items with zero stock
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function balancesWithPrices(
        ?string $productCode = null,
        ?string $warehouseCode = null,
        ?bool $includeZeroQuantity = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetEinamiejiLikuciaiExtSuKainom', [
            'sPrekesKodas' => $productCode,
            'sSandelioKodas' => $warehouseCode,
            'bNuliniaiLikuciai' => $includeZeroQuantity !== null ? ($includeZeroQuantity ? 'true' : 'false') : null,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get stock balances grouped by warehouse group. Calls GetEinamiejiLikuciaiGrp.
     *
     * Unlike its siblings, the endpoint takes no date filters.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseGroupCode  Filter by warehouse group code
     */
    public function balancesByGroup(
        ?string $productCode = null,
        ?string $warehouseGroupCode = null,
    ): Response {
        // v3 also took (modifiedSince, createdSince), which the spec does not
        // define; a v3 call would still run and look date-filtered.
        if (func_num_args() > 2) {
            throw new InvalidArgumentException(
                'balancesByGroup() takes (productCode, warehouseGroupCode) since v4: GetEinamiejiLikuciaiGrp has no '
                . 'date filter, so the v3 date arguments were never applied.'
            );
        }

        return $this->http->get('GetEinamiejiLikuciaiGrp', [
            'sPrekesKodas' => $productCode,
            'sSandelioGrupesKodas' => $warehouseGroupCode,
        ]);
    }

    /**
     * Resolve the purchase operation that currently holds $productCode as stock,
     * and whether a sale has followed it. Derived from GetPrekesIstorija.
     *
     * The LATEST purchase wins: a re-acquired item has several purchase rows and
     * only the most recent one holds the current stock layer. A sale counts as
     * "sold" only when it is dated at or after that purchase — an older sale
     * belongs to a previous ownership cycle.
     *
     * Note this is derived, not raw: unlike the rest of this resource it returns a
     * plain array rather than a Response — it exists to be used as a pre-flight
     * check (see PurchaseUpdateBuilder). Use Products::history() for the raw rows.
     *
     * Limits, all from what GetPrekesIstorija exposes:
     * - Only a SALE counts as consumption. A write-off, purchase return or
     *   internal transfer after the purchase leaves `sold` false.
     * - `warehouse` is the purchase row's warehouse; a later transfer moves the
     *   stock without changing it.
     * - Lithuanian only: the kinds are matched on Lithuanian labels.
     *
     * @param  string  $productCode  Product code (for serialised stock, typically the serial/VIN).
     * @return array{journal:string, op_number:int, warehouse:string, op_date:string,
     *               sold:bool, sale_journal:?string, sale_op_number:?int, sale_date:?string}|null
     *         Null when the product has no purchase history, or the call failed.
     *
     * @throws FinvaldaException when the client is not configured with Language::Lithuanian
     */
    public function purchaseOpFor(string $productCode): ?array
    {
        if ($this->http->getConfig()->language !== Language::Lithuanian) {
            throw new FinvaldaException(
                'purchaseOpFor() matches the Lithuanian operation-kind labels GetPrekesIstorija '
                . 'returns ("Pirkimai", "Pardavimai"); call it on a client configured with '
                . 'Language::Lithuanian.'
            );
        }

        $code = trim($productCode);

        if ($code === '') {
            return null;
        }

        // No warehouse or date-from narrowing: the whole history is needed to find
        // the latest purchase.
        // A failed call throws: null means "no purchase history", and a guard
        // reading null as "nothing bought, nothing sold" must not fail open.
        $response = $this->requireSuccess($this->http->get('GetPrekesIstorija', ['sPreKod' => $code]), 'GetPrekesIstorija');

        $purchase = null;
        $purchaseDate = null;
        $sale = null;
        $saleDate = null;

        foreach ($response->data as $row) {
            if (! is_array($row)) {
                continue;
            }

            $date = $this->historyRowDate($row);

            if ($date === null) {
                continue;
            }

            // Unknown operation kinds are ignored rather than guessed at.
            $kind = $row['op_rusis_pav'] ?? null;

            if ($kind === self::OP_KIND_PURCHASE && ($purchaseDate === null || $date >= $purchaseDate)) {
                $purchase = $row;
                $purchaseDate = $date;
            } elseif ($kind === self::OP_KIND_SALE && ($saleDate === null || $date >= $saleDate)) {
                $sale = $row;
                $saleDate = $date;
            }
        }

        if ($purchase === null || $purchaseDate === null) {
            return null;
        }

        $sold = $sale !== null && $saleDate !== null && $saleDate >= $purchaseDate;

        return [
            'journal' => (string) ($purchase['zurnalas'] ?? ''),
            'op_number' => (int) ($purchase['op_numeris'] ?? 0),
            'warehouse' => (string) ($purchase['sandelis'] ?? ''),
            'op_date' => $purchaseDate,
            'sold' => $sold,
            'sale_journal' => $sold ? (string) ($sale['zurnalas'] ?? '') : null,
            'sale_op_number' => $sold ? (int) ($sale['op_numeris'] ?? 0) : null,
            'sale_date' => $sold ? $saleDate : null,
        ];
    }

    /**
     * Normalise a GetPrekesIstorija row's op_data to Y-m-d for comparison.
     *
     * @param  array<string, mixed>  $row
     */
    private function historyRowDate(array $row): ?string
    {
        $raw = $row['op_data'] ?? null;

        if (! is_string($raw) || $raw === '') {
            return null;
        }

        return substr($raw, 0, 10);
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
