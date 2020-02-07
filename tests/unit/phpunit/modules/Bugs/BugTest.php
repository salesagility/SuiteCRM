<?php


class BugTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testBug()
    {
        //execute the contructor and check for the Object type and  attributes
        $bug = new Bug();
        $this->assertInstanceOf('Bug', $bug);
        $this->assertInstanceOf('SugarBean', $bug);

        $this->assertAttributeEquals('Bugs', 'module_dir', $bug);
        $this->assertAttributeEquals('Bug', 'object_name', $bug);
        $this->assertAttributeEquals('bugs', 'table_name', $bug);
        $this->assertAttributeEquals('accounts_bugs', 'rel_account_table', $bug);
        $this->assertAttributeEquals('contacts_bugs', 'rel_contact_table', $bug);
        $this->assertAttributeEquals('cases_bugs', 'rel_case_table', $bug);
        $this->assertAttributeEquals(true, 'new_schema', $bug);
    }

    public function testget_summary_text()
    {
        $bug = new Bug();

        //test without setting name
        $this->assertEquals(null, $bug->get_summary_text());

        //test with name set//test with name set
        $bug->name = 'test';
        $this->assertEquals('test', $bug->get_summary_text());
    }

    public function testcreate_list_query()
    {
        self::markTestIncomplete('#Warning: Strings contain different line endings!');
        $bug = new Bug();

        //test with empty string params
        $expected = "SELECT \n                               bugs.*\n\n                                ,users.user_name as assigned_user_name, releases.id release_id, releases.name release_name FROM bugs 				LEFT JOIN releases ON bugs.found_in_release=releases.id\n								LEFT JOIN users\n                                ON bugs.assigned_user_id=users.id  where  bugs.deleted=0  ORDER BY bugs.name";
        $actual = $bug->create_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = "SELECT \n                               bugs.*\n\n                                ,users.user_name as assigned_user_name, releases.id release_id, releases.name release_name FROM bugs 				LEFT JOIN releases ON bugs.found_in_release=releases.id\n								LEFT JOIN users\n                                ON bugs.assigned_user_id=users.id  where bugs.name=\"\" AND  bugs.deleted=0  ORDER BY releases.id";
        $actual = $bug->create_list_query('releases.id', 'bugs.name=""');
        $this->assertSame($expected, $actual);
    }

    public function testcreate_export_query()
    {
        self::markTestIncomplete('#Warning: Strings contain different line endings!');
        $bug = new Bug();

        //test with empty string params
        $expected = "SELECT\n                                bugs.*,\n                                r1.name found_in_release_name,\n                                r2.name fixed_in_release_name,\n                                users.user_name assigned_user_name FROM bugs 				LEFT JOIN releases r1 ON bugs.found_in_release = r1.id\n								LEFT JOIN releases r2 ON bugs.fixed_in_release = r2.id\n								LEFT JOIN users\n                                ON bugs.assigned_user_id=users.id where   bugs.deleted=0\n                 ORDER BY bugs.bug_number";
        $actual = $bug->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = "SELECT\n                                bugs.*,\n                                r1.name found_in_release_name,\n                                r2.name fixed_in_release_name,\n                                users.user_name assigned_user_name FROM bugs 				LEFT JOIN releases r1 ON bugs.found_in_release = r1.id\n								LEFT JOIN releases r2 ON bugs.fixed_in_release = r2.id\n								LEFT JOIN users\n                                ON bugs.assigned_user_id=users.id where bugs.name=\"\" AND   bugs.deleted=0\n                 ORDER BY releases.id";
        $actual = $bug->create_export_query('releases.id', 'bugs.name=""');
        $this->assertSame($expected, $actual);
    }

    public function testfill_in_additional_list_fields()
    {
        $bug = new Bug();

        //execute the method and test if it works and does not throws an exception.
        try {
            $bug->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testfill_in_additional_detail_fields()
    {
        $bug = new Bug();
        $bug->assigned_user_id = 1;
        $bug->created_by = 1;
        $bug->modified_user_id = 1;

        //test with attributes preset and verify attributes are set accordingly
        $bug->fill_in_additional_detail_fields();

        $this->assertEquals('Administrator', $bug->assigned_user_name);
        $this->assertEquals('Administrator', $bug->created_by_name);
        $this->assertEquals('Administrator', $bug->modified_by_name);
    }

    public function testset_release()
    {
        $bug = new Bug();
        $bug->found_in_release = '1';

        $bug->set_release();

        $this->assertEquals('', $bug->release_name);
    }

    public function testset_fixed_in_release()
    {
        $bug = new Bug();
        $bug->found_in_release = '1';

        $bug->set_release();

        $this->assertEquals('', $bug->fixed_in_release_name);
    }

    public function testget_list_view_data()
    {
        $bug = new Bug();

        //execute the method and verify that it retunrs expected results
        $expected = array(
            'DELETED' => 0,
            'NAME' => '<em>blank</em>',
            'PRIORITY' => '',
            'STATUS' => '',
            'TYPE' => '',
            'RELEASE' => null,
            'BUG_NUMBER' => null,
            'ENCODED_NAME' => null,
        );

        $actual = $bug->get_list_view_data();
        $this->assertSame($expected, $actual);
    }

    public function testbuild_generic_where_clause()
    {
        $bug = new Bug();

        //execute with blank parameters
        $expected = "bugs.name like '%'";
        $actual = $bug->build_generic_where_clause('');
        $this->assertSame($expected, $actual);

        //execute with numeric parameter
        $expected = "bugs.name like '1%' or bugs.bug_number like '1%'";
        $actual = $bug->build_generic_where_clause(1);
        $this->assertSame($expected, $actual);
    }

    public function testset_notification_body()
    {
        $bug = new Bug();

        $bug->name = 'test';
        $bug->type = 'Defect';
        $bug->priority = 'Urgent';
        $bug->status = 'New';
        $bug->resolution = 'Accepted';
        $bug->bug_number = '1';

        //test with attributes preset and verify template variables are set accordingly
        $result = $bug->set_notification_body(new Sugar_Smarty(), $bug);

        $this->assertEquals($bug->name, $result->_tpl_vars['BUG_SUBJECT']);
        $this->assertEquals($bug->type, $result->_tpl_vars['BUG_TYPE']);
        $this->assertEquals($bug->priority, $result->_tpl_vars['BUG_PRIORITY']);
        $this->assertEquals($bug->status, $result->_tpl_vars['BUG_STATUS']);
        $this->assertEquals($bug->resolution, $result->_tpl_vars['BUG_RESOLUTION']);
        $this->assertEquals($bug->bug_number, $result->_tpl_vars['BUG_BUG_NUMBER']);
    }

    public function testbean_implements()
    {
        $bug = new Bug();
        $this->assertEquals(false, $bug->bean_implements('')); //test with blank value
        $this->assertEquals(false, $bug->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $bug->bean_implements('ACL')); //test with valid value
    }

    public function testsave()
    {
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('bugs');
        $state->pushTable('tracker');
        $state->pushGlobals();

        // test
        
        $bug = new Bug();

        $bug->name = 'test';
        $bug->bug_number = '1';
        $bug->type = 'Defect';
        $bug->priority = 'Urgent';
        $bug->status = 'New';
        $bug->resolution = 'Accepted';

        $bug->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($bug->id));
        $this->assertEquals(36, strlen($bug->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $bug->mark_deleted($bug->id);
        $result = $bug->retrieve($bug->id);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('bugs');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }

    public function testgetReleaseDropDown()
    {
        $result = getReleaseDropDown();

        //execute the method and verify it returns an array
        $this->assertTrue(is_array($result));
    }
}
