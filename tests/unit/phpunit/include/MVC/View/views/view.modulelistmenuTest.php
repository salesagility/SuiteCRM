<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewModulelistmenuTest extends SuitePHPUnitFrameworkTestCase
{
    public function test__construct()
    {
        // Execute the constructor and check for the Object type and options attribute
        $view = new ViewModulelistmenu();

        self::assertInstanceOf('ViewModulelistmenu', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertIsArray($view->options);
    }

    public function testdisplay()
    {
        if (isset($_SESSION)) {
            $session = $_SESSION;
        }

        //execute the method with required child objects preset. it should return some html.
        $view = new ViewModulelistmenu();
        $view->ss = new Sugar_Smarty();

        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();

        self::assertGreaterThan(0, strlen($renderedContent));
        self::assertEquals(false, is_array($renderedContent));

        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }
}
