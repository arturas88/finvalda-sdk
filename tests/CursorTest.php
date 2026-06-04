<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use DateTimeImmutable;
use Finvalda\Pagination\Cursor;
use PHPUnit\Framework\TestCase;

class CursorTest extends TestCase
{
    public function test_yields_all_distinct_items_from_a_single_fetch(): void
    {
        $cursor = new Cursor(
            fetcher: fn () => [
                ['sKodas' => 'A', 'tKoregavimoData' => '2024-01-01'],
                ['sKodas' => 'B', 'tKoregavimoData' => '2024-01-02'],
                ['sKodas' => 'C', 'tKoregavimoData' => '2024-01-03'],
            ],
            dateExtractor: fn (array $item) => new DateTimeImmutable($item['tKoregavimoData']),
        );

        $items = $cursor->all();

        $this->assertCount(3, $items);
        $this->assertSame(['A', 'B', 'C'], array_column($items, 'sKodas'));
    }

    public function test_deduplicates_overlapping_items_across_fetches(): void
    {
        $pages = [
            [
                ['sKodas' => 'A', 'tKoregavimoData' => '2024-01-01'],
                ['sKodas' => 'B', 'tKoregavimoData' => '2024-01-02'],
            ],
            [
                // Overlap: B returned again because the cursor advanced to B's date
                ['sKodas' => 'B', 'tKoregavimoData' => '2024-01-02'],
                ['sKodas' => 'C', 'tKoregavimoData' => '2024-01-03'],
            ],
            [
                ['sKodas' => 'C', 'tKoregavimoData' => '2024-01-03'],
            ],
        ];
        $call = 0;

        $cursor = (new Cursor(
            fetcher: function () use (&$pages, &$call) {
                return $pages[$call++] ?? [];
            },
            dateExtractor: fn (array $item) => new DateTimeImmutable($item['tKoregavimoData']),
        ))->pageSize(2);

        $items = $cursor->all();

        $this->assertSame(['A', 'B', 'C'], array_column($items, 'sKodas'));
    }

    public function test_uses_custom_id_extractor_for_deduplication(): void
    {
        // Same code, different modification dates: with an id extractor keyed
        // on sKodas, the re-modified record must be treated as a duplicate.
        $pages = [
            [
                ['sKodas' => 'A', 'tKoregavimoData' => '2024-01-01'],
                ['sKodas' => 'B', 'tKoregavimoData' => '2024-01-02'],
            ],
            [
                ['sKodas' => 'B', 'tKoregavimoData' => '2024-01-05'],
            ],
        ];
        $call = 0;

        $cursor = (new Cursor(
            fetcher: function () use (&$pages, &$call) {
                return $pages[$call++] ?? [];
            },
            dateExtractor: fn (array $item) => new DateTimeImmutable($item['tKoregavimoData']),
            idExtractor: fn (array $item) => $item['sKodas'],
        ))->pageSize(2);

        $items = $cursor->all();

        $this->assertSame(['A', 'B'], array_column($items, 'sKodas'));
    }

    public function test_stops_when_fetch_returns_fewer_items_than_page_size(): void
    {
        $calls = 0;

        $cursor = (new Cursor(
            fetcher: function () use (&$calls) {
                $calls++;

                return [['sKodas' => 'A', 'tKoregavimoData' => '2024-01-01']];
            },
            dateExtractor: fn (array $item) => new DateTimeImmutable($item['tKoregavimoData']),
        ))->pageSize(100);

        $cursor->all();

        $this->assertSame(1, $calls);
    }

    public function test_first_returns_first_item_without_exhausting(): void
    {
        $cursor = new Cursor(
            fetcher: fn () => [
                ['sKodas' => 'A', 'tKoregavimoData' => '2024-01-01'],
                ['sKodas' => 'B', 'tKoregavimoData' => '2024-01-02'],
            ],
            dateExtractor: fn (array $item) => new DateTimeImmutable($item['tKoregavimoData']),
        );

        $this->assertSame('A', $cursor->first()['sKodas']);
    }
}
