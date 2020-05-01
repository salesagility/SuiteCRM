<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

/**
 * @internal
 */
class configTest extends SuitePHPUnitFrameworkTestCase
{
    public function testConfig()
    {
        global $sugar_config;
        $this->assertNotEmpty($sugar_config, 'SuiteCRM config is empty');
    }

    public function testFoo()
    {
        $this->assertTrue(true);
    }
}
