<?php

namespace SuiteCRM\Exception;

use Psr\Log\LogLevel;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\ForbiddenException;

class ForbiddenExceptionTest extends \SuiteCRM\StateCheckerUnitAbstract
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
        $this->assertEquals('[SuiteCRM] [API] [Forbidden] ', self::$exception->getMessage());
    }

    public function _before()
    {
        parent::_before();
        if (self::$exception === null) {
            self::$exception = new ForbiddenException();
        }
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
