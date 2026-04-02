<?php

declare(strict_types=1);

namespace Finvalda\Data;

/**
 * Client (customer/supplier) entity DTO.
 */
final class Client extends Entity
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly ?string $address = null,
        public readonly ?string $city = null,
        public readonly ?string $country = null,
        public readonly ?string $countryName = null,
        public readonly ?string $phone = null,
        public readonly ?string $fax = null,
        public readonly ?string $email = null,
        public readonly ?string $companyCode = null,
        public readonly ?string $vatCode = null,
        public readonly ?string $bankCode = null,
        public readonly ?string $bankAccount = null,
        public readonly ?string $responsiblePerson = null,
        public readonly ?int $paymentDays = null,
        public readonly ?float $debt = null,
        public readonly ?float $taxPercent = null,
        public readonly ?string $type = null,
        public readonly ?string $tag1 = null,
        public readonly ?string $tag2 = null,
        public readonly ?string $tag3 = null,
        public readonly ?string $debtAccount = null,
        public readonly ?string $creditAccount = null,
        array $raw = [],
    ) {
        $this->raw = $raw;
    }

    public static function fromArray(array $data): static
    {
        return new self(
            code: (string) ($data['sKodas'] ?? $data['kodas'] ?? ''),
            name: (string) ($data['sPavadinimas'] ?? $data['pavadinimas'] ?? ''),
            address: $data['sAdresas'] ?? $data['adresas'] ?? null,
            city: $data['sMiestas'] ?? $data['miestas'] ?? null,
            country: $data['sValstybe'] ?? $data['valstybe'] ?? null,
            countryName: $data['sValstybePav'] ?? $data['valstybe_pav'] ?? null,
            phone: $data['sTelefonas'] ?? $data['telefonas'] ?? null,
            fax: $data['sFaksas'] ?? $data['faksas'] ?? null,
            email: $data['sElPastas'] ?? $data['el_pastas'] ?? null,
            companyCode: $data['sImonesKodas'] ?? $data['im_kodas'] ?? null,
            vatCode: $data['sPVMKodas'] ?? $data['pvm_moketojo_kodas'] ?? null,
            bankCode: $data['sBankas'] ?? $data['bankas'] ?? null,
            bankAccount: $data['sBankoSask'] ?? $data['banko_sask'] ?? null,
            responsiblePerson: $data['sAtskaitingasAsmuo'] ?? $data['atskaitingas_asmuo'] ?? null,
            paymentDays: isset($data['nAtsiskaitytaPer']) ? (int) $data['nAtsiskaitytaPer'] : (isset($data['atsiskaityti_per']) ? (int) $data['atsiskaityti_per'] : null),
            debt: isset($data['dSkola']) ? (float) $data['dSkola'] : (isset($data['skola']) ? (float) $data['skola'] : null),
            taxPercent: isset($data['dMokestis']) ? (float) $data['dMokestis'] : (isset($data['mokestis']) ? (float) $data['mokestis'] : null),
            type: $data['sRusis'] ?? $data['rusis'] ?? null,
            tag1: $data['sPozymis1'] ?? $data['pozymis1'] ?? null,
            tag2: $data['sPozymis2'] ?? $data['pozymis2'] ?? null,
            tag3: $data['sPozymis3'] ?? $data['pozymis3'] ?? null,
            debtAccount: $data['sDebtSask'] ?? null,
            creditAccount: $data['sKredSask'] ?? null,
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'sKodas' => $this->code,
            'sPavadinimas' => $this->name,
            'sAdresas' => $this->address,
            'sMiestas' => $this->city,
            'sValstybe' => $this->country,
            'sTelefonas' => $this->phone,
            'sFaksas' => $this->fax,
            'sElPastas' => $this->email,
            'sImonesKodas' => $this->companyCode,
            'sPVMKodas' => $this->vatCode,
            'sBankas' => $this->bankCode,
            'sBankoSask' => $this->bankAccount,
            'sAtskaitingasAsmuo' => $this->responsiblePerson,
            'nAtsiskaitytaPer' => $this->paymentDays,
            'sRusis' => $this->type,
            'sPozymis1' => $this->tag1,
            'sPozymis2' => $this->tag2,
            'sPozymis3' => $this->tag3,
            'sDebtSask' => $this->debtAccount,
            'sKredSask' => $this->creditAccount,
        ], fn ($v) => $v !== null);
    }
}
