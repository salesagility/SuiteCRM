<?php

class ViewQuickeditTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testpreDisplay()
    {
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
    }

    public function testdisplay()
    {
        error_reporting(E_ALL);
        //error_reporting(E_ERROR | E_PARSE |E_NOTICE);

        //execute the method with required child objects and paramerers preset. it will rteturn some html.
        $view = new ViewQuickedit();
        $_REQUEST['module'] = 'Accounts';
        $_REQUEST['action'] = 'SubpanelCreates';

        try {
            $view->bean = new Account();
        } catch (Exception $e) {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage());
        }

        try {
            ob_start();

            $view->display();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
            $this->assertNotEquals(false, json_decode($renderedContent));
        } catch (Exception $e) {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage());
        }
    }
}
