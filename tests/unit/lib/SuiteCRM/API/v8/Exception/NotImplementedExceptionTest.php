<?php

namespace SuiteCRM\Exception;

use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\NotImplementedException;
use SuiteCRM\LangText;
use UnitTester;

class NotImplementedExceptionTest extends \SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var UnitTester
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
            self::$exception = new NotImplementedException();
        }
    }



    public function testGetMessage()
    {
        $this->assertEquals('[SuiteCRM] [API] [NotImplementedException] ', self::$exception->getMessage());
    }

    public function testGetSetDetail()
    {
        global $app_strings;
        $app_strings['LBL_API_TEST_1'] = 'test';
        self::$exception->setDetail(new LangText('LBL_API_TEST_1'));
        $this->assertEquals('test', self::$exception->getDetail());
    }

    public function testGetSetSource()
    {
        self::$exception->setSource('/data');
        $this->assertSame(array('pointer' => '/data'), self::$exception->getSource());
    }

    public function testGetHttpStatus()
    {
        $this->assertEquals(500, self::$exception->getHttpStatus());
    }
}