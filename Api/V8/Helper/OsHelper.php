<?php

namespace Api\V8\Helper;

/**
 * Class OsHelper
 */
class OsHelper
{
    const OS_WINDOWS = 'WINDOWS';
    const OS_LINUX = 'LINUX';
    const OS_OSX = 'OSX';

    /**
     * @return string
     *
     * @throws \RuntimeException When unable to determine OS.
     */
    public static function getOS()
    {
        switch (true) {
            case stristr(PHP_OS, 'DAR'):
                return self::OS_OSX;

            case stristr(PHP_OS, 'WIN'):
                return self::OS_WINDOWS;

            case stristr(PHP_OS, 'LINUX'):
                return self::OS_LINUX;

            default:
                throw new \RuntimeException('Unable to determine OS');
        }
    }
}
