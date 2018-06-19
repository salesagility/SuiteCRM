<?php

class UserPreferenceTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }
    

    public function testgetUserDateTimePreferences()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushGlobals();

	
        
        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        $result = $userPreference->getUserDateTimePreferences();
        $this->assertTrue(is_array($result));

        
        
        $state->popTable('aod_index');
        $state->popGlobals();

    }

    public function testSetAndGetPreference()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushGlobals();

	
        
        global $sugar_config;

        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        
        $userPreference->setPreference('test', 'test val', 'test_category');
        
        if (!isset($_SESSION[$user->user_name.'_PREFERENCES']['test_category']['test'])) {
            LoggerManager::getLogger()->warn('no session');
            $result = null;
            
            

            $state->popTable('aod_index');
            $state->popGlobals();
            
            self::markTestIncomplete('environment dependency: This test needs session');
            return;
            
        } else {
            $result = $_SESSION[$user->user_name.'_PREFERENCES']['test_category']['test'];
        }
        
        $this->assertEquals('test val', $result);

        
        $result = $userPreference->getPreference('test', 'test_category');
        $this->assertEquals('test val', $result);

        $result = $userPreference->getPreference('chartEngine');
        $this->assertEquals($sugar_config['chartEngine'], $result);
        
        
        
        $state->popTable('aod_index');
        $state->popGlobals();
    }
    
    public function testgetDefaultPreference()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');

	
        
        global $sugar_config;

        

        $userPreference = new UserPreference();

        
        $result = $userPreference->getDefaultPreference('chartEngine', 'Home');
        $this->assertEquals(null, $result);

        

        $result = $userPreference->getDefaultPreference('chartEngine');
        $this->assertEquals($sugar_config['chartEngine'], $result);

        $date_format = $sugar_config['datef'] != '' ? $sugar_config['datef'] : $sugar_config['default_date_format'];
        $result = $userPreference->getDefaultPreference('datef');
        $this->assertEquals($date_format, $result);

        $time_format = $sugar_config['timef'] != '' ? $sugar_config['timef'] : $sugar_config['default_time_format'];
        $result = $userPreference->getDefaultPreference('timef');
        $this->assertEquals($time_format, $result);

        $email_link_type = (isset($sugar_config['email_link_type']) ? $sugar_config['email_link_type'] : null) != '' ? (isset($sugar_config['email_link_type']) ? $sugar_config['email_link_type'] : null) : $sugar_config['email_default_client'];
        $result = $userPreference->getDefaultPreference('email_link_type');
        $this->assertEquals($email_link_type, $result);
        
        
        
        $state->popTable('aod_index');
    }

    public function test__construct()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');

	
        
        
        $userPreference = new UserPreference();

        $this->assertInstanceOf('UserPreference', $userPreference);
        $this->assertInstanceOf('SugarBean', $userPreference);

        $this->assertAttributeEquals('user_preferences', 'table_name', $userPreference);
        $this->assertAttributeEquals('UserPreferences', 'module_dir', $userPreference);
        $this->assertAttributeEquals('UserPreference', 'object_name', $userPreference);

        $this->assertAttributeEquals(true, 'new_schema', $userPreference);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $userPreference);
        
        
        
        $state->popTable('aod_index');
    }

    public function testreloadPreferences()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

	
        
        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        $result = $userPreference->reloadPreferences();
        $this->assertTrue(!$result, 'Result was: ' . var_dump($result, true));

        
        
        $state->popGlobals();

    }
    
    
    public function testloadPreferences()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

	
        
        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        $result = $userPreference->loadPreferences();

        $this->assertTrue(!$result, 'Result was: ' . $result);
        
        
        
        $state->popGlobals();

    }
    
    public function testSavePreferencesToDBAndResetPreferences()
    {
        self::markTestIncomplete('environment dependency');
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('email_addresses');
        $state->pushTable('user_preferences');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        $state->pushGlobals();

	
        
        $user = new User();
        $user->retrieve('1');

        $userPreference = new UserPreference($user);

        
        $userPreference->setPreference('test', 'test val', 'test_category');
        $userPreference->savePreferencesToDB();

        
        $result = $userPreference->retrieve_by_string_fields(array(
                'assigned_user_id' => $user->id,
                'category' => 'test_category',
        ));
        
        

        
        $userPreference->resetPreferences();
        $result = $userPreference->retrieve_by_string_fields(array(
                'assigned_user_id' => $user->id,
                'category' => 'test_category',
        ));
        $this->assertEquals(null, $result);
        
        
        
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('aod_index');
        $state->popTable('user_preferences');
        $state->popTable('email_addresses');

    }




    public function testupdateAllUserPrefs()
    {
        global $current_user;

        $current_user = new User();
        $current_user->retrieve('1');

        

        $this->markTestIncomplete('Multiple errors in method: Unknown column user_preferences in field list');
    }
}
