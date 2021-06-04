<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class SugarThemeTest extends SuitePHPUnitFrameworkTestCase
{
    public function testGetMimeType()
    {
        $theme = SugarThemeRegistry::current();
        self::assertEquals($theme->getMimeType('svg'), 'image/svg+xml');
        self::assertEquals($theme->getMimeType('gif'), 'image/gif');
        self::assertEquals($theme->getMimeType('png'), 'image/png');
        self::assertEquals($theme->getMimeType('notanextension'), null);
    }
}
