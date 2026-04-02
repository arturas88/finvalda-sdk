<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Responses\OperationResult;
use PHPUnit\Framework\TestCase;

class OperationResultTest extends TestCase
{
    public function test_successful_operation_result(): void
    {
        $result = new OperationResult(
            success: true,
            series: 'AA',
            document: 'SF-001',
            journal: 'PARD',
            number: 123,
        );

        $this->assertTrue($result->success);
        $this->assertSame('AA', $result->series);
        $this->assertSame('SF-001', $result->document);
        $this->assertSame('PARD', $result->journal);
        $this->assertSame(123, $result->number);
        $this->assertNull($result->error);
        $this->assertNull($result->errorCode);
    }

    public function test_failed_operation_result(): void
    {
        $result = new OperationResult(
            success: false,
            error: 'Validation failed',
            errorCode: 100,
        );

        $this->assertFalse($result->success);
        $this->assertSame('Validation failed', $result->error);
        $this->assertSame(100, $result->errorCode);
        $this->assertNull($result->series);
        $this->assertNull($result->document);
        $this->assertNull($result->journal);
        $this->assertNull($result->number);
    }
}
