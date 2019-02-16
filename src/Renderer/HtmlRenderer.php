<?php

namespace Temori\ArtisanBrowser\Renderer;

use Illuminate\Routing\RouteCollection;
use Illuminate\Http\Response;

class HtmlRenderer
{
    /**
     * @var
     */
    private $renderContent;

    /**
     * Set contents in html.
     *
     * @param \Illuminate\Routing\RouteCollection $collection
     * @param array  $artisan
     * @param string $js_file_time
     * @param string $css_file_time
     * @return void
     */
    public function setHtml(RouteCollection $collection, $artisan, $js_file_time, $css_file_time)
    {
        $js  = [
            'js' => route('artisanbrowser.assets.js') . '?date=' . $js_file_time,
            'jquery' => route('artisanbrowser.assets.jquery'),
        ];
        $css = route('artisanbrowser.assets.css') . '?date=' . $css_file_time;

        $this->renderContent = view('artisanbrowser::index', compact('js', 'css', 'collection', 'artisan'))->render();
    }

    /**
     * Html render.
     *
     * @param \Illuminate\Http\Response $response
     * @return \Illuminate\Http\Response
     */
    public function render(Response $response)
    {
        $content = $response->getContent();

        $position = strripos($content, '</body>');
        
        if (false !== $position) {
            $content = substr($content, 0, $position) . $this->renderContent . substr($content, $position);
        } else {
            $content = $content . $this->renderContent;
        }
        
        // add new content and reset the content length.
        $response->setContent($content);
        $response->headers->remove('Content-Length');

        return $response;
    }
}
