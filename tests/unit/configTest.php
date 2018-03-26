<?php

class configTest extends SuiteCRM\StateChecker_PHPUnit_Framework_TestCase
{
    public function test_config()
    {
        global $sugar_config;
        $this->assertNotEmpty($sugar_config, 'SuiteCRM config is empty');
    }
}
