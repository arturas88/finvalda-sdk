<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Exceptions\OperationFailedException;
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

    public function test_throw_returns_a_successful_result_unchanged(): void
    {
        $result = new OperationResult(success: true, journal: 'PARD', number: 1);

        $this->assertSame($result, $result->throw());
    }

    public function test_throw_raises_an_operation_failed_exception_carrying_the_code(): void
    {
        $result = new OperationResult(
            success: false,
            journal: 'PARD',
            number: 7,
            error: 'Operacija užrakinta',
            errorCode: 4002,
        );

        try {
            $result->throw();
            $this->fail('Expected OperationFailedException');
        } catch (OperationFailedException $e) {
            $this->assertSame('Operacija užrakinta', $e->getMessage());
            $this->assertSame(4002, $e->errorCode);
            $this->assertSame(4002, $e->getCode());
            $this->assertSame('PARD', $e->journal);
            $this->assertSame(7, $e->number);
        }
    }

    public function test_throw_has_a_message_when_the_server_gave_none(): void
    {
        $result = new OperationResult(success: false, errorCode: 5);

        $this->expectException(OperationFailedException::class);
        $this->expectExceptionMessage('Finvalda operation failed (code 5)');

        $result->throw();
    }
}
