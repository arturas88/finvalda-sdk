<?php

declare(strict_types=1);

namespace Finvalda\Laravel;

use Finvalda\Enums\Language;
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

            return new Finvalda(new FinvaldaConfig(
                baseUrl: $config['base_url'],
                username: $config['username'],
                password: $config['password'],
                connString: $config['conn_string'] ?? null,
                companyId: $config['company_id'] ?? null,
                language: Language::from($config['language'] ?? 0),
                removeEmptyStringTags: $config['remove_empty_string_tags'] ?? false,
                removeZeroNumberTags: $config['remove_zero_number_tags'] ?? false,
                removeNewLines: $config['remove_new_lines'] ?? false,
                timeout: $config['timeout'] ?? 30,
            ));
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
