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
            code: (string) ($data['sKodas'] ?? $data['kodas'] ?? $data['paslauga'] ?? ''),
            name: (string) ($data['sPavadinimas'] ?? $data['pavadinimas'] ?? $data['paslaugos_pav'] ?? ''),
            price: isset($data['dKaina']) ? (float) $data['dKaina']
                : (isset($data['kaina']) ? (float) $data['kaina']
                : (isset($data['dPardavimoKaina']) ? (float) $data['dPardavimoKaina']
                : (isset($data['pardavimo_kaina']) ? (float) $data['pardavimo_kaina'] : null))),
            buyPrice: isset($data['dPirkimoKaina']) ? (float) $data['dPirkimoKaina']
                : (isset($data['pirkimo_kaina']) ? (float) $data['pirkimo_kaina'] : null),
            sellPrice: isset($data['dPardavimoKaina']) ? (float) $data['dPardavimoKaina']
                : (isset($data['pardavimo_kaina']) ? (float) $data['pardavimo_kaina'] : null),
            barcode: $data['sBARKodas'] ?? $data['bar_kodas'] ?? null,
            currency: $data['sValiuta'] ?? $data['valiuta'] ?? null,
            measureUnit: $data['sMatVnt'] ?? $data['sMatVienetas'] ?? $data['matavimo_vienetas'] ?? $data['mato_vnt'] ?? null,
            type: $data['sRusis'] ?? $data['rusis'] ?? null,
            tag1: $data['sPozymis1'] ?? $data['pozymis_1'] ?? $data['pozymis1'] ?? null,
            // note: GetPaslaugosSet returns key `pozymims_2` — an API typo — included for completeness
            tag2: $data['sPozymis2'] ?? $data['pozymis_2'] ?? $data['pozymims_2'] ?? $data['pozymis2'] ?? null,
            tag3: $data['sPozymis3'] ?? $data['pozymis_3'] ?? $data['pozymis3'] ?? null,
            object1: $data['sObjektas1'] ?? $data['objektas1'] ?? null,
            object2: $data['sObjektas2'] ?? $data['objektas2'] ?? null,
            object3: $data['sObjektas3'] ?? $data['objektas3'] ?? null,
            object4: $data['sObjektas4'] ?? $data['objektas4'] ?? null,
            object5: $data['sObjektas5'] ?? $data['objektas5'] ?? null,
            object6: $data['sObjektas6'] ?? $data['objektas6'] ?? null,
            note: $data['sPastaba'] ?? $data['pastaba'] ?? null,
            note1: $data['sPastabos1'] ?? $data['pastabos_1'] ?? $data['pastabos1'] ?? null,
            note2: $data['sPastabos2'] ?? $data['pastabos_2'] ?? $data['pastabos2'] ?? null,
            note3: $data['sPastabos3'] ?? $data['pastabos_3'] ?? $data['pastabos3'] ?? null,
            note4: $data['sPastabos4'] ?? $data['pastabos_4'] ?? $data['pastabos4'] ?? null,
            note5: $data['sPastabos5'] ?? $data['pastabos_5'] ?? $data['pastabos5'] ?? null,
            note6: $data['sPastabos6'] ?? $data['pastabos_6'] ?? $data['pastabos6'] ?? null,
            note7: $data['sPastabos7'] ?? $data['pastabos_7'] ?? $data['pastabos7'] ?? null,
            note8: $data['sPastabos8'] ?? $data['pastabos_8'] ?? $data['pastabos8'] ?? null,
            note9: $data['sPastabos9'] ?? $data['pastabos_9'] ?? $data['pastabos9'] ?? null,
            note10: $data['sPastabos10'] ?? $data['pastabos_10'] ?? $data['pastabos10'] ?? null,
            note11: $data['sPastabos11'] ?? $data['pastabos_11'] ?? $data['pastabos11'] ?? null,
            note12: $data['sPastabos12'] ?? $data['pastabos_12'] ?? $data['pastabos12'] ?? null,
            note13: $data['sPastabos13'] ?? $data['pastabos_13'] ?? $data['pastabos13'] ?? null,
            accountLink: $data['sRysysSuSask'] ?? null,
            taxCode: $data['sMokestis'] ?? null,
            vatPercent: isset($data['dPvmProc']) ? (float) $data['dPvmProc']
                : (isset($data['pvm_proc']) ? (float) $data['pvm_proc'] : null),
            active: isset($data['nAktyvi']) ? (bool) $data['nAktyvi'] : null,
            isNew: isset($data['bNauja']) ? (bool) $data['bNauja'] : null,
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
