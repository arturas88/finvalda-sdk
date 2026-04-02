<?php

declare(strict_types=1);

namespace Finvalda\Collections;

use Finvalda\Data\Client;

/**
 * Typed collection of Client entities.
 *
 * @extends Collection<Client>
 */
final class ClientCollection extends Collection
{
    /**
     * @param  array<int, Client>  $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    public static function fromArray(array $data): static
    {
        return new self(array_map(
            fn (array $item) => Client::fromArray($item),
            $data
        ));
    }

    /**
     * Find a client by code.
     */
    public function findByCode(string $code): ?Client
    {
        foreach ($this->items as $client) {
            if ($client->code === $code) {
                return $client;
            }
        }

        return null;
    }

    /**
     * Filter clients by type.
     */
    public function whereType(string $type): self
    {
        return $this->filter(fn (Client $client) => $client->type === $type);
    }

    /**
     * Filter clients with debt.
     */
    public function withDebt(): self
    {
        return $this->filter(fn (Client $client) => $client->debt !== null && $client->debt > 0);
    }

    /**
     * Get total debt across all clients.
     */
    public function totalDebt(): float
    {
        return array_sum(array_map(
            fn (Client $client) => $client->debt ?? 0,
            $this->items
        ));
    }
}
