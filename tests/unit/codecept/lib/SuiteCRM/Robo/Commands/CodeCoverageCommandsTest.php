<?php

use \SuiteCRM\Robo\Plugin\Commands\CodeCoverageCommands;

class CodeCoverageCommandsTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var \SuiteCRM\Robo\Plugin\Commands\CodeCoverageCommands **/
    protected static $testClass;

    public function _before()
    {
        parent::_before();

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

    public function testDisableStateChecker()
    {
        // backup configure override
        $configOverrideData = '';
        $configOverridePath = 'config_override.php';
        if (file_exists($configOverridePath)) {
            $configOverrideData = \file_get_contents($configOverridePath);
        }

        // Run tests
        $reflection = new ReflectionClass(CodeCoverageCommands::class);
        $method = $reflection->getMethod('disableStateChecker');
        $method->setAccessible(true);

        $actual = $method->invoke(
            self::$testClass
        );

        $this->assertTrue($actual);

        // restore config override
        if (!empty($configOverrideData)) {
            \file_put_contents($configOverridePath, $configOverrideData);
        }
    }

    public function testGetCodeCoverageCommand()
    {
        $paths = new \SuiteCRM\Utility\Paths();
        $os = new \SuiteCRM\Utility\OperatingSystem();
        $commandExpected =  $os->toOsPath($paths->getProjectPath())
            . DIRECTORY_SEPARATOR
            . $os->toOsPath('vendor/bin/codecept')
            . ' run unit --coverage-xml';

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
