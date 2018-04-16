<?php
namespace SuiteCRM\Robo;

trait Path
{
    /**
     * @param string $path
     * @return string path converted for operating system eg Linux, Mac OS, Windows
     */
    private function toOsPath($path)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

}
