<?php

namespace SuiteCRM\Exception;

use Psr\Log\LogLevel;
use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ExceptionTest extends SuitePHPUnitFrameworkTestCase
{
    /**#
     * @var Exception $exception
     */
    private static $exception;

    protected function setUp(): void
    {
        parent::setUp();
        if (self::$exception === null) {
            self::$exception = new Exception();
        }
    }

    public function testGetDetail()
    {
        self::assertEquals(
            'SuiteCRM has encountered an exception which has not been handled',
            self::$exception->getDetail()
        );
    }

    public function testGetLogLevel()
    {
        self::assertEquals(
            LogLevel::CRITICAL,
            self::$exception->getLogLevel()
        );
    }
}
