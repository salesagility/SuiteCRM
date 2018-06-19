<?php

class ViewQuickeditTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

    }

    public function testpreDisplay()
    {
        
        if(isset($_REQUEST)) {
            $_request = $_REQUEST;
        }
        
        
        $view = new ViewQuickedit();
        $view->preDisplay();
        $this->assertEquals(0, count($_REQUEST));

        
        $_REQUEST['source_module'] = 'Users';
        $_REQUEST['module'] = 'Users';
        $_REQUEST['record'] = '';
        $request = $_REQUEST;

        $view->preDisplay();
        $this->assertSame($request, $_REQUEST);

        
        $_REQUEST['record'] = 1;
        $view->preDisplay();
        $this->assertNotSame($request, $_REQUEST);

        

        if(isset($_request)) {
            $_REQUEST = $_request;
        } else {
            unset($_REQUEST);
        }
    }
}
