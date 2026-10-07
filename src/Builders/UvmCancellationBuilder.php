<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\SetsDocumentNumber;
use Finvalda\Builders\Concerns\SetsEmployee;
use Finvalda\Builders\Concerns\SetsMarked;
use Finvalda\Builders\Concerns\SetsName;
use Finvalda\Builders\Concerns\SetsNote;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for UVM cancellation operations (UVMAnulDok).
 *
 * UVM cancellation operations cancel previously created UVM documents
 * by referencing their journal and number.
 *
 * Usage:
 * ```php
 * $result = $finvalda->uvmCancellation()
 *     ->date('2024-01-15')
 *     ->name('Cancel reservation')
 *     ->documentNumber('ANUL-001')
 *     ->addCancellation(journal: 'UVMPARD', number: 123)
 *     ->addCancellation(journal: 'UVMPARD', number: 124)
 *     ->save('CANCEL');
 * ```
 */
final class UvmCancellationBuilder extends OperationBuilder
{
    use SetsDocumentNumber;
    use SetsEmployee;
    use SetsMarked;
    use SetsName;
    use SetsNote;

    /** @var array<int, array<string, mixed>> */
    protected array $cancellations = [];

    public function getOperationClass(): OperationClass
    {
        return OperationClass::UvmCancellation;
    }

    protected function lineMethodHint(): string
    {
        return 'addCancellation()';
    }

    /**
     * Build the complete operation data array.
     *
     * Cancellation rows are nested inside the UVMAnulDok wrapper, matching
     * the docs XML example.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $payload = $this->header;

        if (! empty($this->cancellations)) {
            $payload['UVMAnulDokDetEil'] = $this->cancellations;
        }

        return [$this->getHeaderKey() => $payload];
    }

    // --- UVM cancellation-specific methods ---

    /**
     * Add a cancellation reference to an existing UVM operation.
     */
    public function addCancellation(string $journal, int $number): self
    {
        $this->cancellations[] = [
            'sZurnalas' => $journal,
            'nNumeris' => $number,
        ];

        return $this;
    }
}
