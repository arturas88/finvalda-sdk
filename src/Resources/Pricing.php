<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\Responses\Response;

/**
 * Pricing, discounts, and additional prices for client/product/service combinations.
 */
final class Pricing extends Resource
{
    // --- Combined client + item endpoints ---

    /**
     * Get discounts and additional prices for a client + item combination. Calls GetKliPrekPasNuolPapKain.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  string|null  $itemCode  Filter by product or service code
     * @return Response
     */
    public function clientItemPrices(
        ?string $clientCode = null,
        ?string $itemCode = null,
    ): Response {
        return $this->http->get('GetKliPrekPasNuolPapKain', [
            'sKliKod' => $clientCode,
            'sPreKod' => $itemCode,
        ]);
    }

    /**
     * Get discounts and additional prices for a client type + item combination. Calls GetKliRusPrekPasNuolPapKain.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  string|null  $itemCode  Filter by product or service code
     * @return Response
     */
    public function clientTypeItemPrices(
        ?string $clientTypeCode = null,
        ?string $itemCode = null,
    ): Response {
        return $this->http->get('GetKliRusPrekPasNuolPapKain', [
            'sKliRusKod' => $clientTypeCode,
            'sPreKod' => $itemCode,
        ]);
    }

    /**
     * Get discounts and additional prices for a client + item type combination. Calls GetKliPrekPasRusNuolPapKain.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  string|null  $itemTypeCode  Filter by product or service type code
     * @return Response
     */
    public function clientItemTypePrices(
        ?string $clientCode = null,
        ?string $itemTypeCode = null,
    ): Response {
        return $this->http->get('GetKliPrekPasRusNuolPapKain', [
            'sKliKod' => $clientCode,
            'sPreRusKod' => $itemTypeCode,
        ]);
    }

    /**
     * Get discounts and additional prices for a client type + item type combination. Calls GetKliRusPrekPasRusNuolPapKain.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  string|null  $itemTypeCode  Filter by product or service type code
     * @return Response
     */
    public function clientTypeItemTypePrices(
        ?string $clientTypeCode = null,
        ?string $itemTypeCode = null,
    ): Response {
        return $this->http->get('GetKliRusPrekPasRusNuolPapKain', [
            'sKliRusKod' => $clientTypeCode,
            'sPreRusKod' => $itemTypeCode,
        ]);
    }

    // --- Client + Product ---

    /**
     * Get client-specific product discounts. Calls GetKlientuPrekiuNuol.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientProductDiscounts(
        ?string $clientCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuPrekiuNuol', [
            'sKlientoKodas' => $clientCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client-specific product additional prices. Calls GetKlientuPrekiuPapKainas.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientProductAdditionalPrices(
        ?string $clientCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuPrekiuPapKainas', [
            'sKlientoKodas' => $clientCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client-specific product type discounts. Calls GetKlientuPrekiuRusNuol.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientProductTypeDiscounts(
        ?string $clientCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuPrekiuRusNuol', [
            'sKlientoKodas' => $clientCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client-specific product type additional prices. Calls GetKlientuPrekiuRusPapKainas.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientProductTypeAdditionalPrices(
        ?string $clientCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuPrekiuRusPapKainas', [
            'sKlientoKodas' => $clientCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    // --- Client + Service ---

    /**
     * Get client-specific service discounts. Calls GetKlientuPaslauguNuol.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientServiceDiscounts(
        ?string $clientCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuPaslauguNuol', [
            'sKlientoKodas' => $clientCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client-specific service additional prices. Calls GetKlientuPaslauguPapKainas.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientServiceAdditionalPrices(
        ?string $clientCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuPaslauguPapKainas', [
            'sKlientoKodas' => $clientCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client-specific service type discounts. Calls GetKlientuPaslauguRusNuol.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientServiceTypeDiscounts(
        ?string $clientCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuPaslauguRusNuol', [
            'sKlientoKodas' => $clientCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client-specific service type additional prices. Calls GetKlientuPaslauguRusPapKainas.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientServiceTypeAdditionalPrices(
        ?string $clientCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuPaslauguRusPapKainas', [
            'sKlientoKodas' => $clientCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    // --- Client TYPE + Product ---

    /**
     * Get client type-specific product discounts. Calls GetKlientuRusPrekiuNuol.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientTypeProductDiscounts(
        ?string $clientTypeCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuRusPrekiuNuol', [
            'sKlientoRusKodas' => $clientTypeCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client type-specific product additional prices. Calls GetKlientuRusPrekiuPapKainas.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientTypeProductAdditionalPrices(
        ?string $clientTypeCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuRusPrekiuPapKainas', [
            'sKlientoRusKodas' => $clientTypeCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client type-specific product type discounts. Calls GetKlientuRusPrekiuRusNuol.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientTypeProductTypeDiscounts(
        ?string $clientTypeCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuRusPrekiuRusNuol', [
            'sKlientoRusKodas' => $clientTypeCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client type-specific product type additional prices. Calls GetKlientuRusPrekiuRusPapKainas.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientTypeProductTypeAdditionalPrices(
        ?string $clientTypeCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuRusPrekiuRusPapKainas', [
            'sKlientoRusKodas' => $clientTypeCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    // --- Client TYPE + Service ---

    /**
     * Get client type-specific service discounts. Calls GetKlientuRusPaslauguNuol.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientTypeServiceDiscounts(
        ?string $clientTypeCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuRusPaslauguNuol', [
            'sKlientoRusKodas' => $clientTypeCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client type-specific service additional prices. Calls GetKlientuRusPaslauguPapKainas.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientTypeServiceAdditionalPrices(
        ?string $clientTypeCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuRusPaslauguPapKainas', [
            'sKlientoRusKodas' => $clientTypeCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client type-specific service type discounts. Calls GetKlientuRusPaslauguRusNuol.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientTypeServiceTypeDiscounts(
        ?string $clientTypeCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuRusPaslauguRusNuol', [
            'sKlientoRusKodas' => $clientTypeCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get client type-specific service type additional prices. Calls GetKlientuRusPaslauguRusPapKainas.
     *
     * @param  string|null  $clientTypeCode  Filter by client type code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function clientTypeServiceTypeAdditionalPrices(
        ?string $clientTypeCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientuRusPaslauguRusPapKainas', [
            'sKlientoRusKodas' => $clientTypeCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    // --- Recommended Price ---

    /**
     * Get the recommended price for a client + item combination. Calls GetRecommendedPrice.
     *
     * @param  array  $params  Request parameters (keys: ClientCode, ItemCode, Quantity, etc.)
     * @return Response
     */
    public function recommendedPrice(array $params): Response
    {
        return $this->http->postJson('GetRecommendedPrice', $params);
    }
}
