<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Resources\Clients;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\TestCase;

class ClientsTest extends TestCase
{
    use CreatesMockHttpClient;

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
