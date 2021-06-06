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
}
