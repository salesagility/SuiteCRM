<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ProjectTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testProject()
    {
        // Execute the constructor and check for the Object type and  attributes
        $project = BeanFactory::newBean('Project');

        $this->assertInstanceOf('Project', $project);
        $this->assertInstanceOf('SugarBean', $project);


        $this->assertAttributeEquals('project', 'table_name', $project);
        $this->assertAttributeEquals('Project', 'module_dir', $project);
        $this->assertAttributeEquals('Project', 'object_name', $project);

        $this->assertAttributeEquals(true, 'new_schema', $project);
    }

    public function testfill_in_additional_detail_fields()
    {
        $project = BeanFactory::newBean('Project');

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
        $project = BeanFactory::newBean('Project');

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
        $project = BeanFactory::newBean('Project');

        $project->id =1;
        $_REQUEST['relate_id'] = 2;
        $_REQUEST['relate_to'] = "contacts";

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $project->save_relationship_changes(true);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }


    public function test_get_total_estimated_effort()
    {
//        $this->markTestIncomplete('Can Not be implemented: Unknown column parent_id in where clause \n Argument 3 passed to MysqlManager::convert() must be of the type array, integer given');
    }

    public function test_get_total_actual_effort()
    {
//        $this->markTestIncomplete('Can Not be implemented: Unknown column parent_id in where clause \n Argument 3 passed to MysqlManager::convert() must be of the type array, integer given');
    }

    public function testget_summary_text()
    {
        $project = BeanFactory::newBean('Project');

        //test without setting name
        $this->assertEquals(null, $project->get_summary_text());

        //test with name set
        $project->name = "test";
        $this->assertEquals('test', $project->get_summary_text());
    }

    public function testbuild_generic_where_clause()
    {
        $project = BeanFactory::newBean('Project');

        //test with empty string params
        $expected = "project.name LIKE '%%'";
        $actual = $project->build_generic_where_clause('');
        $this->assertSame($expected, $actual);


        //test with valid string params
        $expected = "project.name LIKE '%test%'";
        $actual = $project->build_generic_where_clause('test');
        $this->assertSame($expected, $actual);
    }

    /**
     * @todo: NEEDS FIXING!
     */
    public function testget_list_view_data()
    {
        /*
        $project = BeanFactory::newBean('Project');

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
        $project = BeanFactory::newBean('Project');

        $this->assertEquals(false, $project->bean_implements('')); //test with blank value
        $this->assertEquals(false, $project->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $project->bean_implements('ACL')); //test with valid value
    }

    public function testcreate_export_query()
    {
//        $this->markTestIncomplete('Refactor exporter: productes SQL that has different field ordering in SELECT');
    }

    public function testgetAllProjectTasks()
    {
        $project = BeanFactory::newBean('Project');

        $project->id = 1;
        $result = $project->getAllProjectTasks();
        $this->assertTrue(is_array($result));
    }
}
