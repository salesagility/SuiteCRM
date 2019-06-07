<?php

class ViewPopupTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testViewPopup()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        // test
        

        //execute the contructor and check for the Object type and type attribute
        $view = new ViewPopup();
        $this->assertInstanceOf('ViewPopup', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('list', 'type', $view);

        unset($view);
        
        // clean up
        
        $state->popGlobals();
    }

    public function testdisplay()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        // test
        


        //execute the method with required child objects preset. it should return some html. 
        $view = new ViewPopup();
        $view->module = 'Accounts';

        try {
            $view->bean = new Account();
        } catch (Exception $e) {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage());
        }

        ob_start();

        $view->display();

        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertGreaterThan(0, strlen($renderedContent));
        
        // clean up
        
        $state->popGlobals();
    }
}
