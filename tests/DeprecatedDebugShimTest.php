<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Finvalda;
use Finvalda\FinvaldaConfig;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * v3's debug mode is gone; setDebug()/getLastDebugInfo() remain as deprecated
 * shims over recording, so callers that guard them with method_exists() keep
 * their debug output, in the v3 shape plus the recording's extra keys.
 */
class DeprecatedDebugShimTest extends TestCase
{
    use CreatesMockHttpClient;

    public function test_get_last_debug_info_returns_the_v3_shape_from_the_recording(): void
    {
        $http = $this->createHttpClient([$this->jsonResponse(['AccessResult' => 'Success', 'items' => []])]);

        $http->setDebug(true);
        $http->get('GetSandelius', ['sKodas' => 'A']);
        $info = $http->getLastDebugInfo();

        $this->assertSame('GET', $info['request']['method']);
        $this->assertStringContainsString('GetSandelius?sKodas=A', $info['request']['url']);
        $this->assertSame(200, $info['response']['status_code']);
        $this->assertStringContainsString('AccessResult', (string) $info['response']['body']);
        $this->assertArrayHasKey('request_id', $info);
    }

    public function test_before_any_request_it_returns_empty_halves_like_v3(): void
    {
        $http = $this->createHttpClient([]);
        $http->setDebug(true);

        $this->assertSame(['request' => [], 'response' => []], $http->getLastDebugInfo());
    }

    public function test_it_does_not_shrink_or_stop_a_recording_the_caller_started(): void
    {
        $http = $this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success']),
            $this->jsonResponse(['AccessResult' => 'Success']),
        ]);

        $http->record(10);
        $http->setDebug(true);
        $http->get('GetA');
        $http->get('GetB');
        $http->setDebug(false);

        $this->assertCount(2, $http->recordings());
    }

    public function test_finvalda_delegates_both_shims(): void
    {
        $finvalda = new Finvalda(new FinvaldaConfig(baseUrl: 'https://example.com', username: 'u', password: 'p'));

        $this->assertSame($finvalda, $finvalda->setDebug(true));
        $this->assertSame(['request' => [], 'response' => []], $finvalda->getLastDebugInfo());
    }

    public function test_get_raw_returns_the_body_undecoded(): void
    {
        // Restored in v4 after a consumer audit: the escape hatch for an
        // endpoint without a resource method, or a body that is not JSON.
        $history = [];
        $http = $this->createHttpClient([new Response(200, [], '<xml>not json</xml>')], $history);

        $this->assertSame('<xml>not json</xml>', $http->getRaw('GetPrekesIstorija', ['sPreKod' => 'P1', 'empty' => null]));
        $this->assertSame('GET', $history[0]['request']->getMethod());
        $this->assertSame('sPreKod=P1', $history[0]['request']->getUri()->getQuery());
    }
}
