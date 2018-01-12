<?php
namespace Api\Core\Configure;

use Interop\Container\ContainerInterface;

class Container
{
    public static function configureRoutes(ContainerInterface $container)
    {
        $services = require __DIR__ . '/../../V8/Config/services.php';
        foreach ($services as $service => $closure) {
            $container[$service] = $closure;
        }
    }
}
