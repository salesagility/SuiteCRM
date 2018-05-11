<?php

class ProjectTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract {


	public function testProject()
	{
        
        // save state
        
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('roles_users');
        
        // test
        
		//execute the contructor and check for the Object type and  attributes
		$project = new Project();

		$this->assertInstanceOf('Project',$project);
		$this->assertInstanceOf('SugarBean',$project);


		$this->assertAttributeEquals('project', 'table_name', $project);
		$this->assertAttributeEquals('Project', 'module_dir', $project);
		$this->assertAttributeEquals('Project', 'object_name', $project);

		$this->assertAttributeEquals(true, 'new_schema', $project);
        
        // clean up
        
        $state->popTable('roles_users');

	}

	public function testfill_in_additional_detail_fields()
	{
        
        // save state
        
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('roles_users');
        
        // test

		$project = new Project();

		//test without setting assigned_user_id
		$project->fill_in_additional_detail_fields();
		$this->assertEquals("", $project->assigned_user_name);


		//test with assigned_user_id set
		$project->assigned_user_id = 1;
		$project->fill_in_additional_detail_fields();
		$this->assertEquals("Administrator", $project->assigned_user_name);
        
        // clean up
        
        $state->popTable('roles_users');

	}


	public function testfill_in_additional_list_fields()
	{
        
        // save state
        
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('roles_users');
        
        // test
		$project = new Project();

		//test without setting assigned_user_id
		$project->fill_in_additional_list_fields();
		$this->assertEquals("", $project->assigned_user_name);


		//test with assigned_user_id set
		$project->assigned_user_id = 1;
		$project->fill_in_additional_list_fields();
		$this->assertEquals("Administrator", $project->assigned_user_name);
        
        // clean up
        
        $state->popTable('roles_users');

	}


    public function testsave_relationship_changes()
    {
        
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('roles_users');
        $state->pushGlobals();
        
        // test


    	$project = new Project();

    	$project->id =1;
    	$_REQUEST['relate_id'] = 2;
    	$_REQUEST['relate_to'] = "contacts";

    	//execute the method and test if it works and does not throws an exception.
    	try {
    		$project->save_relationship_changes(true);
    		$this->assertTrue(true);
    	}
    	catch (Exception $e) {
    		$this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
    	}
        
        // clean up
        
        $state->popTable('roles_users');
        $state->popGlobals();

    }


	public function test_get_total_estimated_effort()
	{
		//$project = new Project();
		//$result = $project->_get_total_estimated_effort("1");
		$this->markTestIncomplete('Can Not be implemented: Unknown column parent_id in where clause \n Argument 3 passed to MysqlManager::convert() must be of the type array, integer given');

	}


	public function test_get_total_actual_effort()
	{
		$this->markTestIncomplete('Can Not be implemented: Unknown column parent_id in where clause \n Argument 3 passed to MysqlManager::convert() must be of the type array, integer given');
	}


	public function testget_summary_text()
	{
        
        // save state
        
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('roles_users');
        
        // test
		$project = new Project();

		//test without setting name
		$this->assertEquals(Null,$project->get_summary_text());

		//test with name set
		$project->name = "test";
		$this->assertEquals('test',$project->get_summary_text());

        
        // clean up
        
        $state->popTable('roles_users');
	}


	public function testbuild_generic_where_clause ()
	{
        
        // save state
        
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('roles_users');
        
        // test

		$project = new Project();

		//test with empty string params
		$expected = "project.name LIKE '%%'";
		$actual = $project->build_generic_where_clause('');
		$this->assertSame($expected,$actual);


		//test with valid string params
		$expected = "project.name LIKE '%test%'";
		$actual = $project->build_generic_where_clause('test');
		$this->assertSame($expected,$actual);

        
        // clean up
        
        $state->popTable('roles_users');
	}

    /**
     * @todo: NEEDS FIXING!
     */
	public function testget_list_view_data()
	{
            $this->markTestIncomplete('NEEDS FIXING!');
            
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
//        $this->assertTrue(true, "NEEDS FIXING!");
	}

	public function testbean_implements(){

        
        // save state
        
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('roles_users');
        
        // test
		$project = new Project();

		$this->assertEquals(false, $project->bean_implements('')); //test with blank value
		$this->assertEquals(false, $project->bean_implements('test')); //test with invalid value
		$this->assertEquals(true, $project->bean_implements('ACL')); //test with valid value

        
        // clean up
        
        $state->popTable('roles_users');
	}

    public function testcreate_export_query()
    {
        
        // save state
        
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('roles_users');
        
        // test
        $this->markTestIncomplete('environment dependency');
        
    	$project = new Project();

    	//test with empty string params
    	$expected = "SELECT
				project.*,
                users.user_name as assigned_user_name ,project_cstm.jjwg_maps_address_c,project_cstm.jjwg_maps_geocode_status_c,project_cstm.jjwg_maps_lat_c,project_cstm.jjwg_maps_lng_c FROM project  LEFT JOIN project_cstm ON project.id = project_cstm.id_c  LEFT JOIN users
                   	ON project.assigned_user_id=users.id where  project.deleted=0 ";
    	$actual = $project->create_export_query('','');
    	$this->assertSame($expected,$actual);


    	//test with valid string params
    	$expected = "SELECT
				project.*,
                users.user_name as assigned_user_name ,project_cstm.jjwg_maps_address_c,project_cstm.jjwg_maps_geocode_status_c,project_cstm.jjwg_maps_lat_c,project_cstm.jjwg_maps_lng_c FROM project  LEFT JOIN project_cstm ON project.id = project_cstm.id_c  LEFT JOIN users
                   	ON project.assigned_user_id=users.id where (users.user_name) AND  project.deleted=0  ORDER BY project.id";
    	$actual = $project->create_export_query('project.id','users.user_name');
    	$this->assertSame($expected,$actual);

        
        // clean up
        
        $state->popTable('roles_users');
    }

	public function testgetAllProjectTasks(){

            $this->markTestIncomplete('Incorrect state hash (in PHPUnitTest): Hash doesn\'t match at key "database::roles_users"');
        
        // save state
        
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('roles_users');
        
        // test
		$project = new Project();

		$project->id = 1;
		$result = $project->getAllProjectTasks();
		$this->assertTrue(is_array($result));

        
        // clean up
        
        $state->popTable('roles_users');
	}

}
?>
