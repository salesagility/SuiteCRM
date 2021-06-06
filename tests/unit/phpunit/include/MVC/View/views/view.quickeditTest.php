<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewQuickeditTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
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
        self::assertCount(0, $_REQUEST);

        //check with values preset but without a valid bean id, it sould not change Request parameters
        $_REQUEST['source_module'] = 'Users';
        $_REQUEST['module'] = 'Users';
        $_REQUEST['record'] = '';
        $request = $_REQUEST;

        $view->preDisplay();
        self::assertSame($request, $_REQUEST);

        //check with values preset, it sould set some addiiotnal Request parameters
        $_REQUEST['record'] = 1;
        $view->preDisplay();
        self::assertNotSame($request, $_REQUEST);

        if (isset($_request)) {
            $_REQUEST = $_request;
        } else {
            unset($_REQUEST);
        }
    }
}
