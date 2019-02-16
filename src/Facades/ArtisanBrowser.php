<?php

namespace Temori\ArtisanBrowser\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * ArtisanBrowser class.
 * 
 * @method static \Temori\ArtisanBrowser\ArtisanBrowser render(Illuminate\Http\Response $response)
 * @method static \Temori\ArtisanBrowser\ArtisanBrowser Logging($command)
 * @method static \Temori\ArtisanBrowser\ArtisanBrowser getHistoryLog()
 * @method static \Temori\ArtisanBrowser\ArtisanBrowser getResource($file)
 * @method static \Temori\ArtisanBrowser\ArtisanBrowser getFilePath($str = '')
 * @method static \Temori\ArtisanBrowser\ArtisanBrowser getAllCommand()
 */
class ArtisanBrowser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Temori\ArtisanBrowser\ArtisanBrowser::class;
    }
}
