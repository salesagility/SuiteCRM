<?php
/**
 * Created by Adam Jakab.
 * Date: 08/03/16
 * Time: 16.07
 */

namespace SuiteCrm\Install;

/**
 * Class SystemChecker
 * @package SuiteCrm\Install
 */
class SystemChecker {

    /**
     * Run all system checks prior to installation
     * @throws \Exception
     */
    public static function runChecks() {
        self::checkPhpVersion();
        self::checkPhpBackwardCompatibilityVersion();
        self::checkDatabaseDrivers();
        self::checkXmlParsing();
        self::checkMbstrings();
        self::checkZipSupport();
        self::checkConfigFile();
        self::checkConfigOverrideFile();
        self::checkCustomDirectory();
        self::checkCacheDirs();
        //@todo: still missing some checks from 'install/installSystemCheck.php' from line: 270

    }

    /**
     * @throws \Exception
     */
    protected static function checkCacheDirs() {
        $cache_files = [
            'images',
            'layout',
            'pdf',
            'xml',
            'include/javascript'
        ];
        foreach ($cache_files as $cache_file) {
            $dirname = PROJECT_ROOT . '/' . sugar_cached( $cache_file);
            $ok = FALSE;
            if ((is_dir($dirname)) || @sugar_mkdir($dirname, 0755, TRUE)) {
                $ok = make_writable($dirname);
            }
            if (!$ok) {
                throw new \Exception("The Cache Directory($dirname) is not writable.");
            }
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkCustomDirectory() {
        if (!make_writable(PROJECT_ROOT . '/custom')) {
            throw new \Exception("The Custom Directory exists but is not writable.");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkConfigOverrideFile() {
        if (file_exists(PROJECT_ROOT . '/config_override.php')
            && (!(make_writable(PROJECT_ROOT . '/config_override.php'))
                || !(is_writable(
                    PROJECT_ROOT . '/config_override.php'
                )))
        ) {
            throw new \Exception("The config_override file is not writable!");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkConfigFile() {
        if (file_exists(PROJECT_ROOT . '/config.php')
            && (!(make_writable(PROJECT_ROOT . '/config.php')) || !(is_writable(PROJECT_ROOT . '/config.php')))
        ) {
            throw new \Exception("The config file is not writable!");
        }
    }


    /**
     * @throws \Exception
     */
    protected static function checkZipSupport() {
        if (!class_exists('ZipArchive')) {
            throw new \Exception("ZIP support is unavailable!");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkMbstrings() {
        if (!function_exists('mb_strlen')) {
            throw new \Exception("MBString support is unavailable!");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkXmlParsing() {
        if (!function_exists('xml_parser_create')) {
            throw new \Exception("XML Parser Libraries are unavailable!");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkDatabaseDrivers() {
        $drivers = \DBManagerFactory::getDbDrivers();
        if (empty($drivers)) {
            throw new \Exception("No Database driver is available!");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkPhpBackwardCompatibilityVersion() {
        if (ini_get("zend.ze1_compatibility_mode")) {
            throw new \Exception("Php Backward Compatibility mode is turned on. Set zend.ze1_compatibility_mode to Off!");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkPhpVersion() {
        $php_version = constant('PHP_VERSION');
        if (check_php_version($php_version) == -1) {
            throw new \Exception("Your version of PHP is not supported by SuiteCRM: $php_version!");
        }
    }
}