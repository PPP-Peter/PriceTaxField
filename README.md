# Laravel Nova Price Tax Fields

<img alt="preview" src="img.png">

## Installation

``` php
composer require wamesk/laravel-nova-price-tax-field
```

## Usage
Add to your nova model <br>
<small>
(You can change sort field but getPriceTaxField must be last, in migration use decimal or double)
</small>

#### Add Alias
``` php
'PriceHelper' => Wame\PriceTaxField\PriceField::class,
```

#### Add to your models
``` php
use Wame\PriceTaxField\PriceField;

// Price tax field options
$price_tax_options = [
    'db_names'          => ['base_price', 'tax', 'price_with_tax'],
    'names'             => ['bez DPH', 'daň', 's DPH'],
    'base_field_name'   => 'Cena',
    'default_tax'       => 20,
    'one_col'           => true,  // display all fields in one column
    'tax_in_one_col'    => true,  // not show tax value in one column
    'col_classes'       => ['strong', 'small', 'small'],  // classes for rows in column
];
        
PriceField::getPriceWithoutTax( $price_tax_options, $this),
PriceField::getPriceTax($price_tax_options)->rules('required'),
PriceField::getPriceWithTax($price_tax_options)->rules('required'),
PriceField::getPriceTaxField($price_tax_options)->rules('required'),
```

<img alt="preview" src="img2.png">


<br><br>

### OR you can use this METHOD for more custom edits

``` php
use Wame\PriceTaxField\PriceTaxField;

// Price tax field options
$db_price_without_tax = 'price';
$db_tax = 'tax';
$db_price_with_tax = 'price_with_tax';
$names = ['bez DPH', 'daň', 's DPH'];
$base_field_name = 'Cena';
$default_tax = 20;
$one_col = true;  // display all fields in one column
$tax_in_one_col = true;

Number::make($base_field_name, $db_price_without_tax)->displayUsing(function ($value) {
    return number_format((float)$value, 2, '.', '') . ' €';
})->hideWhenCreating()->hideWhenUpdating(),
Number::make($names[1], $db_tax)->displayUsing(function ($value) {
    return $value. ' %';
})->rules('required'),
Number::make($names[2], $db_price_with_tax)->displayUsing(function ($value) {
    return number_format((float)$value, 2, '.', '') . ' €';
})->step(0.01)->rules('required'),

PriceTaxField::make($base_field_name, $db_price_without_tax)->fullWidth()->displayUsing(function ($value) {
    return number_format((float)$value, 2, '.', '') . ' €';
})->names($names)->db_names( [$db_price_without_tax, $db_tax,  $db_price_with_tax])->hideFromIndex()->hideFromDetail()
    ->defaultTax($default_tax)->rules('required'),
```


## Licence

The MIT License (MIT). Please see [License File](LICENCE) for more information.
