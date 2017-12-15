<?php

namespace SuiteCRM\Exception;

use Psr\Log\LogLevel;

class ExceptionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**#
     * @var Exception $exception
     */
    private static $exception;

    protected function _before()
    {
        if(self::$exception === null) {
            self::$exception = new Exception();
        }
    }

    protected function _after()
    {
    }

    public function testGetDetail()
    {
        $this->assertEquals(
            'SuiteCRM has encountered an exception which has not been handled',
            self::$exception->getDetail()
        );
    }

    public function testGetLogLevel()
    {
        $this->assertEquals(
           LogLevel::CRITICAL,
            self::$exception->getLogLevel()
        );
    }
}