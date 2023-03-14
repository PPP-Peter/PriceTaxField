<?php

namespace Wame\PriceTaxField;

use Laravel\Nova\Fields\Field;

class PriceTaxField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'price-tax-field';


    public function db_names($value) {
        return $this->withMeta([
            'dbNames' => $value,
        ]);
    }

    public function names($value){
        return $this->withMeta([
            'names' => $value,
        ]);
    }

    public function defaultTax($value){
        return $this->withMeta([
            'defaultTax' => $value,
        ]);
    }
}
