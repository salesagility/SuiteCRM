<?php
namespace Api\Core\Loader;

use Interop\Container\ContainerInterface;
use Slim\Container;

class ContainerLoader
{
    /**
     * @var ContainerInterface|\ArrayAccess
     */
    private static $instance;

    /**
     * @return ContainerInterface
     */
    public static function getInstance(): ContainerInterface
    {
        if (!self::$instance) {
            self::$instance = new Container(require __DIR__ . '/../Config/slim.php');

            // since we have only V8
            $services = require __DIR__ . '/../../V8/Config/services.php';
            foreach ($services as $service => $closure) {
                self::$instance[$service] = $closure;
            }
        }

        return self::$instance;
    }

    /**
     * @param string $pattern
     * @return mixed
     */
    public static function get($pattern)
    {
        return self::getInstance()->get($pattern);
    }
}
