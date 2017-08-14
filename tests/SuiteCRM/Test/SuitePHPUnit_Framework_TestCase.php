<?php
namespace SuiteCRM\Test;

use User;
use DBManagerFactory;

/** @noinspection PhpUndefinedClassInspection */
class SuitePHPUnit_Framework_TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var array
     */
    protected $env = array();

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

    /**
     * @var array
     */
    protected $fieldDefsStore;

    public static function setUpBeforeClass()
    {
        global $db;
        $db->disconnect();
        unset ($db->database);
        $db->checkConnection();
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        global $current_user, $sugar_config;
        $current_user = new User();
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

        $this->fieldDefsStore();
    }

    /**
     * Store static field_defs per modules
     * @param string $key
     */
    protected function fieldDefsStore($key = 'base')
    {
        global $moduleList;

        $this->fieldDefsStore = array();
        foreach ($moduleList as $module => $class) {
            $namespaceAndClass = "\\$class";
            if(class_exists($namespaceAndClass) && isset($namespaceAndClass::$field_defs)) {
                $object = new $namespaceAndClass();
                $this->fieldDefsStore[$key][$namespaceAndClass] = $object->field_defs;
            }
        }

    }

    /**
     * Restore static field_defs per modules
     * @param string $key
     */
    protected function fieldDefsRestore($key = 'base')
    {
        global $moduleList;

        foreach ($moduleList as $module => $class) {
            $namespaceAndClass = "\\$class";
            if(isset($this->fieldDefsStore[$key][$namespaceAndClass])) {
                $object = new $namespaceAndClass();
                $object->field_defs = $this->fieldDefsStore[$key][$namespaceAndClass];
            }
        }

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
        global $sugar_config;

        $this->fieldDefsRestore();

        $sugar_config = $this->sugarConfig;

        if (isset($this->env['$GLOBALS']['reload_vardefs'])) {
            $GLOBALS['reload_vardefs'] = $this->env['$GLOBALS']['reload_vardefs'];
        }
        if (isset($this->env['$GLOBALS']['dictionary'])) {
            $GLOBALS['dictionary'] = $this->env['$GLOBALS']['dictionary'];
        }

        $GLOBALS['log'] = $this->log;

        DBManagerFactory::$instances = $this->dbManagerFactoryInstances;
    }

}
