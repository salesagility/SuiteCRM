<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewAjaxTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testViewAjax()
    {
        // Execute the constructor and check for the Object type and attributes
        $view = new ViewAjax();
        $this->assertInstanceOf('ViewAjax', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertTrue(is_array($view->options));
    }
}
