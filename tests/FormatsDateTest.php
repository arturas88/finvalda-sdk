<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use DateTime;
use DateTimeImmutable;
use Finvalda\Concerns\FormatsDate;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
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

    public function test_it_passes_through_a_string_with_a_time_of_day(): void
    {
        $this->assertSame('2024-01-01T10:30:00', $this->formatDate('2024-01-01T10:30:00'));
        $this->assertSame('2024-01-01 10:30', $this->formatDate('2024-01-01 10:30'));
    }

    /**
     * @return array<string, array{string}>
     */
    public static function malformedDates(): array
    {
        return [
            'day first' => ['15/01/2024'],
            'slashes' => ['2024/01/31'],
            'no padding' => ['2024-1-5'],
            'impossible day' => ['2024-02-30'],
            'trailing junk' => ['2024-01-01x'],
            'empty' => [''],
        ];
    }

    #[DataProvider('malformedDates')]
    public function test_it_rejects_a_string_that_is_not_y_m_d(string $date): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->formatDate($date);
    }
}
