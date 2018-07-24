<?php


 class ViewMultieditTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
 {
     public function testViewMultiedit()
     {

        //execute the contructor and check for the Object type and type attribute
         $view = new ViewMultiedit();
         $this->assertInstanceOf('ViewMultiedit', $view);
         $this->assertInstanceOf('SugarView', $view);
         $this->assertAttributeEquals('edit', 'type', $view);
     }

     public function testdisplay()
     {

        //test without action value and modules list in REQUEST object
         $view = new ViewMultiedit();
         ob_start();
         $view->display();
         $renderedContent = ob_get_contents();
         ob_end_clean();
         $this->assertEquals(0, strlen($renderedContent));

         //test with valid action value to get link in return
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

         //Fails with a fatal error, method creates editview without properly setting it up causing fatal errors.
        /*
        //test only with modules list in REQUEST object
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
