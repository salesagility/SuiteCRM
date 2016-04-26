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
class SystemChecker
{
    /** @var  array */
    protected static $configuration;

    /**
     * Run system checks prior to installation
     *
     * @param array $configuration
     * @throws \Exception
     * @return array
     */
    public static function runChecks($configuration)
    {
        self::$configuration = $configuration;

        self::checkLockedInstaller();
        self::checkPhpVersion();
        self::checkPhpBackwardCompatibilityVersion();
        self::checkXmlParsing();
        self::checkMbstrings();
        self::checkZipSupport();
        self::checkConfigFiles();
        self::checkCustomDirectory();
        self::checkCacheDirs();
        //@todo: still missing some checks from 'install/installSystemCheck.php' from line: 270

        return self::$configuration;
    }

    /**
     * @throws \Exception
     */
    protected static function checkCacheDirs()
    {
        $cache_files = [
            'images',
            'layout',
            'pdf',
            'xml',
            'include/javascript'
        ];
        foreach ($cache_files as $cache_file) {
            $dirname = PROJECT_ROOT . '/' . sugar_cached($cache_file);

            if ((is_dir($dirname)) || @sugar_mkdir($dirname, 0755, TRUE)) {
                InstallUtils::makeWritable($dirname);
            }
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkCustomDirectory()
    {
        InstallUtils::makeWritable(PROJECT_ROOT . '/custom');
    }



    /**
     * @throws \Exception
     */
    protected static function checkConfigFiles()
    {
        if (file_exists(PROJECT_ROOT . '/config.php')) {
            InstallUtils::makeWritable(PROJECT_ROOT . '/config.php');
        }
        if (file_exists(PROJECT_ROOT . '/config_override.php')) {
            InstallUtils::makeWritable(PROJECT_ROOT . '/config.php');
        }
    }


    /**
     * @throws \Exception
     */
    protected static function checkZipSupport()
    {
        if (!class_exists('ZipArchive')) {
            throw new \Exception("ZIP support is unavailable!");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkMbstrings()
    {
        if (!function_exists('mb_strlen')) {
            throw new \Exception("MBString support is unavailable!");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkXmlParsing()
    {
        if (!function_exists('xml_parser_create')) {
            throw new \Exception("XML Parser Libraries are unavailable!");
        }
    }


    /**
     * @throws \Exception
     */
    protected static function checkPhpBackwardCompatibilityVersion()
    {
        if (ini_get("zend.ze1_compatibility_mode")) {
            throw new \Exception(
                "Php Backward Compatibility mode is turned on. Set zend.ze1_compatibility_mode to Off!"
            );
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkPhpVersion()
    {
        $php_version = constant('PHP_VERSION');
        if (check_php_version($php_version) == -1) {
            throw new \Exception("Your version of PHP is not supported by SuiteCRM: $php_version!");
        }
    }

    /**
     * @throws \Exception
     */
    protected static function checkLockedInstaller()
    {
        if (!isset(self::$configuration["force"]) || self::$configuration["force"] != TRUE) {
            if (file_exists(PROJECT_ROOT . '/config.php')) {
                require(PROJECT_ROOT . '/config.php');
                if (isset($sugar_config['installer_locked']) && $sugar_config['installer_locked'] == TRUE) {
                    throw new \Exception(
                        "Your deployment is locked! If you are sure you want to rerun the installation process, use the --force option."
                    );
                }
            }
        }
    }
}