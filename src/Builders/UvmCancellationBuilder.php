<?php

declare(strict_types=1);

namespace Finvalda\Builders;

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
    /** @var array<int, array<string, mixed>> */
    protected array $cancellations = [];

    public function getOperationClass(): OperationClass
    {
        return OperationClass::UvmCancellation;
    }

    protected function getHeaderKey(): string
    {
        return 'UVMAnulDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'UVMAnulDokDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        // Cancellations don't have service lines
        return 'UVMAnulDokPaslaugaDetEil';
    }

    /**
     * Build the complete operation data array.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $data = [];

        if (! empty($this->header)) {
            $data[$this->getHeaderKey()] = $this->header;
        }

        if (! empty($this->cancellations)) {
            $data['UVMAnulDokDetEil'] = $this->cancellations;
        }

        return $data;
    }

    // --- UVM cancellation-specific methods ---

    /**
     * Set the operation name/title.
     */
    public function name(string $name): self
    {
        $this->header['sPavadinimas'] = $name;

        return $this;
    }

    /**
     * Set a note/comment.
     */
    public function note(string $note): self
    {
        $this->header['sPastaba'] = $note;

        return $this;
    }

    /**
     * Set the employee name.
     */
    public function employee(string $name): self
    {
        $this->header['sDarbuotojas'] = $name;

        return $this;
    }

    /**
     * Set the marked/flagged status.
     */
    public function marked(bool $marked = true): self
    {
        $this->header['nPozymis'] = $marked ? 1 : 0;

        return $this;
    }

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
