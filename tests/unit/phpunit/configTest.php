<?php

use SuiteCRM\TestCaseAbstract;

class configTest extends TestCaseAbstract
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
