<?php

class ViewPopupTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testViewPopup()
    {

        //execute the contructor and check for the Object type and type attribute
        $view = new ViewPopup();
        $this->assertInstanceOf('ViewPopup', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('list', 'type', $view);

        unset($view);
    }

}
