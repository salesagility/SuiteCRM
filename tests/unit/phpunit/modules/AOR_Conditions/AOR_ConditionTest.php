<?php

class AOR_ConditionTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testAOR_Condition()
    {

        //execute the contructor and check for the Object type and  attributes
        $aor_Condition = new AOR_Condition();
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
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('aod_index');
        $state->pushTable('aor_conditions');
        $state->pushTable('tracker');
        $state->pushGlobals();
        
        

        $aor_Condition = new AOR_Condition();

        //preset the required data
        $post_data = array();
        $post_data['field'][] = 'test field';
        $post_data['name'][] = 'test';
        $post_data['parameter'][] = '1';
        $post_data['module_path'][] = 'test path';
        $post_data['operator'][] = 'test';
        $post_data['value_type'][] = 'test type';

        //execute the method and test if it works and does not throws an exception.
        try {
            $aor_Condition->save_lines($post_data, new AOR_Report());
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('aor_conditions');
        $state->popTable('aod_index');
        $state->popTable('aod_indexevent');
    }
}
