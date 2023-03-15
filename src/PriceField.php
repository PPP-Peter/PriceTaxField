<?php

namespace Wame\PriceTaxField;

use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;


class PriceField
{

    /**
     * PRICE WITHOUT TAX
     *
     * @param $values
     * @param $options
     * @return Number
     */
    public static function getPriceWithoutTax($options, $values): Number
    {
        $base_field_name = $options['base_field_name'];
        $db_price_without_tax = $options['db_names'][0];
        $names = $options['names'];
        $db_names = $options['db_names'];
        $one_col = $options['one_col'];
        $classes = $options['col_classes'];
        $tax_in_one_col = $options['tax_in_one_col'];

        return Number::make($base_field_name, $db_price_without_tax)
            //->displayUsing(fn () => $values->tax)
            ->displayUsing(function ($value) use ($one_col, $tax_in_one_col, $names, $db_names, $classes, $values) {
                if ($one_col === false) {
                    return self::to_currency($value);
                }
                else {
                    $tax_name = $db_names[1];
                    $with_tax_name = $db_names[2];
                    $rows = [];
                    $rows[] = "<$classes[0]>" . self::to_currency($value) . '<small> ' . $names[0] . "</small></$classes[0]> ";
                    $rows[] = "<$classes[1]>" . self::to_currency($values->$with_tax_name) . ' ' . $names[2] . "</$classes[1]>";
                    if ($tax_in_one_col) $rows[] = "<$classes[2]>" . $values->$tax_name .  ' % ' . $names[1] . "</$classes[2]>";
                    return implode('</br>', $rows);
                }
            })
            ->asHtml()
            ->hideWhenCreating()
            ->hideWhenUpdating()
            ->step(0.01);
    }

    /**
     * TAX
     *
     * @param $options
     * @return Number
     */
    public static function getPriceTax($options): Number
    {
        $name = $options['names'][1];
        $db_tax = $options['db_names'][1];
        $one_col = $options['one_col'];

        return Number::make($name, $db_tax)
            ->displayUsing(function ($value) {
                return $value . ' %';
            })
            ->showOnIndex(function (NovaRequest $request, $resource) use ($one_col){
                if ($one_col===false) return true ;
                else return false;
            })
            ->showOnDetail(function (NovaRequest $request, $resource) use ($one_col){
                if ($one_col===false) return true ;
                else return false;
            });
    }

    /**
     * PRICE WITH TAX
     *
     * @param $options
     * @return Number
     */
    public static function getPriceWithTax($options): Number
    {
        $name = $options['names'][2];
        $db_price_with_tax = $options['db_names'][2];
        $one_col = $options['one_col'];

        return Number::make($name, $db_price_with_tax)
            ->displayUsing(function ($value) {
                return self::to_currency($value);
            })
            ->showOnIndex(function (NovaRequest $request, $resource) use ($one_col){
                if ($one_col===false) return true ;
                else return false;
            })
            ->showOnDetail(function (NovaRequest $request, $resource) use ($one_col){
                if ($one_col===false) return true ;
                else return false;
            })
            ->step(0.01);
    }

    /**
     * CUSTOM PRICE FIELD
     *
     *  @param $options
     * @return PriceTaxField
     */
    public static function getPriceTaxField($options): PriceTaxField
    {
        $base_field_name = $options['base_field_name'];
        $names = $options['names'];
        $db_price_with_tax = $options['db_names'][2];
        $db_price_without_tax = $options['db_names'][0];
        $db_tax = $options['db_names'][1];
        $default_tax =  $options['default_tax'];

        return PriceTaxField::make($base_field_name, $db_price_without_tax)
            ->fullWidth()
            ->displayUsing(function ($value) {
                return self::to_currency($value);
            })
            ->names($names)
            ->db_names([$db_price_without_tax, $db_tax, $db_price_with_tax])
            ->hideFromIndex()
            ->hideFromDetail()
            ->defaultTax($default_tax);
    }

    /**
     * @param $value
     * @return string
     */
    private static function to_currency($value): string
    {
        return number_format((float)$value, 2, '.', '') . ' €';
    }


}




