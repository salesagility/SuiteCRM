<?php

namespace SuiteCRM\Exception;

use Psr\Log\LogLevel;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\InvalidJsonApiRequest;

class InvalidJsonApiRequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**#
     * @var ApiException $exception
     */
    private static $exception;

    public function testGetMessage()
    {
        $this->assertEquals('[SuiteCRM] [API] [InvalidJsonApiRequest] ', self::$exception->getMessage());
    }

    protected function _before()
    {
        if(self::$exception === null) {
            self::$exception = new InvalidJsonApiRequest();
        }
    }

    protected function _after()
    {
    }

    public function testGetSetDetail()
    {
        $this->assertEquals('Unable to validate the Json Api Payload Request', self::$exception->getDetail());
    }

    public function testGetSetSource()
    {
        self::$exception->setSource('/data');
        $this->assertSame(array('pointer' => '/data'), self::$exception->getSource());
    }

    public function testGetHttpStatus()
    {
        $this->assertEquals(400, self::$exception->getHttpStatus());
    }
}