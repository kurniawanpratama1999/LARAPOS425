<?php

// 'isProduction' => env('MIDTRANS_SERVER_CLIENT', false),
return [
    'serverKey' => env('MIDTRANS_SERVER'),
    'isProduction' => false,
    'isSanitized' => true,
    'is3ds' => true,
];
