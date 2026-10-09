<?php

declare(strict_types=1);

namespace Finvalda\Tests\Spec;

/**
 * Field index of the InsertNewOperation (§3.70) and UpdateOperation (§3.72)
 * envelopes, read straight from the spec tables in docs/FVS_Webservice.md.
 *
 * Parsed at test time rather than checked in as a fixture, so the index cannot
 * drift from the document it claims to mirror.
 */
final class OperationSpec
{
    /**
     * Fields the spec omits from a table but documents elsewhere. Every entry
     * must name where the field is documented; nothing here is guessed.
     */
    private const SUPPLEMENTS = [
        'insert' => [
            // The XML example under the Inventorizacija table (FVS_Webservice.md
            // §3.70) carries these on each item; the table lists only five fields.
            'Inventorizacija' => [
                'sSaskaita', 'sSandelioVieta',
                'sObjektas1', 'sObjektas2', 'sObjektas3', 'sObjektas4', 'sObjektas5', 'sObjektas6',
            ],
            // The Trumpas purchase table lists no operation date, while every
            // other operation (including TrumpasPardDok) requires tData.
            'TrumpasPirkDok' => ['tData'],
            // The nKiekis row of both service tables documents nPirmasMat ("arba
            // pirmu jei nurodyta nPirmasMat=1"), and the §3.72 service tables list
            // it as a column; the §3.70 column lists omit it.
            // sPavadinimas: not in the spec table. Kept on live evidence — commit
            // c776ca7 (v2.5.2) moved the service-line description from sPapInf to
            // sPavadinimas after a production UVMPardRezDok booking.
            'PardDokPaslaugaDetEil' => ['nPirmasMat', 'sPavadinimas'],
            // sPavadinimas on purchase lines: not in the spec tables. Kept on live
            // evidence — a 2026-10-09 TEST booking (PIRK/33655) stored it as the
            // line title on both a product and a service line.
            'PirkDokPrekeDetEil' => ['sPavadinimas'],
            'PirkDokPaslaugaDetEil' => ['nPirmasMat', 'sPavadinimas'],
            'TrumpasPirkUzsDok' => ['tData'],
            'TrumpasPirkGrazDok' => ['tData'],
            'TrumpasUVMPirkUzsDok' => ['tData'],
        ],
        'update' => [],
    ];

    /**
     * Envelope names the tables spell differently from the ItemClassName list.
     * The §3.70 ItemClassName list says TrumpasUVMPardRezDok; the table heading
     * says TrumpasUVMPardRDok.
     */
    private const ALIASES = [
        'insert' => ['TrumpasUVMPardRezDok' => 'TrumpasUVMPardRDok'],
        'update' => [],
    ];

    /** @var array<string, array<string, list<string>>>|null */
    private static ?array $index = null;

    /**
     * @return list<string>|null  Null when the spec has no such envelope
     */
    public static function fields(string $section, string $envelope): ?array
    {
        $index = self::index();
        $envelope = self::ALIASES[$section][$envelope] ?? $envelope;

        if (! isset($index[$section][$envelope])) {
            return null;
        }

        return $index[$section][$envelope];
    }

    /**
     * @return array<string, array<string, list<string>>>
     */
    private static function index(): array
    {
        if (self::$index !== null) {
            return self::$index;
        }

        $lines = file(dirname(__DIR__, 2) . '/docs/FVS_Webservice.md', FILE_IGNORE_NEW_LINES) ?: [];

        self::$index = [
            'insert' => self::parse($lines, '## 3.70.', '## 3.71.'),
            'update' => self::parse($lines, '## 3.72.', '## 3.73.'),
        ];

        foreach (self::SUPPLEMENTS as $section => $envelopes) {
            foreach ($envelopes as $envelope => $fields) {
                self::$index[$section][$envelope] = array_values(array_unique(
                    array_merge(self::$index[$section][$envelope] ?? [], $fields)
                ));
            }
        }

        return self::$index;
    }

    /**
     * A table belongs to the envelopes named by the nearest heading above it:
     * `#### A, B` in §3.70, `**A, B**` in §3.72.
     *
     * @param  list<string>  $lines
     * @return array<string, list<string>>
     */
    private static function parse(array $lines, string $from, string $to): array
    {
        $envelopes = [];
        $result = [];
        $inside = false;

        foreach ($lines as $line) {
            if (str_starts_with($line, $from)) {
                $inside = true;

                continue;
            }

            if (! $inside) {
                continue;
            }

            if (str_starts_with($line, $to)) {
                break;
            }

            if (preg_match('/^(?:#{3,4}\s+|\*{2,3})(.+?)\**$/', $line, $m)) {
                $envelopes = [];

                foreach (explode(',', preg_replace('/\(.*?\)/', '', str_replace(['*', '\\'], '', $m[1]))) as $name) {
                    $name = trim($name, " <>\t");

                    if (preg_match('/^[A-Za-z]+$/', $name)) {
                        $envelopes[] = $name;
                    }
                }

                continue;
            }

            if ($envelopes === [] || ! str_starts_with($line, '|')) {
                continue;
            }

            $cells = array_map('trim', explode('|', trim($line, '|')));
            $field = trim(str_replace(['\\', '*', '`'], '', $cells[1] ?? ''));

            if (! preg_match('/^[sndtb][A-Z][A-Za-z0-9_]*$/', $field)) {
                continue;
            }

            foreach ($envelopes as $envelope) {
                $result[$envelope][] = $field;
            }
        }

        return array_map(fn (array $fields): array => array_values(array_unique($fields)), $result);
    }
}
