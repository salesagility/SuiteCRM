<?php

class ViewJsonTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testViewJson()
    {

        //execute the contructor and check for the Object type and type attribute
        $view = new ViewJson();
        $this->assertInstanceOf('ViewJson', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
    }

    //incomplete test. this method uses exit() so it cannot be tested.
    public function testdisplay()
    {

        /*
        setup required paramerers and execute the method. 
        it uses die/exit which stops the execution of PHP unit as well so this method cannot be tested.
        */

        /*
        $view = new ViewJson();
        $GLOBALS['module'] = "Users" ;
        $view->bean = new User();

        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0,strlen($renderedContent));
        $this->assertNotEquals(False,json_decode($renderedContent));
        */
        $this->markTestIncomplete('Can Not be implemented');
    }
}
