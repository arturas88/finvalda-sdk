<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\ServiceTypeId;
use Finvalda\Exceptions\NotFoundException;
use Finvalda\Resources\Services;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\TestCase;

class ServicesTest extends TestCase
{
    use CreatesMockHttpClient;

    public function test_find_throws_not_found_when_entity_envelope_is_null(): void
    {
        $services = new Services($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'error' => '',
                'Fvs.Paslauga' => null,
            ]),
        ]));

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage("Service 'PAS_01' not found");

        $services->find('PAS_01');
    }

    public function test_find_unwraps_entity_envelope_into_populated_dto(): void
    {
        $services = new Services($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'error' => '',
                'Fvs.Paslauga' => [
                    'sKodas' => 'PAS_01',
                    'sPavadinimas' => 'Pirma paslauga',
                ],
            ]),
        ]));

        $service = $services->find('PAS_01');

        $this->assertSame('PAS_01', $service->code);
        $this->assertSame('Pirma paslauga', $service->name);
    }

    public function test_types_and_tags_filters_by_non_sequential_tipas_and_does_not_send_nid(): void
    {
        $history = [];
        $services = new Services($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => [
                ['tipas' => 18, 'kodas' => 'R1', 'pavadinimas' => 'Type'],
                ['tipas' => 15, 'kodas' => 'T1', 'pavadinimas' => 'Tag1'],
                ['tipas' => 16, 'kodas' => 'T2', 'pavadinimas' => 'Tag2'],
            ]]),
        ], $history));

        $this->assertSame(['R1'], $services->typesAndTags(ServiceTypeId::Type)->pluck('code'));
        $this->assertSame(['T1'], $services->typesAndTags(ServiceTypeId::Tag1)->pluck('code'));
        $this->assertSame([18, 15, 16], $services->allTypesAndTags()->types());

        $this->assertCount(1, $history);
        parse_str($history[0]['request']->getUri()->getQuery(), $query);
        $this->assertSame('GetPaslauguRusisPozymius', basename($history[0]['request']->getUri()->getPath()));
        $this->assertArrayNotHasKey('nID', $query);
    }
}
