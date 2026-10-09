<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Resources\Permissions;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\TestCase;

/**
 * GetUserPermissions (FVS_Webservice §3.84) takes only finUser and answers
 * every permission class at once; the class helpers filter client-side.
 */
class PermissionsTest extends TestCase
{
    use CreatesMockHttpClient;

    /**
     * @param  array<int, array<string, mixed>>  $history
     */
    private function permissions(array &$history = [], string $key = 'results', int $errorCode = 0): Permissions
    {
        return new Permissions($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'error' => '',
                $key => [
                    'accessResult' => 2,
                    'errorCode' => $errorCode,
                    'errorText' => $errorCode === 0 ? '' : 'nežinomas Finvaldos darbuotojas',
                    'perrmissions' => [
                        [
                            'perrmisionClass' => 81,
                            'perrmisionCode' => 'X',
                            'permittedEntities' => [['id1' => '2', 'id2' => 'PARD04']],
                        ],
                        [
                            'perrmisionClass' => 65,
                            'perrmisionCode' => 'WH_PERM',
                            'permittedEntities' => [['id1' => 'WH_00', 'id2' => null], ['id1' => 'WH_02', 'id2' => null]],
                        ],
                    ],
                ],
            ]),
        ], $history));
    }

    public function test_warehouses_filters_the_full_answer_by_permission_class(): void
    {
        $history = [];

        $warehouses = $this->permissions($history)->warehouses('S5');

        $this->assertSame([['id1' => 'WH_00', 'id2' => null], ['id1' => 'WH_02', 'id2' => null]], $warehouses);

        parse_str($history[0]['request']->getUri()->getQuery(), $query);
        $this->assertSame(['finUser' => 'S5'], $query);
    }

    public function test_operation_journals_read_class_81(): void
    {
        $this->assertSame([['id1' => '2', 'id2' => 'PARD04']], $this->permissions()->operationJournals());
    }

    public function test_a_class_with_no_record_is_empty(): void
    {
        $this->assertSame([], $this->permissions()->clients());
    }

    public function test_the_singular_result_key_is_read_too(): void
    {
        $this->assertCount(2, $this->permissions(key: 'result')->warehouses());
    }

    public function test_an_error_code_in_the_result_throws(): void
    {
        $this->expectException(FinvaldaException::class);
        $this->expectExceptionMessage('nežinomas Finvaldos darbuotojas');

        $this->permissions(errorCode: 2)->warehouses('NOBODY');
    }
}
