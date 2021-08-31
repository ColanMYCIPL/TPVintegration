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
        __DIR__.'/public' => public_path('/TPVintegration'),
    ], 'public');
             $this->publishes([
        __DIR__.'/views' => resource_path('views'),
    ]);
    

    $this->publishes([
            __DIR__.'/Jobs' => 'app/Jobs',
        ], 'public');
$this->publishes([
            __DIR__.'/Models' => 'app/Models',
        ], 'public');
              $this->publishes([
        __DIR__.'/config/twilioservices.php' => config_path('twilioservices.php')
    ], 'config');

    }
}
