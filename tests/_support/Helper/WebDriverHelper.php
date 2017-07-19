<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Test\Metadata;
use Codeception\TestInterface;
use SuiteCRM\Enumerator\DatabaseDriver;

class WebDriverHelper extends \Codeception\Module
{
    /**
     * @var Metadata $metadata
     */
    public $metadata;

    /**
     * Gets the 'INSTANCE_URL' environment variable or 'url' in a yaml file.
     * @return string the test instance url.
     */
    public function getInstanceURL()
    {
        $envInstanceURL = getenv('INSTANCE_URL');
        if($envInstanceURL === false) {
            $webDriver = $this->moduleContainer->getModule('\SuiteCRM\Test\Driver\WebDriver');
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
            $webDriver = $this->moduleContainer->getModule('\SuiteCRM\Test\Driver\WebDriver');
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
            $webDriver = $this->moduleContainer->getModule('\SuiteCRM\Test\Driver\WebDriver');
            $config = $webDriver->_getConfig();
            if(empty($config['database_name'])) {
                // return default
                return 'automated_tests';
            } else {
                return $config['database_driver'];
            }
        } else {
            return $envDatabaseName;
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
            $webDriver = $this->moduleContainer->getModule('\SuiteCRM\Test\Driver\WebDriver');
            $config = $webDriver->_getConfig();
            if(empty($config['database_user'])) {
                // return default
                return 'automated_tests';
            } else {
                return $config['database_driver'];
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
            $webDriver = $this->moduleContainer->getModule('\SuiteCRM\Test\Driver\WebDriver');
            $config = $webDriver->_getConfig();
            if(empty($config['database_password'])) {
                // return default
                return 'automated_tests';
            } else {
                return $config['database_driver'];
            }
        } else {
            return $envDatabasePassword;
        }
    }

    /**
     * Gets the 'BROWSERSTACK_USERNAME' environment variable or 'browserstack.user' in a yaml file.
     * @url https://www.browserstack.com/automate/codeception
     * @return string.
     */
    public function getBrowserStackUsername()
    {
        $envBrowserStackUsername = getenv('BROWSERSTACK_USERNAME');
        if($envBrowserStackUsername === false) {
            $webDriver = $this->moduleContainer->getModule('\SuiteCRM\Test\Driver\WebDriver');
            $config = $webDriver->_getConfig();
            if(empty($config["capabilities"]["browserstack.user"])) {
                // return default
                return 'automated_tests';
            } else {
                return $config["capabilities"]["browserstack.user"];
            }
        } else {
            return $envBrowserStackUsername;
        }
    }

    /**
     * Gets the 'BROWSERSTACK_ACCESS_KEY' environment variable or 'browserstack.key' in a yaml file.
     * @url https://www.browserstack.com/automate/codeception
     * @return string
     */
    public function getBrowserStackAccessKey()
    {
        $envBrowserStackAccessKey = getenv('BROWSERSTACK_ACCESS_KEY');
        if($envBrowserStackAccessKey === false) {
            $webDriver = $this->moduleContainer->getModule('\SuiteCRM\Test\Driver\WebDriver');
            $config = $webDriver->_getConfig();
            if(empty($config["capabilities"]["browserstack.key"])) {
                // return default
                return 'automated_tests';
            } else {
                return $config["capabilities"]["browserstack.key"];
            }
        } else {
            return $envBrowserStackAccessKey;
        }
    }

    /**
     * Gets the 'BROWSERSTACK_LOCAL_FOLDER_URL' environment variable or 'browserstack.localfolderurl' in a yaml file.
     * @url https://www.browserstack.com/automate/codeception
     * @return string
     */
    public function getBrowserStackLocalFolderURL()
    {
        $envBrowserStackAccessKey = getenv('BROWSERSTACK_LOCAL_FOLDER_URL');
        if($envBrowserStackAccessKey === false) {
            $webDriver = $this->moduleContainer->getModule('\SuiteCRM\Test\Driver\WebDriver');
            $config = $webDriver->_getConfig();
            if(empty($config["capabilities"]["browserstack.localfolderurl"])) {
                // return default
                return 'automated_tests';
            } else {
                return $config["capabilities"]["browserstack.localfolderurl"];
            }
        } else {
            return $envBrowserStackAccessKey;
        }
    }
    // Add other environmental variables here
}
