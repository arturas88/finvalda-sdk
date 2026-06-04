<?php

declare(strict_types=1);

namespace Finvalda\Laravel;

use Finvalda\Finvalda;
use Finvalda\FinvaldaConfig;
use Illuminate\Support\ServiceProvider;

class FinvaldaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/finvalda.php', 'finvalda');

        $this->app->singleton(Finvalda::class, function () {
            /** @var array<string, mixed> $config */
            $config = config('finvalda');

            $logger = null;
            if (! empty($config['log_channel'])) {
                $logger = $this->app->make('log')->channel($config['log_channel']);
            }

            return new Finvalda(FinvaldaConfig::fromArray($config, $logger));
        });

        $this->app->alias(Finvalda::class, 'finvalda');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/finvalda.php' => config_path('finvalda.php'),
            ], 'finvalda-config');
        }
    }
}
