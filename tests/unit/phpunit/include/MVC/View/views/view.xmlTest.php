<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewXMLTest extends SuitePHPUnitFrameworkTestCase
{
    public function testViewXML()
    {
        // Execute the constructor and check for the Object type and type attribute
        $view = new ViewXML();
        $this->assertInstanceOf('ViewXML', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
    }

    public function testdisplay()
    {
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
    }
}
