<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/9/5
 * Time: 11:03
 */

return [
    'clients' => [
        'password' => [
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID', 2),
            'client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
        ],
    ],
];