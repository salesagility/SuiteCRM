<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

/**
 * @internal
 */
class AOW_ConditionTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOWCondition()
    {
        // Execute the constructor and check for the Object type and  attributes
        $aowCondition = new AOW_Condition();
        $this->assertInstanceOf('AOW_Condition', $aowCondition);
        $this->assertInstanceOf('Basic', $aowCondition);
        $this->assertInstanceOf('SugarBean', $aowCondition);

        $this->assertAttributeEquals('AOW_Conditions', 'module_dir', $aowCondition);
        $this->assertAttributeEquals('AOW_Condition', 'object_name', $aowCondition);
        $this->assertAttributeEquals('aow_conditions', 'table_name', $aowCondition);
        $this->assertAttributeEquals(true, 'new_schema', $aowCondition);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aowCondition);
        $this->assertAttributeEquals(false, 'importable', $aowCondition);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aowCondition);
    }

    public function testbeanImplements()
    {
        $aowCondition = new AOW_Condition();
        $this->assertEquals(false, $aowCondition->bean_implements('')); //test with blank value
        $this->assertEquals(false, $aowCondition->bean_implements('test')); //test with invalid value
        $this->assertEquals(false, $aowCondition->bean_implements('ACL')); //test with valid value
    }

    public function testsaveLines()
    {
        $aowCondition = new AOW_Condition();

        //populate required values
        $post_data = [];
        $post_data['name'] = ['test1', 'test2'];
        $post_data['field'] = ['field1', 'field2'];
        $post_data['operator'] = ['=', '!='];
        $post_data['value_type'] = ['int', 'string'];
        $post_data['value'] = ['1', 'abc'];

        //create parent bean
        $aowWorkFlow = new AOW_WorkFlow();
        $aowWorkFlow->id = 1;

        $aowCondition->save_lines($post_data, $aowWorkFlow);

        //get the linked beans and verify if records created
        $aow_conditions = $aowWorkFlow->get_linked_beans('aow_conditions', $aowWorkFlow->object_name);
        $this->assertEquals(count($post_data['field']), count($aow_conditions));

        //cleanup afterwards
        foreach ($aow_conditions as $lineItem) {
            $lineItem->mark_deleted($lineItem->id);
        }
    }
}
