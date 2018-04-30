<?php

class ViewQuickTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testViewQuick()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        // test
        

        //execute the contructor and check for the Object type and type attribute

        $view = new ViewQuick();

        $this->assertInstanceOf('ViewQuick', $view);
        $this->assertInstanceOf('ViewDetail', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
        $this->assertTrue(is_array($view->options));
        
        // clean up
        
        $state->popGlobals();
    }

    public function testdisplay()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        // test
        
        $view = new ViewQuick();

        //execute the method with required child objects preset. it will return some html.
        $view->dv = new DetailView2();
        $view->dv->ss = new Sugar_Smarty();
        $view->dv->module = 'Users';
        $view->bean = new User();
        $view->bean->id = 1;
        $view->dv->setup('Users', $view->bean);

        ob_start();

        $view->display();

        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertGreaterThan(0, strlen($renderedContent));
        $this->assertNotEquals(false, json_decode($renderedContent));
        
        // clean up
        
        $state->popGlobals();
    }
}
