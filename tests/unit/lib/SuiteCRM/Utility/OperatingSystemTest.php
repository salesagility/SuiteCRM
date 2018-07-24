<?php


class OperatingSystemTest extends \SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testToOsPath()
    {
        $os = new \SuiteCRM\Utility\OperatingSystem();
        $simpleUnixPath = './vendor/bin/codecept';
        $complexUnixPath = './Program\ Files/file';
        $simpleWindowsPath = '.\vendor\bin\codecept';
        $complexWindowsPathEscaped = '.\Program Files\file';
        $complexWindowsPathNotEscaped = '".\Program Files\file"';
        $gotchaUnixPath = './One\	Two\ \ Three/file';
        $gotchaWindowsPath = '.\One	Two  Three\file';

        $this->tester->comment('Convert unix path to windows path:');
        $this->assertEquals($simpleWindowsPath, $os->toOsPath($simpleUnixPath, '\\'));
        $this->assertEquals($complexWindowsPathEscaped, $os->toOsPath($complexUnixPath, '\\'));
        $this->assertEquals($gotchaWindowsPath, $os->toOsPath($gotchaUnixPath, '\\'));

        $this->tester->comment('Convert windows path to unix path:');
        $this->assertEquals($simpleUnixPath, $os->toOsPath($simpleWindowsPath, '/'));
        $this->assertEquals($complexUnixPath, $os->toOsPath($complexWindowsPathEscaped, '/'));
        $this->assertEquals($complexUnixPath, $os->toOsPath($complexWindowsPathNotEscaped, '/'));
        $this->assertEquals($gotchaUnixPath, $os->toOsPath($gotchaWindowsPath, '/'));
    }
}
