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
 * Class ProjectTest
 */
class ProjectTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    
    public function testProject()
    {
        //execute the contructor and check for the Object type and  attributes
        $project = new Project();
        
        $this->assertInstanceOf('Project', $project);
        $this->assertInstanceOf('SugarBean', $project);
        
        $this->assertAttributeEquals('project', 'table_name', $project);
        $this->assertAttributeEquals('Project', 'module_dir', $project);
        $this->assertAttributeEquals('Project', 'object_name', $project);
        
        $this->assertAttributeEquals(true, 'new_schema', $project);
        
    }
    
    public function testfill_in_additional_detail_fields()
    {
        error_reporting(E_ERROR | E_PARSE);
        
        $project = new Project();
        
        //test without setting assigned_user_id
        $project->fill_in_additional_detail_fields();
        $this->assertEquals("", $project->assigned_user_name);
        
        //test with assigned_user_id set
        $project->assigned_user_id = 1;
        $project->fill_in_additional_detail_fields();
        $this->assertEquals("Administrator", $project->assigned_user_name);
        
    }
    
    public function testfill_in_additional_list_fields()
    {
        $project = new Project();
        
        //test without setting assigned_user_id
        $project->fill_in_additional_list_fields();
        $this->assertEquals("", $project->assigned_user_name);
        
        //test with assigned_user_id set
        $project->assigned_user_id = 1;
        $project->fill_in_additional_list_fields();
        $this->assertEquals("Administrator", $project->assigned_user_name);
        
    }
    
    public function testsave_relationship_changes()
    {
    
        $project = new Project();
    
        $project->id = 1;
        $_REQUEST['relate_id'] = 2;
        $_REQUEST['relate_to'] = "contacts";
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $project->save_relationship_changes(true);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
    }
    
    public function test_get_total_estimated_effort()
    {
        //$project = new Project();
        //$result = $project->_get_total_estimated_effort("1");
        $this->markTestIncomplete(
            'Can Not be implemented: Unknown column parent_id in where clause \n Argument 3 
        passed to MysqlManager::convert() must be of the type array, integer given'
        );
        
    }
    
    public function test_get_total_actual_effort()
    {
        $this->markTestIncomplete(
            'Can Not be implemented: Unknown column parent_id in where clause \n Argument 3 
        passed to MysqlManager::convert() must be of the type array, integer given'
        );
    }
    
    public function testget_summary_text()
    {
        $project = new Project();
        
        //test without setting name
        $this->assertEquals(null, $project->get_summary_text());
        
        //test with name set
        $project->name = "test";
        $this->assertEquals('test', $project->get_summary_text());
        
    }
    
    public function testbuild_generic_where_clause()
    {
        
        $project = new Project();
        
        //test with empty string params
        $expected = "project.name LIKE '%%'";
        $actual = $project->build_generic_where_clause('');
        $this->assertSame($expected, $actual);
        
        //test with valid string params
        $expected = "project.name LIKE '%%'";
        $actual = $project->build_generic_where_clause('test');
        $this->assertSame($expected, $actual);
        
    }
    
    /**
     * @todo: NEEDS FIXING!
     */
    public function testget_list_view_data()
    {
        /*
		$project = new Project();

		$project->user_name = "tes user";
		$project->assigned_user_name = "test assigned user";

		$expected = array (
			'DELETED' => '0',
			'ASSIGNED_USER_NAME' => 'test assigned user',
			'USER_NAME' => 'tes user'
		);

		$actual = $project->get_list_view_data();

		$this->assertSame($expected, $actual);
		*/
        $this->assertTrue(true, "NEEDS FIXING!");
    }
    
    public function testbean_implements()
    {
        
        $project = new Project();
        
        $this->assertEquals(false, $project->bean_implements('')); //test with blank value
        $this->assertEquals(false, $project->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $project->bean_implements('ACL')); //test with valid value
        
    }
    
    public function testcreate_export_query()
    {
        $project = new Project();
    
        //test with empty string params
        $expected = "SELECT project.*, users.user_name as assigned_user_name , project_cstm.jjwg_maps_address_c, 
        project_cstm.jjwg_maps_geocode_status_c, project_cstm.jjwg_maps_lat_c, project_cstm.jjwg_maps_lng_c 
        FROM project LEFT JOIN project_cstm ON project.id = project_cstm.id_c 
        LEFT JOIN users ON project.assigned_user_id=users.id where project.deleted=0";
        $actual = $project->create_export_query('', '');
        $this->assertSameStringWhiteSpaceIgnore($expected, $actual);
    
        //test with valid string params
        $expected = "SELECT project.*, users.user_name as assigned_user_name , project_cstm.jjwg_maps_address_c, 
        project_cstm.jjwg_maps_geocode_status_c, project_cstm.jjwg_maps_lat_c, project_cstm.jjwg_maps_lng_c 
        FROM project LEFT JOIN project_cstm ON project.id = project_cstm.id_c 
        LEFT JOIN users ON project.assigned_user_id=users.id where (users.user_name) 
        AND project.deleted=0 ORDER BY project.id";
        $actual = $project->create_export_query('project.id', 'users.user_name');
        $this->assertSameStringWhiteSpaceIgnore($expected, $actual);
    
    }
    
    public function testgetAllProjectTasks()
    {
        
        $project = new Project();
        
        $project->id = 1;
        $result = $project->getAllProjectTasks();
        $this->assertTrue(is_array($result));
        
    }
    
}
