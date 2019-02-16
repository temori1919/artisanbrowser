<?php
namespace Temori\ArtisanBrowser\Controllers;

use Illuminate\Routing\Controller;
use Temori\ArtisanBrowser\Facades\ArtisanBrowser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class AssetController extends Controller
{
    /**
     * Js response.
     *
     * @return Illuminate\Http\Response
     */
    public function js()
    {
        return new Response(
            ArtisanBrowser::getResource('artisanbrowser.js'), 200, [
                'Content-Type' => 'text/javascript',
            ]
        );
    }

    /**
     * Css response.
     *
     * @return Illuminate\Http\Response
     */
    public function css()
    {
        return new Response(
            ArtisanBrowser::getResource('artisanbrowser.css'), 200, [
                'Content-Type' => 'text/css',
            ]
        );
    }

    /**
     * Image response.
     *
     * @return Illuminate\Http\Response
     */
    public function img() {
        $file = ArtisanBrowser::getFilePath('image/icon_laravel.png');
        $mime_type = File::mimeType($file);
        $headers = [
            'Content-type' => $mime_type
        ];
    
        return response()->file($file, $headers);
    }
    
    /**
     * Suggest js.
     *
     * @return Illuminate\Http\Response
     */
    public function suggest()
    {
        return new Response(
            ArtisanBrowser::getResource('vendor/suggest.js'), 200, [
                'Content-Type' => 'text/javascript',
            ]
        );
    }

    /**
     * Jquery.
     *
     * @return Illuminate\Http\Response
     */
    public function jquery()
    {
        return new Response(
            ArtisanBrowser::getResource('vendor/jquery-1.12.4.min.js'), 200, [
                'Content-Type' => 'text/javascript',
            ]
        );
    }
}
