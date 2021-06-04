<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewAjaxTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
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
        self::assertInstanceOf('ViewAjax', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertTrue(is_array($view->options));
    }
}
