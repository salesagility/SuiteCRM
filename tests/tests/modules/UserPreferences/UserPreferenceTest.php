<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**
 * Class UserPreferenceTest
 */
class UserPreferenceTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
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
    
        $email_link_type = $sugar_config['email_link_type'] != '' ? $sugar_config['email_link_type'] :
            $sugar_config['email_default_client'];
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
        $result = $_SESSION[$user->user_name . '_PREFERENCES']['test_category']['test'];
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
                                                                 'category'         => 'test_category',
                                                             ));
        $this->assertTrue(isset($result->id));
    
        //reset the preferences and verify that it is deleted
        $userPreference->resetPreferences();
        $result = $userPreference->retrieve_by_string_fields(array(
                                                                 'assigned_user_id' => $user->id,
                                                                 'category'         => 'test_category',
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
