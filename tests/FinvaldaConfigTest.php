<?php

namespace Finvalda\Tests;

use Finvalda\FinvaldaConfig;
use PHPUnit\Framework\TestCase;

class FinvaldaConfigTest extends TestCase
{
    public function test_it_can_be_instantiated(): void
    {
        $config = new FinvaldaConfig(
            baseUrl: 'https://example.com',
            username: 'user',
            password: 'pass',
        );

        $this->assertSame('https://example.com', $config->baseUrl);
        $this->assertSame('user', $config->username);
        $this->assertSame('pass', $config->password);
    }
}
