<?php

namespace Wame\PriceTaxField;

use Laravel\Nova\Fields\Number;
//use Wame\PriceTaxField\PriceTaxField;


class PriceField
{

    /**
     * @param string $base_field_name
     * @param string $db_price_without_tax
     * @param array $names
     * @param string $db_tax
     * @param string $db_price_with_tax
     * @param int $default_tax
     * @return PriceTaxField
     */
    public static function getPriceTaxField(string $base_field_name, string $db_price_without_tax, array $names, string $db_tax, string $db_price_with_tax, int $default_tax): PriceTaxField
    {
        return PriceTaxField::make($base_field_name, $db_price_without_tax)->fullWidth()->displayUsing(function ($value) {
            return number_format((float)$value, 2, '.', '') . ' €';
        })->names($names)->db_names([$db_price_without_tax, $db_tax, $db_price_with_tax])->hideFromIndex()->hideFromDetail()
            ->defaultTax($default_tax);
    }

    /**
     * @param $names
     * @param string $db_price_with_tax
     * @return Number
     */
    public static function getPriceWithTax($names, string $db_price_with_tax): Number
    {
        return Number::make($names, $db_price_with_tax)->displayUsing(function ($value) {
            return number_format((float)$value, 2, '.', '') . ' €';
        })->step(0.01);
    }

    /**
     * @param $names
     * @param string $db_tax
     * @return Number
     */
    public static function getPriceTax($names, string $db_tax): Number
    {
        return Number::make($names, $db_tax)->displayUsing(function ($value) {
            return $value . ' %';
        });
    }

    /**
     * @param string $base_field_name
     * @param string $db_price_without_tax
     * @return Number
     */
    public static function getPriceWithoutTax(string $base_field_name, string $db_price_without_tax): Number
    {
        return Number::make($base_field_name, $db_price_without_tax)->displayUsing(function ($value) {
            return number_format((float)$value, 2, '.', '') . ' €';
        })->step(0.01)->hideWhenCreating()->hideWhenUpdating();
    }

}


