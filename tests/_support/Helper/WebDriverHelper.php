<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Exception\ModuleException;
use Codeception\Module;
use SuiteCRM\Enumerator\DatabaseDriver;
use SuiteCRM\Test\Driver\WebDriver;

/**
 * Class WebDriverHelper
 * @package Helper
 * Helps to get configuration / environment variables for the WebDriver
 */
class WebDriverHelper extends Module
{
    public function getConfig()
    {
        try {
            return $this->moduleContainer->getModule(WebDriver::class)->_getConfig();
        } catch (ModuleException $e) {
            return false;
        }
    }

    /**
     * Gets the 'INSTANCE_URL' environment variable or 'url' in a yaml file.
     * @return string the test instance url.
     * @throws ModuleException
     */
    public function getInstanceURL()
    {
        $envInstanceURL = getenv('INSTANCE_URL');
        if ($envInstanceURL === false) {
            $config = $this->moduleContainer->getModule(WebDriver::class)->_getConfig();
            if (empty($config['url'])) {
                // return default
                return 'http://localhost/';
            }

            return $config['url'];
        }

        return $envInstanceURL;
    }

    /**
     * Gets the 'DATABASE_DRIVER' environment variable or 'database_driver' in a yaml file.
     * @return string
     * @throws ModuleException
     * @see DatabaseDriver
     */
    public function getDatabaseDriver()
    {
        $envDatabaseDriver = getenv('DATABASE_DRIVER');
        if ($envDatabaseDriver === false) {
            $config = $this->moduleContainer->getModule(WebDriver::class)->_getConfig();
            if (empty($config['database_driver'])) {
                // return default
                return DatabaseDriver::MYSQL;
            }

            return $config['database_driver'];
        }

        return $envDatabaseDriver;
    }

    /**
     * Gets the 'DATABASE_NAME' environment variable or 'database_name' in a yaml file.
     * @return string
     * @throws ModuleException
     */
    public function getDatabaseName()
    {
        $envDatabaseName = getenv('DATABASE_NAME');
        if ($envDatabaseName === false) {
            $config = $this->moduleContainer->getModule(WebDriver::class)->_getConfig();
            if (empty($config['database_name'])) {
                // return default
                return 'automated_tests';
            }

            return $config['database_name'];
        }

        return $envDatabaseName;
    }


    /**
     * Gets the 'DATABASE_HOST' environment variable or 'database_host' in a yaml file.
     * @return string
     * @throws ModuleException
     */
    public function getDatabaseHost()
    {
        $envDatabaseHost = getenv('DATABASE_HOST');
        if ($envDatabaseHost === false) {
            $config = $this->moduleContainer->getModule(WebDriver::class)->_getConfig();
            if (empty($config['database_host'])) {
                // return default
                return 'localhost';
            }

            return $config['database_host'];
        }

        return $envDatabaseHost;
    }

    /**
     * Gets the 'DATABASE_USER' environment variable or 'database_user' in a yaml file.
     * @return string the test instance url.
     * @throws ModuleException
     */
    public function getDatabaseUser()
    {
        $envDatabaseUser = getenv('DATABASE_USER');
        if ($envDatabaseUser === false) {
            $config = $this->moduleContainer->getModule(WebDriver::class)->_getConfig();
            if (empty($config['database_user'])) {
                // return default
                return 'automated_tests';
            }

            return $config['database_user'];
        }

        return $envDatabaseUser;
    }

    /**
     * Gets the 'DATABASE_PASSWORD' environment variable or 'database_password' in a yaml file.
     * @return string
     * @throws ModuleException
     */
    public function getDatabasePassword()
    {
        $envDatabasePassword = getenv('DATABASE_PASSWORD');
        if ($envDatabasePassword === false) {
            $config = $this->moduleContainer->getModule(WebDriver::class)->_getConfig();
            if (empty($config['database_password'])) {
                // return default
                return 'automated_tests';
            }

            return $config['database_password'];
        }

        return $envDatabasePassword;
    }


    /**
     * Gets the 'INSTANCE_ADMIN_USER' environment variable or 'instance_admin_user' in a yaml file.
     * @return string
     * @throws ModuleException
     */
    public function getAdminUser()
    {
        $envDatabasePassword = getenv('INSTANCE_ADMIN_USER');
        if ($envDatabasePassword === false) {
            $config = $this->moduleContainer->getModule(WebDriver::class)->_getConfig();
            if (empty($config['INSTANCE_ADMIN_USER'])) {
                // return default
                return 'admin';
            }

            return $config['instance_admin_user'];
        }

        return $envDatabasePassword;
    }

    /**
     * Gets the 'INSTANCE_ADMIN_PASSWORD' environment variable or 'instance_admin_password' in a yaml file.
     * @return string
     * @throws ModuleException
     */
    public function getAdminPassword()
    {
        $envDatabasePassword = getenv('INSTANCE_ADMIN_PASSWORD');
        if ($envDatabasePassword === false) {
            $webDriver = $this->moduleContainer->getModule('\SuiteCRM\Test\Driver\WebDriver');
            $config = $webDriver->_getConfig();
            if (empty($config['INSTANCE_ADMIN_PASSWORD'])) {
                // return default
                return 'admin';
            }

            return $config['instance_admin_password'];
        }

        return $envDatabasePassword;
    }

    // Add other methods to get environmental variables here...
}
