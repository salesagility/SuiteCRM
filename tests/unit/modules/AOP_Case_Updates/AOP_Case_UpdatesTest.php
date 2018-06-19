<?PHP

class AOP_Case_UpdatesTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOP_Case_Updates()
    {

        
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

        
        $this->assertEquals(36, strlen($aopCaseUpdates->id));

        
        $aopCaseUpdates->mark_deleted($aopCaseUpdates->id);
        
        
        
        $state->popGlobals();
        $state->popTable('aop_case_updates');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
        $state->popTable('acl_actions');
    }

    public function testgetCase()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        
        $result = $aopCaseUpdates->getCase();

        $this->assertInstanceOf('aCase', $result);
    }

    public function testgetContacts()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        
        $result = $aopCaseUpdates->getContacts();
        $this->assertTrue(is_array($result));
    }

    public function testgetUpdateContact()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        
        $result = $aopCaseUpdates->getUpdateContact();
        $this->assertEquals(null, $result);

        
        $aopCaseUpdates->contact_id = 1;
        $result = $aopCaseUpdates->getUpdateContact();
        $this->assertEquals(false, $result);
    }

    public function testgetUser()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        
        $result = $aopCaseUpdates->getUser();
        $this->assertInstanceOf('User', $result);
    }

    public function testgetUpdateUser()
    {
        $aopCaseUpdates = new AOP_Case_Updates();

        
        $result = $aopCaseUpdates->getUpdateUser();
        $this->assertInstanceOf('User', $result);
    }
}
