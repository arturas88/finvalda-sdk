<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\ClientTypeId;
use Finvalda\Exceptions\NotFoundException;
use Finvalda\Resources\Clients;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\TestCase;

class ClientsTest extends TestCase
{
    use CreatesMockHttpClient;

    public function test_find_throws_not_found_when_entity_envelope_is_null(): void
    {
        $clients = new Clients($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'error' => '',
                'Fvs.Klientas' => null,
            ]),
        ]));

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage("Client 'KLI_01' not found");

        $clients->find('KLI_01');
    }

    public function test_find_unwraps_entity_envelope_into_populated_dto(): void
    {
        $clients = new Clients($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'error' => '',
                'Fvs.Klientas' => [
                    'sKodas' => 'KLI_01',
                    'sPavadinimas' => 'Pirmas klientas',
                ],
            ]),
        ]));

        $client = $clients->find('KLI_01');

        $this->assertSame('KLI_01', $client->code);
        $this->assertSame('Pirmas klientas', $client->name);
    }

    public function test_find_by_email_sends_email_as_sEMail_query_param(): void
    {
        $history = [];
        $clients = new Clients($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $clients->findByEmail('client@example.com');

        parse_str($history[0]['request']->getUri()->getQuery(), $query);
        $this->assertSame('GetKlientasEMail', basename($history[0]['request']->getUri()->getPath()));
        $this->assertSame('client@example.com', $query['sEMail']);
        $this->assertArrayNotHasKey('sKliKod', $query);
    }

    public function test_types_and_tags_filters_by_non_sequential_tipas_and_does_not_send_nid(): void
    {
        $history = [];
        $clients = new Clients($this->createHttpClient([
            // One response only: filtered + grouped reads share this cached call.
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => [
                ['tipas' => 22, 'kodas' => 'R1', 'pavadinimas' => 'Type'],
                ['tipas' => 12, 'kodas' => 'T1', 'pavadinimas' => 'Tag1'],
                ['tipas' => 13, 'kodas' => 'T2', 'pavadinimas' => 'Tag2'],
            ]]),
        ], $history));

        $this->assertSame(['R1'], $clients->typesAndTags(ClientTypeId::Type)->pluck('code'));
        $this->assertSame(['T1'], $clients->typesAndTags(ClientTypeId::Tag1)->pluck('code'));
        $this->assertSame([22, 12, 13], $clients->allTypesAndTags()->types());

        $this->assertCount(1, $history);
        parse_str($history[0]['request']->getUri()->getQuery(), $query);
        $this->assertSame('GetKlientuRusisPozymius', basename($history[0]['request']->getUri()->getPath()));
        $this->assertArrayNotHasKey('nID', $query);
    }
}
