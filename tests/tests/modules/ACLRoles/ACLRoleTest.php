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
 * Class ACLRoleTest
 */
class ACLRoleTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testACLRole()
    {
    
        //execute the contructor and check for the Object type and type attribute
        $aclRole = new ACLRole();
        $this->assertInstanceOf('ACLRole', $aclRole);
        $this->assertInstanceOf('SugarBean', $aclRole);
    
        $this->assertAttributeEquals('ACLRoles', 'module_dir', $aclRole);
        $this->assertAttributeEquals('ACLRole', 'object_name', $aclRole);
        $this->assertAttributeEquals('acl_roles', 'table_name', $aclRole);
        $this->assertAttributeEquals(true, 'new_schema', $aclRole);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aclRole);
        $this->assertAttributeEquals(true, 'disable_custom_fields', $aclRole);
        $this->assertAttributeEquals(array('user_id' => 'users'), 'relationship_fields', $aclRole);
    }
    
    public function testget_summary_text()
    {
        $aclRole = new ACLRole();
    
        //test with name attribute set and verify it returns expected value. 
        //it works only if name attribute is preset, throws exception otherwise
        $aclRole->name = 'test role';
        $name = $aclRole->get_summary_text();
        $this->assertEquals('test role', $name);
    }
    
    public function testsetAction()
    {
        $aclRole = new ACLRole();
    
        //take count of relationship initially and then after method execution and test if relationship count increases 
        $initial_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id'         => '1',
                                                                                           'action_id'       => '1',
                                                                                           'access_override' => '90',
        ), 'role_id'));
        $aclRole->setAction('1', '1', '90');
        $final_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id'         => '1',
                                                                                         'action_id'       => '1',
                                                                                         'access_override' => '90',
        ), 'role_id'));
        
        $this->assertGreaterThan($initial_count, $final_count);
    }
    
    public function testmark_relationships_deleted()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aclRole = new ACLRole();
    
        //take count of relationship initially and then after method execution and test if relationship count decreases
        $initial_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id'         => '1',
                                                                                           'action_id'       => '1',
                                                                                           'access_override' => '90',
        ), 'role_id'));
        $aclRole->mark_relationships_deleted('1');
        $final_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id'         => '1',
                                                                                         'action_id'       => '1',
                                                                                         'access_override' => '90',
        ), 'role_id'));
        
        $this->assertLessThan($initial_count, $final_count);
    }
    
    public function testgetUserRoles()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aclRole = new ACLRole();
    
        //test with default/true getAsNameArray param value
        $result = $aclRole->getUserRoles('1');
        $this->assertTrue(is_array($result));
    
        //test with flase getAsNameArray param value
        $result = $aclRole->getUserRoles('1', false);
        $this->assertTrue(is_array($result));
    }
    
    public function testgetUserRoleNames()
    {
        $aclRole = new ACLRole();
    
        //test with empty value
        $result = $aclRole->getUserRoleNames('');
        $this->assertTrue(is_array($result));
    
        //test with non empty but non existing role id value
        $result = $aclRole->getUserRoleNames('1');
        $this->assertTrue(is_array($result));
    }
    
    public function testgetAllRoles()
    {
        $aclRole = new ACLRole();
    
        //test with returnAsArray default/flase
        $result = $aclRole->getAllRoles();
        $this->assertTrue(is_array($result));
    
        //test with returnAsArray true
        $result = $aclRole->getAllRoles(true);
        $this->assertTrue(is_array($result));
    }
    
    public function testgetRoleActions()
    {
        $aclRole = new ACLRole();
    
        //test with empty value
        $result = $aclRole->getRoleActions('');
        $this->assertTrue(is_array($result));
        $this->assertEquals(54, count($result));
    
        //test with non empty but non existing role id value, initially no roles exist.
        $result = $aclRole->getRoleActions('1');
        $this->assertTrue(is_array($result));
        $this->assertEquals(54, count($result));
    }
    
    public function testtoArray()
    {
        $aclRole = new ACLRole();
    
        //wihout any fields set
        $expected = array('id' => '', 'name' => '', 'description' => '');
        $actual = $aclRole->toArray();
        $this->assertSame($expected, $actual);
    
        //with fileds pre populated
        $aclRole->id = '1';
        $aclRole->name = 'test';
        $aclRole->description = 'some description text';
    
        $expected = array('id' => '1', 'name' => 'test', 'description' => 'some description text');
        $actual = $aclRole->toArray();
        $this->assertSame($expected, $actual);
    }
    
    public function testfromArray()
    {
        $aclRole = new ACLRole();
    
        $arr = array('id' => '1', 'name' => 'test', 'description' => 'some description text');
        $aclRole->fromArray($arr);
    
        //verify that it sets the object attributes correctly
        $this->assertSame($aclRole->id, '1');
        $this->assertSame($aclRole->name, 'test');
        $this->assertSame($aclRole->description, 'some description text');
    }
}
