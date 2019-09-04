<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;
use SuiteCRM\Utility\StringValidator;

class StringValidatorTest extends SuitePHPUnitFrameworkTestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testStartsWith()
    {
        $testString = 'foobarbaz';
        $this->assertTrue(StringValidator::startsWith($testString, 'foo'));
        $this->assertFalse(StringValidator::startsWith($testString, 'bar'));
    }

    public function testEndsWith()
    {
        $testString = 'foobarbaz';
        $this->assertTrue(StringValidator::endsWith($testString, 'baz'));
        $this->assertFalse(StringValidator::endsWith($testString, 'bar'));
    }
}
