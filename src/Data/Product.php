<?php

declare(strict_types=1);

namespace Finvalda\Data;

/**
 * Product entity DTO.
 */
final class Product extends Entity
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly ?string $measureUnit = null,
        public readonly ?string $measureUnitName = null,
        public readonly ?float $measurementRatio = null,
        public readonly ?float $quantity = null,
        public readonly ?float $price1 = null,
        public readonly ?float $price2 = null,
        public readonly ?float $price3 = null,
        public readonly ?float $price4 = null,
        public readonly ?float $price5 = null,
        public readonly ?float $price6 = null,
        public readonly ?string $currency = null,
        public readonly ?float $buyPrice = null,
        public readonly ?string $buyCurrency = null,
        public readonly ?float $costPrice = null,
        public readonly ?float $markup = null,
        public readonly ?float $netWeight = null,
        public readonly ?float $grossWeight = null,
        public readonly ?float $volume = null,
        public readonly ?int $places = null,
        public readonly ?float $minQuantity = null,
        public readonly ?float $orderableQuantity = null,
        public readonly ?string $type = null,
        public readonly ?string $tag1 = null,
        public readonly ?string $tag2 = null,
        public readonly ?string $tag3 = null,
        public readonly ?string $tag4 = null,
        public readonly ?string $tag5 = null,
        public readonly ?string $tag6 = null,
        public readonly ?string $object1 = null,
        public readonly ?string $object2 = null,
        public readonly ?string $object3 = null,
        public readonly ?string $object4 = null,
        public readonly ?string $object5 = null,
        public readonly ?string $object6 = null,
        public readonly ?string $supplier1 = null,
        public readonly ?string $supplier2 = null,
        public readonly ?string $supplier3 = null,
        public readonly ?string $supplierCatalogCode1 = null,
        public readonly ?string $supplierCatalogCode2 = null,
        public readonly ?string $supplierCatalogCode3 = null,
        public readonly ?string $barcode = null,
        public readonly ?string $otherBarcodes = null,
        public readonly ?string $accountLink = null,
        public readonly ?string $taxCode = null,
        public readonly ?string $note = null,
        public readonly ?string $info = null,
        public readonly ?string $info1 = null,
        public readonly ?string $info2 = null,
        public readonly ?string $info3 = null,
        public readonly ?string $info4 = null,
        public readonly ?string $info5 = null,
        public readonly ?string $intrastatCode = null,
        public readonly ?string $url = null,
        public readonly ?string $productGroups = null,
        public readonly ?string $countryOfOrigin = null,
        public readonly ?bool $active = null,
        public readonly ?bool $isNew = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        array $raw = [],
    ) {
        $this->raw = $raw;
    }

    public static function fromArray(array $data): static
    {
        return new self(
            code: (string) ($data['sKodas'] ?? $data['kodas'] ?? $data['preke'] ?? ''),
            name: (string) ($data['sPavadinimas'] ?? $data['pavadinimas'] ?? $data['prekes_pav'] ?? ''),
            measureUnit: $data['sMatavimoVnt'] ?? $data['sMatVnt'] ?? $data['mat_vieneto_pav'] ?? $data['mato_vnt'] ?? null,
            measureUnitName: $data['sMatVntPav'] ?? $data['mat_vieneto_pav'] ?? $data['mato_vnt_pav'] ?? null,
            measurementRatio: isset($data['mat_santykis']) ? (float) $data['mat_santykis'] : null,
            quantity: isset($data['dKiekis']) ? (float) $data['dKiekis']
                : (isset($data['kiekis']) ? (float) $data['kiekis'] : null),
            price1: isset($data['dKaina1']) ? (float) $data['dKaina1']
                : (isset($data['pard_kaina_1']) ? (float) $data['pard_kaina_1']
                : (isset($data['kaina1']) ? (float) $data['kaina1'] : null)),
            price2: isset($data['dKaina2']) ? (float) $data['dKaina2']
                : (isset($data['pard_kaina_2']) ? (float) $data['pard_kaina_2']
                : (isset($data['kaina2']) ? (float) $data['kaina2'] : null)),
            price3: isset($data['dKaina3']) ? (float) $data['dKaina3']
                : (isset($data['pard_kaina_3']) ? (float) $data['pard_kaina_3']
                : (isset($data['kaina3']) ? (float) $data['kaina3'] : null)),
            price4: isset($data['dKaina4']) ? (float) $data['dKaina4']
                : (isset($data['pard_kaina_4']) ? (float) $data['pard_kaina_4']
                : (isset($data['kaina4']) ? (float) $data['kaina4'] : null)),
            price5: isset($data['dKaina5']) ? (float) $data['dKaina5']
                : (isset($data['pard_kaina_5']) ? (float) $data['pard_kaina_5']
                : (isset($data['kaina5']) ? (float) $data['kaina5'] : null)),
            price6: isset($data['dKaina6']) ? (float) $data['dKaina6']
                : (isset($data['pard_kaina_6']) ? (float) $data['pard_kaina_6']
                : (isset($data['kaina6']) ? (float) $data['kaina6'] : null)),
            currency: $data['sValiuta'] ?? $data['pard_val'] ?? $data['valiuta'] ?? null,
            buyPrice: isset($data['dPirkimoKaina']) ? (float) $data['dPirkimoKaina']
                : (isset($data['pirk_kaina']) ? (float) $data['pirk_kaina'] : null),
            buyCurrency: $data['sPirkimoValiuta'] ?? $data['pirk_valiuta'] ?? null,
            costPrice: isset($data['dSavikaina']) ? (float) $data['dSavikaina']
                : (isset($data['savikaina']) ? (float) $data['savikaina'] : null),
            markup: isset($data['dAntkainis']) ? (float) $data['dAntkainis']
                : (isset($data['antkainis']) ? (float) $data['antkainis'] : null),
            netWeight: isset($data['dNeto']) ? (float) $data['dNeto']
                : (isset($data['neto']) ? (float) $data['neto'] : null),
            grossWeight: isset($data['dBruto']) ? (float) $data['dBruto']
                : (isset($data['bruto']) ? (float) $data['bruto'] : null),
            volume: isset($data['dTuris']) ? (float) $data['dTuris']
                : (isset($data['turis']) ? (float) $data['turis'] : null),
            places: isset($data['nVietuSkaicius']) ? (int) $data['nVietuSkaicius']
                : (isset($data['vietu_skaicius']) ? (int) $data['vietu_skaicius'] : null),
            minQuantity: isset($data['nMinimalusKiekis']) ? (float) $data['nMinimalusKiekis'] : null,
            orderableQuantity: isset($data['nUzsakomaPrekiu']) ? (float) $data['nUzsakomaPrekiu'] : null,
            type: $data['sRusis'] ?? $data['rusis'] ?? null,
            tag1: $data['sPozymis1'] ?? $data['pozymis_1'] ?? $data['pozymis1'] ?? null,
            tag2: $data['sPozymis2'] ?? $data['pozymis_2'] ?? $data['pozymis2'] ?? null,
            tag3: $data['sPozymis3'] ?? $data['pozymis_3'] ?? $data['pozymis3'] ?? null,
            tag4: $data['sPozymis4'] ?? $data['pozymis_4'] ?? $data['pozymis4'] ?? null,
            tag5: $data['sPozymis5'] ?? $data['pozymis_5'] ?? $data['pozymis5'] ?? null,
            tag6: $data['sPozymis6'] ?? $data['pozymis_6'] ?? $data['pozymis6'] ?? null,
            object1: $data['sObjektas1'] ?? $data['objektas1'] ?? null,
            object2: $data['sObjektas2'] ?? $data['objektas2'] ?? null,
            object3: $data['sObjektas3'] ?? $data['objektas3'] ?? null,
            object4: $data['sObjektas4'] ?? $data['objektas4'] ?? null,
            object5: $data['sObjektas5'] ?? $data['objektas5'] ?? null,
            object6: $data['sObjektas6'] ?? $data['objektas6'] ?? null,
            supplier1: $data['sTiekejas1'] ?? $data['tiekejas1'] ?? null,
            supplier2: $data['sTiekejas2'] ?? $data['tiekejas2'] ?? null,
            supplier3: $data['sTiekejas3'] ?? $data['tiekejas3'] ?? null,
            supplierCatalogCode1: $data['sPreKodTiek1Kataloge'] ?? null,
            supplierCatalogCode2: $data['sPreKodTiek2Kataloge'] ?? null,
            supplierCatalogCode3: $data['sPreKodTiek3Kataloge'] ?? null,
            barcode: $data['sBarKodas'] ?? $data['sBruksnKodas'] ?? $data['bar_kodas'] ?? $data['barcode'] ?? null,
            otherBarcodes: $data['sKitiBARKodai'] ?? null,
            accountLink: $data['sRysysSuSask'] ?? null,
            taxCode: $data['sMokestis'] ?? null,
            note: $data['sPastaba'] ?? $data['pastaba'] ?? $data['pastabos'] ?? null,
            info: $data['sInformacija'] ?? $data['informacija'] ?? null,
            info1: $data['sInfo1'] ?? $data['info1'] ?? null,
            info2: $data['sInfo2'] ?? $data['info2'] ?? null,
            info3: $data['sInfo3'] ?? $data['info3'] ?? null,
            info4: $data['sInfo4'] ?? $data['info4'] ?? null,
            info5: $data['sInfo5'] ?? $data['info5'] ?? null,
            intrastatCode: $data['sIntrastatKodas'] ?? $data['intrastat_kodas'] ?? null,
            url: $data['sUrl'] ?? $data['url'] ?? null,
            productGroups: $data['sPrekGrupes'] ?? $data['prek_grupes'] ?? null,
            countryOfOrigin: $data['sKilmesSalis'] ?? $data['kilmes_salis'] ?? null,
            active: isset($data['nAktyvi']) ? (bool) $data['nAktyvi']
                : (isset($data['aktyvi']) ? (bool) $data['aktyvi'] : null),
            isNew: isset($data['bNauja']) ? (bool) $data['bNauja']
                : (isset($data['nauja']) ? (bool) $data['nauja'] : null),
            createdAt: $data['tKurimoData'] ?? $data['kurimo_data'] ?? null,
            updatedAt: $data['tKoregavimoData'] ?? $data['koregavimo_data'] ?? null,
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'sKodas' => $this->code,
            'sPavadinimas' => $this->name,
            'sMatavimoVnt' => $this->measureUnit,
            'dKaina1' => $this->price1,
            'dKaina2' => $this->price2,
            'dKaina3' => $this->price3,
            'dKaina4' => $this->price4,
            'dKaina5' => $this->price5,
            'dKaina6' => $this->price6,
            'sValiuta' => $this->currency,
            'dPirkimoKaina' => $this->buyPrice,
            'sPirkimoValiuta' => $this->buyCurrency,
            'dAntkainis' => $this->markup,
            'dNeto' => $this->netWeight,
            'dBruto' => $this->grossWeight,
            'dTuris' => $this->volume,
            'nVietuSkaicius' => $this->places,
            'nMinimalusKiekis' => $this->minQuantity,
            'nUzsakomaPrekiu' => $this->orderableQuantity,
            'sRusis' => $this->type,
            'sPozymis1' => $this->tag1,
            'sPozymis2' => $this->tag2,
            'sPozymis3' => $this->tag3,
            'sPozymis4' => $this->tag4,
            'sPozymis5' => $this->tag5,
            'sPozymis6' => $this->tag6,
            'sObjektas1' => $this->object1,
            'sObjektas2' => $this->object2,
            'sObjektas3' => $this->object3,
            'sObjektas4' => $this->object4,
            'sObjektas5' => $this->object5,
            'sObjektas6' => $this->object6,
            'sTiekejas1' => $this->supplier1,
            'sTiekejas2' => $this->supplier2,
            'sTiekejas3' => $this->supplier3,
            'sPreKodTiek1Kataloge' => $this->supplierCatalogCode1,
            'sPreKodTiek2Kataloge' => $this->supplierCatalogCode2,
            'sPreKodTiek3Kataloge' => $this->supplierCatalogCode3,
            'sBarKodas' => $this->barcode,
            'sKitiBARKodai' => $this->otherBarcodes,
            'sRysysSuSask' => $this->accountLink,
            'sMokestis' => $this->taxCode,
            'sPastaba' => $this->note,
            'sInformacija' => $this->info,
            'sInfo1' => $this->info1,
            'sInfo2' => $this->info2,
            'sInfo3' => $this->info3,
            'sInfo4' => $this->info4,
            'sInfo5' => $this->info5,
            'sIntrastatKodas' => $this->intrastatCode,
            'sUrl' => $this->url,
            'sPrekGrupes' => $this->productGroups,
            'sKilmesSalis' => $this->countryOfOrigin,
            'nAktyvi' => $this->active === null ? null : (int) $this->active,
            'bNauja' => $this->isNew === null ? null : (int) $this->isNew,
            'tKurimoData' => $this->createdAt,
            'tKoregavimoData' => $this->updatedAt,
        ], fn ($v) => $v !== null);
    }
}
