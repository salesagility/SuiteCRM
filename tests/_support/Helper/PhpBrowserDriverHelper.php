<?php
namespace Helper;

use SuiteCRM\Enumerator\DatabaseDriver;

/**
 * Class PhpBrowserDriverHelper
 * @package Helper
 * Helps to get configuration / environment variables for the PhpBrowser Driver
 */
class PhpBrowserDriverHelper extends \Codeception\Module
{
    public function getConfig()
    {
        $webDriver = $this->moduleContainer->getModule('PhpBrowser');
        return $webDriver->_getConfig();
    }

    /**
     * Gets the 'INSTANCE_URL' environment variable or 'url' in a yaml file.
     * @return string the test instance url.
     */
    public function getInstanceURL()
    {
        $envInstanceURL = getenv('INSTANCE_URL');
        if($envInstanceURL === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['url'])) {
                // return default
                return 'http://localhost/';
            } else {
                return $config['url'];
            }
        } else {
            return $envInstanceURL;
        }
    }

    /**
     * Gets the 'DATABASE_DRIVER' environment variable or 'database_driver' in a yaml file.
     * @see DatabaseDriver
     * @return string
     */
    public function getDatabaseDriver()
    {
        $envDatabaseDriver = getenv('DATABASE_DRIVER');
        if($envDatabaseDriver === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['database_driver'])) {
                // return default
                return DatabaseDriver::MYSQL;
            } else {
                return $config['database_driver'];
            }
        } else {
            return $envDatabaseDriver;
        }
    }

    /**
     * Gets the 'DATABASE_NAME' environment variable or 'database_name' in a yaml file.
     * @return string
     */
    public function getDatabaseName()
    {
        $envDatabaseName = getenv('DATABASE_NAME');
        if($envDatabaseName === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['database_name'])) {
                // return default
                return 'automated_tests';
            } else {
                return $config['database_name'];
            }
        } else {
            return $envDatabaseName;
        }
    }


    /**
     * Gets the 'DATABASE_HOST' environment variable or 'database_host' in a yaml file.
     * @return string
     */
    public function getDatabaseHost()
    {
        $envDatabaseHost = getenv('DATABASE_HOST');
        if($envDatabaseHost === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['database_host'])) {
                // return default
                return 'localhost';
            } else {
                return $config['database_host'];
            }
        } else {
            return $envDatabaseHost;
        }
    }

    /**
     * Gets the 'DATABASE_USER' environment variable or 'database_user' in a yaml file.
     * @return string the test instance url.
     */
    public function getDatabaseUser()
    {
        $envDatabaseUser = getenv('DATABASE_USER');
        if($envDatabaseUser === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['database_user'])) {
                // return default
                return 'automated_tests';
            } else {
                return $config['database_user'];
            }
        } else {
            return $envDatabaseUser;
        }
    }

    /**
     * Gets the 'DATABASE_PASSWORD' environment variable or 'database_password' in a yaml file.
     * @return string
     */
    public function getDatabasePassword()
    {
        $envDatabasePassword = getenv('DATABASE_PASSWORD');
        if($envDatabasePassword === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['database_password'])) {
                // return default
                return 'automated_tests';
            } else {
                return $config['database_password'];
            }
        } else {
            return $envDatabasePassword;
        }
    }


    /**
     * Gets the 'INSTANCE_ADMIN_USER' environment variable or 'instance_admin_user' in a yaml file.
     * @return string
     */
    public function getAdminUser()
    {
        $env = getenv('INSTANCE_ADMIN_USER');
        if($env === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['INSTANCE_ADMIN_USER'])) {
                // return default
                return 'admin';
            } else {
                return $config['instance_admin_user'];
            }
        } else {
            return $env;
        }
    }

    /**
     * Gets the 'INSTANCE_ADMIN_PASSWORD' environment variable or 'instance_admin_password' in a yaml file.
     * @return string
     */
    public function getAdminPassword()
    {
        $env = getenv('INSTANCE_ADMIN_PASSWORD');
        if($env === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['INSTANCE_ADMIN_PASSWORD'])) {
                // return default
                return 'admin';
            } else {
                return $config['instance_admin_password'];
            }
        } else {
            return $env;
        }
    }

    // Add other methods to get environmental variables here...
    public function getClientId()
    {
        $env = getenv('INSTANCE_CLIENT_ID');
        if($env === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['INSTANCE_CLIENT_ID'])) {
                // return default
                return 'admin';
            } else {
                return $config['instance_admin_password'];
            }
        } else {
            return $env;
        }
    }

    /**
     * @return string
     * @throws \Codeception\Exception\ModuleException
     */
    public function getClientSecret()
    {
        $env = getenv('INSTANCE_CLIENT_SECRET');
        if($env === false) {
            $webDriver = $this->moduleContainer->getModule('PhpBrowser');
            $config = $webDriver->_getConfig();
            if(empty($config['INSTANCE_CLIENT_SECRET'])) {
                // return default
                return 'client_secret';
            } else {
                return $config['instance_client_secret'];
            }
        } else {
            return $env;
        }
    }
}
