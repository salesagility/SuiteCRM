<?php

class ViewAjaxUITest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function test__construct()
    {
        
        $view = new ViewAjaxUI();
        $this->assertInstanceOf('ViewAjaxUI', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertTrue(is_array($view->options));
    }

    public function testdisplay()
    {
        $view = new ViewAjaxUI();







        $this->markTestIncomplete('Can Not be implemented');
    }
}
