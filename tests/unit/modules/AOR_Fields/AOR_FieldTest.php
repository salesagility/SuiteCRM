<?php


class AOR_FieldTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testAOR_Field()
    {

        //execute the contructor and check for the Object type and  attributes
        $aor_Field = new AOR_Field();
        $this->assertInstanceOf('AOR_Field', $aor_Field);
        $this->assertInstanceOf('Basic', $aor_Field);
        $this->assertInstanceOf('SugarBean', $aor_Field);

        $this->assertAttributeEquals('AOR_Fields', 'module_dir', $aor_Field);
        $this->assertAttributeEquals('AOR_Field', 'object_name', $aor_Field);
        $this->assertAttributeEquals('aor_fields', 'table_name', $aor_Field);
        $this->assertAttributeEquals(true, 'new_schema', $aor_Field);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aor_Field);
        $this->assertAttributeEquals(true, 'importable', $aor_Field);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aor_Field);
    }

    public function testsave_lines()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('aor_fields');
        $state->pushTable('tracker');
        $state->pushGlobals();
        
        

        $aor_Field = new AOR_Field();

        //preset the required data
        $post_data = array();
        $post_data['field'][] = 'test field';
        $post_data['name'][] = 'test';
        $post_data['module_path'][] = 'test path';
        $post_data['display'][] = '1';
        $post_data['link'][] = '1';
        $post_data['label'][] = 'test label';
        $post_data['field_function'][] = 'test function';
        $post_data['total'][] = 'total';
        $post_data['group_by'][] = '1';
        $post_data['group_order'][] = 'desc';
        $post_data['group_display'][] = '1';

        //execute the method and test if it works and does not throws an exception.
        try {
            $aor_Field->save_lines($post_data, new AOR_Report());
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('aor_fields');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }
}
