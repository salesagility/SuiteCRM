<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewImportvcardsaveTest extends SuitePHPUnitFrameworkTestCase
{
    public function test__construct(): void
    {
        // Execute the constructor and check for the Object type and type attribute
        $view = new ViewImportvcardsave();
        self::assertInstanceOf('ViewImportvcardsave', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertEquals('save', $view->type);
    }
}
