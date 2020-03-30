<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOW_ActionTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAOW_Action()
    {
        // Execute the constructor and check for the Object type and  attributes
        $aowAction = BeanFactory::newBean('AOW_Actions');
        $this->assertInstanceOf('AOW_Action', $aowAction);
        $this->assertInstanceOf('Basic', $aowAction);
        $this->assertInstanceOf('SugarBean', $aowAction);

        $this->assertAttributeEquals('AOW_Actions', 'module_dir', $aowAction);
        $this->assertAttributeEquals('AOW_Action', 'object_name', $aowAction);
        $this->assertAttributeEquals('aow_actions', 'table_name', $aowAction);
        $this->assertAttributeEquals(true, 'new_schema', $aowAction);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aowAction);
        $this->assertAttributeEquals(false, 'importable', $aowAction);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aowAction);
    }

    public function testsave_lines()
    {
        $aowAction = BeanFactory::newBean('AOW_Actions');

        //populate required values
        $post_data = array();
        $post_data['name'] = array('test1', 'test2');
        $post_data['action'] = array('action1', 'action2');
        $post_data['param'] = array(array('param1' => 'value'), array('value' => array('param2' => 'value')));

        //create parent bean
        $aowWorkFlow = BeanFactory::newBean('AOW_WorkFlow');
        $aowWorkFlow->id = 1;

        $aowAction->save_lines($post_data, $aowWorkFlow);

        //get the linked beans and verify if records created
        $aow_actions = $aowWorkFlow->get_linked_beans('aow_actions', $aowWorkFlow->object_name);
        $this->assertEquals(count($post_data['action']), count($aow_actions));

        //cleanup afterwards
        foreach ($aow_actions as $lineItem) {
            $lineItem->mark_deleted($lineItem->id);
        }
    }

    public function testbean_implements()
    {
        $aowAction = BeanFactory::newBean('AOW_Actions');
        $this->assertEquals(false, $aowAction->bean_implements('')); //test with blank value
        $this->assertEquals(false, $aowAction->bean_implements('test')); //test with invalid value
        $this->assertEquals(false, $aowAction->bean_implements('ACL')); //test with valid value
    }
}
