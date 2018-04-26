<?php


class ViewXMLTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testViewXML()
    {

        //execute the contructor and check for the Object type and type attribute
        $view = new ViewXML();
        $this->assertInstanceOf('ViewXML', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
    }

    public function testdisplay()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        

        //execute the method and check for rexcetions. it should return some html. 
        $view = new ViewXML();

        try {
            ob_start();

            $view->display();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }
}
