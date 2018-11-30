<?php

class ViewAjaxTest extends SuiteCRM\StateCheckerUnitAbstract
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
        //execute the contructor and check for the Object type and attributes
        $view = new ViewAjax();
        $this->assertInstanceOf('ViewAjax', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertTrue(is_array($view->options));
    }
}
