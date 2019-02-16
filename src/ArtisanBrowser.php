<?php

namespace Temori\ArtisanBrowser;

use Temori\ArtisanBrowser\Renderer\HtmlRenderer;
use Temori\ArtisanBrowser\Renderer\AssetRenderer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Temori\ArtisanBrowser\Logs\HistoryLogger;

class ArtisanBrowser
{
    /**
     * @var
     */
    protected $asset;

     /**
     * @var
     */
    protected $logger;

    /**
     * Constructer.
     */
    public function __construct()
    {
        $this->asset  = new AssetRenderer(app('files'));
        $this->logger = new HistoryLogger('artisanbrowser', config('artisanbrowser.artisanbrowser_log_path'));
    }

    /**
     * Html render.
     *
     * @param \Illuminate\Http\Response $response
     * @return void
     */
    public function render(Response $response)
    {
        $html = new HtmlRenderer();
        $html->setHtml(
            app('router')->getRoutes(), 
            $this->getAllCommand(),
            $this->asset->getFileTime('artisanBrowser.js'),
            $this->asset->getFileTime('artisanBrowser.css')
        );
        
        return $html->render($response);
    }

    /**
     * Logging command history. 
     *
     * @param string $command
     * @return void
     */
    public function Logging($command)
    {
        $this->logger->addLine($command, config('artisanbrowser.artisanbrowser_cache'));
    }

    /**
     * Get command history log.
     *
     * @return array
     */
    public function getHistoryLog()
    {
        return $this->logger->getLogContent();
    }

    /**
     * Get asset resource.
     *
     * @param string $file
     * @return string
     */
    public function getResource($file)
    {
        return $this->asset->getAsset($file);
    }

    /**
     * Get file path.
     *
     * @param string $str
     * @return string
     */
    public function getFilePath($str = '')
    {
        return $this->asset->getPath($str);
    }

    /**
     * Get all artisan command.
     *
     * @return array
     */
    public function getAllCommand()
    {
        $cmd = app('\Illuminate\Support\Facades\Artisan')::all();
        $cmd_list = [];
        foreach ($cmd as $key => $val) {
            if ($key === 'route:list') continue;
            $cmd_list[]  = 'php artisan ' . $key;
        }
        
        $history = $this->logger->getLogContent();

        if (count($history) > 1) krsort($history);

        return array_values(array_unique(array_merge($history, $cmd_list)));
    }
}
