<?php


class AdministrationTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAdministration()
    {

        //execute the contructor and check for the Object type and type attribute
        $admin = new Administration();
        $this->assertInstanceOf('Administration', $admin);
        $this->assertInstanceOf('SugarBean', $admin);

        $this->assertAttributeEquals('Administration', 'module_dir', $admin);
        $this->assertAttributeEquals('Administration', 'object_name', $admin);
        $this->assertAttributeEquals('config', 'table_name', $admin);
        $this->assertAttributeEquals(true, 'new_schema', $admin);
        $this->assertAttributeEquals(true, 'disable_custom_fields', $admin);
        $this->assertAttributeEquals(array('disclosure', 'notify', 'system', 'portal', 'proxy', 'massemailer', 'ldap', 'captcha', 'sugarpdf'), 'config_categories', $admin);
        $this->assertAttributeEquals(array('notify_send_by_default', 'mail_smtpauth_req', 'notify_on', 'portal_on', 'skypeout_on', 'system_mailmerge_on', 'proxy_auth', 'proxy_on', 'system_ldap_enabled', 'captcha_on'), 'checkbox_fields', $admin);
    }

    public function testretrieveSettings()
    {
        $admin = new Administration();

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
        $admin = new Administration();
        $result = $admin->retrieveSettings('notify', true);
        $this->assertInstanceOf('Administration', $result);
        $this->assertSame($admin, $result);
    }

    public function testsaveConfig()
    {
        self::markTestIncomplete('environment dependency');
        
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('config');
        $state->pushGlobals();

        // test
        $admin = new Administration();

        $_POST['proxy_test'] = 'test value';

        //execute the method and verify that it sets the correct config key
        $admin->saveConfig();
        $actual = $admin->settings['proxy_test'];
        $this->assertEquals($actual, 'test value');
        
        // clean up
        $state->popGlobals();
        $state->popTable('config');
    }

    public function testsaveSetting()
    {
        self::markTestIncomplete('environment dependency');
        
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('config');
        $state->pushGlobals();

        // test
        $admin = new Administration();

        //execute the method and verify that sets the correct config key
        $result = $admin->saveSetting('category', 'key', 'test value');
        $admin->retrieveSettings('category');
        $actual = $admin->settings['category_key'];
        $this->assertEquals($actual, 'test value');
        
        // clean up
        $state->popGlobals();
        $state->popTable('config');
    }

    public function testget_config_prefix()
    {
        $admin = new Administration();

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
