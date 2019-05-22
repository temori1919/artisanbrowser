<?php

namespace Temori\ArtisanBrowser;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Temori\ArtisanBrowser\ArtisanBrowser;
use Illuminate\Http\Response;


class ArtisanBrowserServiceProvider extends ServiceProvider
{
    /**
     * @var
     */
    protected $routeMiddleware = \Temori\ArtisanBrowser\Middleware\Inject::class;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'artisanbrowser');
        
        $attributes = [
            'prefix'    => '__artisanbrowser',
            'namespace' => 'Temori\ArtisanBrowser\Controllers',
        ];
        
        app('router')->group($attributes, function($router) {
            $router->get('assets/js', 'AssetController@js')->name('artisanbrowser.assets.js');
            $router->get('assets/jquery', 'AssetController@jquery')->name('artisanbrowser.assets.jquery');
            $router->get('assets/draggabilly', 'AssetController@draggabilly')->name('artisanbrowser.assets.draggabilly');
            $router->get('assets/suggest', 'AssetController@suggest')->name('artisanbrowser.assets.suggest');
            $router->get('assets/css', 'AssetController@css')->name('artisanbrowser.assets.css');
            $router->get('assets/img', 'AssetController@img')->name('artisanbrowser.assets.img');
            $router->post('assets/cmd', 'AjaxController@index')->name('artisanbrowser.assets.ajax');
        });

        $this->publishes([
            __DIR__ . '/../config/artisanbrowser.php' => config_path('artisanbrowser.php'),
        ]);

        $this->registerMiddleware();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/artisanbrowser.php', 'artisanbrowser'
        );
    }
    
    /**
     * Register Middleware.
     *
     * @return void
     */
    protected function registerMiddleware()
    {
        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware($this->routeMiddleware);
    }
}
