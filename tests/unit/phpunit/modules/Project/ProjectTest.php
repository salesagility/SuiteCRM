<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

/**
 * @internal
 */
class ProjectTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testProject()
    {
        // Execute the constructor and check for the Object type and  attributes
        $project = new Project();

        $this->assertInstanceOf('Project', $project);
        $this->assertInstanceOf('SugarBean', $project);

        $this->assertAttributeEquals('project', 'table_name', $project);
        $this->assertAttributeEquals('Project', 'module_dir', $project);
        $this->assertAttributeEquals('Project', 'object_name', $project);

        $this->assertAttributeEquals(true, 'new_schema', $project);
    }

    public function testfillInAdditionalDetailFields()
    {
        $project = new Project();

        //test without setting assigned_user_id
        $project->fill_in_additional_detail_fields();
        $this->assertEquals('', $project->assigned_user_name);

        //test with assigned_user_id set
        $project->assigned_user_id = 1;
        $project->fill_in_additional_detail_fields();
        $this->assertEquals('Administrator', $project->assigned_user_name);
    }

    public function testfillInAdditionalListFields()
    {
        $project = new Project();

        //test without setting assigned_user_id
        $project->fill_in_additional_list_fields();
        $this->assertEquals('', $project->assigned_user_name);

        //test with assigned_user_id set
        $project->assigned_user_id = 1;
        $project->fill_in_additional_list_fields();
        $this->assertEquals('Administrator', $project->assigned_user_name);
    }

    public function testsaveRelationshipChanges()
    {
        $project = new Project();

        $project->id = 1;
        $_REQUEST['relate_id'] = 2;
        $_REQUEST['relate_to'] = 'contacts';

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $project->save_relationship_changes(true);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testGetTotalEstimatedEffort()
    {
//        $this->markTestIncomplete('Can Not be implemented: Unknown column parent_id in where clause \n Argument 3 passed to MysqlManager::convert() must be of the type array, integer given');
    }

    public function testGetTotalActualEffort()
    {
//        $this->markTestIncomplete('Can Not be implemented: Unknown column parent_id in where clause \n Argument 3 passed to MysqlManager::convert() must be of the type array, integer given');
    }

    public function testgetSummaryText()
    {
        $project = new Project();

        //test without setting name
        $this->assertEquals(null, $project->get_summary_text());

        //test with name set
        $project->name = 'test';
        $this->assertEquals('test', $project->get_summary_text());
    }

    public function testbuildGenericWhereClause()
    {
        $project = new Project();

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
    public function testgetListViewData()
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
        $this->assertTrue(true, 'NEEDS FIXING!');
    }

    public function testbeanImplements()
    {
        $project = new Project();

        $this->assertEquals(false, $project->bean_implements('')); //test with blank value
        $this->assertEquals(false, $project->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $project->bean_implements('ACL')); //test with valid value
    }

    public function testcreateExportQuery()
    {
//        $this->markTestIncomplete('Refactor exporter: productes SQL that has different field ordering in SELECT');
    }

    public function testgetAllProjectTasks()
    {
        $project = new Project();

        $project->id = 1;
        $result = $project->getAllProjectTasks();
        $this->assertTrue(is_array($result));
    }
}
