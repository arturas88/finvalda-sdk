<?php

declare(strict_types=1);

namespace Finvalda\Collections;

use Finvalda\Data\Product;

/**
 * Typed collection of Product entities.
 *
 * @extends Collection<Product>
 */
final class ProductCollection extends Collection
{
    /**
     * @param  array<int, Product>  $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    public static function fromArray(array $data): static
    {
        return new self(array_map(
            fn (array $item) => Product::fromArray($item),
            $data
        ));
    }

    /**
     * Find a product by code.
     */
    public function findByCode(string $code): ?Product
    {
        foreach ($this->items as $product) {
            if ($product->code === $code) {
                return $product;
            }
        }

        return null;
    }

    /**
     * Find a product by barcode.
     */
    public function findByBarcode(string $barcode): ?Product
    {
        foreach ($this->items as $product) {
            if ($product->barcode === $barcode) {
                return $product;
            }
        }

        return null;
    }

    /**
     * Filter products by type.
     */
    public function whereType(string $type): self
    {
        return $this->filter(fn (Product $product) => $product->type === $type);
    }

    /**
     * Filter products by supplier.
     */
    public function whereSupplier(string $supplier): self
    {
        return $this->filter(fn (Product $product) => $product->supplier1 === $supplier
            || $product->supplier2 === $supplier
            || $product->supplier3 === $supplier
        );
    }

    /**
     * Filter products with quantity.
     */
    public function withStock(): self
    {
        return $this->filter(fn (Product $product) => $product->quantity !== null && $product->quantity > 0);
    }

    /**
     * Get products by tag.
     */
    public function whereTag(int $tagNumber, string $value): self
    {
        return $this->filter(function (Product $product) use ($tagNumber, $value) {
            return match ($tagNumber) {
                1 => $product->tag1 === $value,
                2 => $product->tag2 === $value,
                3 => $product->tag3 === $value,
                4 => $product->tag4 === $value,
                5 => $product->tag5 === $value,
                6 => $product->tag6 === $value,
                default => false,
            };
        });
    }
}
