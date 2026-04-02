<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use DateTime;
use DateTimeImmutable;
use Finvalda\Concerns\FormatsDate;
use PHPUnit\Framework\TestCase;

class FormatsDateTest extends TestCase
{
    use FormatsDate;

    public function test_it_formats_datetime_interface(): void
    {
        $date = new DateTime('2024-03-15');

        $this->assertSame('2024-03-15', $this->formatDate($date));
    }

    public function test_it_formats_datetime_immutable(): void
    {
        $date = new DateTimeImmutable('2024-12-25');

        $this->assertSame('2024-12-25', $this->formatDate($date));
    }

    public function test_it_passes_through_string_dates(): void
    {
        $this->assertSame('2024-01-01', $this->formatDate('2024-01-01'));
    }

    public function test_it_returns_null_for_null(): void
    {
        $this->assertNull($this->formatDate(null));
    }
}
