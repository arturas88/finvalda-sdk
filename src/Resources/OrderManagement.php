<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Responses\Response;

/**
 * UVM (Order Management Module) - sales reservations and order tracking.
 */
final class OrderManagement extends Resource
{
    /**
     * Get sales reservation status by journal and number. Calls GetUVMPardRBusena.
     *
     * @param  string  $journal  Journal code
     * @param  int  $number  Operation number within the journal
     * @return Response  Status codes: 0=new, 1=preparing, 2=executing, 3=completed, 4=cancelled, 5=collected
     */
    public function salesReservationStatus(string $journal, int $number): Response
    {
        return $this->http->get('GetUVMPardRBusena', [
            'sZurnalas' => $journal,
            'nNumeris' => $number,
        ]);
    }

    /**
     * Get completed (fulfilled) sales reservations. Calls GetUVMPardRIvykdyti.
     *
     * @param  string|null  $journalGroup  Filter by journal group code
     * @param  string|null  $dateFrom  Date in Y-m-d format, period start
     * @param  string|null  $dateTo  Date in Y-m-d format, period end
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function completedReservations(
        ?string $journalGroup = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetUVMPardRIvykdyti', [
            'sZurnaluGrupe' => $journalGroup,
            'tDataNuo' => $dateFrom,
            'tDataIki' => $dateTo,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get pending (unfulfilled) sales reservations. Calls GetUVMPardRNeivykdyti.
     *
     * @param  string|null  $journalGroup  Filter by journal group code
     * @param  string|null  $dateFrom  Date in Y-m-d format, period start
     * @param  string|null  $dateTo  Date in Y-m-d format, period end
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function pendingReservations(
        ?string $journalGroup = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetUVMPardRNeivykdyti', [
            'sZurnaluGrupe' => $journalGroup,
            'tDataNuo' => $dateFrom,
            'tDataIki' => $dateTo,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get cancelled sales reservations. Calls GetUVMPardRAnuliuoti.
     *
     * @param  string|null  $journalGroup  Filter by journal group code
     * @param  string|null  $dateFrom  Date in Y-m-d format, period start
     * @param  string|null  $dateTo  Date in Y-m-d format, period end
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function cancelledReservations(
        ?string $journalGroup = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetUVMPardRAnuliuoti', [
            'sZurnaluGrupe' => $journalGroup,
            'tDataNuo' => $dateFrom,
            'tDataIki' => $dateTo,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get products from sales reservations (ordered products). Calls GetUVMPardRUzsakytosPrekes.
     *
     * @param  string|null  $journalGroup  Filter by journal group code
     * @param  string|null  $dateFrom  Date in Y-m-d format, period start
     * @param  string|null  $dateTo  Date in Y-m-d format, period end
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function orderedProducts(
        ?string $journalGroup = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetUVMPardRUzsakytosPrekes', [
            'sZurnaluGrupe' => $journalGroup,
            'tDataNuo' => $dateFrom,
            'tDataIki' => $dateTo,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }
}
