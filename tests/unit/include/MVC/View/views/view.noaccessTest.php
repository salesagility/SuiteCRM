<?php

class ViewNoaccessTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testdisplay()
    {
        
        $view = new ViewNoaccess();

        ob_start();

        $view->display();

        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertAttributeEquals('noaccess', 'type', $view);
        $this->assertGreaterThan(0, strlen($renderedContent));

        $this->assertEquals(false, json_decode($renderedContent)); //check that it doesn't return json.
    }
}
