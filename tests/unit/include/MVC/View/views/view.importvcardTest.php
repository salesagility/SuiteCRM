<?php

class ViewImportvcardTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function test__construct()
    {
        
        $view = new ViewImportvcard();
        $this->assertInstanceOf('ViewImportvcard', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('edit', 'type', $view);
    }

    public function testdisplay()
    {
        
        if(isset($_REQUEST)) {
            $request = $_REQUEST;
        }

        
        $view = new ViewImportvcard();
        $_REQUEST['module'] = 'Users';
        $view->ss = new Sugar_Smarty();

        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
         
        
        
        if(isset($request)) {
            $_REQUEST = $request;
        } else {
            unset($_REQUEST);
        }
    }
}
