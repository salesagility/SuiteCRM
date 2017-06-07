<?php

require_once __DIR__ . '/exceptions.php';

class SugarErrorLevel
{
    const debug      = 100;
    const info       = 70;
    const warn       = 50;
    const deprecated = 40;
    const error      = 25;
    const fatal      = 10;
    const security   = 5;
    const off        = 0;

    /**
     * @param $sugarErrorLevel
     * @return bool|string
     */
    public static function toString($sugarErrorLevel)
    {
        $response = false;
        switch ($sugarErrorLevel)
        {
            case self::debug:
                $response = 'debug';
                break;
            case self::info:
                $response = 'info';
                break;
            case self::warn:
                $response = 'warn';
                break;
            case self::deprecated:
                $response = 'deprecated';
                break;
            case self::error:
                $response = 'error';
                break;
            case self::fatal:
                $response = 'fatal';
                break;
            case self::security:
                $response = 'security';
                break;
            case self::off:
                $response = 'off';
                break;
        }
        return $response;
    }
}