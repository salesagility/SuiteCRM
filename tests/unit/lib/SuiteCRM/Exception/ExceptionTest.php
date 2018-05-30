<?php

namespace SuiteCRM\Exception;

use Psr\Log\LogLevel;

class ExceptionTest extends \SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**#
     * @var Exception $exception
     */
    private static $exception;

    public function _before()
    {
        parent::_before();
        if(self::$exception === null) {
            self::$exception = new Exception();
        }
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