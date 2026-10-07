<?php

declare(strict_types=1);

namespace Finvalda\Tests\Laravel;

use Finvalda\Finvalda;
use Finvalda\Laravel\Facades\Finvalda as FinvaldaFacade;
use Finvalda\Laravel\FinvaldaServiceProvider;
use Illuminate\Support\Facades\Facade;
use Orchestra\Testbench\TestCase;

class FinvaldaServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [FinvaldaServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('finvalda.base_url', 'https://example.com/FvsServicePure.svc');
        $app['config']->set('finvalda.username', 'demo');
        $app['config']->set('finvalda.password', 'secret');
    }

    public function test_it_resolves_the_client_from_config(): void
    {
        $this->assertInstanceOf(Finvalda::class, $this->app->make(Finvalda::class));
        $this->assertSame($this->app->make(Finvalda::class), $this->app->make('finvalda'));
    }

    public function test_the_client_is_shared_within_a_request_or_job(): void
    {
        $this->assertSame($this->app->make(Finvalda::class), $this->app->make(Finvalda::class));
    }

    public function test_a_new_request_or_job_gets_a_fresh_client(): void
    {
        $first = FinvaldaFacade::getFacadeRoot();

        // What the queue worker does between jobs (QueueServiceProvider).
        $this->app->forgetScopedInstances();
        Facade::clearResolvedInstances();

        $this->assertNotSame($first, $this->app->make(Finvalda::class));
        $this->assertNotSame($first, FinvaldaFacade::getFacadeRoot(), 'the Facade must not keep the previous job\'s client');
    }
}
