<?php
namespace Api\Core\Loaders;

use Api\Core\Config\ConfigResolver;
use Interop\Container\ContainerInterface;

class ContainerLoader
{
    /**
     * Load all service containers
     *
     * @param ContainerInterface $container
     */
    public static function configureInstances(ContainerInterface $container)
    {
        $containerConfig = [
            __DIR__ . '/../../V8/Config/services.php'
        ];

        $services = ConfigResolver::resolveFromFiles($containerConfig);
        foreach ($services as $service => $closure) {
            $container[$service] = $closure;
        }
    }
}
