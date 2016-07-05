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
 * Class ACLActionTest
 */
class ACLActionTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testACLAction()
    {
    
        //execute the contructor and check for the Object type and type attribute
        $aclAction = new ACLAction();
        $this->assertInstanceOf('ACLAction', $aclAction);
        $this->assertInstanceOf('SugarBean', $aclAction);
    
        $this->assertAttributeEquals('ACLActions', 'module_dir', $aclAction);
        $this->assertAttributeEquals('ACLAction', 'object_name', $aclAction);
        $this->assertAttributeEquals('acl_actions', 'table_name', $aclAction);
        $this->assertAttributeEquals(true, 'new_schema', $aclAction);
        $this->assertAttributeEquals(true, 'disable_custom_fields', $aclAction);
    }
    
    public function testaddActions()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        //take count of actions initially and then after method execution and test if action count increases
        $action_count = count(ACLAction::getDefaultActions());
        ACLAction::addActions('Test');
        $actual = ACLAction::getDefaultActions();
        $this->assertGreaterThan($action_count, count($actual));
    }
    
    public function testremoveActions()
    {
    
        //take count of actions initially and then after method execution and test if action count decreases
        $action_count = count(ACLAction::getDefaultActions());
        ACLAction::removeActions('Test');
        $actual = ACLAction::getDefaultActions();
        $this->assertLessThan($action_count, count($actual));
    }
    
    public function testAccessName()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $this->assertFalse(ACLAction::AccessName('')); //test with invalid value
        $this->assertEquals('All', ACLAction::AccessName(90)); //test with a valid value
    }
    
    public function testgetDefaultActions()
    {
        global $beanList;
        $actual = ACLAction::getDefaultActions();
        $this->assertTrue(is_array($actual)); //verify that it returns an array
        foreach ($actual as $acl)
        {
            $this->assertInstanceOf('ACLAction', $acl);
        }
        $actual = ACLAction::getDefaultActions('module', 'list');
        $this->assertTrue(is_array($actual)); //verify that it returns an array
        foreach ($actual as $acl)
        {
            $this->assertInstanceOf('ACLAction', $acl);
            $this->assertEquals('list', $acl->name);
        }
    }
    
    public function testgetUserActions()
    {
        $result1 = ACLAction::getUserActions('1');
        $result2 = ACLAction::getUserActions('1', false, 'Accounts');
        $result3 = ACLAction::getUserActions('1', false, 'Accounts', 'list');
    
        //verify that all three results retunred are different
        $this->assertNotSame($result1, $result2);
        $this->assertNotSame($result1, $result3);
        $this->assertNotSame($result2, $result3);
    }
    
    public function testhasAccess()
    {
        $this->assertFalse(ACLAction::hasAccess()); //check with defaults 
        $this->assertTrue(ACLAction::hasAccess(false, false, 90));  //access All with is owner false
        $this->assertTrue(ACLAction::hasAccess(true, true, 90)); //access All with is owner true 
        $this->assertFalse(ACLAction::hasAccess(false, false, -98));// check access disabled
        $this->assertFalse(ACLAction::hasAccess(true, true, 89)); //check access enabled 
        $this->assertTrue(ACLAction::hasAccess(true, true, 75)); //check owner access with is owner true
        $this->assertFalse(ACLAction::hasAccess(false, true, 75)); //check owner access with is owner false
    }
    
    public function testuserNeedsSecurityGroup()
    {
        $this->assertFalse(ACLAction::userNeedsSecurityGroup('1', '', ''));//test with empty module and action 
        $this->assertFalse(ACLAction::userNeedsSecurityGroup('1', 'Accounts',
                                                             'list')); //test with valid module and action
    }
    
    public function testuserHasAccess()
    {
        $this->assertFalse(ACLAction::userHasAccess('', '', '')); //test with empty module and action
        $this->assertTrue(ACLAction::userHasAccess('', 'Accounts',
                                                   'list')); //test with e,pty user and valid module and action
        $this->assertTrue(ACLAction::userHasAccess('1', 'Accounts', 'list')); //test with valid User, module and action
        $this->assertTrue(ACLAction::userHasAccess('1', 'SecurityGroups',
                                                   'list')); //test with valid User, module and action
        $this->assertTrue(ACLAction::userHasAccess('1', 'Users', 'list')); //test with valid User, module and action
    }
    
    public function testgetUserAccessLevel()
    {
    
        //tes for accoounts module with two different actions
        $this->assertEquals(90, ACLAction::getUserAccessLevel('1', 'Accounts', 'list'));
        $this->assertEquals(89, ACLAction::getUserAccessLevel('1', 'Accounts', 'access'));
    
        //tes for users module with two different actions
        $this->assertEquals(90, ACLAction::getUserAccessLevel('1', 'Users', 'list'));
        $this->assertEquals(89, ACLAction::getUserAccessLevel('1', 'Users', 'access'));
    }
    
    public function testuserNeedsOwnership()
    {
    
        //test with invalid values
        $this->assertFalse(ACLAction::userNeedsOwnership('', '', ''));
    
        //test with valid values for different module and action combination
        $this->assertFalse(ACLAction::userNeedsOwnership('1', 'Accounts', 'list'));
        $this->assertFalse(ACLAction::userNeedsOwnership('1', 'Accounts', 'delete'));
        $this->assertFalse(ACLAction::userNeedsOwnership('1', 'Users', 'delete'));
        $this->assertFalse(ACLAction::userNeedsOwnership('1', 'Users', 'list'));
    }
    
    public function testsetupCategoriesMatrix()
    {
    
        //preset required data
        $categories = array();
        $categories['Accounts']['module']['list'][] = 'list';
        $categories['Accounts']['module']['edit'][] = 'edit';
    
        $names_expected = array('list' => 'List', 'edit' => 'Edit');
    
        $categories_expected = array(
            'Accounts' => array(
                'module' => array(
                    'list' => array('list',
                                    'accessColor'   => false,
                                    'accessName'    => false,
                                    'accessLabel'   => false,
                                    'accessOptions' => array(90  => 'All',
                                                             80  => 'Group',
                                                             75  => 'Owner',
                                                             0   => 'Not Set',
                                                             -99 => 'None',
                                    ),
                    ),
                    'edit' => array('edit',
                                    'accessColor'   => false,
                                    'accessName'    => false,
                                    'accessLabel'   => false,
                                    'accessOptions' => array(90  => 'All',
                                                             80  => 'Group',
                                                             75  => 'Owner',
                                                             0   => 'Not Set',
                                                             -99 => 'None',
                                    ),
                    ),
                ),
            ),
        );
    
        //execute the method and verify that it retunrs expected results
        $result = ACLAction::setupCategoriesMatrix($categories);
        $this->assertSame($names_expected, $result);
        $this->assertSame($categories, $categories_expected);
    }
    
    public function testtoArray()
    {
        $aclAction = new ACLAction();
    
        //wihout any fields set 
        $expected = array('id' => null, 'aclaccess' => null);
        $actual = $aclAction->toArray();
        $this->assertSame($expected, $actual);
    
        //with fileds pre populated
        $aclAction->populateFromRow(array('id' => '1234', 'aclaccess' => '9999'));
        $expected = array('id' => '1234', 'aclaccess' => '9999');
        $actual = $aclAction->toArray();
        $this->assertSame($expected, $actual);
    }
    
    public function testfromArray()
    {
        $aclAction = new ACLAction();
        $arr = array('id' => '1234', 'name' => 'test');
    
        //execute the method and verify that it retunrs expected results
        $aclAction->fromArray($arr);
        $this->assertSame($aclAction->id, '1234');
        $this->assertSame($aclAction->name, 'test');
    }
    
    public function testclearSessionCache()
    {
        $aclAction = new ACLAction();
    
        //execute the method and verify that it unsets the session cache
        $aclAction->clearSessionCache();
        $this->assertFalse(isset($_SESSION['ACL']));
    }
}
