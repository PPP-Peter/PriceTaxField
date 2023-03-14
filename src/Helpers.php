<?php

namespace Wame\PriceTaxField;

use Laravel\Nova\Fields\Number;


class Helpers
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
        });
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
        })->hideWhenCreating()->hideWhenUpdating();
    }

}


/*
public static function getPriceTaxField2(string $field, )
{
    $config = config('price-tax-field.field1');
    $db_price_without_tax = 'price';
    $db_tax = 'tax';
    $db_price_with_tax = 'price_with_tax';
    $names = ['bez DPH', 'daň', 's DPH'];
    $base_field_name = 'Cena';
    $default_tax = 20;
    // Price tax field options
//        $db_price_without_tax = 'price';
//        $db_tax = 'tax';
//        $db_price_with_tax = 'price_with_tax';
//        $names = ['bez DPH', 'daň', 's DPH'];
//        $base_field_name = 'Cena';
//        $default_tax = 20;

    $price_field = Number::make($names[1], $db_tax)->displayUsing(function ($value) {
        return $value . ' %';
    });

    $tax_field = Number::make($base_field_name, $db_price_without_tax)->displayUsing(function ($value) {
        return number_format((float)$value, 2, '.', '') . ' €';
    })->hideWhenCreating()->hideWhenUpdating();

    $price_tax_field = Number::make($names[2], $db_price_with_tax)->displayUsing(function ($value) {
        return number_format((float)$value, 2, '.', '') . ' €';
    });

    $custom_field = PriceTaxField::make($base_field_name, $db_price_without_tax)->fullWidth()->displayUsing(function ($value) {
        return number_format((float)$value, 2, '.', '') . ' €';
    })->names($names)->db_names([$db_price_without_tax, $db_tax, $db_price_with_tax])->hideFromIndex()->hideFromDetail()
        ->defaultTax($default_tax);


    if ($field == 'tax') return $tax_field;
    if ($field == 'price') return $price_field;
    if ($field == 'price_tax') return $price_tax_field;
    if ($field == 'custom') return $custom_field;
    return [$price_field, $tax_field,  $price_tax_field, $custom_field] ;
}

*/
