<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewAjaxUITest extends SuitePHPUnitFrameworkTestCase
{
    public function test__construct(): void
    {
        // Execute the constructor and check for the Object type and type attribute
        $view = new ViewAjaxUI();
        self::assertInstanceOf('ViewAjaxUI', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertIsArray($view->options);
    }
}
