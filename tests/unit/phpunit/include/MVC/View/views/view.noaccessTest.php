<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

/**
 * @internal
 */
class ViewNoaccessTest extends SuitePHPUnitFrameworkTestCase
{
    public function testdisplay()
    {
        //execute the method and check for default attributes and check that it returns some html.
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
