<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Concerns\DecodesBinaryResponse;
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Responses\Response;

/**
 * Invoice and report PDF generation, and auto-report retrieval.
 */
final class Reports extends Resource
{
    use DecodesBinaryResponse;

    /**
     * Generate an invoice PDF envelope. Calls MakeInvoice.
     *
     * @param  array<string, mixed>|string  $param  Invoice parameters, or a pre-encoded XML/JSON string
     *
     * @throws \JsonException
     */
    public function makeInvoice(array|string $param): Response
    {
        return $this->http->get('MakeInvoice', [
            'sParam' => $this->encodeReportParams($param),
        ]);
    }

    /**
     * Generate an invoice PDF and return the decoded binary contents.
     *
     * @param  array<string, mixed>|string  $param
     *
     * @throws FinvaldaException
     * @throws \JsonException
     */
    public function makeInvoicePdf(array|string $param): string
    {
        return $this->decodeBinaryResponse($this->makeInvoice($param), 'MakeInvoice');
    }

    /**
     * Generate a report PDF envelope. Calls MakeReport.
     *
     * @param  array<string, mixed>|string  $param  Report parameters, or a pre-encoded XML/JSON string
     *
     * @throws \JsonException
     */
    public function makeReport(array|string $param): Response
    {
        return $this->http->get('MakeReport', [
            'sParam' => $this->encodeReportParams($param),
        ]);
    }

    /**
     * Generate a report PDF and return the decoded binary contents.
     *
     * @param  array<string, mixed>|string  $param
     *
     * @throws FinvaldaException
     * @throws \JsonException
     */
    public function makeReportPdf(array|string $param): string
    {
        return $this->decodeBinaryResponse($this->makeReport($param), 'MakeReport');
    }

    /**
     * List all available auto-reports. Calls GetAutoReportsList.
     */
    public function autoReports(): Response
    {
        return $this->http->get('GetAutoReportsList');
    }

    /**
     * Get a specific auto-report envelope by filename. Calls GetAutoReport.
     */
    public function autoReport(string $fileName): Response
    {
        return $this->http->get('GetAutoReport', [
            'fileName' => $fileName,
        ]);
    }

    /**
     * Get a specific auto-report and return the decoded binary contents.
     *
     * @throws FinvaldaException
     */
    public function autoReportPdf(string $fileName): string
    {
        return $this->decodeBinaryResponse($this->autoReport($fileName), 'GetAutoReport');
    }

    /**
     * @param  array<string, mixed>|string  $param
     *
     * @throws \JsonException
     */
    private function encodeReportParams(array|string $param): string
    {
        if (is_string($param)) {
            return $param;
        }

        return $this->jsonEncode($param);
    }
}
