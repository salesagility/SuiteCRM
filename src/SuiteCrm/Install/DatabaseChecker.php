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
class DatabaseChecker {

    /**
     * Run database checks prior to installation
     * @throws \Exception
     */
    public static function runChecks() {
        self::checkDatabaseDrivers();
        self::checkSessionData();
        self::checkDatabaseConnection();
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
    protected static function checkDatabaseConnection() {
        $db = getInstallDbInstance();

        if (!$db->isDatabaseNameValid($_SESSION['setup_db_database_name'])) {
            throw new \Exception('Invalid database name("'.$_SESSION['setup_db_database_name'].'") was supplied!');
        }


    }

    /**
     * Work out some configuration values
     * @throws \Exception
     */
    protected static function checkSessionData() {
        if(empty(trim($_SESSION['setup_db_database_name']))){
            throw new \Exception('No database name was supplied!');
        }

        if($_SESSION['setup_db_type'] != 'oci8') {
            // Oracle doesn't need host name, others do
            if(empty(trim($_SESSION['setup_db_host_name']))){
                throw new \Exception('No database hostname name was supplied!');
            }
        }

        if(isset($_SESSION['setup_db_type']) && (!isset($_SESSION['setup_db_manager']) || empty($_SESSION['setup_db_manager']))) {
            $_SESSION['setup_db_manager'] = \DBManagerFactory::getManagerByType($_SESSION['setup_db_type']);
        }
    }

}