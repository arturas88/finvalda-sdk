<?php

declare(strict_types=1);

namespace Finvalda\Tests;

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
}
