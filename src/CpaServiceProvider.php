<?php

namespace Arttiger\Cpa;

use Arttiger\Cpa\Conversion\ConversionService;
use Arttiger\Cpa\Interfaces\Lead\LeadParser;
use Arttiger\Cpa\Lead\LeadService;
use Arttiger\Cpa\Lead\Parser\Chain;
use Illuminate\Support\ServiceProvider;

class CpaServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/cpa.php', 'cpa');

        // Register the service the package provides.
        $this->app->singleton('cpa', function ($app) {
            return new Cpa;
        });
        $this->app->singleton('cpaLead', LeadService::class);
        $this->app->singleton('cpaConversion', ConversionService::class);
        $this->app->singleton(LeadParser::class, Chain::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['cpa'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/cpa.php' => config_path('cpa.php'),
        ], 'cpa.config');
    }
}
