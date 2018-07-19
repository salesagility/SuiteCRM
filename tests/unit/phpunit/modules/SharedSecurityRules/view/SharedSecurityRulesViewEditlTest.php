<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

include_once __DIR__ . '/../../../../../../modules/SharedSecurityRules/views/view.edit.php';

/**
 * SharedSecurityRulesViewEditTest
 *
 * @author gyula
 */
class SharedSecurityRulesViewEditTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract {
              
    /**
     * testPreDisplayWithBeanIdAndSharedSecurityRoleConditionWidthDateValueTypeWithCurrentBeanWithModulePathArray
     * 
     * @global type $current_user
     */
    public function testPreDisplayWithModulePathArray() {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('sharedsecurityrulesconditions');
        $state->pushTable('aod_indexevent');
        $state->pushTable('email_addresses');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $this->assertTrue((bool)$usr);
        $_REQUEST['page'] = 'EditView';
        $_REQUEST['module'] = 'Users';
        $_REQUEST['action'] = 'Save';
        $_REQUEST['Users1emailAddress1'] = 'test@email.com';
        $_REQUEST['Users1emailAddressId1'] = 'test_email_id';
        $query = "INSERT INTO email_addresses (`id`, deleted) VALUES ('test_email_id', 0);";
        $ret = DBManagerFactory::getInstance()->query($query);        
        $uid = $usr->save();
        $this->assertEquals($uid, $usr->id);
        $current_user = $usr;
        
        $ssrve = new SharedSecurityRulesViewEdit();
        $ssrve->bean = BeanFactory::getBean('Accounts');
        $ssrve->bean->flow_module = 'Accounts';
        $id = $ssrve->bean->save();
        $this->assertEquals($ssrve->bean->id, $id);
        
        $ssrc = BeanFactory::getBean('SharedSecurityRulesConditions');
        $this->assertTrue((bool)$ssrc);
        $ssrc->sa_shared_sec_rules_id = $ssrve->bean->id;
        $ssrc->module_path = ['Accounts', 'email1', 'Test'];
        $ssrc->value_type = 'Date';
        $ssrc->field = 'test';
        $id = $ssrc->save();
        $this->assertEquals($ssrc->id, $id);
        
        ob_start();
        try {
            $ssrve->preDisplay();
            $this->assertTrue(false, 'It should throwing a SuiteException with code FILE_NOT_FOUND');
        } catch (SuiteException $e) {
            $this->assertEquals(SuiteException::FILE_NOT_FOUND, $e->getCode());
        }
        $contents = ob_get_contents();
        ob_end_clean();        
        $this->assertContains($ssrve->bean->id, $contents);
        $this->assertContains($ssrc->id, $contents);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('email_addresses');
        $state->popTable('aod_indexevent');
        $state->popTable('sharedsecurityrulesconditions');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
        $state->popTable('users');
    } 
    
              
    /**
     * testPreDisplayWithBeanIdAndSharedSecurityRoleConditionWidthDateValueTypeWithCurrentBeanWithModulePath
     * 
     * @global type $current_user
     */
    public function testPreDisplayWithModulePath() {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('sharedsecurityrulesconditions');
        $state->pushTable('aod_indexevent');
        $state->pushTable('email_addresses');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $this->assertTrue((bool)$usr);
        $_REQUEST['page'] = 'EditView';
        $_REQUEST['module'] = 'Users';
        $_REQUEST['action'] = 'Save';
        $_REQUEST['Users1emailAddress1'] = 'test@email.com';
        $_REQUEST['Users1emailAddressId1'] = 'test_email_id';
        $query = "INSERT INTO email_addresses (`id`, deleted) VALUES ('test_email_id', 0);";
        $ret = DBManagerFactory::getInstance()->query($query);        
        $uid = $usr->save();
        $this->assertEquals($uid, $usr->id);
        $current_user = $usr;
        
        $ssrve = new SharedSecurityRulesViewEdit();
        $ssrve->bean = BeanFactory::getBean('Accounts');
        $ssrve->bean->flow_module = 'Accounts';
        $id = $ssrve->bean->save();
        $this->assertEquals($ssrve->bean->id, $id);
        
        $ssrc = BeanFactory::getBean('SharedSecurityRulesConditions');
        $this->assertTrue((bool)$ssrc);
        $ssrc->sa_shared_sec_rules_id = $ssrve->bean->id;
        $ssrc->module_path = 'Module::Path::Test';
        $ssrc->value_type = 'Date';
        $ssrc->field = 'test';
        $id = $ssrc->save();
        $this->assertEquals($ssrc->id, $id);
        
        ob_start();
        try {
            $ssrve->preDisplay();
            $this->assertTrue(false, 'It should throwing a SuiteException with code FILE_NOT_FOUND');
        } catch (SuiteException $e) {
            $this->assertEquals(SuiteException::FILE_NOT_FOUND, $e->getCode());
        }
        $contents = ob_get_contents();
        ob_end_clean();        
        $this->assertContains($ssrve->bean->id, $contents);
        $this->assertContains($ssrc->id, $contents);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('email_addresses');
        $state->popTable('aod_indexevent');
        $state->popTable('sharedsecurityrulesconditions');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
        $state->popTable('users');
    } 
          
    /**
     * testPreDisplayWithBeanIdAndSharedSecurityRoleConditionWidthDateValueTypeWithCurrentBean
     * 
     * @global type $current_user
     */
    public function testPreDisplayWithCurrentBean() {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('sharedsecurityrulesconditions');
        $state->pushTable('aod_indexevent');
        $state->pushTable('email_addresses');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $this->assertTrue((bool)$usr);
        $_REQUEST['page'] = 'EditView';
        $_REQUEST['module'] = 'Users';
        $_REQUEST['action'] = 'Save';
        $_REQUEST['Users1emailAddress1'] = 'test@email.com';
        $_REQUEST['Users1emailAddressId1'] = 'test_email_id';
        $query = "INSERT INTO email_addresses (`id`, deleted) VALUES ('test_email_id', 0);";
        $ret = DBManagerFactory::getInstance()->query($query);        
        $uid = $usr->save();
        $this->assertEquals($uid, $usr->id);
        $current_user = $usr;
        
        $ssrve = new SharedSecurityRulesViewEdit();
        $ssrve->bean = BeanFactory::getBean('Accounts');
        $ssrve->bean->flow_module = 'Accounts';
        $id = $ssrve->bean->save();
        $this->assertEquals($ssrve->bean->id, $id);
        
        $ssrc = BeanFactory::getBean('SharedSecurityRulesConditions');
        $this->assertTrue((bool)$ssrc);
        $ssrc->sa_shared_sec_rules_id = $ssrve->bean->id;
        $ssrc->value_type = 'Date';
        $ssrc->field = 'test';
        $id = $ssrc->save();
        $this->assertEquals($ssrc->id, $id);
        
        ob_start();
        try {
            $ssrve->preDisplay();
            $this->assertTrue(false, 'It should throwing a SuiteException with code FILE_NOT_FOUND');
        } catch (SuiteException $e) {
            $this->assertEquals(SuiteException::FILE_NOT_FOUND, $e->getCode());
        }
        $contents = ob_get_contents();
        ob_end_clean();        
        $this->assertContains($ssrve->bean->id, $contents);
        $this->assertContains($ssrc->id, $contents);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('email_addresses');
        $state->popTable('aod_indexevent');
        $state->popTable('sharedsecurityrulesconditions');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
        $state->popTable('users');
    } 
          
    /**
     * testPreDisplayWithBeanIdAndSharedSecurityRoleConditionWidthDateValueType
     * 
     * @global type $current_user
     */
    public function testPreDisplayWidthDateValueType() {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('sharedsecurityrulesconditions');
        $state->pushTable('aod_indexevent');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $this->assertTrue((bool)$usr);
        $_REQUEST['page'] = 'EditView';
        $_REQUEST['module'] = 'Users';
        $_REQUEST['action'] = 'Save';
        $_REQUEST['Users1emailAddress1'] = 'test@email.com';
        $_REQUEST['Users1emailAddressId1'] = 'test_email_id';
        $query = "INSERT INTO email_addresses (`id`, deleted) VALUES ('test_email_id', 0);";
        $ret = DBManagerFactory::getInstance()->query($query);        
        $uid = $usr->save();
        $this->assertEquals($uid, $usr->id);
        $current_user = $usr;
        
        $ssrve = new SharedSecurityRulesViewEdit();
        $ssrve->bean = BeanFactory::getBean('Accounts');
        $id = $ssrve->bean->save();
        $this->assertEquals($ssrve->bean->id, $id);
        
        $ssrc = BeanFactory::getBean('SharedSecurityRulesConditions');
        $this->assertTrue((bool)$ssrc);
        $ssrc->sa_shared_sec_rules_id = $ssrve->bean->id;
        $ssrc->value_type = 'Date';
        $id = $ssrc->save();
        $this->assertEquals($ssrc->id, $id);
        
        ob_start();
        try {
            $ssrve->preDisplay();
            $this->assertTrue(false, 'It should throwing a SuiteException with code FILE_NOT_FOUND');
        } catch (SuiteException $e) {
            $this->assertEquals(SuiteException::FILE_NOT_FOUND, $e->getCode());
        }
        $contents = ob_get_contents();
        ob_end_clean();        
        $this->assertContains($ssrve->bean->id, $contents);
        $this->assertContains($ssrc->id, $contents);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('aod_indexevent');
        $state->popTable('sharedsecurityrulesconditions');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
        $state->popTable('users');
    } 
              
    /**
     * testPreDisplayWithBeanIdAndSharedSecurityRoleCondition
     * 
     * @global type $current_user
     */
    public function testPreDisplayWithSharedSecurityRoleCondition() {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('sharedsecurityrulesconditions');
        $state->pushTable('aod_indexevent');
        $state->pushTable('email_addresses');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $this->assertTrue((bool)$usr);
        $_REQUEST['page'] = 'EditView';
        $_REQUEST['module'] = 'Users';
        $_REQUEST['action'] = 'Save';
        $_REQUEST['Users1emailAddress1'] = 'test@email.com';
        $_REQUEST['Users1emailAddressId1'] = 'test_email_id';
        $query = "INSERT INTO email_addresses (`id`, deleted) VALUES ('test_email_id', 0);";
        $ret = DBManagerFactory::getInstance()->query($query);        
        $uid = $usr->save();
        $this->assertEquals($uid, $usr->id);
        $current_user = $usr;
        
        $ssrve = new SharedSecurityRulesViewEdit();
        $ssrve->bean = BeanFactory::getBean('Accounts');
        $id = $ssrve->bean->save();
        $this->assertEquals($ssrve->bean->id, $id);
        
        $ssrc = BeanFactory::getBean('SharedSecurityRulesConditions');
        $this->assertTrue((bool)$ssrc);
        $ssrc->sa_shared_sec_rules_id = $ssrve->bean->id;
        $id = $ssrc->save();
        $this->assertEquals($ssrc->id, $id);
        
        ob_start();
        try {
            $ssrve->preDisplay();
            $this->assertTrue(false, 'It should throwing a SuiteException with code FILE_NOT_FOUND');
        } catch (SuiteException $e) {
            $this->assertEquals(SuiteException::FILE_NOT_FOUND, $e->getCode());
        }
        $contents = ob_get_contents();
        ob_end_clean();        
        $this->assertContains($ssrve->bean->id, $contents);
        $this->assertContains($ssrc->id, $contents);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('email_addresses');
        $state->popTable('aod_indexevent');
        $state->popTable('sharedsecurityrulesconditions');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
        $state->popTable('users');
    } 
    
    public function testPreDisplayWithBeanId() {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('aod_indexevent');
        $state->pushTable('email_addresses');
        $state->pushGlobals();
        
        $ssrve = new SharedSecurityRulesViewEdit();
        $ssrve->bean = BeanFactory::getBean('Accounts');
        $id = $ssrve->bean->save();
        $this->assertEquals($ssrve->bean->id, $id);        
        ob_start();
        try {
            $ssrve->preDisplay();
            $this->assertTrue(false, 'It should throwing a SuiteException with code FILE_NOT_FOUND');
        } catch (SuiteException $e) {
            $this->assertEquals(SuiteException::FILE_NOT_FOUND, $e->getCode());
        }
        $contents = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('<script>var conditionLines = []</script>', $contents);
        
        $state->popGlobals();
        $state->popTable('email_addresses');
        $state->popTable('aod_indexevent');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    public function testPreDisplayWithNoBeanId() {
        $ssrve = new SharedSecurityRulesViewEdit();
        $ssrve->bean = BeanFactory::getBean('Accounts');
        ob_start();
        try {
            $ssrve->preDisplay();
            $this->assertTrue(false, 'It should throwing a SuiteException with code FILE_NOT_FOUND');
        } catch (SuiteException $e) {
            $this->assertEquals(SuiteException::FILE_NOT_FOUND, $e->getCode());
        }
        $contents = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('<script>var conditionLines = []</script>', $contents);
    }
    
    public function testPreDisplay() {
        $ssrve = new SharedSecurityRulesViewEdit();
        ob_start();
        try {
            $ssrve->preDisplay();
            $this->assertTrue(false, 'It should throwing a SuiteException with code FILE_NOT_FOUND');
        } catch (SuiteException $e) {
            $this->assertEquals(SuiteException::FILE_NOT_FOUND, $e->getCode());
        }
        $contents = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('<script>var conditionLines = []</script>', $contents);
    }
    
}
