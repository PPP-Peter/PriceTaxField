<?php

namespace Wame\PriceTaxField;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('price-tax-field', __DIR__.'/../dist/js/field.js');
            Nova::style('price-tax-field', __DIR__.'/../dist/css/field.css');
        });

        if ($this->app->runningInConsole()) {

            //export config
            $this->publishes([
                __DIR__.'/../config/price-fields.php' => config_path('price-fields.php'),
            ], 'config');

            // export lang
            $this->publishes([
                __DIR__ . '/../resources/lang/' => resource_path('lang')
            ], ['langs', 'price-field', 'wame']);

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
