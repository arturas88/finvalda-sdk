<?php

declare(strict_types=1);

namespace Finvalda\Tests;

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
}
