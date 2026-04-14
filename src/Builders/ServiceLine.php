<?php

declare(strict_types=1);

namespace Finvalda\Builders;

/**
 * Fluent value object for building service detail lines.
 *
 * Usage:
 * ```php
 * ServiceLine::make('TRANSPORT', 1)
 *     ->amount(50.00, local: 50.00)
 *     ->vat(percent: 21, amount: 10.50, amountLocal: 10.50)
 *     ->object(1, 'DEPT01')
 * ```
 */
final class ServiceLine
{
    /** @var array<string, mixed> */
    private array $data;

    private function __construct(string $code, float $quantity)
    {
        $this->data = [
            'sKodas' => $code,
            'nKiekis' => (int) ($quantity * 100),
        ];
    }

    public static function make(string $code, float $quantity): self
    {
        return new self($code, $quantity);
    }

    /**
     * Set the unit price (dKaina).
     */
    public function price(float $price): self
    {
        $this->data['dKaina'] = $price;

        return $this;
    }

    /**
     * Set amounts excluding VAT.
     *
     * @param  float  $currency  Amount in operation currency (dSumaV)
     * @param  float|null  $local  Amount in EUR (dSumaL). Defaults to $currency if null.
     */
    public function amount(float $currency, ?float $local = null): self
    {
        $this->data['dSumaV'] = $currency;
        $this->data['dSumaL'] = $local ?? $currency;

        return $this;
    }

    /**
     * Set VAT details.
     *
     * @param  float  $percent  VAT percentage (dPVM_Procentas)
     * @param  float|null  $amount  VAT amount in currency (dSumaPVMV)
     * @param  float|null  $amountLocal  VAT amount in EUR (dSumaPVML)
     */
    public function vat(float $percent, ?float $amount = null, ?float $amountLocal = null): self
    {
        $this->data['dPVM_Procentas'] = $percent;

        if ($amount !== null) {
            $this->data['dSumaPVMV'] = $amount;
            $this->data['dSumaPVML'] = $amountLocal ?? $amount;
        }

        return $this;
    }

    /**
     * Set discount details.
     *
     * @param  float|null  $percent  Discount percentage (dNlProc)
     * @param  float|null  $amount  Discount amount in currency (dSumaNV)
     * @param  float|null  $amountLocal  Discount amount in EUR (dSumaNL)
     */
    public function discount(?float $percent = null, ?float $amount = null, ?float $amountLocal = null): self
    {
        if ($percent !== null) {
            $this->data['dNlProc'] = $percent;
        }

        if ($amount !== null) {
            $this->data['dSumaNV'] = $amount;
            $this->data['dSumaNL'] = $amountLocal ?? $amount;
        }

        return $this;
    }

    /**
     * Set a single analytical object by level (1-6).
     */
    public function object(int $level, string $code): self
    {
        $this->data["sObjektas{$level}"] = $code;

        return $this;
    }

    /**
     * Set multiple analytical objects at once, keyed by level.
     *
     * @param  array<int, string>  $map  e.g. [1 => 'DEPT01', 4 => '1234567']
     */
    public function objects(array $map): self
    {
        foreach ($map as $level => $code) {
            $this->data["sObjektas{$level}"] = $code;
        }

        return $this;
    }

    /**
     * Set the description/additional info text (sPapInf).
     */
    public function description(string $text): self
    {
        $this->data['sPapInf'] = $text;

        return $this;
    }

    /**
     * Set the VAT tax code (sPvmKodas).
     */
    public function vatCode(string $code): self
    {
        $this->data['sPvmKodas'] = $code;

        return $this;
    }

    /**
     * Use first measurement unit for quantity (nPirmasMat=1).
     */
    public function firstMeasurement(bool $flag = true): self
    {
        $this->data['nPirmasMat'] = $flag ? 1 : 0;

        return $this;
    }

    /**
     * Set additional info text (sPapInf).
     */
    public function info(string $text): self
    {
        $this->data['sPapInf'] = $text;

        return $this;
    }

    /**
     * Set the line marked flag (nPozymis).
     */
    public function marked(bool $flag = true): self
    {
        $this->data['nPozymis'] = $flag ? 1 : 0;

        return $this;
    }

    /**
     * Set a raw API field directly. Escape hatch for fields not covered by named methods.
     */
    public function set(string $key, mixed $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Convert to the raw API array format.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
