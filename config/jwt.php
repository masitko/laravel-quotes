<?php

return [

    /*
    |--------------------------------------------------------------------------
    | JWT Secret
    |--------------------------------------------------------------------------
    | The secret should contain a number, a upper and a lowercase letter, and a
    | special character *&!@%^#$. It should be at least 12 characters in length.
    */
    'secret' => env('JWT_SECRET', 'Not-so-secret-Secret-0!'),

    /*
    |--------------------------------------------------------------------------
    | Token expiration time
    |--------------------------------------------------------------------------
    */
    'expiration' => env('JWT_EXPIRATION', 3600)

];
