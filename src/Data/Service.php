<?php

declare(strict_types=1);

namespace Finvalda\Data;

/**
 * Service entity DTO.
 */
final class Service extends Entity
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly ?float $price = null,
        public readonly ?float $buyPrice = null,
        public readonly ?float $sellPrice = null,
        public readonly ?string $barcode = null,
        public readonly ?string $currency = null,
        public readonly ?string $measureUnit = null,
        public readonly ?string $type = null,
        public readonly ?string $tag1 = null,
        public readonly ?string $tag2 = null,
        public readonly ?string $tag3 = null,
        public readonly ?string $object1 = null,
        public readonly ?string $object2 = null,
        public readonly ?string $object3 = null,
        public readonly ?string $object4 = null,
        public readonly ?string $object5 = null,
        public readonly ?string $object6 = null,
        public readonly ?string $note = null,
        public readonly ?string $note1 = null,
        public readonly ?string $note2 = null,
        public readonly ?string $note3 = null,
        public readonly ?string $note4 = null,
        public readonly ?string $note5 = null,
        public readonly ?string $note6 = null,
        public readonly ?string $note7 = null,
        public readonly ?string $note8 = null,
        public readonly ?string $note9 = null,
        public readonly ?string $note10 = null,
        public readonly ?string $note11 = null,
        public readonly ?string $note12 = null,
        public readonly ?string $note13 = null,
        public readonly ?string $accountLink = null,
        public readonly ?string $taxCode = null,
        public readonly ?float $vatPercent = null,
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
            code: self::stringValue($data, 'sKodas', 'kodas', 'paslauga') ?? '',
            name: self::stringValue($data, 'sPavadinimas', 'pavadinimas', 'paslaugos_pav') ?? '',
            price: self::floatValue($data, 'dKaina', 'kaina', 'dPardavimoKaina', 'pardavimo_kaina'),
            buyPrice: self::floatValue($data, 'dPirkimoKaina', 'pirkimo_kaina'),
            sellPrice: self::floatValue($data, 'dPardavimoKaina', 'pardavimo_kaina'),
            barcode: self::stringValue($data, 'sBARKodas', 'bar_kodas'),
            currency: self::stringValue($data, 'sValiuta', 'valiuta'),
            measureUnit: self::stringValue($data, 'sMatVnt', 'sMatVienetas', 'matavimo_vienetas', 'mato_vnt'),
            type: self::stringValue($data, 'sRusis', 'rusis'),
            tag1: self::stringValue($data, 'sPozymis1', 'pozymis_1', 'pozymis1'),
            // note: GetPaslaugosSet returns key `pozymims_2` — an API typo — included for completeness
            tag2: self::stringValue($data, 'sPozymis2', 'pozymis_2', 'pozymims_2', 'pozymis2'),
            tag3: self::stringValue($data, 'sPozymis3', 'pozymis_3', 'pozymis3'),
            object1: self::stringValue($data, 'sObjektas1', 'objektas1'),
            object2: self::stringValue($data, 'sObjektas2', 'objektas2'),
            object3: self::stringValue($data, 'sObjektas3', 'objektas3'),
            object4: self::stringValue($data, 'sObjektas4', 'objektas4'),
            object5: self::stringValue($data, 'sObjektas5', 'objektas5'),
            object6: self::stringValue($data, 'sObjektas6', 'objektas6'),
            note: self::stringValue($data, 'sPastaba', 'pastaba'),
            note1: self::stringValue($data, 'sPastabos1', 'pastabos_1', 'pastabos1'),
            note2: self::stringValue($data, 'sPastabos2', 'pastabos_2', 'pastabos2'),
            note3: self::stringValue($data, 'sPastabos3', 'pastabos_3', 'pastabos3'),
            note4: self::stringValue($data, 'sPastabos4', 'pastabos_4', 'pastabos4'),
            note5: self::stringValue($data, 'sPastabos5', 'pastabos_5', 'pastabos5'),
            note6: self::stringValue($data, 'sPastabos6', 'pastabos_6', 'pastabos6'),
            note7: self::stringValue($data, 'sPastabos7', 'pastabos_7', 'pastabos7'),
            note8: self::stringValue($data, 'sPastabos8', 'pastabos_8', 'pastabos8'),
            note9: self::stringValue($data, 'sPastabos9', 'pastabos_9', 'pastabos9'),
            note10: self::stringValue($data, 'sPastabos10', 'pastabos_10', 'pastabos10'),
            note11: self::stringValue($data, 'sPastabos11', 'pastabos_11', 'pastabos11'),
            note12: self::stringValue($data, 'sPastabos12', 'pastabos_12', 'pastabos12'),
            note13: self::stringValue($data, 'sPastabos13', 'pastabos_13', 'pastabos13'),
            accountLink: self::stringValue($data, 'sRysysSuSask'),
            taxCode: self::stringValue($data, 'sMokestis'),
            vatPercent: self::floatValue($data, 'dPvmProc', 'pvm_proc'),
            active: self::boolValue($data, 'nAktyvi'),
            isNew: self::boolValue($data, 'bNauja'),
            createdAt: self::stringValue($data, 'tKurimoData', 'kurimo_data'),
            updatedAt: self::stringValue($data, 'tKoregavimoData', 'koregavimo_data'),
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'sKodas' => $this->code,
            'sPavadinimas' => $this->name,
            'dKaina' => $this->price,
            'dPirkimoKaina' => $this->buyPrice,
            'dPardavimoKaina' => $this->sellPrice,
            'sBARKodas' => $this->barcode,
            'sValiuta' => $this->currency,
            'sMatVnt' => $this->measureUnit,
            'sRusis' => $this->type,
            'sPozymis1' => $this->tag1,
            'sPozymis2' => $this->tag2,
            'sPozymis3' => $this->tag3,
            'sObjektas1' => $this->object1,
            'sObjektas2' => $this->object2,
            'sObjektas3' => $this->object3,
            'sObjektas4' => $this->object4,
            'sObjektas5' => $this->object5,
            'sObjektas6' => $this->object6,
            'sPastaba' => $this->note,
            'sPastabos1' => $this->note1,
            'sPastabos2' => $this->note2,
            'sPastabos3' => $this->note3,
            'sPastabos4' => $this->note4,
            'sPastabos5' => $this->note5,
            'sPastabos6' => $this->note6,
            'sPastabos7' => $this->note7,
            'sPastabos8' => $this->note8,
            'sPastabos9' => $this->note9,
            'sPastabos10' => $this->note10,
            'sPastabos11' => $this->note11,
            'sPastabos12' => $this->note12,
            'sPastabos13' => $this->note13,
            'sRysysSuSask' => $this->accountLink,
            'sMokestis' => $this->taxCode,
            'dPvmProc' => $this->vatPercent,
            'nAktyvi' => $this->active === null ? null : (int) $this->active,
            'bNauja' => $this->isNew === null ? null : (int) $this->isNew,
            'tKurimoData' => $this->createdAt,
            'tKoregavimoData' => $this->updatedAt,
        ], fn ($v) => $v !== null);
    }
}
