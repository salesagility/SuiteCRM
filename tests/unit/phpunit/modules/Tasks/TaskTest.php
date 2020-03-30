<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class TaskTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();
        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testTask()
    {
        // Execute the constructor and check for the Object type and  attributes
        $task = BeanFactory::newBean('Tasks');

        $this->assertInstanceOf('Task', $task);
        $this->assertInstanceOf('SugarBean', $task);

        $this->assertAttributeEquals('tasks', 'table_name', $task);
        $this->assertAttributeEquals('Tasks', 'module_dir', $task);
        $this->assertAttributeEquals('Task', 'object_name', $task);

        $this->assertAttributeEquals(true, 'new_schema', $task);
        $this->assertAttributeEquals(true, 'importable', $task);
    }

    public function testsave()
    {
        $task = BeanFactory::newBean('Tasks');

        $task->name = 'test';
        $task->priority = 'Medium';
        $task->parent_type = 'Accounts';
        $task->status = 'In Progress';

        $result = $task->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($task->id));
        $this->assertEquals(36, strlen($task->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $task->mark_deleted($task->id);
        $result = $task->retrieve($task->id);
        $this->assertEquals(null, $result);
    }

    public function testget_summary_text()
    {
        $task = BeanFactory::newBean('Tasks');

        //test without setting name
        $this->assertEquals(null, $task->get_summary_text());

        //test with name set
        $task->name = 'test';
        $this->assertEquals('test', $task->get_summary_text());
    }

    public function testcreate_export_query()
    {
        $task = BeanFactory::newBean('Tasks');

        //test with empty string params
        $expected = 'SELECT tasks.*, users.user_name as assigned_user_name  FROM tasks   LEFT JOIN users ON tasks.assigned_user_id=users.id where tasks.deleted=0 ORDER BY tasks.name';
        $actual = $task->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = 'SELECT tasks.*, users.user_name as assigned_user_name  FROM tasks   LEFT JOIN users ON tasks.assigned_user_id=users.id where users.user_name = "" AND tasks.deleted=0 ORDER BY tasks.name';
        $actual = $task->create_export_query('tasks.id', 'users.user_name = ""');
        $this->assertSame($expected, $actual);
    }

    public function testfill_in_additional_list_fields()
    {
        $task = BeanFactory::newBean('Tasks');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $task->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
    }

    public function testfill_in_additional_detail_fields()
    {
        $task = BeanFactory::newBean('Tasks');
        $task->contact_id = 1;

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $task->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testfill_in_additional_parent_fields()
    {
        $task = BeanFactory::newBean('Tasks');
        $task->parent_type = 'Accounts';
        $task->parent_id = '1';

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $task->fill_in_additional_parent_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testget_list_view_data()
    {
        $task = BeanFactory::newBean('Tasks');
        $current_theme = SugarThemeRegistry::current();

        $task->name = 'test';
        $task->priority = 'Medium';
        $task->parent_type = 'Accounts';
        $task->status = 'In Progress';
        $task->contact_name = 'test';
        $task->contact_phone = '1234567';
        $task->parent_name = 'test';

        $expected = array(
                'NAME' => 'test',
                'DELETED' => 0,
                'STATUS' => 'In Progress',
                'DATE_DUE_FLAG' => '0',
                'DATE_START_FLAG' => '0',
                'PARENT_TYPE' => 'Accounts',
                'PARENT_NAME' => 'test',
                'CONTACT_NAME' => 'test',
                'CONTACT_PHONE' => '1234567',
                'PRIORITY' => 'Medium',
                'PARENT_MODULE' => 'Accounts',
                'SET_COMPLETE' => '<b><a id=\'\' class=\'list-view-data-icon\' title=\'Close\' onclick=\'SUGAR.util.closeActivityPanel.show("Tasks","","Completed","listview","1");\'><span class=\'suitepicon suitepicon-action-clear\'></span></a></b>',
                'TITLE' => ": test\nAccount: test",
        );

        $actual = $task->get_list_view_data();
        $this->assertSame($expected, $actual);
    }

    public function testset_notification_body()
    {
        $task = BeanFactory::newBean('Tasks');

        //test with attributes preset and verify template variables are set accordingly

        $task->name = 'test';
        $task->priority = 'Medium';
        $task->date_due = '2016-02-11 17:30:00';
        $task->status = 'In Progress';
        $task->description = 'test description';

        $task->current_notify_user = new User(1);

        $result = $task->set_notification_body(new Sugar_Smarty(), $task);

        $this->assertEquals($task->name, $result->_tpl_vars['TASK_SUBJECT']);
        $this->assertEquals($task->status, $result->_tpl_vars['TASK_STATUS']);
        $this->assertEquals($task->priority, $result->_tpl_vars['TASK_PRIORITY']);
        $this->assertEquals('02/11/2016 17:30 UTC(+00:00)', $result->_tpl_vars['TASK_DUEDATE']);
        $this->assertEquals($task->description, $result->_tpl_vars['TASK_DESCRIPTION']);
    }

    public function testbean_implements()
    {
        $task = BeanFactory::newBean('Tasks');

        $this->assertEquals(false, $task->bean_implements('')); //test with blank value
        $this->assertEquals(false, $task->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $task->bean_implements('ACL')); //test with valid value
    }

    public function testlistviewACLHelper()
    {
        $task = BeanFactory::newBean('Tasks');

        $expected = array('MAIN' => 'a', 'PARENT' => 'a', 'CONTACT' => 'a');
        $actual = $task->listviewACLHelper();
        $this->assertSame($expected, $actual);
    }

    public function testgetDefaultStatus()
    {
        $task = BeanFactory::newBean('Tasks');

        $result = $task->getDefaultStatus();
        $this->assertEquals('Not Started', $result);
    }
}
