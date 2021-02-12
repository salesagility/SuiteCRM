<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class GroupTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        $current_user = BeanFactory::newBean('Users');
        get_sugar_config_defaults();
    }

    public function testGroup()
    {
        //execute the constructor and check for the Object type and attributes
        $group = BeanFactory::newBean('Groups');
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

        $group = BeanFactory::newBean('Groups');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $group->mark_deleted('');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testcreate_export_query()
    {
        $group = BeanFactory::newBean('Groups');

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
