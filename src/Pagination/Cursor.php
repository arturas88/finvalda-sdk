<?php

declare(strict_types=1);

namespace Finvalda\Pagination;

use DateTimeImmutable;
use DateTimeInterface;
use Generator;
use InvalidArgumentException;

/**
 * Cursor-based pagination helper using modifiedSince dates.
 *
 * @template T
 */
final class Cursor
{
    private ?DateTimeInterface $modifiedSince = null;

    private ?DateTimeInterface $createdSince = null;

    private int $pageSize = 100;

    private int $maxIterations = 1000;

    /**
     * @param  callable(DateTimeInterface|null, DateTimeInterface|null): array<int, T>  $fetcher
     * @param  callable(T): DateTimeInterface|null  $dateExtractor
     */
    public function __construct(
        private readonly mixed $fetcher,
        private readonly mixed $dateExtractor,
    ) {}

    /**
     * Set the initial modifiedSince date.
     */
    public function modifiedSince(DateTimeInterface|string|null $date): self
    {
        if ($date === null) {
            $this->modifiedSince = null;
        } elseif (is_string($date)) {
            $this->modifiedSince = new DateTimeImmutable($date);
        } else {
            $this->modifiedSince = $date;
        }

        return $this;
    }

    /**
     * Set the initial createdSince date.
     */
    public function createdSince(DateTimeInterface|string|null $date): self
    {
        if ($date === null) {
            $this->createdSince = null;
        } elseif (is_string($date)) {
            $this->createdSince = new DateTimeImmutable($date);
        } else {
            $this->createdSince = $date;
        }

        return $this;
    }

    /**
     * Set the page size (used to determine when to stop paginating).
     */
    public function pageSize(int $size): self
    {
        if ($size < 1) {
            throw new InvalidArgumentException('Page size must be at least 1');
        }
        $this->pageSize = $size;

        return $this;
    }

    /**
     * Set the maximum number of iterations to prevent infinite loops.
     */
    public function maxIterations(int $max): self
    {
        if ($max < 1) {
            throw new InvalidArgumentException('Max iterations must be at least 1');
        }
        $this->maxIterations = $max;

        return $this;
    }

    /**
     * Iterate through all pages.
     *
     * @return Generator<int, T>
     */
    public function getIterator(): Generator
    {
        $modifiedSince = $this->modifiedSince;
        $seenIds = [];
        $iteration = 0;

        while ($iteration < $this->maxIterations) {
            $items = ($this->fetcher)($modifiedSince, $this->createdSince);

            if (empty($items)) {
                break;
            }

            $newItems = 0;
            $lastDate = null;

            foreach ($items as $item) {
                $id = spl_object_hash((object) $item);

                // Skip duplicates from overlapping date ranges
                if (isset($seenIds[$id])) {
                    continue;
                }

                $seenIds[$id] = true;
                $newItems++;
                $lastDate = ($this->dateExtractor)($item);
                yield $item;
            }

            // Stop if we got fewer items than expected (last page)
            if (count($items) < $this->pageSize) {
                break;
            }

            // Stop if no new items (all duplicates)
            if ($newItems === 0) {
                break;
            }

            // Advance cursor to the last item's date
            if ($lastDate !== null) {
                $modifiedSince = $lastDate;
            } else {
                break;
            }

            $iteration++;
        }
    }

    /**
     * Get all items as an array.
     *
     * @return array<int, T>
     */
    public function all(): array
    {
        return iterator_to_array($this->getIterator(), false);
    }

    /**
     * Get the first item.
     *
     * @return T|null
     */
    public function first(): mixed
    {
        foreach ($this->getIterator() as $item) {
            return $item;
        }

        return null;
    }

    /**
     * Count all items (consumes the iterator).
     */
    public function count(): int
    {
        return count($this->all());
    }

    /**
     * Execute a callback for each item.
     *
     * @param  callable(T): void  $callback
     */
    public function each(callable $callback): void
    {
        foreach ($this->getIterator() as $item) {
            $callback($item);
        }
    }

    /**
     * Take only the first N items.
     *
     * @return array<int, T>
     */
    public function take(int $limit): array
    {
        $result = [];
        $count = 0;

        foreach ($this->getIterator() as $item) {
            if ($count >= $limit) {
                break;
            }
            $result[] = $item;
            $count++;
        }

        return $result;
    }
}
