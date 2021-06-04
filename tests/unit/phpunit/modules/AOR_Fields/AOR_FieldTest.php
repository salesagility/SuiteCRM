<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOR_FieldTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOR_Field()
    {
        // Execute the constructor and check for the Object type and  attributes
        $aor_Field = BeanFactory::newBean('AOR_Fields');
        self::assertInstanceOf('AOR_Field', $aor_Field);
        self::assertInstanceOf('Basic', $aor_Field);
        self::assertInstanceOf('SugarBean', $aor_Field);

        self::assertAttributeEquals('AOR_Fields', 'module_dir', $aor_Field);
        self::assertAttributeEquals('AOR_Field', 'object_name', $aor_Field);
        self::assertAttributeEquals('aor_fields', 'table_name', $aor_Field);
        self::assertAttributeEquals(true, 'new_schema', $aor_Field);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aor_Field);
        self::assertAttributeEquals(true, 'importable', $aor_Field);
        self::assertAttributeEquals(false, 'tracker_visibility', $aor_Field);
    }

    public function testsave_lines()
    {
        $aor_Field = BeanFactory::newBean('AOR_Fields');

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

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $aor_Field->save_lines($post_data, BeanFactory::newBean('AOR_Reports'));
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }
}
