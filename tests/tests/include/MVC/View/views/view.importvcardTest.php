<?php

class ViewImportvcardTest extends PHPUnit_Framework_TestCase
{
    public function test__construct()
    {
        //execute the contructor and check for the Object type and type attribute
        $view = new ViewImportvcard();
        $this->assertInstanceOf('ViewImportvcard', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('edit', 'type', $view);
    }

    public function testdisplay()
    {

        //execute the method with essential parameters set. it should return some html.
        $view = new ViewImportvcard();
        $_REQUEST['module'] = 'Users';
        $view->ss = new Sugar_Smarty();

        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
    }
}
