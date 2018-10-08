<?php

class MergeRecordTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testMergeRecord()
    {

        //execute the contructor and check for the Object type and  attributes
        $mergeRecord = new MergeRecord();

        $this->assertInstanceOf('MergeRecord', $mergeRecord);
        $this->assertInstanceOf('SugarBean', $mergeRecord);

        $this->assertAttributeEquals('MergeRecords', 'module_dir', $mergeRecord);
        $this->assertAttributeEquals('MergeRecord', 'object_name', $mergeRecord);

        $this->assertAttributeEquals(true, 'new_schema', $mergeRecord);
        $this->assertAttributeEquals(true, 'acl_display_only', $mergeRecord);
    }

    public function testsave()
    {
        $mergeRecord = new MergeRecord();
        //$mergeRecord->save();

        $this->markTestIncomplete('method has no implementation');
    }

    public function testretrieve()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');

        $mergeRecord = new MergeRecord();

        //preset variables required
        $mergeRecord->merge_bean = 'Users';
        $_REQUEST['action'] = 'Step2';

        $mergeRecord->retrieve('1');

        $this->markTestIncomplete('Merge bean is broken at the moment');
        //$this->assertTrue(isset($mergeRecord->merge_bean->id));
        
        $this->assertEquals(1, $mergeRecord->merge_bean->id);
    }

    public function testload_merge_bean()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');


        $mergeRecord = new MergeRecord();

        //test without merge_id
        $mergeRecord->load_merge_bean('Contacts');

        $this->assertAttributeEquals('Contacts', 'merge_module', $mergeRecord);
        $this->assertAttributeEquals('Contact', 'merge_bean_class', $mergeRecord);
        $this->assertAttributeEquals('modules/Contacts/Contact.php', 'merge_bean_file_path', $mergeRecord);

        //test with merge_id
        $mergeRecord->load_merge_bean('Users', false, 1);

        $this->assertAttributeEquals('Users', 'merge_module', $mergeRecord);
        $this->assertAttributeEquals('User', 'merge_bean_class', $mergeRecord);
        $this->assertAttributeEquals('modules/Users/User.php', 'merge_bean_file_path', $mergeRecord);

        $this->assertInstanceOf('User', $mergeRecord->merge_bean);
    }

    public function testload_merge_bean2()
    {
        $mergeRecord = new MergeRecord();

        //test without merge_id
        $mergeRecord->load_merge_bean2('Contacts');

        $this->assertAttributeEquals('Contacts', 'merge_module2', $mergeRecord);
        $this->assertAttributeEquals('Contact', 'merge_bean_class2', $mergeRecord);
        $this->assertAttributeEquals('modules/Contacts/Contact.php', 'merge_bean_file_path2', $mergeRecord);

        //test with merge_id
        $mergeRecord->load_merge_bean2('Users', false, 1);

        $this->assertAttributeEquals('Users', 'merge_module2', $mergeRecord);
        $this->assertAttributeEquals('User', 'merge_bean_class2', $mergeRecord);
        $this->assertAttributeEquals('modules/Users/User.php', 'merge_bean_file_path2', $mergeRecord);

        $this->assertInstanceOf('User', $mergeRecord->merge_bean2);
    }

    public function testfill_in_additional_list_fields()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');

        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        

        $mergeRecord = new MergeRecord();

        $mergeRecord->load_merge_bean('Users', false, 1);

        //execute the method and test if it works and does not throws an exception.
        try {
            $mergeRecord->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
    }

    public function testfill_in_additional_detail_fields()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');


        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $mergeRecord = new MergeRecord();

        $mergeRecord->load_merge_bean('Users', false, 1);

        //execute the method and test if it works and does not throws an exception.
        try {
            $mergeRecord->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
    }

    public function testget_summary_text()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');



        $mergeRecord = new MergeRecord();

        $mergeRecord->load_merge_bean('Users');

        //test without setting name
        $this->assertEquals(null, $mergeRecord->get_summary_text());

        //test with name set
        $mergeRecord->merge_bean->name = 'test';
        $this->assertEquals('test', $mergeRecord->get_summary_text());
    }

    public function testget_list_view_data()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');


        $mergeRecord = new MergeRecord();

        $mergeRecord->load_merge_bean('Users');

        $result = $mergeRecord->get_list_view_data();

        $this->assertTrue(is_array($result));
    }

    public function testbuild_generic_where_clause()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');



        $mergeRecord = new MergeRecord();

        $mergeRecord->load_merge_bean('Contacts');

        //test with string
        $expected = "contacts.last_name like 'test%' or contacts.first_name like 'test%' or accounts.name like 'test%' or contacts.assistant like 'test%' or ea.email_address like 'test%'";
        $actual = $mergeRecord->build_generic_where_clause('test');
        $this->assertSame($expected, $actual);

        //test with number
        $expected = "contacts.last_name like '1%' or contacts.first_name like '1%' or accounts.name like '1%' or contacts.assistant like '1%' or ea.email_address like '1%' or contacts.phone_home like '%1%' or contacts.phone_mobile like '%1%' or contacts.phone_work like '%1%' or contacts.phone_other like '%1%' or contacts.phone_fax like '%1%' or contacts.assistant_phone like '%1%'";
        $actual = $mergeRecord->build_generic_where_clause(1);
        $this->assertSame($expected, $actual);
    }

    public function testbean_implements()
    {
        $mergeRecord = new MergeRecord();

        $this->assertEquals(false, $mergeRecord->bean_implements('')); //test with blank value
        $this->assertEquals(false, $mergeRecord->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $mergeRecord->bean_implements('ACL')); //test with valid value
    }

    public function testACLAccess()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');


        $mergeRecord = new MergeRecord();

        //test without loading merge bean
        $this->assertEquals(true, $mergeRecord->ACLAccess('')); //test with valid value

        //test with merge bean loaded
        $mergeRecord->load_merge_bean('Meetings');

        $this->assertEquals(true, $mergeRecord->ACLAccess('edit'));
        $this->assertEquals(true, $mergeRecord->ACLAccess('save'));
        $this->assertEquals(true, $mergeRecord->ACLAccess('editview'));
        $this->assertEquals(true, $mergeRecord->ACLAccess('delete'));
    }

    public function testpopulate_search_params()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');



        $mergeRecord = new MergeRecord();

        $mergeRecord->load_merge_bean('Meetings');

        $expected = array(
                          'id' => array('name' => 'id', 'vname' => 'LBL_ID', 'type' => 'id', 'required' => true, 'reportable' => true, 'comment' => 'Unique identifier', 'inline_edit' => false, 'value' => '1', 'search_type' => 'Exact'),
                          'name' => array('name' => 'name', 'vname' => 'LBL_SUBJECT', 'required' => true, 'type' => 'name', 'dbType' => 'varchar', 'unified_search' => true, 'full_text_search' => array('boost' => 3), 'len' => '50', 'comment' => 'Meeting name', 'importable' => 'required', 'value' => 'test', 'search_type' => 'Exact'),
                        );

        $mergeRecord->populate_search_params(array('nameSearchField' => 'test', 'idSearchField' => '1'));

        $this->assertSame($expected, $mergeRecord->field_search_params);
    }

    public function testget_inputs_for_search_params()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');


        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $mergeRecord = new MergeRecord();

        $mergeRecord->load_merge_bean('Meetings');

        $expected = "<input type='hidden' name='idSearchField' value='1' />\n<input type='hidden' name='idSearchType' value='' />\n<input type='hidden' name='nameSearchField' value='test' />\n<input type='hidden' name='nameSearchType' value='' />\n";

        $result = $mergeRecord->get_inputs_for_search_params(array('nameSearchField' => 'test', 'idSearchField' => '1'));

        $this->assertSame($expected, $result);
        
        // clean up
    }

    public function testemail_addresses_query()
    {
        $table = 'accounts';
        $module = 'Accounts';
        $bean_id = 1;
        $expected = $table.".id IN (SELECT ear.bean_id FROM email_addresses ea
                                LEFT JOIN email_addr_bean_rel ear ON ea.id = ear.email_address_id
                                WHERE ear.bean_module = '{$module}'
                                AND ear.bean_id != '{$bean_id}'
                                AND ear.deleted = 0";

        $mergeRecord = new MergeRecord();
        $result = $mergeRecord->email_addresses_query($table, $module, $bean_id);

        $this->assertSame($expected, $result);
    }

    public function testrelease_name_query()
    {
        $mergeRecord = new MergeRecord();

        //test with type = like
        $result = $mergeRecord->release_name_query('like', 'test');
        $this->assertSame('', $result);

        //test with type = start
        $result = $mergeRecord->release_name_query('start', 'test');
        $this->assertSame('', $result);
    }

    public function testcreate_where_statement()
    {
        self::markTestIncomplete('Test failing since commit a5acea613 applied php7fix patch');



        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $mergeRecord = new MergeRecord();

        $mergeRecord->load_merge_bean('Contacts');
        $mergeRecord->populate_search_params(array('nameSearchField' => 'test', 'idSearchField' => '1'));

        $expected = array(
            0 => "contacts.id='1'",
            1 => "contacts.name='test'",
            2 => "contacts.id !=''",
        );

        $actual = $mergeRecord->create_where_statement();

        $this->assertSame($expected, $actual);
    }

    public function testgenerate_where_statement()
    {
        $mergeRecord = new MergeRecord();

        $clauses = array("contacts.id='1'",  "contacts.name='test'", "contacts.id !=''");
        $expected = "contacts.id='1' AND contacts.name='test' AND contacts.id !=''";

        $actual = $mergeRecord->generate_where_statement($clauses);

        $this->assertSame($expected, $actual);

        ////error_reporting(E_ALL);
    }
}
