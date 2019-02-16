<?php

namespace Temori\ArtisanBrowser\Renderer;

use Illuminate\Filesystem\Filesystem;

class AssetRenderer
{
    /**
     * @var Illuminate\Filesystem\Filesystem
     */
    private $file;

    /**
     * @var string
     */
    private $path;

    /**
     * constructer
     *
     * @param Illuminate\Filesystem\Filesystem
     */
    public function __construct(Filesystem $file)
    {
        $this->file  = $file;
        $this->path = dirname(dirname(__FILE__)) . '/Resources/';
    }

    /**
     * return js or css resource.
     *
     * @param  string $str
     * @param  string $file
     * @return string
     */
    public function getAsset($str)
    {
        try {
            $asset = $this->file->get($this->path . $str);
        } catch (\Illuminate\Filesystem\FileNotFoundException $exception) {
            die('file not found.');
        }

        return $asset;
    }

    /**
     * return file time.
     *
     * @param string $str
     * @return string
     */
    public function getFileTime($str)
    {
        return filemtime($this->path . $str);
    }

    /**
     * Get file path.
     *
     * @param string $str
     * @return void
     */
    public function getPath($str)
    {
        return $this->path . $str;
    }
}
