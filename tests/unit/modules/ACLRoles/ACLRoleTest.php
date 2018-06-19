<?php

class ACLRoleTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testACLRole()
    {

        
        $aclRole = new ACLRole();
        $this->assertInstanceOf('ACLRole', $aclRole);
        $this->assertInstanceOf('SugarBean', $aclRole);

        $this->assertAttributeEquals('ACLRoles', 'module_dir', $aclRole);
        $this->assertAttributeEquals('ACLRole', 'object_name', $aclRole);
        $this->assertAttributeEquals('acl_roles', 'table_name', $aclRole);
        $this->assertAttributeEquals(true, 'new_schema', $aclRole);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aclRole);
        $this->assertAttributeEquals(true, 'disable_custom_fields', $aclRole);
        $this->assertAttributeEquals(array('user_id' => 'users'), 'relationship_fields', $aclRole);
    }

    public function testget_summary_text()
    {
        $aclRole = new ACLRole();

        
        
        $aclRole->name = 'test role';
        $name = $aclRole->get_summary_text();
        $this->assertEquals('test role', $name);
    }

    public function testsetAction()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('acl_roles_actions');
        
        $aclRole = new ACLRole();

        
        $initial_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id' => '1', 'action_id' => '1', 'access_override' => '90'), 'role_id'));
        $aclRole->setAction('1', '1', '90');
        $final_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id' => '1', 'action_id' => '1', 'access_override' => '90'), 'role_id'));

        $this->assertGreaterThanOrEqual($initial_count, $final_count, "values were: [$initial_count], [$final_count]");
        
        
        $state->popTable('acl_roles_actions');
    }

    public function testmark_relationships_deleted()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $aclRole = new ACLRole();

        
        $initial_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id' => '1', 'action_id' => '1', 'access_override' => '90'), 'role_id'));
        $aclRole->mark_relationships_deleted('1');
        $final_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id' => '1', 'action_id' => '1', 'access_override' => '90'), 'role_id'));

        $this->assertLessThanOrEqual($initial_count, $final_count, "values were: [$initial_count], [$final_count]");
        
        
        
        
    }

    public function testgetUserRoles()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $aclRole = new ACLRole();

        
        $result = $aclRole->getUserRoles('1');
        $this->assertTrue(is_array($result));

        
        $result = $aclRole->getUserRoles('1', false);
        $this->assertTrue(is_array($result));
        
        
        
        
    }

    public function testgetUserRoleNames()
    {
        $aclRole = new ACLRole();

        
        $result = $aclRole->getUserRoleNames('');
        $this->assertTrue(is_array($result));

        
        $result = $aclRole->getUserRoleNames('1');
        $this->assertTrue(is_array($result));
    }

    public function testgetAllRoles()
    {
        $aclRole = new ACLRole();

        
        $result = $aclRole->getAllRoles();
        $this->assertTrue(is_array($result));

        
        $result = $aclRole->getAllRoles(true);
        $this->assertTrue(is_array($result));
    }

    public function testgetRoleActions()
    {
        $aclRole = new ACLRole();

        
        $result = $aclRole->getRoleActions('');
        $this->assertTrue(is_array($result));
        $this->assertTrue(56 === count($result) || 0 === count($result));

        
        $result = $aclRole->getRoleActions('1');
        $this->assertTrue(is_array($result));
        $this->assertTrue(56 === count($result) || 0 === count($result));
    }

    public function testtoArray()
    {
        $aclRole = new ACLRole();

        
        $expected = array('id' => '', 'name' => '',  'description' => '');
        $actual = $aclRole->toArray();
        $this->assertSame($expected, $actual);

        
        $aclRole->id = '1';
        $aclRole->name = 'test';
        $aclRole->description = 'some description text';

        $expected = array('id' => '1', 'name' => 'test',  'description' => 'some description text');
        $actual = $aclRole->toArray();
        $this->assertSame($expected, $actual);
    }

    public function testfromArray()
    {
        $aclRole = new ACLRole();

        $arr = array('id' => '1', 'name' => 'test',  'description' => 'some description text');
        $aclRole->fromArray($arr);

        
        $this->assertSame($aclRole->id, '1');
        $this->assertSame($aclRole->name, 'test');
        $this->assertSame($aclRole->description, 'some description text');
    }
}
