<?php
namespace Temori\ArtisanBrowser\Controllers;

use Illuminate\Routing\Controller;
use Temori\ArtisanBrowser\Facades\ArtisanBrowser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class AssetController extends Controller
{
    /**
     * Artisan browser js.
     *
     * @return Illuminate\Http\Response
     */
    public function js()
    {
        return $this->responseJs('artisanbrowser.js');
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
        $file = ArtisanBrowser::getFilePath('image/logo.png');
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
        return $this->responseJs('vendor/suggest.js');
    }

    /**
     * Jquery.
     *
     * @return Illuminate\Http\Response
     */
    public function jquery()
    {
        return $this->responseJs('vendor/jquery-1.12.4.min.js');
    }

    /**
     * Draggabilly.
     *
     * @return \Illuminate\Http\Response
     */
    public function draggabilly()
    {
        return $this->responseJs('vendor/draggabilly.pkgd.min.js');
    }

    /**
     * Js response.
     * @param string $file
     * @return \Illuminate\Http\Response
     */
    protected function responseJs($file = '')
    {
        return new Response(
            ArtisanBrowser::getResource($file), 200, [
                'Content-Type' => 'text/javascript',
            ]
        );
    }
}
