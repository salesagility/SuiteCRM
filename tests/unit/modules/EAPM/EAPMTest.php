<?PHP

class EAPMTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testEAPM()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('aod_index');
        $eapmTable = $state->pushTable('eapm');
        
        
        

        
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
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        self::assertEquals($eapmTable, $state->popTable('eapm'));
        $state->popTable('aod_index');
        $state->popGlobals();
    }

    public function testbean_implements()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('aod_index');
        $eapmTable = $state->pushTable('eapm');
        
        
        
        

        $eapm = new EAPM();
        $this->assertEquals(false, $eapm->bean_implements('')); //test with blank value
        $this->assertEquals(false, $eapm->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $eapm->bean_implements('ACL')); //test with valid value
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        self::assertEquals($eapmTable, $state->popTable('eapm'));
        $state->popTable('aod_index');
        $state->popGlobals();
    }

    public function testgetLoginInfo()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('aod_index');
        $eapmTable = $state->pushTable('eapm');
        
        
        
        $eapm = new EAPM();

        
        $result = $eapm->getLoginInfo('');
        $this->assertEquals(null, $result);

        
        $result = $eapm->getLoginInfo('', true);
        $this->assertEquals(null, $result);
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        self::assertEquals($eapmTable, $state->popTable('eapm'));
        $state->popTable('aod_index');
        $state->popGlobals();
    }

    public function testcreate_new_list_query()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('aod_index');
        $eapmTable = $state->pushTable('eapm');
        
        
        
        $eapm = new EAPM();

        
        $expected = " SELECT  eapm.*  , jt0.user_name modified_by_name , jt0.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt1.user_name created_by_name , jt1.created_by created_by_name_owner  , 'Users' created_by_name_mod , jt2.user_name assigned_user_name , jt2.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM eapm   LEFT JOIN  users jt0 ON eapm.modified_user_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0  LEFT JOIN  users jt1 ON eapm.created_by=jt1.id AND jt1.deleted=0\n\n AND jt1.deleted=0  LEFT JOIN  users jt2 ON eapm.assigned_user_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where ( eapm.assigned_user_id ='' ) AND eapm.deleted=0";
        $actual = $eapm->create_new_list_query('', '');
        $this->assertSame($expected, $actual);

        
        $expected = " SELECT  eapm.*  , jt0.user_name modified_by_name , jt0.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt1.user_name created_by_name , jt1.created_by created_by_name_owner  , 'Users' created_by_name_mod , jt2.user_name assigned_user_name , jt2.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM eapm   LEFT JOIN  users jt0 ON eapm.modified_user_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0  LEFT JOIN  users jt1 ON eapm.created_by=jt1.id AND jt1.deleted=0\n\n AND jt1.deleted=0  LEFT JOIN  users jt2 ON eapm.assigned_user_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where (eapm.name=\"\" AND  eapm.assigned_user_id ='' ) AND eapm.deleted=0";
        $actual = $eapm->create_new_list_query('eapm.id', 'eapm.name=""');
        $this->assertSame($expected, $actual);
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        self::assertEquals($eapmTable, $state->popTable('eapm'));
        $state->popTable('aod_index');
        $state->popGlobals();
    }

    public function testsaveAndMarkDeletedAndValidated()
    {
        self::markTestIncomplete('eapm table fails');
        
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $eapmTable = $state->pushTable('eapm');
        
        
        
        $eapm = new EAPM();

        $eapm->name = 'test';
        $eapm->url = 'test_url';
        $eapm->application = 'webex';

        
        $this->assertEquals(false, $eapm->validated());

        $eapm->save();

        
        $this->assertTrue(isset($eapm->id));
        $this->assertEquals(36, strlen($eapm->id));

        
        $this->assertEquals(null, $eapm->validated());

        
        $eapmValidated = $eapm->retrieve($eapm->id);
        
        $this->markTestSkipped('Validated column never gets updated in Db ');

        
        $eapm->mark_deleted($eapm->id);
        $result = $eapm->retrieve($eapm->id);
        $this->assertEquals(null, $result);
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        self::assertEquals($eapmTable, $state->popTable('eapm'));
        $state->popTable('aod_index');
    }

    public function testfill_in_additional_detail_fields()
    {
        
        $state = new SuiteCRM\StateSaver();
        $eapmTable = $state->pushTable('eapm');
        $state->pushTable('tracker');
        $state->pushTable('aod_index');
        
        
        
        
        $eapm = new EAPM();

        
        try {
            $eapm->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        $state->popTable('aod_index');
        $state->popTable('tracker');
        self::assertEquals($eapmTable, $state->popTable('eapm'));
    }

    public function testfill_in_additional_list_fields()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $eapmTable = $state->pushTable('eapm');
        
        
        
        
        
        
        $eapm = new EAPM();

        
        try {
            $eapm->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        self::assertEquals($eapmTable, $state->popTable('eapm'));
        $state->popTable('aod_index');
    }

    public function testsave_cleanup()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $eapmTable = $state->pushTable('eapm');
        
        
        
        $eapm = new EAPM();

        
        $eapm->save_cleanup();

        $this->assertEquals('', $eapm->oauth_token);
        $this->assertEquals('', $eapm->oauth_secret);
        $this->assertEquals('', $eapm->api_data);
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        self::assertEquals($eapmTable, $state->popTable('eapm'));
        $state->popTable('aod_index');
    }

    public function testdelete_user_accounts()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $eapmTable = $state->pushTable('eapm');
        
        
        
        
        
        
        $eapm = new EAPM();

        
        try {
            $eapm->delete_user_accounts(1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        self::assertEquals($eapmTable, $state->popTable('eapm'));
        $state->popTable('aod_index');
    }

    public function testgetEAPMExternalApiDropDown()
    {        
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $eapmTable = $state->pushTable('eapm');
        
        
        

        $result = getEAPMExternalApiDropDown();
        $this->assertEquals(array('' => ''), $result);
        
        
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE eapm");
        
        self::assertEquals($eapmTable, $state->popTable('eapm'));
        $state->popTable('aod_index');
    }
}
