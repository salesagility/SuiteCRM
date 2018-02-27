<?php

class UserPreferenceTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function test__construct()
    {
        //execute the contructor and check for the Object type and  attributes
        $userPreference = new UserPreference();

        $this->assertInstanceOf('UserPreference', $userPreference);
        $this->assertInstanceOf('SugarBean', $userPreference);

        $this->assertAttributeEquals('user_preferences', 'table_name', $userPreference);
        $this->assertAttributeEquals('UserPreferences', 'module_dir', $userPreference);
        $this->assertAttributeEquals('UserPreference', 'object_name', $userPreference);

        $this->assertAttributeEquals(true, 'new_schema', $userPreference);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $userPreference);
    }

    public function testgetDefaultPreference()
    {
        global $sugar_config;

        error_reporting(E_ERROR | E_PARSE);

        $userPreference = new UserPreference();

        //test with non global category
        $result = $userPreference->getDefaultPreference('chartEngine', 'Home');
        $this->assertEquals(null, $result);

        //test with default global category

        $result = $userPreference->getDefaultPreference('chartEngine');
        $this->assertEquals($sugar_config['chartEngine'], $result);

        $date_format = $sugar_config['datef'] != '' ? $sugar_config['datef'] : $sugar_config['default_date_format'];
        $result = $userPreference->getDefaultPreference('datef');
        $this->assertEquals($date_format, $result);

        $time_format = $sugar_config['timef'] != '' ? $sugar_config['timef'] : $sugar_config['default_time_format'];
        $result = $userPreference->getDefaultPreference('timef');
        $this->assertEquals($time_format, $result);

        $email_link_type = $sugar_config['email_link_type'] != '' ? $sugar_config['email_link_type'] : $sugar_config['email_default_client'];
        $result = $userPreference->getDefaultPreference('email_link_type');
        $this->assertEquals($email_link_type, $result);
    }

    public function testSetAndGetPreference()
    {
        global $sugar_config;

        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        //test setPreference method
        $userPreference->setPreference('test', 'test val', 'test_category');
        $result = $_SESSION[$user->user_name.'_PREFERENCES']['test_category']['test'];
        $this->assertEquals('test val', $result);

        //test getPreference method
        $result = $userPreference->getPreference('test', 'test_category');
        $this->assertEquals('test val', $result);

        $result = $userPreference->getPreference('chartEngine');
        $this->assertEquals($sugar_config['chartEngine'], $result);
    }

    public function testloadPreferences()
    {
        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        $result = $userPreference->loadPreferences();

        $this->assertEquals(false, $result);
    }

    public function testreloadPreferences()
    {
        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        $result = $userPreference->reloadPreferences();
        $this->assertEquals(false, $result);
    }

    public function testgetUserDateTimePreferences()
    {
        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        $result = $userPreference->getUserDateTimePreferences();
        $this->assertTrue(is_array($result));
    }

    public function testSavePreferencesToDBAndResetPreferences()
    {
        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        //create a Preference record, save it to DB
        $userPreference->setPreference('test', 'test val', 'test_category');
        $userPreference->savePreferencesToDB();

        //retrieve it back and verify
        $result = $userPreference->retrieve_by_string_fields(array(
                'assigned_user_id' => $user->id,
                'category' => 'test_category',
        ));
        $this->assertTrue(isset($result->id));

        //reset the preferences and verify that it is deleted
        $userPreference->resetPreferences();
        $result = $userPreference->retrieve_by_string_fields(array(
                'assigned_user_id' => $user->id,
                'category' => 'test_category',
        ));
        $this->assertEquals(null, $result);
    }

    public function testupdateAllUserPrefs()
    {
        global $current_user;

        $current_user = new User();
        $current_user->retrieve('1');

        //UserPreference::updateAllUserPrefs("test","test val");

        $this->markTestIncomplete('Multiple errors in method: Unknown column user_preferences in field list');
    }
}
