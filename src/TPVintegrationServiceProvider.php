<?php

namespace ColanMYCIPL\TPVintegration;

use Illuminate\Support\ServiceProvider;


class TPVintegrationServiceProvider extends ServiceProvider
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

             $this->loadViewsFrom(__DIR__.'/views', 'TPVintegration');
             $this->loadRoutesFrom(__DIR__.'/routes/web.php');
             $this->loadMigrationsFrom(__DIR__.'/database/migrations');
             $this->publishes([
        __DIR__.'/public' => public_path('vendor/ColanMYCIPL/TPVintegration'),
    ], 'public');
             $this->publishes([
        __DIR__.'/views' => resource_path('views/vendor/ColanMYCIPL/TPVintegration'),
    ]);
              $this->publishes([
        __DIR__.'/config/twilioservices.php' => config_path('twilioservices.php')
    ], 'config');

    }
}
