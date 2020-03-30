<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AlertTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAlert()
    {
        // Execute the constructor and check for the Object type and type attribute
        $alert = BeanFactory::newBean('Alerts');
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
        $alert = BeanFactory::newBean('Alerts');

        $this->assertEquals(false, $alert->bean_implements('')); //test with empty value
        $this->assertEquals(false, $alert->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $alert->bean_implements('ACL')); //test with valid value
    }
}
