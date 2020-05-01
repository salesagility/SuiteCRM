<?php

namespace Api\Core\Resolver;

class ConfigResolver
{
    /**
     * Loading and merge files which are arrays.
     *
     * @param array $files
     *
     * @throws \InvalidArgumentException when config file does not contain an array
     *
     * @return array
     */
    public static function loadFiles(array $files)
    {
        $configs = [];

        foreach ($files as $file) {
            // base dir must exist in entryPoint.php
            $file = sprintf('%s/%s', $GLOBALS['BASE_DIR'], $file);

            if (self::isFileExist($file)) {
                $config = require $file;
            }

            if (!is_array($config)) {
                throw new \InvalidArgumentException(sprintf('File %s is invalid', $file));
            }

            $configs[] = $config;
        }

        // since we support 5.5.9, we can't use splat op here
        return !$configs ? $configs : array_reduce($configs, 'array_merge', []);
    }

    /**
     * @param string $file
     *
     * @throws \RuntimeException when config file is not readable
     *
     * @return bool
     */
    public static function isFileExist($file)
    {
        if (!file_exists($file) || !is_readable($file)) {
            throw new \RuntimeException(sprintf('File %s is not readable', $file));
        }

        return true;
    }
}
