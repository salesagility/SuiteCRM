<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewJsonTest extends SuitePHPUnitFrameworkTestCase
{
    public function testViewJson(): void
    {
        // Execute the constructor and check for the Object type and type attribute
        $view = new ViewJson();
        self::assertInstanceOf('ViewJson', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertEquals('detail', $view->type);
    }

    //incomplete test. this method uses exit() so it cannot be tested.
    public function testdisplay(): void
    {
        /*
        setup required paramerers and execute the method.
        it uses die/exit which stops the execution of PHP unit as well so this method cannot be tested.
        */

        /*
        $view = new ViewJson();
        $GLOBALS['module'] = "Users" ;
        $view->bean = BeanFactory::newBean('Users');

        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0,strlen($renderedContent));
        $this->assertNotEquals(False,json_decode($renderedContent));
        */
        self::markTestIncomplete('Can Not be implemented');
    }
}
