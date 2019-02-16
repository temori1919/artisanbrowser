<?php
namespace Temori\ArtisanBrowser\Controllers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Temori\ArtisanBrowser\Facades\ArtisanBrowser;

class AjaxController extends Controller
{
    /**
     * Run artisan command.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->filled('cmd')) {
            // Logging history.
            if (config('artisanbrowser.artisanbrowser_cache') > 0) {
                ArtisanBrowser::Logging($request->cmd);
            }
            
            $cmd = multiexplode([' ', '　'], $request->cmd);
            
            $command = '';
            $option = [];
            foreach ($cmd as $c) {
                // Split request array.
                $ex_cmd = mb_strtolower(trim($c));
                if ($ex_cmd === 'php' || $ex_cmd === 'artisan') {
                    continue;
                }

                // Get command.
                if (empty($command)) {
                    if ($ex_cmd === 'help') {
                        $option = ['-h' => true];
                    } else {
                        $command = $ex_cmd;
                    }
                // Get options.
                } else {
                     if (!preg_match("/^-/", $ex_cmd)) {
                        $option = array_add($option, 'name', $ex_cmd);
                    } else {
                        $ex_cmd = explode('=', $ex_cmd);
                        $ex_cmd[1] = !empty($ex_cmd[1]) ? $ex_cmd[1] : true;
                        $option = array_add($option, $ex_cmd[0], $ex_cmd[1]);
                    }
                    
                }
            }

            // Run artisan command.
            $status = Artisan::call($command, $option);
            $output = Artisan::output();
            
            $response['message'] = $output;
            $code = $status === 0 ? 200 : 500;

            // Commands with added history.
            $response['cmd'] = json_encode(ArtisanBrowser::getAllCommand());

            return response()->json($response, $code);
        } else {
            $response = [
                'message' => 'Illegal parameter number in definition',
            ];
            return response()->json($response, 500);
        }
    }
}
