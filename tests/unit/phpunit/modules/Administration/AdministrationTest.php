<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AdministrationTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAdministration()
    {
        // Execute the constructor and check for the Object type and type attribute
        $admin = BeanFactory::newBean('Administration');
        $this->assertInstanceOf('Administration', $admin);
        $this->assertInstanceOf('SugarBean', $admin);

        $this->assertAttributeEquals('Administration', 'module_dir', $admin);
        $this->assertAttributeEquals('Administration', 'object_name', $admin);
        $this->assertAttributeEquals('config', 'table_name', $admin);
        $this->assertAttributeEquals(true, 'new_schema', $admin);
        $this->assertAttributeEquals(true, 'disable_custom_fields', $admin);
        $this->assertAttributeEquals(array('disclosure', 'notify', 'system', 'portal', 'proxy', 'massemailer', 'ldap', 'captcha', 'sugarpdf'), 'config_categories', $admin);
        $this->assertAttributeEquals(array('notify_send_by_default', 'mail_smtpauth_req', 'notify_on', 'portal_on', 'system_mailmerge_on', 'proxy_auth', 'proxy_on', 'system_ldap_enabled', 'captcha_on'), 'checkbox_fields', $admin);
    }

    public function testretrieveSettings()
    {
        $admin = BeanFactory::newBean('Administration');

        //execute with default parameters and test if it returns object itself
        $result = $admin->retrieveSettings();
        $this->assertInstanceOf('Administration', $result);
        $this->assertSame($admin, $result);

        //execute with a invalid category and test if it returns object itself.
        $result = $admin->retrieveSettings('test');
        $this->assertInstanceOf('Administration', $result);
        $this->assertSame($admin, $result);
        $this->assertEquals(true, $admin->settings['test']);

        //execute with a valid category and test if it returns object itself.
        $result = $admin->retrieveSettings('notify');
        $this->assertInstanceOf('Administration', $result);
        $this->assertSame($admin, $result);

        //execute with a valid category and clean=true and test if it returns object itself.
        $admin = BeanFactory::newBean('Administration');
        $result = $admin->retrieveSettings('notify', true);
        $this->assertInstanceOf('Administration', $result);
        $this->assertSame($admin, $result);
    }

    public function testsaveConfig()
    {
        self::markTestIncomplete('environment dependency');

        // test
        $admin = BeanFactory::newBean('Administration');

        $_POST['proxy_test'] = 'test value';

        //execute the method and verify that it sets the correct config key
        $admin->saveConfig();
        $actual = $admin->settings['proxy_test'];
        $this->assertEquals($actual, 'test value');
    }

    public function testsaveSetting()
    {
        self::markTestIncomplete('environment dependency');

        // test
        $admin = BeanFactory::newBean('Administration');

        //execute the method and verify that sets the correct config key
        $result = $admin->saveSetting('category', 'key', 'test value');
        $admin->retrieveSettings('category');
        $actual = $admin->settings['category_key'];
        $this->assertEquals($actual, 'test value');
    }

    public function testget_config_prefix()
    {
        $admin = BeanFactory::newBean('Administration');

        //test with empty string
        $expected = array(false, false);
        $actual = $admin->get_config_prefix('');
        $this->assertSame($expected, $actual);

        //test with a valid string
        $expected = array('category', 'test');
        $actual = $admin->get_config_prefix('category_test');
        $this->assertSame($expected, $actual);
    }
}
