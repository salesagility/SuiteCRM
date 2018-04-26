<?php


class PathsTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\Utility\Paths $paths
     */
    private static $paths;

    /**#
     * @var string $projectPath
     */
    private static $projectPath;

    public function _before()
    {
        parent::_before();
        if (self::$paths === null) {
            self::$paths = new \SuiteCRM\Utility\Paths();
        }

        if(self::$projectPath === null) {
            self::$projectPath = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
        }
    }



    public function testGetProjectPath()
    {
        $expected =  self::$projectPath;
        $actual = self::$paths->getProjectPath();
        $this->assertEquals($expected, $actual);
    }

    public function testGetLibraryPath()
    {
        $expected =  self::$projectPath.'/lib';
        $actual = self::$paths->getLibraryPath();
        $this->assertEquals($expected, $actual);
    }

    public function testGetContainersPath()
    {
        $expected =  self::$projectPath.'/lib/API/core/containers.php';
        $actual = self::$paths->getContainersFilePath();
        $this->assertEquals($expected, $actual);
    }
}