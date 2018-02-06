<?php
namespace Api\Core\Config;

class ConfigResolver
{
    /**
     * Get all files which return all dependencies as array
     *
     * @param array $files
     *
     * @return array
     * @throws \RuntimeException When config file is not readable or does not contain an array.
     */
    public static function resolveFromFiles(array $files = [])
    {
        $configs = [];

        foreach ($files as $file) {
            if (!file_exists($file) || !is_readable($file)) {
                throw new \RuntimeException(sprintf('failed to read config file: "%s"', $file));
            }

            $config = require $file;
            if (!is_array($config)) {
                throw new \RuntimeException(sprintf('invalid config file: "%s"', $file));
            }

            $configs[] = $config;
        }

        return !$configs ? $configs : array_merge(...$configs);
    }
}
