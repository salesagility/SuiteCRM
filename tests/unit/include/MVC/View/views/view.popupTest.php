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

    public function testdisplay()
    {

        //error_reporting(E_ERROR | E_PARSE |E_ALL);

        //execute the method with required child objects preset. it should return some html. 
        $view = new ViewPopup();
        $view->module = 'Accounts';

        try {
            $view->bean = new Account();
        } catch (Exception $e) {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage());
        }

        ob_start();

        $view->display();

        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertGreaterThan(0, strlen($renderedContent));
    }
}
