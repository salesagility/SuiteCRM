<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AlertTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAlert(): void
    {
        // Execute the constructor and check for the Object type and type attribute
        $alert = BeanFactory::newBean('Alerts');
        self::assertInstanceOf('Alert', $alert);
        self::assertInstanceOf('Basic', $alert);
        self::assertInstanceOf('SugarBean', $alert);

        self::assertAttributeEquals('Alerts', 'module_dir', $alert);
        self::assertAttributeEquals('Alert', 'object_name', $alert);
        self::assertAttributeEquals('alerts', 'table_name', $alert);
        self::assertAttributeEquals(true, 'new_schema', $alert);
        self::assertAttributeEquals(true, 'disable_row_level_security', $alert);
        self::assertAttributeEquals(false, 'importable', $alert);
    }

    public function testbean_implements(): void
    {
        $alert = BeanFactory::newBean('Alerts');

        self::assertEquals(false, $alert->bean_implements('')); //test with empty value
        self::assertEquals(false, $alert->bean_implements('test')); //test with invalid value
        self::assertEquals(true, $alert->bean_implements('ACL')); //test with valid value
    }
}
