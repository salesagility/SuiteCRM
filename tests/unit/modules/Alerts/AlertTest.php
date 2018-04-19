<?php


class AlertTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAlert()
    {

        //execute the contructor and check for the Object type and type attribute
        $alert = new Alert();
        $this->assertInstanceOf('Alert', $alert);
        $this->assertInstanceOf('Basic', $alert);
        $this->assertInstanceOf('SugarBean', $alert);

        $this->assertAttributeEquals('Alerts', 'module_dir', $alert);
        $this->assertAttributeEquals('Alert', 'object_name', $alert);
        $this->assertAttributeEquals('alerts', 'table_name', $alert);
        $this->assertAttributeEquals(true, 'new_schema', $alert);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $alert);
        $this->assertAttributeEquals(false, 'importable', $alert);
    }

    public function testbean_implements()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $alert = new Alert();

        $this->assertEquals(false, $alert->bean_implements('')); //test with empty value
        $this->assertEquals(false, $alert->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $alert->bean_implements('ACL')); //test with valid value
        
        // clean up
        
        
    }
}
