<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Demo login credentials (login page)
    |--------------------------------------------------------------------------
    |
    | Shown on the login screen for local/testing. Disable in production by
    | setting SHOW_DEMO_CREDENTIALS=false in .env
    |
    */

    'enabled' => env('SHOW_DEMO_CREDENTIALS', env('APP_ENV') === 'local' || env('APP_DEBUG', false)),

    'password' => env('DEMO_LOGIN_PASSWORD', 'password'),

    'accounts' => [
        ['role' => 'Admin',      'email' => 'admin@skoolyst.com'],
        ['role' => 'Teacher',    'email' => 'ahmed.teacher@skoolyst.com'],
        ['role' => 'Student',    'email' => 'student2@skoolyst.com'],
        ['role' => 'Parent',     'email' => 'parent.father2@skoolyst.com'],
        ['role' => 'Accountant', 'email' => 'kamran.acc@skoolyst.com'],
    ],

];
