<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewAjaxTest extends SuitePHPUnitFrameworkTestCase
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
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
