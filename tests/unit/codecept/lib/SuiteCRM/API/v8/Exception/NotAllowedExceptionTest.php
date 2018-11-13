<?php

namespace SuiteCRM\Exception;

use Psr\Log\LogLevel;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\NotAllowedException;

class NotAllowedExceptionTest extends \SuiteCRM\StateCheckerUnitAbstract
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
            self::$exception = new NotAllowedException();
        }
    }



    public function testGetMessage()
    {
        $this->assertEquals('[SuiteCRM] [API] [Not Allowed] ', self::$exception->getMessage());
    }

    public function testGetSetDetail()
    {
        $this->assertEquals('Api Version: 8', self::$exception->getDetail());
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