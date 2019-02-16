<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ArtisanBrowser is enabled by default, 
    | when you whant to use ArtisanBrowser is set for true.
    |--------------------------------------------------------------------------
    */
    'artisanbrowser_enabled' => true,
    
    /*
    |--------------------------------------------------------------------------
    | Number of command history to cache.
    |--------------------------------------------------------------------------
    */
    'artisanbrowser_cache' => 100,
    'artisanbrowser_log_path' => storage_path() . '/logs/artisanbrowser.log',

    /*
    |--------------------------------------------------------------------------
    | Write the url you want to exclude.
    |--------------------------------------------------------------------------
    */
    'artisanbrowser_exclusion' => [
        '*debugbar*',
        '*_artisanbrowser*',
    ],
];
