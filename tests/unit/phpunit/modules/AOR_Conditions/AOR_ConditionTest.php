<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOR_ConditionTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOR_Condition()
    {
        // Execute the constructor and check for the Object type and  attributes
        $aor_Condition = BeanFactory::newBean('AOR_Conditions');
        $this->assertInstanceOf('AOR_Condition', $aor_Condition);
        $this->assertInstanceOf('Basic', $aor_Condition);
        $this->assertInstanceOf('SugarBean', $aor_Condition);

        $this->assertAttributeEquals('AOR_Conditions', 'module_dir', $aor_Condition);
        $this->assertAttributeEquals('AOR_Condition', 'object_name', $aor_Condition);
        $this->assertAttributeEquals('aor_conditions', 'table_name', $aor_Condition);
        $this->assertAttributeEquals(true, 'new_schema', $aor_Condition);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aor_Condition);
        $this->assertAttributeEquals(true, 'importable', $aor_Condition);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aor_Condition);
    }

    public function testsave_lines()
    {
        $aor_Condition = BeanFactory::newBean('AOR_Conditions');

        //preset the required data
        $post_data = array();
        $post_data['field'][] = 'test field';
        $post_data['name'][] = 'test';
        $post_data['parameter'][] = '1';
        $post_data['module_path'][] = 'test path';
        $post_data['operator'][] = 'test';
        $post_data['value_type'][] = 'test type';

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $aor_Condition->save_lines($post_data, BeanFactory::newBean('AOR_Reports'));
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }
}
