<?php

declare(strict_types=1);

namespace Finvalda\Collections;

use Finvalda\Data\Service;

/**
 * Typed collection of Service entities.
 *
 * @extends Collection<Service>
 */
final class ServiceCollection extends Collection
{
    /**
     * @param  array<int, Service>  $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    public static function fromArray(array $data): static
    {
        return new self(array_map(
            fn (array $item) => Service::fromArray($item),
            $data
        ));
    }

    /**
     * Find a service by code.
     */
    public function findByCode(string $code): ?Service
    {
        foreach ($this->items as $service) {
            if ($service->code === $code) {
                return $service;
            }
        }

        return null;
    }

    /**
     * Filter services by type.
     */
    public function whereType(string $type): self
    {
        return $this->filter(fn (Service $service) => $service->type === $type);
    }

    /**
     * Filter services by currency.
     */
    public function whereCurrency(string $currency): self
    {
        return $this->filter(fn (Service $service) => $service->currency === $currency);
    }

    /**
     * Get services by tag.
     */
    public function whereTag(int $tagNumber, string $value): self
    {
        return $this->filter(function (Service $service) use ($tagNumber, $value) {
            return match ($tagNumber) {
                1 => $service->tag1 === $value,
                2 => $service->tag2 === $value,
                3 => $service->tag3 === $value,
                default => false,
            };
        });
    }
}
