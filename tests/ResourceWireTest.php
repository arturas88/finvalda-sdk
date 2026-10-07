<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Closure;
use Finvalda\Enums\DescriptionType;
use Finvalda\Enums\OffsetStatus;
use Finvalda\Filters\PaymentFilter;
use Finvalda\Filters\TransactionFilter;
use Finvalda\HttpClient;
use Finvalda\Resources\Clients;
use Finvalda\Resources\Descriptions;
use Finvalda\Resources\Objects;
use Finvalda\Resources\Permissions;
use Finvalda\Resources\Pricing;
use Finvalda\Resources\Products;
use Finvalda\Resources\References;
use Finvalda\Resources\Reports;
use Finvalda\Resources\Resource;
use Finvalda\Resources\Services;
use Finvalda\Resources\Stock;
use Finvalda\Resources\Transactions;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

/**
 * One request per public read/write method on every resource (Operations and
 * the hand-tested Documents/OrderManagement aside): verb, endpoint, and the
 * exact parameter keys on the wire.
 *
 * Parameter names follow the method signatures in docs/FVS_Webservice.md.
 * Where the SDK deliberately differs, the case says why:
 * - GetPrekesSandelyje[Order] send sSandKod, not the documented sSanKod —
 *   verified against a live server (CHANGELOG 2.x).
 * - GetFvsUser sends sUserName where the signature reads sUsername.
 * - GetAtsiskaitymaiUzDokDataNuoDet lists tSukurimoData/tKoregavimoData as
 *   `out` — taken to be a documentation slip, since the method is the
 *   "data nuo" (date-from) variant.
 * - Transactions endpoints (GetSales*, GetPurchases*, ...) are not in the
 *   document at all; these cases pin the current wire, not a spec.
 */
class ResourceWireTest extends TestCase
{
    use CreatesMockHttpClient;

    /**
     * Methods that do not map one-to-one onto a request, each covered by its
     * own test file instead.
     */
    private const COVERED_ELSEWHERE = [
        'Clients::find', 'Clients::collect', 'Clients::typesAndTags', 'Clients::allTypesAndTags',
        'Products::find', 'Products::collect', 'Products::typesAndTags', 'Products::allTypesAndTags', 'Products::imageJpeg',
        'Services::find', 'Services::collect', 'Services::typesAndTags', 'Services::allTypesAndTags',
        'Stock::purchaseOpFor',
        'Reports::makeInvoicePdf', 'Reports::makeReportPdf', 'Reports::autoReportPdf',
        'Pricing::recommendedPrice',
        'Permissions::entities', 'Permissions::warehouses', 'Permissions::clients',
        'Permissions::operationTypes', 'Permissions::operationJournals',
    ];

    /**
     * Resources whose every method is tested in its own file.
     */
    private const TESTED_IN_OWN_FILE = ['Documents', 'OrderManagement', 'Operations'];

    /**
     * @return array<string, array{Closure(HttpClient): mixed, string, string, array<string, mixed>}>
     */
    public static function requests(): array
    {
        $filter = new TransactionFilter(
            journal: 'PARD',
            opNumber: 5,
            series: 'AA',
            orderNumber: 'SF-1',
            journalGroup: 'PG',
            dateFrom: '2024-01-01',
            dateTo: '2024-01-31',
            modifiedSince: '2024-02-01',
        );
        $filterParams = [
            'sJournal' => 'PARD', 'nOpNumber' => '5', 'sSeries' => 'AA', 'sOrderNumber' => 'SF-1',
            'sJournalGroup' => 'PG', 'tOpDateFrom' => '2024-01-01', 'tOpDateTill' => '2024-01-31',
            'tDateEdited' => '2024-02-01',
        ];
        $payment = new PaymentFilter('PARD', 7, 'AA', 'SF-2');
        $paymentParams = [
            'sPayedForDocJournal' => 'PARD', 'nPayedForDocNumber' => '7',
            'sPayedForDocSeries' => 'AA', 'sPayedForDocOrderNumber' => 'SF-2',
        ];
        $dates = ['tKoregavimoData' => '2024-01-01', 'tSukurimoData' => '2023-01-01'];

        $get = fn (string $endpoint, array $query = []): array => ['GET', $endpoint, $query];
        $item = fn (string $endpoint, array $body): array => ['POST', $endpoint, ['json' => $body]];

        $cases = [
            // --- Clients ---
            'Clients::list' => [fn ($h) => (new Clients($h))->list('K1', '2024-01-01', '2023-01-01'),
                ...$get('GetKlientusSet', ['sKliKod' => 'K1'] + $dates)],
            'Clients::get' => [fn ($h) => (new Clients($h))->get('K1'), ...$get('GetKlientas', ['sKliKod' => 'K1'])],
            'Clients::all' => [fn ($h) => (new Clients($h))->all('2024-01-01', '2023-01-01'), ...$get('GetKlientus', $dates)],
            'Clients::findByEmail' => [fn ($h) => (new Clients($h))->findByEmail('a@b.lt'),
                ...$get('GetKlientasEMail', ['sEMail' => 'a@b.lt'])],
            'Clients::byType' => [fn ($h) => (new Clients($h))->byType('VIP'),
                ...$get('GetKlientusRusiesSudeti', ['sRusiesKodas' => 'VIP'])],
            'Clients::accounts' => [fn ($h) => (new Clients($h))->accounts('K1', '302', 'G', 1, 'PG', 'AA', 2, '2024-01-01', '2024-01-31'),
                ...$get('GetKlientoSaskaitas', [
                    'sKlientas' => 'K1', 'sKlientImonesKodas' => '302', 'sKlientuGrupe' => 'G', 'nSkolosTipas' => '1',
                    'sZurnaluGrupe' => 'PG', 'sSerija' => 'AA', 'nOperacijosTipas' => '2',
                    'tDokumentoDataNuo' => '2024-01-01', 'tDokumentoDataIki' => '2024-01-31',
                ])],
            'Clients::unpaidDocuments' => [fn ($h) => (new Clients($h))->unpaidDocuments('K1'),
                ...$get('GetNeapmoketiKliDok', ['sKlientoKodas' => 'K1'])],
            'Clients::unpaidPurchaseDocuments' => [fn ($h) => (new Clients($h))->unpaidPurchaseDocuments('K1'),
                ...$get('GetNeapmoketiPirkKliDok', ['sKlientoKodas' => 'K1'])],
            'Clients::debtCondition' => [fn ($h) => (new Clients($h))->debtCondition('K1', 'PG'),
                ...$get('GetClientDebtCondition', ['sKlientoKodas' => 'K1', 'sZurnaluGrupe' => 'PG'])],
            'Clients::settlements' => [fn ($h) => (new Clients($h))->settlements('AA', 'D1', 'PARD', 3),
                ...$get('GetAtsiskaitymaiUzDok', ['sSerija' => 'AA', 'sDokumentas' => 'D1', 'sZurnalas' => 'PARD', 'nNumeris' => '3'])],
            'Clients::settlementsDetailed' => [fn ($h) => (new Clients($h))->settlementsDetailed('AA', 'D1', 'PARD', 3, 9, 2),
                ...$get('GetAtsiskaitymaiUzDokDet', [
                    'sSerija' => 'AA', 'sDokumentas' => 'D1', 'sZurnalas' => 'PARD', 'nNumeris' => '3',
                    'nOperacijosID' => '9', 'nOperacijosKlase' => '2',
                ])],
            'Clients::settlementsFromDate' => [fn ($h) => (new Clients($h))->settlementsFromDate('AA', 'D1', 'PARD', 3, 9, 2, '2023-01-01', '2024-01-01'),
                ...$get('GetAtsiskaitymaiUzDokDataNuoDet', [
                    'sSerija' => 'AA', 'sDokumentas' => 'D1', 'sZurnalas' => 'PARD', 'nNumeris' => '3',
                    'nOperacijosID' => '9', 'nOperacijosKlase' => '2',
                    'tSukurimoData' => '2023-01-01', 'tKoregavimoData' => '2024-01-01',
                ])],
            'Clients::settlementsFromDateParam' => [fn ($h) => (new Clients($h))->settlementsFromDateParam('<root/>'),
                ...$get('GetAtsiskaitymaiUzDokDataNuoDetParam', ['sParam' => '<root/>'])],
            'Clients::create' => [fn ($h) => (new Clients($h))->create(['sKodas' => 'K1']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.Klientas', 'xmlstring' => ['Fvs.Klientas' => ['sKodas' => 'K1']]])],
            'Clients::update' => [fn ($h) => (new Clients($h))->update(['sKodas' => 'K1', 'sPavadinimas' => 'N']),
                ...$item('EditItem', [
                    'ItemClassName' => 'Fvs.Klientas', 'sItemCode' => 'K1',
                    'xmlstring' => ['Fvs.Klientas' => ['sKodas' => 'K1', 'sPavadinimas' => 'N']],
                ])],
            'Clients::delete' => [fn ($h) => (new Clients($h))->delete('K1'),
                ...$item('DeleteItem', ['input' => ['ItemClassName' => 'Fvs.Klientas', 'Code' => 'K1']])],
            'Clients::invoicesRelatedToCustomer' => [fn ($h) => (new Clients($h))->invoicesRelatedToCustomer('K1', 1),
                'POST', 'GetInvoicesRelatedToCustomer', ['sKlientoKodas' => 'K1', 'nDebtType' => '1']],

            // --- Products ---
            'Products::list' => [fn ($h) => (new Products($h))->list('P1', '2024-01-01', '2023-01-01'),
                ...$get('GetPrekesSet', ['sPreKod' => 'P1'] + $dates)],
            'Products::listExtended' => [fn ($h) => (new Products($h))->listExtended(
                'P1', 'R', 't1', 't2', 't3', 't4', 't5', 't6', 's1', 's2', 's3', 'A', 'o1', 'o2', 'o3', 'o4', 'o5', 'o6', '2024-01-01', '2023-01-01'),
                ...$get('GetPrekesSetExt', [
                    'sPreKod' => 'P1', 'sRusis' => 'R', 'sPozymis1' => 't1', 'sPozymis2' => 't2', 'sPozymis3' => 't3',
                    'sPozymis4' => 't4', 'sPozymis5' => 't5', 'sPozymis6' => 't6', 'sTiekejas1' => 's1', 'sTiekejas2' => 's2',
                    'sTiekejas3' => 's3', 'sRysysSuSask' => 'A', 'sObj1' => 'o1', 'sObj2' => 'o2', 'sObj3' => 'o3',
                    'sObj4' => 'o4', 'sObj5' => 'o5', 'sObj6' => 'o6',
                ] + $dates)],
            'Products::get' => [fn ($h) => (new Products($h))->get('P1'), ...$get('GetPreke', ['sPrekesKodas' => 'P1'])],
            'Products::all' => [fn ($h) => (new Products($h))->all('2024-01-01', '2023-01-01'), ...$get('GetPrekes', $dates)],
            'Products::image' => [fn ($h) => (new Products($h))->image('P1', '2024-01-01', '2023-01-01'),
                ...$get('GetPrekesImage', ['sPreKod' => 'P1'] + $dates)],
            'Products::inWarehouse' => [fn ($h) => (new Products($h))->inWarehouse('W1', '2024-01-01', '2023-01-01'),
                ...$get('GetPrekesSandelyje', ['sSandKod' => 'W1'] + $dates)],
            'Products::inWarehouseOrdered' => [fn ($h) => (new Products($h))->inWarehouseOrdered('W1', 2, '2024-01-01', '2023-01-01'),
                ...$get('GetPrekesSandelyjeOrder', ['sSandKod' => 'W1', 'nOrder' => '2'] + $dates)],
            'Products::typeGroups' => [fn ($h) => (new Products($h))->typeGroups(), ...$get('GetPrekiuRusiuGrupes')],
            'Products::typeGroupComposition' => [fn ($h) => (new Products($h))->typeGroupComposition('G1'),
                ...$get('GetPrekiuRusiuGrupesSudeti', ['sPrekiuRusiuGrupe' => 'G1'])],
            'Products::byType' => [fn ($h) => (new Products($h))->byType('R'),
                ...$get('GetPrekiuRusiesSudeti', ['sRusiesKodas' => 'R'])],
            'Products::history' => [fn ($h) => (new Products($h))->history('P1', 'W1', '2024-01-01'),
                ...$get('GetPrekesIstorija', ['sPreKod' => 'P1', 'sSandKod' => 'W1', 'tDataNuo' => '2024-01-01'])],
            'Products::soldPerPeriod' => [fn ($h) => (new Products($h))->soldPerPeriod('P1', 'W1', '2024-01-01', '2024-01-31', 'PARD', true),
                ...$get('GetPardPrekPerPerioda', [
                    'sPrekesKodas' => 'P1', 'sSandelioKodas' => 'W1', 'tDataNuo' => '2024-01-01', 'tDataIki' => '2024-01-31',
                    'sPardZurKodas' => 'PARD', 'bItrauktiVisasPrekes' => 'true',
                ])],
            'Products::create' => [fn ($h) => (new Products($h))->create(['sKodas' => 'P1']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.Preke', 'xmlstring' => ['Fvs.Preke' => ['sKodas' => 'P1']]])],
            'Products::update' => [fn ($h) => (new Products($h))->update(['sKodas' => 'P1']),
                ...$item('EditItem', ['ItemClassName' => 'Fvs.Preke', 'sItemCode' => 'P1', 'xmlstring' => ['Fvs.Preke' => ['sKodas' => 'P1']]])],
            'Products::editProperties' => [fn ($h) => (new Products($h))->editProperties(['Kodas' => ['P1'], 'pardKaina1' => '1.5']),
                ...$item('EditItemProps', ['xmlstring' => ['Fvs.EditItemProps' => ['Fvs.Prekes' => ['Kodas' => ['P1'], 'pardKaina1' => '1.5']]]])],
            'Products::delete' => [fn ($h) => (new Products($h))->delete('P1'),
                ...$item('DeleteItem', ['input' => ['ItemClassName' => 'Fvs.Preke', 'Code' => 'P1']])],

            // --- Services ---
            'Services::list' => [fn ($h) => (new Services($h))->list('S1', '2024-01-01', '2023-01-01'),
                ...$get('GetPaslaugosSet', ['sPasKod' => 'S1'] + $dates)],
            'Services::get' => [fn ($h) => (new Services($h))->get('S1'), ...$get('GetPaslauga', ['sPaslaugosKodas' => 'S1'])],
            'Services::all' => [fn ($h) => (new Services($h))->all('2024-01-01', '2023-01-01'), ...$get('GetPaslaugos', $dates)],
            'Services::byType' => [fn ($h) => (new Services($h))->byType('R'),
                ...$get('GetPaslauguRusiesSudeti', ['sRusiesKodas' => 'R'])],
            'Services::create' => [fn ($h) => (new Services($h))->create(['sKodas' => 'S1']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.Paslauga', 'xmlstring' => ['Fvs.Paslauga' => ['sKodas' => 'S1']]])],
            'Services::update' => [fn ($h) => (new Services($h))->update(['sKodas' => 'S1']),
                ...$item('EditItem', ['ItemClassName' => 'Fvs.Paslauga', 'sItemCode' => 'S1', 'xmlstring' => ['Fvs.Paslauga' => ['sKodas' => 'S1']]])],
            'Services::delete' => [fn ($h) => (new Services($h))->delete('S1'),
                ...$item('DeleteItem', ['input' => ['ItemClassName' => 'Fvs.Paslauga', 'Code' => 'S1']])],

            // --- Objects ---
            'Objects::list' => [fn ($h) => (new Objects($h))->list(3, 'O1', '2024-01-01', '2023-01-01'),
                ...$get('GetObjektai3Set', ['sObj3Kod' => 'O1'] + $dates)],
            'Objects::get' => [fn ($h) => (new Objects($h))->get(3, 'O1'), ...$get('GetObjektas3', ['sObj3Kod' => 'O1'])],
            'Objects::create' => [fn ($h) => (new Objects($h))->create(3, ['sKodas' => 'O1']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.ObjektasIII', 'xmlstring' => ['Fvs.ObjektasIII' => ['sKodas' => 'O1']]])],
            'Objects::update' => [fn ($h) => (new Objects($h))->update(3, ['sKodas' => 'O1']),
                ...$item('EditItem', ['ItemClassName' => 'Fvs.ObjektasIII', 'sItemCode' => 'O1', 'xmlstring' => ['Fvs.ObjektasIII' => ['sKodas' => 'O1']]])],

            // --- Stock ---
            'Stock::balances' => [fn ($h) => (new Stock($h))->balances('P1', 'W1', '2024-01-01', '2023-01-01'),
                ...$get('GetEinamiejiLikuciai', ['sPrekesKodas' => 'P1', 'sSandelioKodas' => 'W1'] + $dates)],
            'Stock::balancesExtended' => [fn ($h) => (new Stock($h))->balancesExtended('P1', 'W1', '2024-01-01', '2023-01-01'),
                ...$get('GetEinamiejiLikuciaiExt', ['sPrekesKodas' => 'P1', 'sSandelioKodas' => 'W1'] + $dates)],
            'Stock::balancesWithPrices' => [fn ($h) => (new Stock($h))->balancesWithPrices('P1', 'W1', false, '2024-01-01', '2023-01-01'),
                ...$get('GetEinamiejiLikuciaiExtSuKainom', ['sPrekesKodas' => 'P1', 'sSandelioKodas' => 'W1', 'bNuliniaiLikuciai' => 'false'] + $dates)],
            'Stock::balancesByGroup' => [fn ($h) => (new Stock($h))->balancesByGroup('P1', 'WG'),
                ...$get('GetEinamiejiLikuciaiGrp', ['sPrekesKodas' => 'P1', 'sSandelioGrupesKodas' => 'WG'])],
            'Stock::orderedProducts' => [fn ($h) => (new Stock($h))->orderedProducts('P1', 'W1'),
                ...$get('GetUzsakytasPrekes', ['sPrekesKodas' => 'P1', 'sSandelioKodas' => 'W1'])],

            // --- Permissions (GetUserPermissions takes only finUser; §3.84 PURE example) ---
            'Permissions::get' => [fn ($h) => (new Permissions($h))->get('S5'), ...$get('GetUserPermissions', ['finUser' => 'S5'])],

            // --- References ---
            'References::measurementUnits' => [fn ($h) => (new References($h))->measurementUnits(), ...$get('GetMatavimoVienetus')],
            'References::warehouses' => [fn ($h) => (new References($h))->warehouses(), ...$get('GetSandelius')],
            'References::taxes' => [fn ($h) => (new References($h))->taxes(), ...$get('GetMokesciai')],
            'References::paymentTerms' => [fn ($h) => (new References($h))->paymentTerms(), ...$get('GetAtsiskaitymoTerm')],
            'References::user' => [fn ($h) => (new References($h))->user('U', 'P'),
                ...$get('GetFvsUser', ['sUserName' => 'U', 'sPassword' => 'P'])],
            'References::materiallyResponsiblePersons' => [fn ($h) => (new References($h))->materiallyResponsiblePersons('M1'),
                ...$get('GetMaterialAtsakAsmSar', ['sKodas' => 'M1'])],
            'References::createBank' => [fn ($h) => (new References($h))->createBank(['sKodas' => 'B1']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.Bankas', 'xmlstring' => ['Fvs.Bankas' => ['sKodas' => 'B1']]])],
            'References::createWarehouse' => [fn ($h) => (new References($h))->createWarehouse(['sKodas' => 'W1']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.Sandelis', 'xmlstring' => ['Fvs.Sandelis' => ['sKodas' => 'W1']]])],
            'References::updateWarehouse' => [fn ($h) => (new References($h))->updateWarehouse(['sKodas' => 'W1']),
                ...$item('EditItem', ['ItemClassName' => 'Fvs.Sandelis', 'sItemCode' => 'W1', 'xmlstring' => ['Fvs.Sandelis' => ['sKodas' => 'W1']]])],
            'References::createPaymentTerm' => [fn ($h) => (new References($h))->createPaymentTerm(['sKodas' => 'T1']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.AtsTerminas', 'xmlstring' => ['Fvs.AtsTerminas' => ['sKodas' => 'T1']]])],
            'References::updatePaymentTerm' => [fn ($h) => (new References($h))->updatePaymentTerm(['sKodas' => 'T1']),
                ...$item('EditItem', ['ItemClassName' => 'Fvs.AtsTerminas', 'sItemCode' => 'T1', 'xmlstring' => ['Fvs.AtsTerminas' => ['sKodas' => 'T1']]])],
            'References::createClientType' => [fn ($h) => (new References($h))->createClientType(['sKodas' => 'CT']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.KlientoRusis', 'xmlstring' => ['Fvs.KlientoRusis' => ['sKodas' => 'CT']]])],
            'References::createProductType' => [fn ($h) => (new References($h))->createProductType(['sKodas' => 'PT']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.PrekesRusis', 'xmlstring' => ['Fvs.PrekesRusis' => ['sKodas' => 'PT']]])],
            'References::createProductTag' => [fn ($h) => (new References($h))->createProductTag(2, ['sKodas' => 'X']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.PrekesPoz2', 'xmlstring' => ['Fvs.PrekesPoz2' => ['sKodas' => 'X']]])],
            'References::createClientTag' => [fn ($h) => (new References($h))->createClientTag(2, ['sKodas' => 'X']),
                ...$item('InsertNewItem', ['ItemClassName' => 'Fvs.KlientoIIPoz', 'xmlstring' => ['Fvs.KlientoIIPoz' => ['sKodas' => 'X']]])],
            'References::updateProductType' => [fn ($h) => (new References($h))->updateProductType(['sKodas' => 'PT']),
                ...$item('EditItem', ['ItemClassName' => 'Fvs.PrekesRusis', 'sItemCode' => 'PT', 'xmlstring' => ['Fvs.PrekesRusis' => ['sKodas' => 'PT']]])],
            'References::updateProductTag' => [fn ($h) => (new References($h))->updateProductTag(2, ['sKodas' => 'X']),
                ...$item('EditItem', ['ItemClassName' => 'Fvs.PrekesPoz2', 'sItemCode' => 'X', 'xmlstring' => ['Fvs.PrekesPoz2' => ['sKodas' => 'X']]])],
            'References::updateClientType' => [fn ($h) => (new References($h))->updateClientType(['sKodas' => 'CT']),
                ...$item('EditItem', ['ItemClassName' => 'Fvs.KlientoRusis', 'sItemCode' => 'CT', 'xmlstring' => ['Fvs.KlientoRusis' => ['sKodas' => 'CT']]])],
            'References::updateClientTag' => [fn ($h) => (new References($h))->updateClientTag(2, ['sKodas' => 'X']),
                ...$item('EditItem', ['ItemClassName' => 'Fvs.KlientoIIPoz', 'sItemCode' => 'X', 'xmlstring' => ['Fvs.KlientoIIPoz' => ['sKodas' => 'X']]])],
            'References::deleteProductType' => [fn ($h) => (new References($h))->deleteProductType('PT'),
                ...$item('DeleteItem', ['input' => ['ItemClassName' => 'Fvs.PrekesRusis', 'Code' => 'PT']])],
            'References::deleteProductTag' => [fn ($h) => (new References($h))->deleteProductTag(2, 'X'),
                ...$item('DeleteItem', ['input' => ['ItemClassName' => 'Fvs.PrekesPoz2', 'Code' => 'X']])],
            'References::deleteClientType' => [fn ($h) => (new References($h))->deleteClientType('CT'),
                ...$item('DeleteItem', ['input' => ['ItemClassName' => 'Fvs.KlientoRusis', 'Code' => 'CT']])],
            'References::deleteClientTag' => [fn ($h) => (new References($h))->deleteClientTag(2, 'X'),
                ...$item('DeleteItem', ['input' => ['ItemClassName' => 'Fvs.KlientoIIPoz', 'Code' => 'X']])],
            'References::addToGroup' => [fn ($h) => (new References($h))->addToGroup('Fvs.Klientas', 'G1', 'K1', 'K2'),
                ...$item('AppendGroup', ['ItemClassName' => 'Fvs.Klientas', 'sGroupCode' => 'G1', 'sItemCode' => 'K1', 'sItemCode2' => 'K2'])],

            // --- Reports ---
            'Reports::makeInvoice' => [fn ($h) => (new Reports($h))->makeInvoice('{"FakturosKodas":"F1"}'),
                ...$get('MakeInvoice', ['sParam' => '{"FakturosKodas":"F1"}'])],
            'Reports::makeReport' => [fn ($h) => (new Reports($h))->makeReport('{"code":"R1"}'),
                ...$get('MakeReport', ['sParam' => '{"code":"R1"}'])],
            'Reports::autoReports' => [fn ($h) => (new Reports($h))->autoReports(), ...$get('GetAutoReportsList')],
            'Reports::autoReport' => [fn ($h) => (new Reports($h))->autoReport('a.pdf'), ...$get('GetAutoReport', ['fileName' => 'a.pdf'])],

            // --- Descriptions (all one POST GetDescriptions; body shape per type) ---
            'Descriptions::get' => [fn ($h) => (new Descriptions($h))->get(DescriptionType::Accounts, ['Codes' => ['1']]),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'Accounts', 'Accounts' => ['Codes' => ['1']]]])],
            'Descriptions::stockOnDate' => [fn ($h) => (new Descriptions($h))->stockOnDate('2024-01-01'),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'StockOnDate', 'StockOnDate' => ['Date' => '2024-01-01']]])],
            'Descriptions::addresses' => [fn ($h) => (new Descriptions($h))->addresses(['Codes' => ['K1']], ['Codes' => ['A1']]),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'Address', 'Clients' => ['Codes' => ['K1']], 'Address' => ['Codes' => ['A1']]]])],
            'Descriptions::products' => [fn ($h) => (new Descriptions($h))->products(['Codes' => ['P1']], 1, 10),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'Products', 'page' => 1, 'limit' => 10, 'Products' => ['Codes' => ['P1']]]])],
            'Descriptions::clients' => [fn ($h) => (new Descriptions($h))->clients(['Codes' => ['K1']]),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'Clients', 'Clients' => ['Codes' => ['K1']]]])],
            'Descriptions::services' => [fn ($h) => (new Descriptions($h))->services(['Codes' => ['S1']]),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'Services', 'Services' => ['Codes' => ['S1']]]])],
            'Descriptions::currentStock' => [fn ($h) => (new Descriptions($h))->currentStock(['Codes' => ['P1']]),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'CurrentStock', 'Products' => ['Codes' => ['P1']]]])],
            'Descriptions::fixedAssets' => [fn ($h) => (new Descriptions($h))->fixedAssets(['Codes' => ['F1']]),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'FixedAsset', 'FixedAsset' => ['Codes' => ['F1']]]])],
            'Descriptions::barCodes' => [fn ($h) => (new Descriptions($h))->barCodes(['BarCodes' => ['4770']]),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'BarCodes', 'Products' => ['BarCodes' => ['4770']]]])],
            'Descriptions::prices' => [fn ($h) => (new Descriptions($h))->prices(['Type' => 1]),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'Prices', 'Prices' => ['Type' => 1]]])],
            'Descriptions::typesAndTags' => [fn ($h) => (new Descriptions($h))->typesAndTags('product', 2),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'TypesAndTags', 'TypesAndTags' => ['Type' => 'product', 'Number' => 2]]])],
            'Descriptions::currencyRates' => [fn ($h) => (new Descriptions($h))->currencyRates('2024-01-01', '2024-01-31', ['USD']),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'CurrencyRates', 'CurrencyRates' => [
                    'DateFrom' => '2024-01-01', 'DateTo' => '2024-01-31', 'Codes' => ['USD'],
                ]]])],
            'Descriptions::clientGroups' => [fn ($h) => (new Descriptions($h))->clientGroups(),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'ClientGroups']])],
            'Descriptions::warehouseGroups' => [fn ($h) => (new Descriptions($h))->warehouseGroups(),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'WarehouseGroups']])],
            'Descriptions::logbookGroups' => [fn ($h) => (new Descriptions($h))->logbookGroups(),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'LogbookGroups']])],
            'Descriptions::opTypeGroups' => [fn ($h) => (new Descriptions($h))->opTypeGroups(),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'OpTypeGroups']])],
            'Descriptions::documentSeries' => [fn ($h) => (new Descriptions($h))->documentSeries(0, 'WEB'),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'DocumentSeries', 'Series' => ['Type' => 0, 'UserName' => 'WEB']]])],
            'Descriptions::calendarEvents' => [fn ($h) => (new Descriptions($h))->calendarEvents('ADMIN', ['StartFrom' => '2024-01-01']),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'CalendarEvents', 'CalendarEvents' => ['UserName' => 'ADMIN', 'StartFrom' => '2024-01-01']]])],
            'Descriptions::vehicles' => [fn ($h) => (new Descriptions($h))->vehicles(),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'Vehicles']])],
            'Descriptions::invoiceList' => [fn ($h) => (new Descriptions($h))->invoiceList('Sales'),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'InvoiceList', 'InvoiceList' => ['OpClass' => 'Sales']]])],
            'Descriptions::reportList' => [fn ($h) => (new Descriptions($h))->reportList('Balansas'),
                ...$item('GetDescriptions', ['readParams' => ['type' => 'ReportList', 'ReportList' => ['Class' => 'Balansas']]])],

            // --- Transactions (not in the document; pins the current wire) ---
            'Transactions::inflowsDetail' => [fn ($h) => (new Transactions($h))->inflowsDetail($filter, $payment),
                ...$get('GetInflowsDet', $filterParams + $paymentParams)],
            'Transactions::advancedPaymentsDetail' => [fn ($h) => (new Transactions($h))->advancedPaymentsDetail($filter, $payment, 'K1', OffsetStatus::Offset->value),
                ...$get('GetAdvancedPaymentsDet', $filterParams + $paymentParams + ['sClient' => 'K1', 'nOffsetStatus' => '1'])],
            'Transactions::advancedPaymentsDetailExtended' => [fn ($h) => (new Transactions($h))->advancedPaymentsDetailExtended($filter, $payment, 'K1', 0),
                ...$get('GetAdvancedPaymentsDetExt', $filterParams + $paymentParams + ['sClient' => 'K1', 'nOffsetStatus' => '0'])],
            'Transactions::disbursementsDetail' => [fn ($h) => (new Transactions($h))->disbursementsDetail($filter, $payment),
                ...$get('GetDisbursementsDet', $filterParams + $paymentParams)],
            'Transactions::clearingOffsDetail' => [fn ($h) => (new Transactions($h))->clearingOffsDetail($filter, $payment),
                ...$get('GetClearingOffsDet', $filterParams + $paymentParams)],
            'Transactions::ommSalesXmlCondition' => [fn ($h) => (new Transactions($h))->ommSalesXmlCondition('<c/>'),
                ...$get('GetOMMSalesXmlCond', ['sXmlData' => '<c/>'])],
            'Transactions::ommSalesXmlConditionWithTitle' => [fn ($h) => (new Transactions($h))->ommSalesXmlConditionWithTitle('<c/>'),
                ...$get('GetOMMSalesXmlCondOpTitle', ['sXmlData' => '<c/>'])],
            'Transactions::depreciationOfFixedAssets' => [fn ($h) => (new Transactions($h))->depreciationOfFixedAssets($filter, 'F1', 2024, 3),
                ...$get('GetDepreciationOfFixedAssets', $filterParams + ['sAssetCode' => 'F1', 'nYear' => '2024', 'nMonth' => '3'])],
            'Transactions::depreciationOfFixedAssetsObjects' => [fn ($h) => (new Transactions($h))->depreciationOfFixedAssetsObjects($filter, 'F1', 2024, 3),
                ...$get('GetDepreciationOfFixedAssetsObjects', $filterParams + ['sAssetCode' => 'F1', 'nYear' => '2024', 'nMonth' => '3'])],
            'Transactions::lowValueInventory' => [fn ($h) => (new Transactions($h))->lowValueInventory(), ...$get('GetLowValueInventory')],
        ];

        // Pricing: every client/type x product/service/type x discount/price
        // reader takes (code, modifiedSince, createdSince).
        foreach ([
            'clientProductDiscounts' => ['GetKlientuPrekiuNuol', 'sKlientoKodas'],
            'clientProductAdditionalPrices' => ['GetKlientuPrekiuPapKainas', 'sKlientoKodas'],
            'clientProductTypeDiscounts' => ['GetKlientuPrekiuRusNuol', 'sKlientoKodas'],
            'clientProductTypeAdditionalPrices' => ['GetKlientuPrekiuRusPapKainas', 'sKlientoKodas'],
            'clientServiceDiscounts' => ['GetKlientuPaslauguNuol', 'sKlientoKodas'],
            'clientServiceAdditionalPrices' => ['GetKlientuPaslauguPapKainas', 'sKlientoKodas'],
            'clientServiceTypeDiscounts' => ['GetKlientuPaslauguRusNuol', 'sKlientoKodas'],
            'clientServiceTypeAdditionalPrices' => ['GetKlientuPaslauguRusPapKainas', 'sKlientoKodas'],
            'clientTypeProductDiscounts' => ['GetKlientuRusPrekiuNuol', 'sKlientoRusKodas'],
            'clientTypeProductAdditionalPrices' => ['GetKlientuRusPrekiuPapKainas', 'sKlientoRusKodas'],
            'clientTypeProductTypeDiscounts' => ['GetKlientuRusPrekiuRusNuol', 'sKlientoRusKodas'],
            'clientTypeProductTypeAdditionalPrices' => ['GetKlientuRusPrekiuRusPapKainas', 'sKlientoRusKodas'],
            'clientTypeServiceDiscounts' => ['GetKlientuRusPaslauguNuol', 'sKlientoRusKodas'],
            'clientTypeServiceAdditionalPrices' => ['GetKlientuRusPaslauguPapKainas', 'sKlientoRusKodas'],
            'clientTypeServiceTypeDiscounts' => ['GetKlientuRusPaslauguRusNuol', 'sKlientoRusKodas'],
            'clientTypeServiceTypeAdditionalPrices' => ['GetKlientuRusPaslauguRusPapKainas', 'sKlientoRusKodas'],
        ] as $method => [$endpoint, $codeKey]) {
            $cases["Pricing::{$method}"] = [fn ($h) => (new Pricing($h))->{$method}('C1', '2024-01-01', '2023-01-01'),
                ...$get($endpoint, [$codeKey => 'C1'] + $dates)];
        }

        foreach ([
            'clientItemPrices' => ['GetKliPrekPasNuolPapKain', []],
            'clientTypeItemPrices' => ['GetKliRusPrekPasNuolPapKain', $dates],
            'clientItemTypePrices' => ['GetKliPrekPasRusNuolPapKain', $dates],
            'clientTypeItemTypePrices' => ['GetKliRusPrekPasRusNuolPapKain', $dates],
        ] as $method => [$endpoint, $query]) {
            $cases["Pricing::{$method}"] = [
                $query === []
                    ? fn ($h) => (new Pricing($h))->{$method}()
                    : fn ($h) => (new Pricing($h))->{$method}('2024-01-01', '2023-01-01'),
                ...$get($endpoint, $query),
            ];
        }

        // Transactions that take only the common filter.
        foreach ([
            'sales' => 'GetSales', 'salesDetail' => 'GetSalesDet', 'salesDetailWithPrimeCost' => 'GetSalesDetWithPrimeCost',
            'saleReservations' => 'GetSaleReservations', 'saleReservationsDetail' => 'GetSaleReservationsDet',
            'salesReturns' => 'GetSalesReturns', 'salesReturnsDetail' => 'GetSalesReturnsDet',
            'purchases' => 'GetPurchases', 'purchasesDetail' => 'GetPurchasesDet', 'purchasesExtendedDetail' => 'GetPurchasesExtDet',
            'purchaseOrders' => 'GetPurchaseOrders', 'purchaseOrdersDetail' => 'GetPurchaseOrdersDet',
            'purchaseReturns' => 'GetPurchaseReturns', 'purchaseReturnsDetail' => 'GetPurchaseReturnsDet',
            'ommSales' => 'GetOMMSales', 'ommSalesDetail' => 'GetOMMSalesDet',
            'ommPurchases' => 'GetOMMPurchases', 'ommPurchasesDetail' => 'GetOMMPurchasesDet',
            'currencyDebtRecount' => 'GetCurrencyDebtRecount',
        ] as $method => $endpoint) {
            $cases["Transactions::{$method}"] = [fn ($h) => (new Transactions($h))->{$method}($filter), ...$get($endpoint, $filterParams)];
        }

        return $cases;
    }

    /**
     * @param  Closure(HttpClient): mixed  $call
     * @param  array<string, mixed>  $expected  Query parameters, or ['json' => body] for a JSON POST
     */
    #[DataProvider('requests')]
    public function test_the_request_goes_out_as_specified(Closure $call, string $verb, string $endpoint, array $expected): void
    {
        $history = [];
        $call($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'error' => '', 'nResult' => 0, 'items' => []]),
        ], $history));

        $this->assertCount(1, $history);
        $request = $history[0]['request'];

        $this->assertSame($verb, $request->getMethod());
        $this->assertSame($endpoint, basename($request->getUri()->getPath()));

        if (array_key_exists('json', $expected)) {
            $body = json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);

            if (is_string($body['xmlstring'] ?? null)) {
                $body['xmlstring'] = json_decode($body['xmlstring'], true, flags: JSON_THROW_ON_ERROR);
            }

            $this->assertSame($expected['json'], $body);

            return;
        }

        parse_str($request->getUri()->getQuery(), $query);
        ksort($query);
        ksort($expected);

        $this->assertSame($expected, $query);
    }

    public function test_every_public_resource_method_has_a_wire_case(): void
    {
        $covered = array_merge(array_keys(self::requests()), self::COVERED_ELSEWHERE);
        $missing = [];

        foreach (glob(__DIR__ . '/../src/Resources/*.php') as $file) {
            $short = basename($file, '.php');
            $class = "Finvalda\\Resources\\{$short}";

            if ($class === Resource::class || in_array($short, self::TESTED_IN_OWN_FILE, true)) {
                continue;
            }

            foreach ((new ReflectionClass($class))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->class === $class && ! $method->isConstructor() && ! in_array("{$short}::{$method->name}", $covered, true)) {
                    $missing[] = "{$short}::{$method->name}";
                }
            }
        }

        $this->assertSame([], $missing, 'add a case to requests() for each new resource method');
    }
}
