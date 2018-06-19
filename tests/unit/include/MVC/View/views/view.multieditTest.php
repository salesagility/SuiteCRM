<?php


 class ViewMultieditTest  extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
 {
     public function testViewMultiedit()
     {

        
        $view = new ViewMultiedit();
         $this->assertInstanceOf('ViewMultiedit', $view);
         $this->assertInstanceOf('SugarView', $view);
         $this->assertAttributeEquals('edit', 'type', $view);
     }

     public function testdisplay()
     {

        
        $view = new ViewMultiedit();
         ob_start();
         $view->display();
         $renderedContent = ob_get_contents();
         ob_end_clean();
         $this->assertEquals(0, strlen($renderedContent));

        
        $view = new ViewMultiedit();
         $view->action = 'AjaxFormSave';
         $view->module = 'Users';
         $view->bean = new User();
         $view->bean->id = 1;
         ob_start();
         $view->display();
         $renderedContent = ob_get_contents();
         ob_end_clean();
         $this->assertGreaterThan(0, strlen($renderedContent));

        
        /*
        
        $view = new ViewMultiedit();
        $GLOBALS['current_language']= 'en_us';
        $_REQUEST['modules']= Array('Calls','Accounts');
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0,strlen($renderedContent));
        */
     }
 }
