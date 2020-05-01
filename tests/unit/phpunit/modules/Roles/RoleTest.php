<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

/**
 * @internal
 */
class RoleTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testRole()
    {
        // Execute the constructor and check for the Object type and  attributes
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

    public function testgetSummaryText()
    {
        $role = new Role();

        //test without setting name
        $this->assertEquals(null, $role->get_summary_text());

        //test with name set
        $role->name = 'test';
        $this->assertEquals('test', $role->get_summary_text());
    }

    public function testcreateExportQuery()
    {
        $role = new Role();

        //test with empty string params
        $expected = ' SELECT  roles.*  FROM roles  where roles.deleted=0';
        $actual = $role->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = ' SELECT  roles.*  FROM roles  where (roles.name = "") AND roles.deleted=0';
        $actual = $role->create_export_query('roles.id', 'roles.name = ""');
        $this->assertSame($expected, $actual);
    }

    public function testSetModuleRelationshipAndQueryModules()
    {
        $role = new Role();

        $role->id = 1;
        $mod_ids = ['Accounts', 'Leads'];

        //test set_module_relationship.
        //creates related records
        $role->set_module_relationship($role->id, $mod_ids, 1);

        //get the related records count
        $result = $role->query_modules();
        $this->assertGreaterThanOrEqual(2, count((array) $result));

        //test clear_module_relationship method
        $this->clear_module_relationship($role->id);
    }

    public function clear_module_relationship($id)
    {
        $role = new Role();

        $role->id = $id;
        $role->clear_module_relationship($id);

        //get related records count and verify that records are removed
        $result = $role->query_modules();
        $this->assertEquals(0, count((array) $result));
    }

    public function testSetUserRelationshipAndCheckUserRoleCount()
    {
        // test
        $role = new Role();

        $role->id = 1;
        $user_ids = ['1', '2'];

        //create related records
        $role->set_user_relationship($role->id, $user_ids, 1);

        //get the related records count
        $result = $role->check_user_role_count('1');
        $this->assertGreaterThanOrEqual(1, count((array) $result));

        //get the related records count
        $result = $role->check_user_role_count('2');
        $this->assertGreaterThanOrEqual(1, count((array) $result));

        //test get_users method
        $this->get_users($role->id);

        //test clear_user_relationship method
        $this->clear_user_relationship($role->id, '1');
        $this->clear_user_relationship($role->id, '2');
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

        //get related records count and verify that records are removed
        $result = $role->clear_user_relationship($role_id, $user_id);
        $this->assertEquals(0, count((array) $result));
    }

    public function testqueryUserAllowedModules()
    {
        $role = new Role();

        $result = $role->query_user_allowed_modules('1');
        $this->assertTrue(is_array($result));
    }

    public function testqueryUserDisallowedModules()
    {
        $role = new Role();

        $allowed = ['Accounts' => 'Accounts', 'Leads' => 'Leads'];
        $result = $role->query_user_disallowed_modules(null, $allowed);

        $this->assertTrue(is_array($result));
    }
}
