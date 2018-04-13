<?php

class ViewSerializedTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testViewSerialized()
    {

        //execute the contructor and check for the Object type
        $view = new ViewSerialized();
        $this->assertInstanceOf('ViewSerialized', $view);
        $this->assertInstanceOf('SugarView', $view);
    }

    //Incomplete Test. method uses exit() so it cannot be tested.
    public function testdisplay()
    {

        /* //this method call uses exit() so it cannot be tested as it forces the PHP unit to quite as well
        $view = new ViewSerialized();
        $view->bean = new User();
        
        ob_start();
        
        $view->display();
        
        $renderedContent = ob_get_contents();
        ob_end_clean();
        
        $this->assertGreaterThan(0,strlen($renderedContent));
        */

        $this->markTestIncomplete('Can Not be implemented');
    }
}
