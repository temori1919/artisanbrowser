<?php

if (!function_exists('multiexplode')) {
    /**
     * Multiple delimiter exploded.
     *
     * @param array $delimiters
     * @param string $string
     * @return string 
     */
    function multiexplode($delimiters, $string) 
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
}
