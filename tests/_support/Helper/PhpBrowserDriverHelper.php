<?php

namespace Helper;

use Codeception\Exception\ModuleException;
use Codeception\Module;
use SuiteCRM\Enumerator\DatabaseDriver;

/**
 * Class PhpBrowserDriverHelper.
 */
class PhpBrowserDriverHelper extends Module
{
    /**
     * @throws ModuleException
     *
     * @return null|array|mixed
     */
    public function getConfig()
    {
        return $this->moduleContainer->getModule('PhpBrowser')->_getConfig();
    }

    /**
     * Gets the 'INSTANCE_URL' environment variable or 'url' in a yaml file.
     *
     * @throws ModuleException
     *
     * @return string the test instance url
     */
    public function getInstanceURL()
    {
        return $this->getEnvironmentVariableOrDefault(
            'INSTANCE_URL',
            'http://localhost'
        );
    }

    /**
     * Gets the 'DATABASE_DRIVER' environment variable or 'database_driver' in a yaml file.
     *
     * @throws ModuleException
     *
     * @return string
     *
     * @see DatabaseDriver
     */
    public function getDatabaseDriver()
    {
        return $this->getEnvironmentVariableOrDefault(
            'DATABASE_DRIVER',
            DatabaseDriver::MYSQL
        );
    }

    /**
     * Gets the 'DATABASE_NAME' environment variable or 'database_name' in a yaml file.
     *
     * @throws ModuleException
     *
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->getEnvironmentVariableOrDefault(
            'DATABASE_NAME',
            'automated_tests'
        );
    }

    /**
     * Gets the 'DATABASE_HOST' environment variable or 'database_host' in a yaml file.
     *
     * @throws ModuleException
     *
     * @return string
     */
    public function getDatabaseHost()
    {
        return $this->getEnvironmentVariableOrDefault(
            'DATABASE_HOST',
            'database_host'
        );
    }

    /**
     * Gets the 'DATABASE_USER' environment variable or 'database_user' in a yaml file.
     *
     * @throws ModuleException
     *
     * @return string the test instance url
     */
    public function getDatabaseUser()
    {
        return $this->getEnvironmentVariableOrDefault(
            'DATABASE_USER',
            'automated_tests'
        );
    }

    /**
     * Gets the 'DATABASE_PASSWORD' environment variable or 'database_password' in a yaml file.
     *
     * @throws ModuleException
     *
     * @return string
     */
    public function getDatabasePassword()
    {
        return $this->getEnvironmentVariableOrDefault(
            'DATABASE_PASSWORD',
            'automated_tests'
        );
    }

    /**
     * Gets the 'INSTANCE_ADMIN_USER' environment variable or 'instance_admin_user' in a yaml file.
     *
     * @throws ModuleException
     *
     * @return string
     */
    public function getAdminUser()
    {
        return $this->getEnvironmentVariableOrDefault(
            'INSTANCE_ADMIN_USER',
            'admin'
        );
    }

    /**
     * Gets the 'INSTANCE_ADMIN_PASSWORD' environment variable or 'instance_admin_password' in a yaml file.
     *
     * @throws ModuleException
     *
     * @return string
     */
    public function getAdminPassword()
    {
        return $this->getEnvironmentVariableOrDefault(
            'INSTANCE_ADMIN_PASSWORD',
            'admin'
        );
    }

    /**
     * @throws ModuleException
     *
     * @return array|false|string
     */
    public function getPasswordGrantClientId()
    {
        return $this->getEnvironmentVariableOrDefault(
            'INSTANCE_CLIENT_ID',
            'API-4c59-f678-cecc-6594-5a8d9c704473'
        );
    }

    /**
     * @throws ModuleException
     *
     * @return string
     */
    public function getPasswordGrantClientSecret()
    {
        return $this->getEnvironmentVariableOrDefault(
            'INSTANCE_CLIENT_SECRET',
            'secret'
        );
    }

    /**
     * @throws ModuleException
     *
     * @return array|false|string
     */
    public function getClientCredentialsGrantClientId()
    {
        return $this->getEnvironmentVariableOrDefault(
            'INSTANCE_CREDENTIALS_CLIENT_ID',
            'API-ea74-c352-badd-c2be-5a8d9c9d4351'
        );
    }

    /**
     * @throws ModuleException
     *
     * @return string
     */
    public function getClientCredentialsGrantClientSecret()
    {
        return $this->getEnvironmentVariableOrDefault(
            'INSTANCE_CREDENTIALS_CLIENT_SECRET',
            'secret'
        );
    }

    /**
     * @param string $variable
     * @param string $default
     *
     * @throws ModuleException
     *
     * @return string
     */
    private function getEnvironmentVariableOrDefault($variable, $default)
    {
        $upperCase = strtoupper($variable);
        $lowerCase = strtoupper($variable);

        $env = getenv($upperCase);
        if ($env === false) {
            $config = $this->moduleContainer->getModule('PhpBrowser')->_getConfig();
            if (empty($config[$upperCase])) {
                return $default;
            }

            return $config[$lowerCase];
        }

        return $env;
    }
}
