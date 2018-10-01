<?php
namespace Api\Core\Config;

class ApiConfig
{
    // we still support 5.5.9
    private static $slimSettings = [
        'Api/Core/Config/slim.php',
    ];

    private static $containers = [
        'Api/V8/Config/services.php',
    ];

    private static $routes = [
        'Api/V8/Config/routes.php',
    ];

    const OAUTH2_PRIVATE_KEY = 'Api/V8/OAuth2/private.key';
    const OAUTH2_PUBLIC_KEY = 'Api/V8/OAuth2/public.key';
    const OAUTH2_ENCRYPTION_KEY = 'KcWedk/XtvWgtuf7UHx6ayHnrIaMC/t4RjZrdVBY2Ho=';
    
    /**
     *
     * @var boolean
     */
    private static $debugExceptions = false;
    
    /**
     *
     * @return boolean
     */
    public static function getDebugExceptions()
    {
        return self::$debugExceptions;
    }

    /**
     * @return array
     */
    public static function getSlimSettings()
    {
        return self::$slimSettings;
    }

    /**
     * @return array
     */
    public static function getContainers()
    {
        return self::$containers;
    }

    /**
     * @return array
     */
    public static function getRoutes()
    {
        return self::$routes;
    }
}
