<?php

use SuiteCRM\Test\SuitePHPUnit_Framework_TestCase;

class SugarThemeTest extends SuitePHPUnit_Framework_TestCase
{
    public function testGetMimeType()
    {
        $theme = SugarThemeRegistry::current();
        $this->assertEquals($theme->getMimeType('svg'), 'image/svg+xml');
        $this->assertEquals($theme->getMimeType('gif'), 'image/gif');
        $this->assertEquals($theme->getMimeType('png'), 'image/png');
        $this->assertEquals($theme->getMimeType('notanextension'), null);
    }
}
