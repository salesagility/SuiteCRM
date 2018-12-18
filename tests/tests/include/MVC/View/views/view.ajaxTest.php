<?php

class ViewAjaxTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testViewAjax()
    {
        //execute the contructor and check for the Object type and attributes 		
        $view = new ViewAjax();
        $this->assertInstanceOf('ViewAjax', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertTrue(is_array($view->options));
    }
}
