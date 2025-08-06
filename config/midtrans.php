<?php

return [
    'clientKey'     => env('MIDTRANS_CLIENT_KEY'),
    'serverKey'     => env('MIDTRANS_SERVER_KEY'),
    'isProduction'  => env('MIDTRANS_IS_PRODUCTION', false),
    'isSanitized'   => true,
    'is3ds'         => true,
];
