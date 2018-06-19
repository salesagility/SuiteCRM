<?php


class ViewXMLTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testViewXML()
    {

        
        $view = new ViewXML();
        $this->assertInstanceOf('ViewXML', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
    }

    public function testdisplay()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        

        
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
        
        
        
        
    }
}
