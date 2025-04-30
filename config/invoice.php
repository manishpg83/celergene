<?php

return [

    'invoice_variable_name' => env('INVOICE_VARIABLE_NAME', 'celergen'),

    'starting_numbers' => [
        'caviarlieri' => 17000,
        'celergen' => 13000,
        'default' => 10000,
    ],    

    'prefixes' => [
        'regular' => 'INV-',
        'shipping' => 'SHIP-',       
    ],
];