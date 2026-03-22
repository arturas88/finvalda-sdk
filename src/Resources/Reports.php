<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Responses\Response;

/**
 * Invoice and report PDF generation, and auto-report retrieval.
 */
final class Reports extends Resource
{
    /**
     * Generate an invoice PDF. Calls MakeInvoice.
     *
     * @param  string  $param  Serialized parameter string identifying the operation to invoice
     * @return Response
     */
    public function makeInvoice(string $param): Response
    {
        return $this->http->get('MakeInvoice', [
            'sParam' => $param,
        ]);
    }

    /**
     * Generate a report PDF. Calls MakeReport.
     *
     * @param  string  $param  Serialized parameter string defining the report criteria
     * @return Response
     */
    public function makeReport(string $param): Response
    {
        return $this->http->get('MakeReport', [
            'sParam' => $param,
        ]);
    }

    /**
     * List all available auto-reports. Calls GetAutoReportsList.
     *
     * @return Response
     */
    public function autoReports(): Response
    {
        return $this->http->get('GetAutoReportsList');
    }

    /**
     * Get a specific auto-report by its filename. Calls GetAutoReport.
     *
     * @param  string  $fileName  The auto-report filename
     * @return Response
     */
    public function autoReport(string $fileName): Response
    {
        return $this->http->get('GetAutoReport', [
            'fileName' => $fileName,
        ]);
    }
}
