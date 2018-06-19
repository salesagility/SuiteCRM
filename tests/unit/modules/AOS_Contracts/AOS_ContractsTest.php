<?php

class AOS_ContractsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOS_Contracts()
    {

        
        $aosContracts = new AOS_Contracts();
        $this->assertInstanceOf('AOS_Contracts', $aosContracts);
        $this->assertInstanceOf('Basic', $aosContracts);
        $this->assertInstanceOf('SugarBean', $aosContracts);

        $this->assertAttributeEquals('AOS_Contracts', 'module_dir', $aosContracts);
        $this->assertAttributeEquals('AOS_Contracts', 'object_name', $aosContracts);
        $this->assertAttributeEquals('aos_contracts', 'table_name', $aosContracts);
        $this->assertAttributeEquals(true, 'new_schema', $aosContracts);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosContracts);
        $this->assertAttributeEquals(true, 'importable', $aosContracts);

        $this->assertTrue(isset($aosContracts->renewal_reminder_date));
    }

    public function testsaveAndDelete()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('aod_indexevent');
        $state->pushTable('aos_contracts');
        $state->pushTable('tracker');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        

        $aosContracts = new AOS_Contracts();
        $aosContracts->name = 'test';

        $aosContracts->save();

        
        $this->assertTrue(isset($aosContracts->id));
        $this->assertEquals(36, strlen($aosContracts->id));

        
        $aosContracts->mark_deleted($aosContracts->id);
        $result = $aosContracts->retrieve($aosContracts->id);
        $this->assertEquals(null, $result);
        
        
        
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('tracker');
        $state->popTable('aos_contracts');
        $state->popTable('aod_indexevent');
        
    }

    public function testCreateReminderAndCreateLinkAndDeleteCall()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('calls');
        $state->pushTable('vcals');
        $state->pushTable('tracker');
        $state->pushGlobals();
        
        $call = new call();

        $aosContracts = new AOS_Contracts();
        $aosContracts->name = 'test';

        
        $aosContracts->createReminder();

        
        $this->assertTrue(isset($aosContracts->call_id));
        $this->assertEquals(36, strlen($aosContracts->call_id));

        
        $call->retrieve($aosContracts->call_id);
        $this->assertAttributeEquals('AOS_Contracts', 'parent_type', $call);

        
        $aosContracts->createLink();
        $call->retrieve($aosContracts->call_id);
        $this->assertAttributeEquals('Accounts', 'parent_type', $call);

        
        $aosContracts->deleteCall();
        $result = $call->retrieve($aosContracts->call_id);
        $this->assertEquals(null, $result);
        
        
        
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('vcals');
        $state->popTable('calls');
        $state->popTable('aod_indexevent');
    }
}
