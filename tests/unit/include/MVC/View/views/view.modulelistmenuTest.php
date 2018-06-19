<?php

class ViewModulelistmenuTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function test__construct()
    {

        
        $view = new ViewModulelistmenu();

        $this->assertInstanceOf('ViewModulelistmenu', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertTrue(is_array($view->options));
    }

    public function testdisplay()
    {
        
        if(isset($_SESSION)) {
            $session = $_SESSION;
        }
        
        
        
        $view = new ViewModulelistmenu();
        $view->ss = new Sugar_Smarty();

        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertGreaterThan(0, strlen($renderedContent));
        $this->assertEquals(false, is_array($renderedContent));
        
        if(isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }
}
