<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class RelationshipTest extends SuitePHPUnitFrameworkTestCase
{
    public function testRelationship()
    {
        // Execute the constructor and check for the Object type and  attributes
        $relationship = BeanFactory::newBean('Relationships');

        $this->assertInstanceOf('Relationship', $relationship);
        $this->assertInstanceOf('SugarBean', $relationship);

        $this->assertAttributeEquals('Relationships', 'module_dir', $relationship);
        $this->assertAttributeEquals('Relationship', 'object_name', $relationship);
        $this->assertAttributeEquals('relationships', 'table_name', $relationship);

        $this->assertAttributeEquals(true, 'new_schema', $relationship);
    }

    public function testis_self_referencing()
    {
        //test without setting any attributes
        $relationship = BeanFactory::newBean('Relationships');

        $result = $relationship->is_self_referencing();
        $this->assertEquals(true, $result);

        //test with attributes set to different values
        $relationship = BeanFactory::newBean('Relationships');

        $relationship->lhs_table = 'lhs_table';
        $relationship->rhs_table = 'rhs_table';
        $relationship->lhs_key = 'lhs_key';
        $relationship->rhs_key = 'rhs_key';

        $result = $relationship->is_self_referencing();
        $this->assertEquals(false, $result);

        //test with attributes set to same values
        $relationship = BeanFactory::newBean('Relationships');

        $relationship->lhs_table = 'table';
        $relationship->rhs_table = 'table';
        $relationship->lhs_key = 'key';
        $relationship->rhs_key = 'key';

        $result = $relationship->is_self_referencing();
        $this->assertEquals(true, $result);
    }

    public function testexists()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $relationship = BeanFactory::newBean('Relationships');

        //test with invalid relationship
        $result = $relationship->exists('test_test', $db);
        $this->assertEquals(false, $result);

        //test with valid relationship
        $result = $relationship->exists('roles_users', $db);
        $this->assertEquals(true, $result);
    }

    public function testdelete()
    {
        $db = DBManagerFactory::getInstance();

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            Relationship::delete('test_test', $db);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testget_other_module()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $relationship = BeanFactory::newBean('Relationships');

        //test with invalid relationship
        $result = $relationship->get_other_module('test_test', 'test', $db);
        $this->assertEquals(false, $result);

        //test with valid relationship
        $result = $relationship->get_other_module('roles_users', 'Roles', $db);
        $this->assertEquals('Users', $result);
    }

    public function testretrieve_by_sides()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $relationship = BeanFactory::newBean('Relationships');

        //test with invalid relationship
        $result = $relationship->retrieve_by_sides('test1', 'test2', $db);
        $this->assertEquals(null, $result);

        //test with valid relationship
        $result = $relationship->retrieve_by_sides('Roles', 'Users', $db);

        $this->assertEquals('Users', $result['rhs_module']);
        $this->assertEquals('Roles', $result['lhs_module']);

        $this->assertEquals('id', $result['rhs_key']);
        $this->assertEquals('id', $result['lhs_key']);

        $this->assertEquals('many-to-many', $result['relationship_type']);
    }

    public function testretrieve_by_modules()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $relationship = BeanFactory::newBean('Relationships');

        //test with invalid relationship
        $result = $relationship->retrieve_by_modules('test1', 'test2', $db);
        $this->assertEquals(null, $result);

        //test with valid relationship but incorecct type
        $result = $relationship->retrieve_by_modules('Roles', 'Users', $db, 'one-to-many');
        $this->assertEquals(null, $result);

        //test with valid relationship and valid type
        $result = $relationship->retrieve_by_modules('Roles', 'Users', $db, 'many-to-many');
        $this->assertEquals('roles_users', $result);
    }

    public function testretrieve_by_name()
    {
        $relationship = BeanFactory::newBean('Relationships');

        //test with invalid relationship
        $result = $relationship->retrieve_by_name('test_test');
        $this->assertEquals(false, $result);

        //test with invalid relationship
        unset($result);
        $result = $relationship->retrieve_by_name('roles_users');
        $this->assertEquals(null, $result);

        $this->assertEquals('Users', $relationship->rhs_module);
        $this->assertEquals('Roles', $relationship->lhs_module);

        $this->assertEquals('id', $relationship->rhs_key);
        $this->assertEquals('id', $relationship->lhs_key);

        $this->assertEquals('many-to-many', $relationship->relationship_type);
    }

    public function testload_relationship_meta()
    {
        $relationship = BeanFactory::newBean('Relationships');

        $relationship->load_relationship_meta();
        $this->assertTrue(isset($GLOBALS['relationships']));
    }

    public function testbuild_relationship_cache()
    {
        $relationship = BeanFactory::newBean('Relationships');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $relationship->build_relationship_cache();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testcache_file_dir()
    {
        $result = Relationship::cache_file_dir();
        $this->assertEquals('cache/modules/Relationships', $result);
    }

    public function testcache_file_name_only()
    {
        $result = Relationship::cache_file_name_only();
        $this->assertEquals('relationships.cache.php', $result);
    }

    public function testdelete_cache()
    {
        // Execute the method and test that it works and doesn't throw an exception.
        try {
            Relationship::delete_cache();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testtrace_relationship_module()
    {
        $relationship = BeanFactory::newBean('Relationships');
        $result = $relationship->trace_relationship_module('Roles', 'Users');
        $this->assertInstanceOf('User', $result);
    }
}
