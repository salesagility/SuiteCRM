<?php
/**
 * Created by Adam Jakab.
 * Date: 09/03/16
 * Time: 8.54
 */

namespace SuiteCrm\Install;

/**
 * Class DatabaseChecker
 * @package SuiteCrm\Install
 */
class DatabaseChecker
{
    /** @var  array */
    protected static $configuration;

    /**
     * Run database checks prior to installation
     *
     * @param array $configuration
     * @throws \Exception
     * @return array
     */
    public static function runChecks($configuration)
    {
        self::$configuration = $configuration;

        self::checkConfigurationData();
        self::checkDatabaseDrivers();
        self::checkDatabaseConnection();

        return self::$configuration;
    }


    /**
     * @throws \Exception
     */
    protected static function checkDatabaseConnection()
    {
        $db = InstallUtils::getInstallDatabaseInstance(
            self::$configuration['database-type'],
            ["db_manager" => self::$configuration['database-manager']]
        );

        if (!$db->isDatabaseNameValid(self::$configuration['database-name'])) {
            throw new \Exception('Invalid database name("' . self::$configuration['database-name'] . '") was supplied!');
        }
    }


    /**
     * @throws \Exception
     */
    protected static function checkDatabaseDrivers()
    {
        $drivers = \DBManagerFactory::getDbDrivers();
        if (empty($drivers)) {
            throw new \Exception("No Database driver is available!");
        }
    }

    /**
     * Check the configuration options which refer to the database
     *
     * @throws \Exception
     */
    protected static function checkConfigurationData()
    {
        if (empty(trim(self::$configuration['database-name']))) {
            throw new \Exception('No database name was supplied!');
        }

        if (self::$configuration['database-type'] != 'oci8') {
            // Oracle doesn't need host name, others do
            if (empty(trim(self::$configuration['database-host']))) {
                throw new \Exception('No database hostname name was supplied!');
            }
        }

        if (isset(self::$configuration['database-type'])
            && (!isset(self::$configuration['database-manager'])
                || empty(self::$configuration['database-manager']))
        ) {
            self::$configuration['database-manager'] = \DBManagerFactory::getManagerByType(
                self::$configuration['database-type']
            );
        }
    }
}