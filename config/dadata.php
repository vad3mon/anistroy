<?php

/**
 * Copyright (c) Dmitry Kovalev.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/movemoveapp/laravel-dadata
 */
return [
    /*
    |--------------------------------------------------------------------------
    | DaData config
    |--------------------------------------------------------------------------
    |
    | To receive the parameters of the token and the secret, you need to
    | register on the https://dadata.ru/ website and get credentials from the cabinet.
    |
    */

    'token'     => env('DADATA_TOKEN', "63f499753c1c2c70000526e54d57e11dbd4a25da"),

    /*
     |--------------------------------------------------------------------------
     | Secret key for standardization
     |--------------------------------------------------------------------------
     */
    'secret'    => env('DADATA_SECRET', "82de831f07ccf63894ea1897b224905dfd207522"),

    /*
     |--------------------------------------------------------------------------
     | DaData timeout
     |--------------------------------------------------------------------------
     | The maximum number of seconds to wait for a response
     */
    'timeout'   => env('DADATA_TIMEOUT', 10),

];
