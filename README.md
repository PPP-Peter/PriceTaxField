# Laravel Nova Price Tax Fields

<img alt="preview" src="img.png">

## Installation

``` php
composer require wamesk/laravel-nova-price-tax-fields
```

## Usage
Add to your nova model <br>
<small>(Helper = field, you can change sort field but getPriceTaxField must be last) </small>

``` php
use Wame\PriceTaxField\PriceTaxField;
use Wame\PriceTaxField\Helpers;

// Price tax field options
$db_price_without_tax = 'price';
$db_tax = 'tax';
$db_price_with_tax = 'price_with_tax';
$names = ['bez DPH', 'daň', 's DPH'];
$base_field_name = 'Cena';
$default_tax = 20;
        
Helpers::getPriceWithoutTax($base_field_name, $db_price_without_tax),
Helpers::getPriceTax($names[1], $db_tax)->rules('required'),
Helpers::getPriceWithTax($names[2], $db_price_with_tax)->rules('required'),
Helpers::getPriceTaxField($base_field_name, $db_price_without_tax, $names, $db_tax, $db_price_with_tax, $default_tax)->rules('required'),

```
### OR use SECOND METHOD for more custom edits

``` php
use Wame\PriceTaxField\PriceTaxField;

// Price tax field options
$db_price_without_tax = 'price';
$db_tax = 'tax';
$db_price_with_tax = 'price_with_tax';
$names = ['bez DPH', 'daň', 's DPH'];
$base_field_name = 'Cena';
$default_tax = 20;

Number::make($base_field_name, $db_price_without_tax)->displayUsing(function ($value) {
    return number_format((float)$value, 2, '.', '') . ' €';
})->hideWhenCreating()->hideWhenUpdating(),
Number::make($names[1], $db_tax)->displayUsing(function ($value) {
    return $value. ' %';
})->rules('required'),
Number::make($names[2], $db_price_with_tax)->displayUsing(function ($value) {
    return number_format((float)$value, 2, '.', '') . ' €';
})->rules('required'),

PriceTaxField::make($base_field_name, $db_price_without_tax)->fullWidth()->displayUsing(function ($value) {
    return number_format((float)$value, 2, '.', '') . ' €';
})->names($names)->db_names( [$db_price_without_tax, $db_tax,  $db_price_with_tax])->hideFromIndex()->hideFromDetail()
    ->defaultTax($default_tax)->rules('required'),
```

## Licence

The MIT License (MIT). Please see [License File](LICENCE) for more information.
