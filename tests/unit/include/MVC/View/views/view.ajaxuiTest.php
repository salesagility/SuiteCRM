<?php

class ViewAjaxUITest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function test__construct()
    {
        //execute the contructor and check for the Object type and type attribute
        $view = new ViewAjaxUI();
        $this->assertInstanceOf('ViewAjaxUI', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertTrue(is_array($view->options));
    }

    public function testdisplay()
    {
        $view = new ViewAjaxUI();

//        //execute the method and test if it works and does not throws an exception other than headers output exception.
//        try {
//            $view->display();
//        } catch (Exception $e) {
//            $this->assertStringStartsWith('Cannot modify header information', $e->getMessage());
//        }
        $this->markTestIncomplete('Can Not be implemented');
    }
}
