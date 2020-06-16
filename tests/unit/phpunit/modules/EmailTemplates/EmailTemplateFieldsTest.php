<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once 'modules/EmailTemplates/templateFields.php';

class EmailTemplateFieldsTest extends SuitePHPUnitFrameworkTestCase
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testgenerateFieldDefsJS()
    {
        // execute the method and verify that it returns expected results
        $actual = generateFieldDefsJS2();

        $this->assertGreaterThan(0, strlen($actual));
    }

}
