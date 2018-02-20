<?php

namespace SuiteCRM\Exception;

use Psr\Log\LogLevel;
use SuiteCRM\API\v8\Exception\ApiException;

class ModuleNotFound extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**#
     * @var ApiException $exception
     */
    private static $exception;


    protected function _before()
    {
        if(self::$exception === null) {
            self::$exception = new \SuiteCRM\API\v8\Exception\ModuleNotFound();
        }
    }

    protected function _after()
    {
    }

    public function testGetMessage()
    {
        $this->assertEquals('[SuiteCRM] [API] [Module Not Found] ', self::$exception->getMessage());
    }

    public function testGetSetDetail()
    {
        $this->assertEquals('Json API cannot find resource', self::$exception->getDetail());
    }

    public function testGetSetSource()
    {
        self::$exception->setSource('/data');
        $this->assertSame(array('pointer' => '/data'), self::$exception->getSource());
    }

    public function testGetHttpStatus()
    {
        $this->assertEquals(406, self::$exception->getHttpStatus());
    }
}