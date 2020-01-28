<?php

use \SuiteCRM\Robo\Plugin\Commands\CodeCoverageCommands;
use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class CodeCoverageCommandsTest extends SuitePHPUnitFrameworkTestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var \SuiteCRM\Robo\Plugin\Commands\CodeCoverageCommands **/
    protected static $testClass;

    protected function setUp()
    {
        parent::setUp();

        if (self::$testClass === null) {
            self::$testClass = new CodeCoverageCommands();
        }
    }

    public function testIsEnvironmentTravisCI()
    {
        $reflection = new ReflectionClass(CodeCoverageCommands::class);
        $method = $reflection->getMethod('isEnvironmentTravisCI');
        $method->setAccessible(true);

        $actual = $method->invoke(
            self::$testClass
        );

        $returnType = is_string($actual) || is_array($actual) || is_bool($actual);
        $this->assertTrue($returnType);
    }

    public function testGetCommitRangeForTravisCi()
    {
        $reflection = new ReflectionClass(CodeCoverageCommands::class);
        $method = $reflection->getMethod('getCommitRangeForTravisCi');
        $method->setAccessible(true);

        $actual = $method->invoke(
            self::$testClass
        );

        $returnType = is_string($actual) || is_array($actual) || is_bool($actual);
        $this->assertTrue($returnType);
    }

    public function testGetCodeCoverageCommand()
    {
        $commandExpected = './vendor/bin/phpunit --configuration ./tests/phpunit.xml.dist --coverage-clover ./tests/_output/coverage.xml ./tests/unit/phpunit';
        // Run tests
        $reflection = new ReflectionClass(CodeCoverageCommands::class);
        $method = $reflection->getMethod('getCodeCoverageCommand');
        $method->setAccessible(true);

        $actual = $method->invoke(
            self::$testClass
        );

        $this->assertEquals($commandExpected, $actual);
    }
}
