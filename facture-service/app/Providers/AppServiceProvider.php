<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $eureka = new EurekaService();
        $status = $eureka->register();
        if ($status == 200) {
            logger("Laravel service successfully registered with Eureka.");
        } else {
            logger("Failed to register Laravel service with Eureka.");
        }
    }






}
