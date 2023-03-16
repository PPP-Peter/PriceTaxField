<?php

declare(strict_types = 1);

return [
    'db_names'          => [
        'price',
        'tax',
        'price_with_tax'
    ],
    'default_tax'       => 20,
    'one_col'           => true,  // display all fields in one column
    'tax_in_one_col'    => true,  // not show tax value in one column
    'col_classes'       => ['strong', 'small', 'small'],  // classes for rows in column

//        names edit in translate file
//        'names'             => ['bez DPH', 'daň', 's DPH'],
//        'base_field_name'   => 'cena',

];
