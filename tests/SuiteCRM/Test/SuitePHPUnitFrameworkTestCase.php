<?php

namespace SuiteCRM\Test;

use BeanFactory;
use DBManager;
use DBManagerFactory;
use LoggerManager;
use SuiteCRM\Exception\Exception;
use SuiteCRM\TestCaseAbstract;

/**
 * Class SuitePHPUnitFrameworkTestCase
 * @package SuiteCRM\Test
 */
abstract class SuitePHPUnitFrameworkTestCase extends TestCaseAbstract
{

    /**
     * @var array
     */
    protected $env = [];

    /**
     * @var LoggerManager
     */
    protected $log;

    /**
     * @var DBManager
     */
    protected $db;

    /**
     * @var array
     */
    protected $dbManagerFactoryInstances;

    /**
     * @var array
     */
    protected $sugarConfig;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     * @throws Exception
     */
    protected function setUp()
    {
        parent::setUp();

        global $current_user, $sugar_config;
        $current_user = @BeanFactory::getBean('Users');
        get_sugar_config_defaults();

        $this->log = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        $this->dbManagerFactoryInstances = DBManagerFactory::$instances;
        $this->db = DBManagerFactory::getInstance();


        if (isset($GLOBALS['reload_vardefs'])) {
            $this->env['$GLOBALS']['reload_vardefs'] = $GLOBALS['reload_vardefs'];
        }
        if (isset($GLOBALS['dictionary'])) {
            $this->env['$GLOBALS']['dictionary'] = $GLOBALS['dictionary'];
        }

        $this->sugarConfig = $sugar_config;
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        global $sugar_config;

        $sugar_config = $this->sugarConfig;

        if (isset($this->env['$GLOBALS']['reload_vardefs'])) {
            $GLOBALS['reload_vardefs'] = $this->env['$GLOBALS']['reload_vardefs'];
        }
        if (isset($this->env['$GLOBALS']['dictionary'])) {
            $GLOBALS['dictionary'] = $this->env['$GLOBALS']['dictionary'];
        }

        $GLOBALS['log'] = $this->log;

        DBManagerFactory::$instances = $this->dbManagerFactoryInstances;

        parent::tearDown();
    }
}
