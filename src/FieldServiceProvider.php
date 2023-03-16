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

            $this->publishes([
                __DIR__.'/../config/price-fields.php' => config_path('price-fields.php'),
            ], 'config');

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
