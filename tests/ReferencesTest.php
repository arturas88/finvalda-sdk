<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\ItemClass;
use Finvalda\Exceptions\OperationNotSupportedException;
use Finvalda\Resources\References;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PHPUnit\Framework\TestCase;
use ValueError;

class ReferencesTest extends TestCase
{
    use CreatesMockHttpClient;

    /**
     * @param  array<int, array<string, mixed>>  $history
     */
    private function references(array &$history): References
    {
        return new References($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'nResult' => 0]),
        ], $history));
    }

    /**
     * @return array<string, mixed>
     */
    private function requestBody(array $history): array
    {
        return json_decode((string) $history[0]['request']->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }

    private function endpoint(array $history): string
    {
        return basename($history[0]['request']->getUri()->getPath());
    }

    public function test_client_tag_helper_maps_number_to_roman_class(): void
    {
        $this->assertSame('Fvs.KlientoIPoz', ItemClass::clientTag(1)->value);
        $this->assertSame('Fvs.KlientoIIPoz', ItemClass::clientTag(2)->value);
        $this->assertSame('Fvs.KlientoIIIPoz', ItemClass::clientTag(3)->value);
    }

    public function test_client_tag_helper_rejects_out_of_range(): void
    {
        $this->expectException(ValueError::class);
        ItemClass::clientTag(4);
    }

    public function test_create_client_tag_inserts_under_roman_class(): void
    {
        $history = [];
        $references = $this->references($history);

        $result = $references->createClientTag(1, ['sKodas' => 'VIP', 'sPavadinimas' => 'VIP']);

        $this->assertTrue($result->success);
        $this->assertSame('InsertNewItem', $this->endpoint($history));
        $body = $this->requestBody($history);
        $this->assertSame('Fvs.KlientoIPoz', $body['ItemClassName']);
        $xml = json_decode($body['xmlstring'], true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame(['Fvs.KlientoIPoz' => ['sKodas' => 'VIP', 'sPavadinimas' => 'VIP']], $xml);
    }

    public function test_update_product_type_edits_item_with_code(): void
    {
        $history = [];
        $references = $this->references($history);

        $references->updateProductType(['sKodas' => 'ELEKTRO', 'sPavadinimas' => 'Renamed']);

        $this->assertSame('EditItem', $this->endpoint($history));
        $body = $this->requestBody($history);
        $this->assertSame('Fvs.PrekesRusis', $body['ItemClassName']);
        $this->assertSame('ELEKTRO', $body['sItemCode']);
        $xml = json_decode($body['xmlstring'], true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame('Renamed', $xml['Fvs.PrekesRusis']['sPavadinimas']);
    }

    public function test_update_product_tag_uses_numbered_class(): void
    {
        $history = [];
        $references = $this->references($history);

        $references->updateProductTag(5, ['sKodas' => 'PROMO', 'sPavadinimas' => 'Promo']);

        $this->assertSame('EditItem', $this->endpoint($history));
        $body = $this->requestBody($history);
        $this->assertSame('Fvs.PrekesPoz5', $body['ItemClassName']);
        $this->assertSame('PROMO', $body['sItemCode']);
    }

    public function test_delete_product_type_sends_delete_item_input(): void
    {
        $history = [];
        $references = $this->references($history);

        $references->deleteProductType('ELEKTRO');

        $this->assertSame('DeleteItem', $this->endpoint($history));
        $this->assertSame(
            ['input' => ['ItemClassName' => 'Fvs.PrekesRusis', 'Code' => 'ELEKTRO']],
            $this->requestBody($history),
        );
    }

    public function test_delete_product_tag_sends_numbered_class(): void
    {
        $history = [];
        $references = $this->references($history);

        $references->deleteProductTag(2, 'PROMO');

        $this->assertSame('DeleteItem', $this->endpoint($history));
        $this->assertSame(
            ['input' => ['ItemClassName' => 'Fvs.PrekesPoz2', 'Code' => 'PROMO']],
            $this->requestBody($history),
        );
    }

    public function test_update_client_type_and_tag_use_correct_classes(): void
    {
        $history = [];
        $references = $this->references($history);
        $references->updateClientType(['sKodas' => 'WHOLESALE', 'sPavadinimas' => 'Wholesale']);
        $body = $this->requestBody($history);
        $this->assertSame('Fvs.KlientoRusis', $body['ItemClassName']);
        $this->assertSame('WHOLESALE', $body['sItemCode']);

        $history2 = [];
        $references2 = $this->references($history2);
        $references2->updateClientTag(3, ['sKodas' => 'TAG3']);
        $this->assertSame('Fvs.KlientoIIIPoz', $this->requestBody($history2)['ItemClassName']);
    }

    public function test_delete_client_type_and_tag_use_correct_classes(): void
    {
        $history = [];
        $references = $this->references($history);
        $references->deleteClientType('WHOLESALE');
        $this->assertSame(
            ['input' => ['ItemClassName' => 'Fvs.KlientoRusis', 'Code' => 'WHOLESALE']],
            $this->requestBody($history),
        );

        $history2 = [];
        $references2 = $this->references($history2);
        $references2->deleteClientTag(2, 'TAG2');
        $this->assertSame(
            ['input' => ['ItemClassName' => 'Fvs.KlientoIIPoz', 'Code' => 'TAG2']],
            $this->requestBody($history2),
        );
    }

    /**
     * Build a client whose DeleteItem call hits the WCF "endpoint not found"
     * page a Pure build without DeleteItem returns.
     */
    private function deleteItemNotFoundClient(): References
    {
        $wcfHtml = '<html><head><title>Service</title></head><body>'
            . 'Endpoint not found.</body></html>';

        return new References($this->createHttpClient([
            new GuzzleResponse(404, ['Content-Type' => 'text/html'], $wcfHtml),
        ]));
    }

    public function test_delete_product_type_throws_when_server_lacks_deleteitem(): void
    {
        $this->expectException(OperationNotSupportedException::class);
        $this->expectExceptionMessage('DeleteItem is not supported by this Finvalda server build');

        $this->deleteItemNotFoundClient()->deleteProductType('ELEC');
    }

    public function test_delete_client_tag_throws_operation_not_supported_with_endpoint(): void
    {
        try {
            $this->deleteItemNotFoundClient()->deleteClientTag(1, 'KEY');
            $this->fail('Expected OperationNotSupportedException');
        } catch (OperationNotSupportedException $e) {
            $this->assertSame('DeleteItem', $e->endpoint);
            $this->assertSame(404, $e->getCode());
        }
    }
}
