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
 * Class RelationshipTest
 */
class RelationshipTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testRelationship()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $relationship = new Relationship();
    
        $this->assertInstanceOf('Relationship', $relationship);
        $this->assertInstanceOf('SugarBean', $relationship);
    
        $this->assertAttributeEquals('Relationships', 'module_dir', $relationship);
        $this->assertAttributeEquals('Relationship', 'object_name', $relationship);
        $this->assertAttributeEquals('relationships', 'table_name', $relationship);
    
        $this->assertAttributeEquals(true, 'new_schema', $relationship);
    }
    
    public function testis_self_referencing()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        //test without setting any attributes
        $relationship = new Relationship();
    
        $result = $relationship->is_self_referencing();
        $this->assertEquals(true, $result);
    
        //test with attributes set to different values
        $relationship = new Relationship();
    
        $relationship->lhs_table = 'lhs_table';
        $relationship->rhs_table = 'rhs_table';
        $relationship->lhs_key = 'lhs_key';
        $relationship->rhs_key = 'rhs_key';
    
        $result = $relationship->is_self_referencing();
        $this->assertEquals(false, $result);
    
        //test with attributes set to same values
        $relationship = new Relationship();
    
        $relationship->lhs_table = 'table';
        $relationship->rhs_table = 'table';
        $relationship->lhs_key = 'key';
        $relationship->rhs_key = 'key';
    
        $result = $relationship->is_self_referencing();
        $this->assertEquals(true, $result);
    }
    
    public function testexists()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $relationship = new Relationship();
    
        //test with invalid relationship
        $result = $relationship->exists('test_test', $db);
        $this->assertEquals(false, $result);
    
        //test with valid relationship
        $result = $relationship->exists('roles_users', $db);
        $this->assertEquals(true, $result);
    }
    
    public function testdelete()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            Relationship::delete('test_test', $db);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testget_other_module()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $relationship = new Relationship();
    
        //test with invalid relationship
        $result = $relationship->get_other_module('test_test', 'test', $db);
        $this->assertEquals(false, $result);
    
        //test with valid relationship
        $result = $relationship->get_other_module('roles_users', 'Roles', $db);
        $this->assertEquals('Users', $result);
    }
    
    public function testretrieve_by_sides()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $relationship = new Relationship();
    
        //test with invalid relationship
        $result = $relationship->retrieve_by_sides('test1', 'test2', $db);
        $this->assertEquals(null, $result);
    
        //test with valid relationship
        $result = $relationship->retrieve_by_sides('Roles', 'Users', $db);
    
        $this->assertEquals('Users', $result['rhs_module']);
        $this->assertEquals('Roles', $result['lhs_module']);
    
        $this->assertEquals('id', $result['rhs_key']);
        $this->assertEquals('id', $result['lhs_key']);
    
        $this->assertEquals('many-to-many', $result['relationship_type']);
    }
    
    public function testretrieve_by_modules()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $relationship = new Relationship();
    
        //test with invalid relationship
        $result = $relationship->retrieve_by_modules('test1', 'test2', $db);
        $this->assertEquals(null, $result);
    
        //test with valid relationship but incorecct type
        $result = $relationship->retrieve_by_modules('Roles', 'Users', $db, 'one-to-many');
        $this->assertEquals(null, $result);
    
        //test with valid relationship and valid type
        $result = $relationship->retrieve_by_modules('Roles', 'Users', $db, 'many-to-many');
        $this->assertEquals('roles_users', $result);
    }
    
    public function testretrieve_by_name()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $relationship = new Relationship();
    
        //test with invalid relationship
        $result = $relationship->retrieve_by_name('test_test');
        $this->assertEquals(false, $result);
    
        //test with invalid relationship
        unset($result);
        $result = $relationship->retrieve_by_name('roles_users');
        $this->assertEquals(null, $result);
    
        $this->assertEquals('Users', $relationship->rhs_module);
        $this->assertEquals('Roles', $relationship->lhs_module);
    
        $this->assertEquals('id', $relationship->rhs_key);
        $this->assertEquals('id', $relationship->lhs_key);
    
        $this->assertEquals('many-to-many', $relationship->relationship_type);
    }
    
    public function testload_relationship_meta()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $relationship = new Relationship();
    
        $relationship->load_relationship_meta();
        $this->assertTrue(isset($GLOBALS['relationships']));
    }
    
    public function testbuild_relationship_cache()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $relationship = new Relationship();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $relationship->build_relationship_cache();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testcache_file_dir()
    {
        $result = Relationship::cache_file_dir();
        $this->assertEquals('cache/modules/Relationships', $result);
    }
    
    public function testcache_file_name_only()
    {
        $result = Relationship::cache_file_name_only();
        $this->assertEquals('relationships.cache.php', $result);
    }
    
    public function testdelete_cache()
    {
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            Relationship::delete_cache();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testtrace_relationship_module()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $relationship = new Relationship();
        $result = $relationship->trace_relationship_module('Roles', 'Users');
        $this->assertInstanceOf('User', $result);
    }
}
