<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewAjaxUITest extends SuitePHPUnitFrameworkTestCase
{
    public function test__construct(): void
    {
        // Execute the constructor and check for the Object type and type attribute
        $view = new ViewAjaxUI();
        self::assertInstanceOf('ViewAjaxUI', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertIsArray($view->options);
    }

    public function testdisplay(): void
    {
//        $view = new ViewAjaxUI();
//
////        //execute the method and test if it works and does not throws an exception other than headers output exception.
////        try {
////            $view->display();
////        } catch (Exception $e) {
////            $this->assertStringStartsWith('Cannot modify header information', $e->getMessage());
////        }
//        $this->markTestIncomplete('Can Not be implemented');
    }
}
