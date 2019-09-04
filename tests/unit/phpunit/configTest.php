<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class configTest extends SuitePHPUnitFrameworkTestCase
{
    public function test_config()
    {
        global $sugar_config;
        $this->assertNotEmpty($sugar_config, 'SuiteCRM config is empty');
    }
    
    public function testFoo()
    {
        $this->assertTrue(true);
    }
}
