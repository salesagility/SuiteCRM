<?php

use SuiteCRM\Test\SuitePHPUnit_Framework_TestCase;
use SuiteCRM\Utility\StringValidator;

class StringValidatorTest extends SuitePHPUnit_Framework_TestCase
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
