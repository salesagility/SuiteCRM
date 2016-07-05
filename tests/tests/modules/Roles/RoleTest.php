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
 * Class RoleTest
 */
class RoleTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testRole()
    {
        //execute the contructor and check for the Object type and  attributes
        $role = new Role();
    
        $this->assertInstanceOf('Role', $role);
        $this->assertInstanceOf('SugarBean', $role);
    
        $this->assertAttributeEquals('roles', 'table_name', $role);
        $this->assertAttributeEquals('roles_modules', 'rel_module_table', $role);
        $this->assertAttributeEquals('Roles', 'module_dir', $role);
        $this->assertAttributeEquals('Role', 'object_name', $role);
    
        $this->assertAttributeEquals(true, 'new_schema', $role);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $role);
    }
    
    public function testget_summary_text()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $role = new Role();
    
        //test without setting name
        $this->assertEquals(null, $role->get_summary_text());
    
        //test with name set
        $role->name = 'test';
        $this->assertEquals('test', $role->get_summary_text());
    }
    
    public function testcreate_export_query()
    {
        $role = new Role();
    
        //test with empty string params
        $expected = ' SELECT  roles.*  FROM roles  where roles.deleted=0';
        $actual = $role->create_export_query('', '');
        $this->assertSame($expected, $actual);
    
        //test with valid string params
        $expected = ' SELECT  roles.*  FROM roles  where (roles.name = "") AND roles.deleted=0';
        $actual = $role->create_export_query('roles.id', 'roles.name = ""');
        $this->assertSame($expected, $actual);
    }
    
    public function testSet_module_relationshipAndQuery_modules()
    {
        $role = new Role();
    
        $role->id = 1;
        $mod_ids = array('Accounts', 'Leads');
    
        //test set_module_relationship. 
        //creates related records
        $role->set_module_relationship($role->id, $mod_ids, 1);
    
        //get the related records count
        $result = $role->query_modules();
        $this->assertGreaterThanOrEqual(2, count($result));
    
        //test clear_module_relationship method 
        $this->clear_module_relationship($role->id);
    }
    
    public function clear_module_relationship($id)
    {
        $role = new Role();
    
        $role->id = $id;
        $role->clear_module_relationship($id);
    
        //get related records count and verify that records are removed
        $result = $role->query_modules();
        $this->assertEquals(0, count($result));
    }
    
    public function testSet_user_relationshipAndCheck_user_role_count()
    {
        $role = new Role();
    
        $role->id = 1;
        $user_ids = array('1', '2');
    
        //create related records
        $role->set_user_relationship($role->id, $user_ids, 1);
    
        //get the related records count
        $result = $role->check_user_role_count('1');
        $this->assertGreaterThanOrEqual(1, count($result));
    
        //get the related records count
        $result = $role->check_user_role_count('2');
        $this->assertGreaterThanOrEqual(1, count($result));
    
        //test get_users method
        $this->get_users($role->id);
    
        //test clear_user_relationship method
        $this->clear_user_relationship($role->id, '1');
        $this->clear_user_relationship($role->id, '2');
    }
    
    public function get_users($id)
    {
        $role = new Role();
    
        $role->id = $id;
        $result = $role->get_users();
    
        $this->assertTrue(is_array($result));
    }
    
    public function clear_user_relationship($role_id, $user_id)
    {
        $role = new Role();
    
        //get related records count and verify that records are removed
        $role->clear_user_relationship($role_id, $user_id);
        $this->assertEquals(0, count($result));
    }
    
    public function testquery_user_allowed_modules()
    {
        $role = new Role();
    
        $result = $role->query_user_allowed_modules('1');
        $this->assertTrue(is_array($result));
    }
    
    public function testquery_user_disallowed_modules()
    {
        $role = new Role();
    
        $allowed = array('Accounts' => 'Accounts', 'Leads' => 'Leads');
        $result = $role->query_user_disallowed_modules($user_id, $allowed);
    
        $this->assertTrue(is_array($result));
    }
}
