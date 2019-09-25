<?php

class AOP_Case_UpdatesTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOP_Case_Updates()
    {

        //execute the contructor and check for the Object type and  attributes
        $aopCaseUpdates = new AOP_Case_Updates();
        $this->assertInstanceOf('AOP_Case_Updates', $aopCaseUpdates);
        $this->assertInstanceOf('Basic', $aopCaseUpdates);
        $this->assertInstanceOf('SugarBean', $aopCaseUpdates);

        $this->assertAttributeEquals('AOP_Case_Updates', 'module_dir', $aopCaseUpdates);
        $this->assertAttributeEquals('AOP_Case_Updates', 'object_name', $aopCaseUpdates);
        $this->assertAttributeEquals('aop_case_updates', 'table_name', $aopCaseUpdates);
        $this->assertAttributeEquals(true, 'new_schema', $aopCaseUpdates);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aopCaseUpdates);
        $this->assertAttributeEquals(false, 'importable', $aopCaseUpdates);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aopCaseUpdates);
    }

    public function testsave()
    {
        self::markTestIncomplete('environment dependency');
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('acl_actions');
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('aop_case_updates');
        $state->pushGlobals();

        $aopCaseUpdates = new AOP_Case_Updates();
        $aopCaseUpdates->name = 'test name';
        $aopCaseUpdates->description = 'test description';
        $aopCaseUpdates->case_id = 'test case id';
        $aopCaseUpdates->contact_id = 'test id';
        $aopCaseUpdates->internal = 1;
        $aopCaseUpdates->save();

        //test for record ID to verify that record is saved
        $this->assertEquals(36, strlen($aopCaseUpdates->id));

        //mark the record as deleted for cleanup
        $aopCaseUpdates->mark_deleted($aopCaseUpdates->id);
        
        // clean up
        $state->popGlobals();
        $state->popTable('aop_case_updates');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
        $state->popTable('acl_actions');
    }

    public function testgetCase()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        //execute the method and verify that it returns a Case object
        $result = $aopCaseUpdates->getCase();

        $this->assertInstanceOf('aCase', $result);
    }

    public function testgetContacts()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        //execute the method and verify that it returns an array
        $result = $aopCaseUpdates->getContacts();
        $this->assertTrue(is_array($result));
    }

    public function testgetUpdateContact()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        //execute the method without contact_id and verify that it returns null
        $result = $aopCaseUpdates->getUpdateContact();
        $this->assertEquals(null, $result);

        //execute the method without contact_id and verify that it returns false
        $aopCaseUpdates->contact_id = 1;
        $result = $aopCaseUpdates->getUpdateContact();
        $this->assertEquals(false, $result);
    }

    public function testgetUser()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        //execute the method and verify that it returns an instance of User
        $result = $aopCaseUpdates->getUser();
        $this->assertInstanceOf('User', $result);
    }

    public function testgetUpdateUser()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        //execute the method and verify that it returns an instance of User
        $result = $aopCaseUpdates->getUpdateUser();
        $this->assertInstanceOf('User', $result);
    }
}
