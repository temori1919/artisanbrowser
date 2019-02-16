<?php
namespace Temori\ArtisanBrowser\Logs;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class HistoryLogger extends Logger
{
    /**
     * @var
     */
    protected $path;
    
    /**
     * Constructer.
     *
     * @param string $name
     * @param string $path
     */
    public function __construct($name, $path)
    {        
        parent::__construct($name);
        $this->path = $path;
    }
        
    /**
     * Add artisan command history.
     *
     * @return void
     */
    public function addLine($command, $line_number)
    {
        $this->removeLine($line_number);

        // Logging command history.
        $level = 'debug';
        $bubble = true;
        $permission = 0777;

        $log_format = "%message%\n";
        $log_date_format = 'Y-m-d H:i:s.u';
        
        $handler = new StreamHandler($this->path, $level , $bubble, $permission);
        $handler->setFormatter(new LineFormatter($log_format, $log_date_format , true, true));
        $this->pushHandler($handler);

        //　Output message.
        $this->addInfo($command);
    }

    /**
     * Delete the specified number of lines or more in the command history.
     *
     * @param integer $number
     * @return void
     */
    public function removeLine($number)
    {
        $log = $this->getLogContent();

        if (!$log) return false;

        $diff = ($number - 1) - count($log);
        if ($diff < 0) {
            for ($i = 0; $i < -$diff; $i++) { 
                unset($log[$i]);
            }
        }

        file_put_contents($this->path, implode(PHP_EOL, $log) . PHP_EOL);
    }

    /**
     * Get contents of Log.
     *
     * @return void
     */
    public function getLogContent()
    {
        if (file_exists($this->path)) {
            return file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        } else {
            return [];
        }
    }
}
