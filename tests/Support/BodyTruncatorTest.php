<?php

declare(strict_types=1);

namespace Finvalda\Tests\Support;

use Finvalda\Support\BodyTruncator;
use PHPUnit\Framework\TestCase;

class BodyTruncatorTest extends TestCase
{
    public function test_it_never_cuts_inside_a_multibyte_character(): void
    {
        // 'ą' is two bytes in UTF-8, so an odd budget lands mid-character.
        $body = str_repeat('ą', 10);

        $truncated = (string) BodyTruncator::truncate($body, 7);

        $this->assertTrue(mb_check_encoding($truncated, 'UTF-8'));
        $this->assertSame('ąąą... [truncated 14 bytes]', $truncated);
    }

    public function test_it_returns_a_body_within_the_budget_unchanged(): void
    {
        $body = str_repeat('ą', 10);

        $this->assertSame($body, BodyTruncator::truncate($body, 20));
        $this->assertSame($body, BodyTruncator::truncate($body, 21));
    }

    public function test_it_cuts_an_ascii_body_at_exactly_the_budget(): void
    {
        $this->assertSame('aaaaa... [truncated 3 bytes]', BodyTruncator::truncate(str_repeat('a', 8), 5));
    }

    public function test_it_passes_null_through(): void
    {
        $this->assertNull(BodyTruncator::truncate(null, 5));
    }
}
