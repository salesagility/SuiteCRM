<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewSerializedTest extends SuitePHPUnitFrameworkTestCase
{
    public function testViewSerialized(): void
    {
        // Execute the constructor and check for the Object type
        $view = new ViewSerialized();
        self::assertInstanceOf('ViewSerialized', $view);
        self::assertInstanceOf('SugarView', $view);
    }
}
