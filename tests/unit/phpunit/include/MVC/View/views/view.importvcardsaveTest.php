<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewImportvcardsaveTest extends SuitePHPUnitFrameworkTestCase
{
    public function test__construct()
    {
        // Execute the constructor and check for the Object type and type attribute
        $view = new ViewImportvcardsave();
        $this->assertInstanceOf('ViewImportvcardsave', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('save', 'type', $view);
    }

    //incomplete test. this method uses exit() so it cannot be tested.
    public function testdisplay()
    {
        $this->markTestIncomplete('Cannot be implemented due to use of exit().');

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
    }
}
