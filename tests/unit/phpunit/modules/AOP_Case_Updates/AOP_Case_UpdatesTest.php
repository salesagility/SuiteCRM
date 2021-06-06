<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOP_Case_UpdatesTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAOP_Case_Updates()
    {
        // Execute the constructor and check for the Object type and  attributes
        $aopCaseUpdates = BeanFactory::newBean('AOP_Case_Updates');
        self::assertInstanceOf('AOP_Case_Updates', $aopCaseUpdates);
        self::assertInstanceOf('Basic', $aopCaseUpdates);
        self::assertInstanceOf('SugarBean', $aopCaseUpdates);

        self::assertAttributeEquals('AOP_Case_Updates', 'module_dir', $aopCaseUpdates);
        self::assertAttributeEquals('AOP_Case_Updates', 'object_name', $aopCaseUpdates);
        self::assertAttributeEquals('aop_case_updates', 'table_name', $aopCaseUpdates);
        self::assertAttributeEquals(true, 'new_schema', $aopCaseUpdates);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aopCaseUpdates);
        self::assertAttributeEquals(false, 'importable', $aopCaseUpdates);
        self::assertAttributeEquals(false, 'tracker_visibility', $aopCaseUpdates);
    }

    public function testsave()
    {
        self::markTestIncomplete('environment dependency');

        $aopCaseUpdates = BeanFactory::newBean('AOP_Case_Updates');
        $aopCaseUpdates->name = 'test name';
        $aopCaseUpdates->description = 'test description';
        $aopCaseUpdates->case_id = 'test case id';
        $aopCaseUpdates->contact_id = 'test id';
        $aopCaseUpdates->internal = 1;
        $aopCaseUpdates->save();

        //test for record ID to verify that record is saved
        self::assertEquals(36, strlen($aopCaseUpdates->id));

        //mark the record as deleted for cleanup
        $aopCaseUpdates->mark_deleted($aopCaseUpdates->id);
    }

    public function testgetCase()
    {
        //execute the method and verify that it returns a Case object
        $result = BeanFactory::newBean('AOP_Case_Updates')->getCase();

        self::assertInstanceOf('aCase', $result);
    }

    public function testgetContacts()
    {
        //execute the method and verify that it returns an array
        $result = BeanFactory::newBean('AOP_Case_Updates')->getContacts();
        self::assertIsArray($result);
    }

    public function testgetUpdateContact()
    {
        $aopCaseUpdates = BeanFactory::newBean('AOP_Case_Updates');

        //execute the method without contact_id and verify that it returns null
        $result = $aopCaseUpdates->getUpdateContact();
        self::assertEquals(null, $result);

        //execute the method without contact_id and verify that it returns false
        $aopCaseUpdates->contact_id = 1;
        $result = $aopCaseUpdates->getUpdateContact();
        self::assertEquals(false, $result);
    }

    public function testgetUser()
    {
        //execute the method and verify that it returns an instance of User
        $result = BeanFactory::newBean('AOP_Case_Updates')->getUser();
        self::assertInstanceOf('User', $result);
    }

    public function testgetUpdateUser()
    {
        //execute the method and verify that it returns an instance of User
        $result = BeanFactory::newBean('AOP_Case_Updates')->getUpdateUser();
        self::assertInstanceOf('User', $result);
    }
}
