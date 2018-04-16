<?php
namespace SuiteCRM\Robo;

trait OperatingSystem
{
    /**
     * @return bool true when operating system is BSD
     */
    private function isOsBSD() {
        return stristr(php_uname('s'), 'BSD') !== FALSE;
    }

    /**
     * @return bool true when operating system is Linux
     */
    private function isOsLinux() {
        return stristr(php_uname('s'), 'Linux') !== FALSE;
    }

    /**
     * @return bool true when operating system is Mac OS X
     */
    private function isOsMacOSX() {
        return stristr(php_uname('s'), 'Darwin') !== FALSE;
    }

    /**
     * @return bool true when operating system is Solaris
     */
    private function isOsSolaris() {
        return stristr(php_uname('s'), 'Solaris') !== FALSE;
    }

    /**
     * @return bool true when operating system is Unknown
     */
    private function isOsUnknown() {
        return php_uname('s') === 'Unknown';
    }

    /**
     * @return bool true when operating system is Windows
     */
    private function isOsWindows() {
        return stristr(php_uname('s'), 'Windows') !== FALSE;
    }

}
