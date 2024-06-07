<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Quotes Driver
    |--------------------------------------------------------------------------
    */

    'default_driver' => env('AVATAR_DRIVER', 'giphy'),

    'giphy_api_key' => env('GIPHY_API_KEY', 'your-giphy-api-key-here'),

];
