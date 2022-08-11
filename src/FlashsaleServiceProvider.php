<?php

namespace Haycalgiyaz\Flashsale;

use Illuminate\Support\ServiceProvider;

class FlashsaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Haycalgiyaz\Flashsale\Controllers\FlashSaleController');

        $this->mergeConfigFrom(
            $this->getConfigPath(), 'flashsale'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // dd($this->loadViewsFrom(__DIR__.'/views', 'flashsale'));
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'flashsale');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/mineralcms/flashsale'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->getConfigPath() => config_path('flashsale.php')
            ]);
        }
    }

    public function getConfigPath()
    {
        return __DIR__ . '/../config/flashsale.php';
    }
}
