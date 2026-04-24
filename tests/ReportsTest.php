<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Exceptions\FinvaldaException;
use Finvalda\FinvaldaConfig;
use Finvalda\HttpClient;
use Finvalda\Resources\Reports;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PHPUnit\Framework\TestCase;

class ReportsTest extends TestCase
{
    private function createReports(array $responses, array &$history = []): Reports
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push(Middleware::history($history));
        $guzzle = new Client(['handler' => $handlerStack]);

        $config = new FinvaldaConfig(
            baseUrl: 'https://example.com',
            username: 'user',
            password: 'pass',
        );

        return new Reports(new HttpClient($config, $guzzle));
    }

    public function test_make_invoice_keeps_legacy_response_shape(): void
    {
        $pdf = '%PDF-1.4 invoice';
        $reports = $this->createReports([
            new GuzzleResponse(200, [], json_encode([
                'AccessResult' => 'Success',
                'error' => '',
                'fileContents' => base64_encode($pdf),
            ], JSON_THROW_ON_ERROR)),
        ]);

        $response = $reports->makeInvoice('{"FakturosKodas":"PARD_01"}');

        $this->assertTrue($response->successful());
        $this->assertSame(base64_encode($pdf), $response->data['fileContents']);
    }

    public function test_make_invoice_pdf_accepts_array_params_and_returns_binary_contents(): void
    {
        $history = [];
        $pdf = '%PDF-1.4 invoice';
        $reports = $this->createReports([
            new GuzzleResponse(200, [], json_encode([
                'AccessResult' => 'Success',
                'error' => '',
                'fileContents' => base64_encode($pdf),
            ], JSON_THROW_ON_ERROR)),
        ], $history);

        $contents = $reports->makeInvoicePdf([
            'FakturosKodas' => 'PARD_01',
            'sZurnalas' => '$PARD.',
            'nNumeris' => 45151,
        ]);

        $this->assertSame($pdf, $contents);

        parse_str($history[0]['request']->getUri()->getQuery(), $query);
        $this->assertSame('MakeInvoice', basename($history[0]['request']->getUri()->getPath()));
        $this->assertSame([
            'FakturosKodas' => 'PARD_01',
            'sZurnalas' => '$PARD.',
            'nNumeris' => 45151,
        ], json_decode($query['sParam'], true, flags: JSON_THROW_ON_ERROR));
    }

    public function test_make_report_pdf_returns_binary_contents(): void
    {
        $pdf = '%PDF-1.4 report';
        $reports = $this->createReports([
            new GuzzleResponse(200, [], json_encode([
                'AccessResult' => 'Success',
                'error' => '',
                'fileContents' => base64_encode($pdf),
            ], JSON_THROW_ON_ERROR)),
        ]);

        $contents = $reports->makeReportPdf([
            'code' => 'PARDSAR_01',
            'DateFrom' => '2024-01-01',
            'DateTo' => '2024-01-31',
        ]);

        $this->assertSame($pdf, $contents);
    }

    public function test_auto_report_pdf_returns_binary_contents(): void
    {
        $pdf = '%PDF-1.4 auto report';
        $reports = $this->createReports([
            new GuzzleResponse(200, [], json_encode([
                'AccessResult' => 'Success',
                'error' => '',
                'fileContents' => base64_encode($pdf),
            ], JSON_THROW_ON_ERROR)),
        ]);

        $this->assertSame($pdf, $reports->autoReportPdf('sales.pdf'));
    }

    public function test_make_invoice_pdf_throws_for_failed_response(): void
    {
        $reports = $this->createReports([
            new GuzzleResponse(200, [], json_encode([
                'AccessResult' => 'Fail',
                'error' => 'Invoice template not found',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $this->expectException(FinvaldaException::class);
        $this->expectExceptionMessage('MakeInvoice failed: Invoice template not found');

        $reports->makeInvoicePdf(['FakturosKodas' => 'BAD']);
    }

    public function test_make_invoice_pdf_throws_when_file_contents_are_missing(): void
    {
        $reports = $this->createReports([
            new GuzzleResponse(200, [], json_encode([
                'AccessResult' => 'Success',
                'error' => '',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $this->expectException(FinvaldaException::class);
        $this->expectExceptionMessage('MakeInvoice did not contain fileContents');

        $reports->makeInvoicePdf(['FakturosKodas' => 'PARD_01']);
    }
}
