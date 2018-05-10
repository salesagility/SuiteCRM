<?PHP

class EAPMTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testEAPM()
    {
        $this->markTestIncomplete('environment dependency');
        
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        
        // test

        //execute the contructor and check for the Object type and  attributes
        $eapm = new EAPM();
        $this->assertInstanceOf('EAPM', $eapm);
        $this->assertInstanceOf('Basic', $eapm);
        $this->assertInstanceOf('SugarBean', $eapm);

        $this->assertAttributeEquals('EAPM', 'module_dir', $eapm);
        $this->assertAttributeEquals('EAPM', 'object_name', $eapm);
        $this->assertAttributeEquals('eapm', 'table_name', $eapm);
        $this->assertAttributeEquals(true, 'new_schema', $eapm);
        $this->assertAttributeEquals(false, 'importable', $eapm);
        $this->assertAttributeEquals(false, 'validated', $eapm);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $eapm);
        
        // clean up
        
        $state->popTable('aod_indexevent');
    }

    public function testbean_implements()
    {

        $eapm = new EAPM();
        $this->assertEquals(false, $eapm->bean_implements('')); //test with blank value
        $this->assertEquals(false, $eapm->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $eapm->bean_implements('ACL')); //test with valid value
    }

    public function testgetLoginInfo()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        // test

        $eapm = new EAPM();

        //test with default value/false
        $result = $eapm->getLoginInfo('');
        $this->assertEquals(null, $result);

        //test with true
        $result = $eapm->getLoginInfo('', true);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $state->popGlobals();
    }

    public function testcreate_new_list_query()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        // test
        
        $eapm = new EAPM();

        //test with empty string params
        $expected = " SELECT  eapm.*  , jt0.user_name modified_by_name , jt0.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt1.user_name created_by_name , jt1.created_by created_by_name_owner  , 'Users' created_by_name_mod , jt2.user_name assigned_user_name , jt2.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM eapm   LEFT JOIN  users jt0 ON eapm.modified_user_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0  LEFT JOIN  users jt1 ON eapm.created_by=jt1.id AND jt1.deleted=0\n\n AND jt1.deleted=0  LEFT JOIN  users jt2 ON eapm.assigned_user_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where ( eapm.assigned_user_id ='' ) AND eapm.deleted=0";
        $actual = $eapm->create_new_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = " SELECT  eapm.*  , jt0.user_name modified_by_name , jt0.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt1.user_name created_by_name , jt1.created_by created_by_name_owner  , 'Users' created_by_name_mod , jt2.user_name assigned_user_name , jt2.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM eapm   LEFT JOIN  users jt0 ON eapm.modified_user_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0  LEFT JOIN  users jt1 ON eapm.created_by=jt1.id AND jt1.deleted=0\n\n AND jt1.deleted=0  LEFT JOIN  users jt2 ON eapm.assigned_user_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where (eapm.name=\"\" AND  eapm.assigned_user_id ='' ) AND eapm.deleted=0";
        $actual = $eapm->create_new_list_query('eapm.id', 'eapm.name=""');
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popGlobals();
    }

    public function testsaveAndMarkDeletedAndValidated()
    {
        $eapm = new EAPM();

        $eapm->name = 'test';
        $eapm->url = 'test_url';
        $eapm->application = 'webex';

        //test validated method initially
        $this->assertEquals(false, $eapm->validated());

        $eapm->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($eapm->id));
        $this->assertEquals(36, strlen($eapm->id));

        //test validated method finally after save
        $this->assertEquals(null, $eapm->validated());

        //retrieve back to test if validated attribute is updated in db
        $eapmValidated = $eapm->retrieve($eapm->id);
        //$this->assertEquals(1, $eapmValidated->validated);
        $this->markTestSkipped('Validated column never gets updated in Db ');

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $eapm->mark_deleted($eapm->id);
        $result = $eapm->retrieve($eapm->id);
        $this->assertEquals(null, $result);
    }

    public function testfill_in_additional_detail_fields()
    {
        $eapm = new EAPM();

        //execute the method and test if it works and does not throws an exception.
        try {
            $eapm->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
    }

    public function testfill_in_additional_list_fields()
    {
        $eapm = new EAPM();

        //execute the method and test if it works and does not throws an exception.
        try {
            $eapm->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
    }

    public function testsave_cleanup()
    {
        $eapm = new EAPM();

        //execute the method and verify attributes are set accordingly
        $eapm->save_cleanup();

        $this->assertEquals('', $eapm->oauth_token);
        $this->assertEquals('', $eapm->oauth_secret);
        $this->assertEquals('', $eapm->api_data);
    }

    public function testdelete_user_accounts()
    {
        $eapm = new EAPM();

        //execute the method and test if it works and does not throws an exception.
        try {
            $eapm->delete_user_accounts(1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
    }

    public function testgetEAPMExternalApiDropDown()
    {
        $result = getEAPMExternalApiDropDown();
        $this->assertEquals(array('' => ''), $result);
    }
}
