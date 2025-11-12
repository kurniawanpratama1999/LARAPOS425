<?php

// 'isProduction' => env('MIDTRANS_SERVER_CLIENT', false),
return [
    'serverKey' => env('MIDTRANS_SERVER_KEY'),
    'isProduction' => false,
    'isSanitized' => true,
    'is3ds' => true,
];
