<?php

use SuiteCRM\StateCheckerPHPUnitTestCaseAbstract;
use SuiteCRM\StateSaver;
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


/**
 * SharedSecurityRulesTest
 *
 * @author gyula
 */
class SharedSecurityRulesTest extends StateCheckerPHPUnitTestCaseAbstract {
    
    /**
     *
     * @var StateSaver
     */
    protected $state;

    protected function setUp() {
        parent::setUp();
        $this->state = new StateSaver();
        $this->state->pushTable('aod_indexevent');
    }
    
    protected function tearDown() {
        $this->state->popTable('aod_indexevent');
        parent::tearDown();
    }


    public function testBeanImplementsIfNotImplemented() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $result = $ssr->bean_implements('should_not_implemented_for_test');
        $this->assertFalse($result);
    }
    
    public function testSave() {
        $state = new StateSaver();
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushGlobals();
        
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue((bool)$usr->id);
        
        global $current_user;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $id = $ssr->save();
        $this->assertTrue(isValidId($id));
        
        $ssr = BeanFactory::getBean('SharedSecurityRules', $id);
        $this->assertEquals($id, $ssr->id);
                        
        $this->assertTrue(isset($_SESSION['ACL'][$usr->id]) && is_array($_SESSION['ACL'][$usr->id]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
    }
    
    
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelAndCorrectEmail
     * 
     * @global type $current_user
     */
    public function testCheckRulesWithCorrectAccessLevelAndCorrectEmail() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushTable('acl_roles');
        $state->pushTable('acl_roles_users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $role = BeanFactory::getBean('ACLRoles');
        $role->role_id = 'a_role_id';
        $role->user_id = $uid;        
        $rid = $role->save();
        $this->assertEquals($role->id, $rid);
        $ssra->parameters = base64_encode(serialize([
            'test', 
            'foo' => 'bar', 
            'email_target_type' => ['test_key' => 'Users'], 
            'accesslevel' => ['test_al_key' => 'test_al_value', 'test_key' => 'test_value'],
            'email' => ['test_key' => [0 => 'role', 2 => $rid]],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'test_value');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('acl_roles_users');
        $state->popTable('acl_roles');
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
        
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelAndCorrectEmailWithUserIdInAclRolesUsersTable
     * 
     * @global type $current_user
     */
    public function testCheckRulesWithUserIdInAclRolesUsersTable() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushTable('acl_roles');
        $state->pushTable('acl_roles_users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $role = BeanFactory::getBean('ACLRoles');
        $role->role_id = 'a_role_id';
        $role->user_id = $uid; 
        $rid = $role->save();
        $this->assertEquals($role->id, $rid);
        $ssra->parameters = base64_encode(serialize([
            'test', 
            'foo' => 'bar', 
            'email_target_type' => ['test_key' => 'Users'], 
            'accesslevel' => ['test_al_key' => 'test_al_value', 'test_key' => 'test_value'],
            'email' => ['test_key' => [0 => 'role', 2 => $rid]],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'test_value');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('acl_roles_users');
        $state->popTable('acl_roles');
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * 
     * @global type $current_usertestCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelAndCorrectEmailWithSecurityGroup
     */
    public function testCheckRulesWithSecurityGroup() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushTable('acl_roles');
        $state->pushTable('acl_roles_users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $role = BeanFactory::getBean('ACLRoles');
        $role->role_id = 'a_role_id';
        $role->user_id = $uid;        
        $rid = $role->save();
        $this->assertEquals($role->id, $rid);
        $ssra->parameters = base64_encode(serialize([
            'test', 
            'foo' => 'bar', 
            'email_target_type' => ['test_key' => 'Users'], 
            'accesslevel' => ['test_al_key' => 'test_al_value', 'test_key' => 'test_value'],
            'email' => ['test_key' => [0 => 'security_group', 2 => $rid]],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'test_value');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('acl_roles_users');
        $state->popTable('acl_roles');
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * 
     * @global type $current_usertestCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelAndCorrectEmailAndFindAccess
     */
    public function testCheckRulesWithCorrectAccessLevelAndCorrectEmailAndFindAccess() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushTable('acl_roles');
        $state->pushTable('acl_roles_users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $role = BeanFactory::getBean('ACLRoles');
        $role->role_id = 'a_role_id';
        $role->user_id = $uid;        
        $rid = $role->save();
        $this->assertEquals($role->id, $rid);
        $ssra->parameters = base64_encode(serialize([
            'test', 
            'foo' => 'bar', 
            'email_target_type' => ['test_key' => 'Users'], 
            'accesslevel' => ['test_al_key' => 'test_al_value', 'test_key' => 'test_value', 'list'],
            'email' => ['test_key' => [0 => 'role', 2 => $rid]],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('acl_roles_users');
        $state->popTable('acl_roles');
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * 
     * @global type $current_usertestCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelButIncorrectEmail
     */
    public function testCheckRulesWithCorrectAccessLevelButIncorrectEmail() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssra->parameters = base64_encode(serialize([
            'test', 
            'foo' => 'bar', 
            'email_target_type' => ['test_key' => 'Users'], 
            'accesslevel' => ['test_al_key' => 'test_al_value'],
            'email' => ['test_key' => [0 => 'role']],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithIncorrectAccessLevel
     * 
     * @global type $current_user
     */
    public function testCheckRulesWithIncorrectAccessLevel() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssra->parameters = base64_encode(serialize(['test', 'foo' => 'bar', 'email_target_type' => ['test_key' => 'test_value'], 'accesslevel' => 'it_is_incorrect']));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithNoAccessLevel
     * 
     * @global type $current_user
     */
    public function testCheckRulesWithNoAccessLevel() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssra->parameters = base64_encode(serialize(['test', 'foo' => 'bar', 'email_target_type' => ['test_key' => 'test_value']]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParameters
     * 
     * @global type $current_user
     */
    public function testCheckRulesWithBase64EncodedSerializedActionParameters() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssra->parameters = base64_encode(serialize(['test', 'foo' => 'bar']));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResults
     * 
     * @global type $current_user
     */
    public function testCheckRulesWithQueryResults() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    public function testCheckRulesWithFilledFetchedRow() {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);   
        $acc->retrieve($id);
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    public function testCheckRules() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
    }
    
    public function testGetParenthesisConditions() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $ret = $ssr->getPrimaryFieldDefinition();
        $this->assertEquals([
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => true,
            'comment' => 'Unique identifier',
            'inline_edit' => false,
                ], $ret);
    }

    public function testBuildRuleWhere() {
        $acc = BeanFactory::getBean('Accounts');
        $ret = SharedSecurityRules::buildRuleWhere($acc);
        $this->assertEquals([
            'resWhere' => '',
            'addWhere' => '',
                ], $ret);
    }

    public function testCheckHistory() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $ret = $ssr->checkHistory($acc, 'name', 'test');
        $this->assertEquals(null, $ret);
    }
    
    public function testChangeOperator() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $ret = $ssr->checkHistory($acc, 'incorrect_value', 'incorrect_reverse');
        $this->assertEquals(null, $ret);
    }
    
    public function testGetFieldDefs() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $ret = $ssr->getFieldDefs(array(), 'module_not_exists');
        $this->assertEquals(['' => ''], $ret);
    }
    
}
