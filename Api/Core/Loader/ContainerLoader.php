<?php
namespace Api\Core\Loader;

use Interop\Container\ContainerInterface;

class ContainerLoader
{
    /**
     * Load all service containers
     *
     * @param ContainerInterface $container
     */
    public static function configure(ContainerInterface $container)
    {
        $containerConfig = [
            __DIR__ . '/../../V8/Config/services.php',
            __DIR__ . '/../../../custom/Extension/Api/Config/services.php'
        ];

        $services = self::loadFiles($containerConfig);
        foreach ($services as $service => $closure) {
            $container[$service] = $closure;
        }
    }

    /**
     * @param array $files
     *
     * @return array
     * @throws \RuntimeException When config file is not readable or does not contain an array.
     */
    private static function loadFiles(array $files)
    {
        $configs = [];

        foreach ($files as $file) {
            if (!file_exists($file) || !is_readable($file)) {
                throw new \RuntimeException(sprintf('Config file %s is not readable', $file));
            }

            $config = require $file;
            if (!is_array($config)) {
                throw new \RuntimeException(sprintf('Config file %s is invalid', $file));
            }

            $configs[] = $config;
        }

        // since we support 5.5.9, we can't use splat op here
        return !$configs ? $configs : array_reduce($configs, 'array_merge', []);
    }
}
