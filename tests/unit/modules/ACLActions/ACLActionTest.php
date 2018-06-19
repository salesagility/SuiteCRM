<?php


class ACLActionTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }
    
    public function tearDown() {
        parent::tearDown();
    }

    public function testACLAction()
    {
        self::markTestIncomplete('environment dependency');
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('acl_actions');
        $state->pushGlobals();
        
$_POST['foo'] = 'bar123ase';
        
        $aclAction = new ACLAction();
        $this->assertInstanceOf('ACLAction', $aclAction);
        $this->assertInstanceOf('SugarBean', $aclAction);

        $this->assertAttributeEquals('ACLActions', 'module_dir', $aclAction);
        $this->assertAttributeEquals('ACLAction', 'object_name', $aclAction);
        $this->assertAttributeEquals('acl_actions', 'table_name', $aclAction);
        $this->assertAttributeEquals(true, 'new_schema', $aclAction);
        $this->assertAttributeEquals(true, 'disable_custom_fields', $aclAction);
        
        
        
        $state->popGlobals();
        $state->popTable('acl_actions');
    }

    public function testaddActions()
    {
        self::markTestIncomplete('environment dependency');
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('acl_actions');
        $state->pushTable('aod_index');
        
        

        
        $action_count = count(ACLAction::getDefaultActions());
        ACLAction::addActions('Test');
        $actual = ACLAction::getDefaultActions();
        $this->assertGreaterThan($action_count, count($actual));
        
        
        
        $state->popTable('aod_index');
        $state->popTable('acl_actions');
    }

    public function testremoveActions()
    {

        
        $action_count = count(ACLAction::getDefaultActions());
        ACLAction::removeActions('Test');
        $actual = ACLAction::getDefaultActions();
        $this->assertLessThanOrEqual($action_count, count($actual), 'actual count was: ' . count($actual));
    }

    public function testAccessName()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $this->assertFalse(ACLAction::AccessName('')); //test with invalid value
        $this->assertEquals('All', ACLAction::AccessName(90)); //test with a valid value
        
        
        
        
    }

    public function testgetDefaultActions()
    {
        global $beanList;
        $actual = ACLAction::getDefaultActions();
        $this->assertTrue(is_array($actual)); //verify that it returns an array
        foreach ($actual as $acl) {
            $this->assertInstanceOf('ACLAction', $acl);
        }
        $actual = ACLAction::getDefaultActions('module', 'list');
        $this->assertTrue(is_array($actual)); //verify that it returns an array
        foreach ($actual as $acl) {
            $this->assertInstanceOf('ACLAction', $acl);
            $this->assertEquals('list', $acl->name);
        }
    }

    public function testgetUserActions()
    {
        $result1 = ACLAction::getUserActions('1');
        $result2 = ACLAction::getUserActions('1', false, 'Accounts');
        $result3 = ACLAction::getUserActions('1', false, 'Accounts', 'list');

        self::markTestIncomplete('Need to implement: verify that all three results retunred are different.');
        
        
        
        
    }

    public function testhasAccess()
    {
        $this->assertFalse(ACLAction::hasAccess()); //check with defaults 
        $this->assertTrue(ACLAction::hasAccess(false, false, 90));  //access All with is owner false
        $this->assertTrue(ACLAction::hasAccess(true, true, 90)); //access All with is owner true 
        $this->assertFalse(ACLAction::hasAccess(false, false, -98));// check access disabled
        $this->assertFalse(ACLAction::hasAccess(true, true, 89)); //check access enabled 
        $this->assertTrue(ACLAction::hasAccess(true, true, 75)); //check owner access with is owner true
        $this->assertFalse(ACLAction::hasAccess(false, true, 75)); //check owner access with is owner false
    }

    public function testuserNeedsSecurityGroup()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        $this->assertFalse(ACLAction::userNeedsSecurityGroup('1', '', ''));//test with empty module and action 
        $this->assertFalse(ACLAction::userNeedsSecurityGroup('1', 'Accounts', 'list')); //test with valid module and action
        
        
        
        $state->popGlobals();
    }

    public function testuserHasAccess()
    {
        self::markTestIncomplete('Need to fix checking user access. Hint: session is a system state perhaps its failing because the user session');
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        $this->assertFalse(ACLAction::userHasAccess('', '', '')); //test with empty module and action
        $this->assertTrue(ACLAction::userHasAccess('', 'Accounts', 'list')); //test with e,pty user and valid module and action
        $this->assertTrue(ACLAction::userHasAccess('1', 'Accounts', 'list')); //test with valid User, module and action
        $this->assertTrue(ACLAction::userHasAccess('1', 'SecurityGroups', 'list')); //test with valid User, module and action
        $this->assertTrue(ACLAction::userHasAccess('1', 'Users', 'list')); //test with valid User, module and action
        
        
        
        $state->popGlobals();
    }

    public function testgetUserAccessLevel()
    {
        self::markTestIncomplete('Need to fix checking user access. Hint: session is a system state perhaps its failing because the user session');
        

        
        $this->assertEquals(90, ACLAction::getUserAccessLevel('1', 'Accounts', 'list'));
        $this->assertEquals(89, ACLAction::getUserAccessLevel('1', 'Accounts', 'access'));

        
        $this->assertEquals(90, ACLAction::getUserAccessLevel('1', 'Users', 'list'));
        $this->assertEquals(89, ACLAction::getUserAccessLevel('1', 'Users', 'access'));
    }

    public function testuserNeedsOwnership()
    {
        self::markTestIncomplete('Need to fix checking user access. Hint: session is a system state perhaps its failing because the user session');
        

        
        $this->assertFalse(ACLAction::userNeedsOwnership('', '', ''));

        
        $this->assertFalse(ACLAction::userNeedsOwnership('1', 'Accounts', 'list'));
        $this->assertFalse(ACLAction::userNeedsOwnership('1', 'Accounts', 'delete'));
        $this->assertFalse(ACLAction::userNeedsOwnership('1', 'Users', 'delete'));
        $this->assertFalse(ACLAction::userNeedsOwnership('1', 'Users', 'list'));
    }

    public function testsetupCategoriesMatrix()
    {

        
        $categories = array();
        $categories['Accounts']['module']['list'][] = 'list';
        $categories['Accounts']['module']['edit'][] = 'edit';

        $names_expected = array('list' => 'List', 'edit' => 'Edit');

        $categories_expected = array(
                'Accounts' => array(
                        'module' => array(
                                'list' => array('list', 'accessColor' => false, 'accessName' => false, 'accessLabel' => false, 'accessOptions' => array(90 => 'All', 80 => 'Group', 75 => 'Owner', 0 => 'Not Set', -99 => 'None')),
                                'edit' => array('edit', 'accessColor' => false, 'accessName' => false, 'accessLabel' => false, 'accessOptions' => array(90 => 'All', 80 => 'Group', 75 => 'Owner', 0 => 'Not Set', -99 => 'None')),
                        ),
                ),
        );

        
        $result = ACLAction::setupCategoriesMatrix($categories);
        $this->assertSame($names_expected, $result);
        $this->assertSame($categories, $categories_expected);
    }

    public function testtoArray()
    {
        $aclAction = new ACLAction();

        
        $expected = array('id' => null, 'aclaccess' => null);
        $actual = $aclAction->toArray();
        $this->assertSame($expected, $actual);

        
        $aclAction->populateFromRow(array('id' => '1234', 'aclaccess' => '9999'));
        $expected = array('id' => '1234', 'aclaccess' => '9999');
        $actual = $aclAction->toArray();
        $this->assertSame($expected, $actual);
    }

    public function testfromArray()
    {
        $aclAction = new ACLAction();
        $arr = array('id' => '1234', 'name' => 'test');

        
        $aclAction->fromArray($arr);
        $this->assertSame($aclAction->id, '1234');
        $this->assertSame($aclAction->name, 'test');
    }

    public function testclearSessionCache()
    {
        $aclAction = new ACLAction();

        
        $aclAction->clearSessionCache();
        $this->assertFalse(isset($_SESSION['ACL']));
    }
}
