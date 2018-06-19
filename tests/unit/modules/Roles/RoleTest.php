<?php

class RoleTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testRole()
    {
        
        $role = new Role();

        $this->assertInstanceOf('Role', $role);
        $this->assertInstanceOf('SugarBean', $role);

        $this->assertAttributeEquals('roles', 'table_name', $role);
        $this->assertAttributeEquals('roles_modules', 'rel_module_table', $role);
        $this->assertAttributeEquals('Roles', 'module_dir', $role);
        $this->assertAttributeEquals('Role', 'object_name', $role);

        $this->assertAttributeEquals(true, 'new_schema', $role);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $role);
    }

    public function testget_summary_text()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $role = new Role();

        
        $this->assertEquals(null, $role->get_summary_text());

        
        $role->name = 'test';
        $this->assertEquals('test', $role->get_summary_text());
        
        
        
        
    }

    public function testcreate_export_query()
    {
        $role = new Role();

        
        $expected = ' SELECT  roles.*  FROM roles  where roles.deleted=0';
        $actual = $role->create_export_query('', '');
        $this->assertSame($expected, $actual);

        
        $expected = ' SELECT  roles.*  FROM roles  where (roles.name = "") AND roles.deleted=0';
        $actual = $role->create_export_query('roles.id', 'roles.name = ""');
        $this->assertSame($expected, $actual);
    }

    public function testSet_module_relationshipAndQuery_modules()
    {
        $role = new Role();

        $role->id = 1;
        $mod_ids = array('Accounts', 'Leads');

        
        
        $role->set_module_relationship($role->id, $mod_ids, 1);

        
        $result = $role->query_modules();
        $this->assertGreaterThanOrEqual(2, count((array)$result));

        
        $this->clear_module_relationship($role->id);
    }

    public function clear_module_relationship($id)
    {
        $role = new Role();

        $role->id = $id;
        $role->clear_module_relationship($id);

        
        $result = $role->query_modules();
        $this->assertEquals(0, count((array)$result));
    }

    public function testSet_user_relationshipAndCheck_user_role_count()
    {

	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('email_addresses');

	
        
        $role = new Role();

        $role->id = 1;
        $user_ids = array('1', '2');

        
        $role->set_user_relationship($role->id, $user_ids, 1);

        
        $result = $role->check_user_role_count('1');
        $this->assertGreaterThanOrEqual(1, count((array)$result));

        
        $result = $role->check_user_role_count('2');
        $this->assertGreaterThanOrEqual(1, count((array)$result));

        
        $this->get_users($role->id);

        
        $this->clear_user_relationship($role->id, '1');
        $this->clear_user_relationship($role->id, '2');
        
        
        
        $state->popTable('email_addresses');

    }

    public function get_users($id)
    {
        $role = new Role();

        $role->id = $id;
        $result = $role->get_users();

        $this->assertTrue(is_array($result));
    }

    public function clear_user_relationship($role_id, $user_id)
    {
        $role = new Role();

        
        $result = $role->clear_user_relationship($role_id, $user_id);
        $this->assertEquals(0, count((array)$result));
    }

    public function testquery_user_allowed_modules()
    {
        $role = new Role();

        $result = $role->query_user_allowed_modules('1');
        $this->assertTrue(is_array($result));
    }

    public function testquery_user_disallowed_modules()
    {
        $role = new Role();

        $allowed = array('Accounts' => 'Accounts', 'Leads' => 'Leads');
        $result = $role->query_user_disallowed_modules(null, $allowed);

        $this->assertTrue(is_array($result));
    }
}
