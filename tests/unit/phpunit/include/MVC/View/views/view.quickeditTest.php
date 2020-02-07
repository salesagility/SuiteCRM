<?php

class ViewQuickeditTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testpreDisplay()
    {
        if (isset($_REQUEST)) {
            $_request = $_REQUEST;
        }
        
        //check without setting any values, it should execute without any issues.
        $view = new ViewQuickedit();
        $view->preDisplay();
        $this->assertEquals(0, count($_REQUEST));

        //check with values preset but without a valid bean id, it sould not change Request parameters
        $_REQUEST['source_module'] = 'Users';
        $_REQUEST['module'] = 'Users';
        $_REQUEST['record'] = '';
        $request = $_REQUEST;

        $view->preDisplay();
        $this->assertSame($request, $_REQUEST);

        //check with values preset, it sould set some addiiotnal Request parameters
        $_REQUEST['record'] = 1;
        $view->preDisplay();
        $this->assertNotSame($request, $_REQUEST);

        // clean up

        if (isset($_request)) {
            $_REQUEST = $_request;
        } else {
            unset($_REQUEST);
        }
    }
}
