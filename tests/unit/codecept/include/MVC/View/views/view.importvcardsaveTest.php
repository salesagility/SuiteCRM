<?php

class ViewImportvcardsaveTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function test__construct()
    {
        //execute the contructor and check for the Object type and type attribute
        $view = new ViewImportvcardsave();
        $this->assertInstanceOf('ViewImportvcardsave', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('save', 'type', $view);
    }

    //incomplete test. this method uses exit() so it cannot be tested.
    public function testdisplay()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $view = new ViewImportvcardsave();

        //execute without any parameters set. it should return some html/JS
        //this method uses exit() which causes PHP unit to quit a well. so this method cannot be tested.
        /*
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0,strlen($renderedContent));
        */

        $this->markTestIncomplete('Can Not be implemented');
        
        
        // clean up
    }
}
