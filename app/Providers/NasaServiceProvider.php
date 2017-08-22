<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NasaService;
use GuzzleHttp\Client;

class NasaServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(NasaService::class, function($app) {
            return new NasaService(new Client(), getenv('NASA_API_KEY'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [NasaService::class];
    }

}
