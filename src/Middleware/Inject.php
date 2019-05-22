<?php

namespace Temori\ArtisanBrowser\Middleware;

use Closure;
use Temori\ArtisanBrowser\Facades\ArtisanBrowser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class Inject
{
    /**
     * inject context to response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!config('artisanbrowser.artisanbrowser_enabled', true)) return $next($request);
        
        $response = $next($request);

        // Don't process when redirect response.
        if (get_class($response) != 'Illuminate\Http\Response') return $response;

        // If the Content-Type is not html, we will return the response as is.
        if (($response->headers->has('Content-Type') && strpos($response->headers->get('Content-Type'), 'html') === false)
         || empty($response->headers->has('Content-Type'))) {
            return $response;
        }

        // Exclusion urls.
        foreach (config('artisanbrowser.exclusion', []) as $dir) {
            if ($request->is($dir)) return $response;
        }
        
        return ArtisanBrowser::render($response);
    }
}
