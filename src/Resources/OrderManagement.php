<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
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
     * @param  DateTimeInterface|string|null  $dateFrom  Period start
     * @param  DateTimeInterface|string|null  $dateTo  Period end
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function completedReservations(
        ?string $journalGroup = null,
        DateTimeInterface|string|null $dateFrom = null,
        DateTimeInterface|string|null $dateTo = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->reservations('GetUVMPardRIvykdyti', $journalGroup, $dateFrom, $dateTo, $modifiedSince, $createdSince);
    }

    /**
     * Get pending (unfulfilled) sales reservations. Calls GetUVMPardRNeivykdyti.
     *
     * @param  string|null  $journalGroup  Filter by journal group code
     * @param  DateTimeInterface|string|null  $dateFrom  Period start
     * @param  DateTimeInterface|string|null  $dateTo  Period end
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function pendingReservations(
        ?string $journalGroup = null,
        DateTimeInterface|string|null $dateFrom = null,
        DateTimeInterface|string|null $dateTo = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->reservations('GetUVMPardRNeivykdyti', $journalGroup, $dateFrom, $dateTo, $modifiedSince, $createdSince);
    }

    /**
     * Get cancelled sales reservations. Calls GetUVMPardRAnuliuoti.
     *
     * @param  string|null  $journalGroup  Filter by journal group code
     * @param  DateTimeInterface|string|null  $dateFrom  Period start
     * @param  DateTimeInterface|string|null  $dateTo  Period end
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function cancelledReservations(
        ?string $journalGroup = null,
        DateTimeInterface|string|null $dateFrom = null,
        DateTimeInterface|string|null $dateTo = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->reservations('GetUVMPardRAnuliuoti', $journalGroup, $dateFrom, $dateTo, $modifiedSince, $createdSince);
    }

    /**
     * Get products from sales reservations (ordered products). Calls GetUVMPardRUzsakytosPrekes.
     *
     * Not in the API document; parameters assumed to match its three siblings.
     *
     * @param  string|null  $journalGroup  Filter by journal group code
     * @param  DateTimeInterface|string|null  $dateFrom  Period start
     * @param  DateTimeInterface|string|null  $dateTo  Period end
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function orderedProducts(
        ?string $journalGroup = null,
        DateTimeInterface|string|null $dateFrom = null,
        DateTimeInterface|string|null $dateTo = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->reservations('GetUVMPardRUzsakytosPrekes', $journalGroup, $dateFrom, $dateTo, $modifiedSince, $createdSince);
    }

    /**
     * The UVM reservation reads share one signature:
     * (string sZurnaluGrupe, DateTime tNuo, DateTime tIki, DateTime tKoregavimoData, DateTime tSukurimoData).
     */
    private function reservations(
        string $endpoint,
        ?string $journalGroup,
        DateTimeInterface|string|null $dateFrom,
        DateTimeInterface|string|null $dateTo,
        DateTimeInterface|string|null $modifiedSince,
        DateTimeInterface|string|null $createdSince,
    ): Response {
        return $this->http->get($endpoint, [
            'sZurnaluGrupe' => $journalGroup,
            'tNuo' => $this->formatDate($dateFrom),
            'tIki' => $this->formatDate($dateTo),
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }
}
