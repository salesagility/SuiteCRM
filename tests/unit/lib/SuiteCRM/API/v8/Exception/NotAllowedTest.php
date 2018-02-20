<?php

namespace SuiteCRM\Exception;

use Psr\Log\LogLevel;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\NotAllowed;

class NotAllowedTest extends \Codeception\Test\Unit
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
            self::$exception = new NotAllowed();
        }
    }

    protected function _after()
    {
    }

    public function testGetMessage()
    {
        $this->assertEquals('[SuiteCRM] [API] [Not Allowed] ', self::$exception->getMessage());
    }

    public function testGetSetDetail()
    {
        $this->assertEquals('', self::$exception->getDetail());
    }

    public function testGetSetSource()
    {
        self::$exception->setSource('/data');
        $this->assertSame(array('pointer' => '/data'), self::$exception->getSource());
    }

    public function testGetHttpStatus()
    {
        $this->assertEquals(403, self::$exception->getHttpStatus());
    }
}