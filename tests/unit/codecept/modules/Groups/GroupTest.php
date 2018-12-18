<?php

class GroupTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        $current_user = new User();
        get_sugar_config_defaults();
    }

    public function testGroup()
    {

        //execute the contructor and check for the Object type and  attributes
        $group = new Group();
        $this->assertInstanceOf('Group', $group);
        $this->assertInstanceOf('User', $group);
        $this->assertInstanceOf('SugarBean', $group);

        $this->assertAttributeEquals('Group', 'status', $group);
        $this->assertAttributeEquals('', 'password', $group);
        $this->assertAttributeEquals(false, 'importable', $group);
    }

    public function testmark_deleted()
    {
        self::markTestIncomplete('environment dependency (php7: Incorrect state hash: Hash doesn\'t match at key "database::users".)');
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        $state->pushTable('users');
        
        //error_reporting(E_ERROR | E_PARSE);

        $group = new Group();

        //execute the method and test if it works and does not throws an exception.
        try {
            $group->mark_deleted('');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popTable('users');
        $state->popTable('tracker');
        $state->popTable('aod_index');
    }

    public function testcreate_export_query()
    {
        $group = new Group();

        //test with empty string params
        $expected = 'SELECT users.* FROM users  WHERE  users.deleted = 0 ORDER BY users.user_name';
        $actual = $group->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = 'SELECT users.* FROM users  WHERE users.user_name="" AND  users.deleted = 0 ORDER BY users.id';
        $actual = $group->create_export_query('users.id', 'users.user_name=""');
        $this->assertSame($expected, $actual);
    }
}
