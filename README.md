# Laravel Nova Price Tax Fields

## Installation

``` php
composer require wamesk/laravel-nova-price-tax-fields
```

## Usage

``` php
use Wame\TelInput\TelInput;

// Price tax field options
$db_price_without_tax = 'price';
$db_tax = 'tax';
$db_price_with_tax = 'price_with_tax';
$names = ['bez DPH', 'daň', 's DPH'];
$base_field_name = 'Cena';

Number::make($names[2], $db_price_with_tax)->displayUsing(function ($value) {
    return number_format((float)$value, 2, '.', '') . ' €';
}),
Number::make($names[1], $db_tax)->displayUsing(function ($value) {
    return $value. ' %';
}),
PriceTaxField::make($base_field_name, $db_price_without_tax)->fullWidth()->displayUsing(function ($value) {
    return number_format((float)$value, 2, '.', '') . ' €';
})->names($names)->db_names( [$db_price_without_tax, $db_tax,  $db_price_with_tax]),
```

## Licence

The MIT License (MIT). Please see [License File](LICENCE) for more information.
