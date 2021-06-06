<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOR_ConditionTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOR_Condition(): void
    {
        // Execute the constructor and check for the Object type and  attributes
        $aor_Condition = BeanFactory::newBean('AOR_Conditions');
        self::assertInstanceOf('AOR_Condition', $aor_Condition);
        self::assertInstanceOf('Basic', $aor_Condition);
        self::assertInstanceOf('SugarBean', $aor_Condition);

        self::assertAttributeEquals('AOR_Conditions', 'module_dir', $aor_Condition);
        self::assertAttributeEquals('AOR_Condition', 'object_name', $aor_Condition);
        self::assertAttributeEquals('aor_conditions', 'table_name', $aor_Condition);
        self::assertAttributeEquals(true, 'new_schema', $aor_Condition);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aor_Condition);
        self::assertAttributeEquals(true, 'importable', $aor_Condition);
        self::assertAttributeEquals(false, 'tracker_visibility', $aor_Condition);
    }

    public function testsave_lines(): void
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
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }
}
