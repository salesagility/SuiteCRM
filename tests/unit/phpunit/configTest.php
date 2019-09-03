<?php

use SuiteCRM\Test\SuitePHPUnit_Framework_TestCase;

class configTest extends SuitePHPUnit_Framework_TestCase
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
