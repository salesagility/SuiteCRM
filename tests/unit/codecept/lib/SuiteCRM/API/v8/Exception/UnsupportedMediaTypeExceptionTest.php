<?php

namespace SuiteCRM\Exception;

use Psr\Log\LogLevel;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\UnsupportedMediaTypeException;

class UnsupportedMediaTypeExceptionTest extends \SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**#
     * @var ApiException $exception
     */
    private static $exception;

    public function _before()
    {
        parent::_before();
        if(self::$exception === null) {
            self::$exception = new UnsupportedMediaTypeException();
        }
    }



    public function testGetMessage()
    {
        $this->assertEquals('[SuiteCRM] [API] [Unsupported Media Type] ', self::$exception->getMessage());
    }

    public function testGetSetDetail()
    {
        $this->assertEquals('Json API expects the "Content-Type" header to be application/vnd.api+json', self::$exception->getDetail());
    }

    public function testGetSetSource()
    {
        self::$exception->setSource('/data');
        $this->assertSame(array('pointer' => '/data'), self::$exception->getSource());
    }

    public function testGetHttpStatus()
    {
        $this->assertEquals(415, self::$exception->getHttpStatus());
    }
}