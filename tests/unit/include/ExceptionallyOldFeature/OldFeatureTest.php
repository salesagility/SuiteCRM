<?php

// this is just because i don't want to change bootstrap.php
require_once 'include/ExceptionallyOldFeature/OldFeature.php';
require_once 'include/Exceptions/SugarEmptyValueException.php';
require_once 'include/Exceptions/SugarErrorHandler.php';
require_once 'include/Exceptions/SugarException.php';
require_once 'include/Exceptions/SugarInvalidTypeException.php';

class OldFeatureTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var OldFeature $class
     */
    protected static $class;

    /**
     * Set up dependencies
     */
    protected function setUp()
    {
        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
        self::$class = new OldFeature();
    }

    /**
     * test old feature
     */
    public function test_old_function()
    {
        //
        // good cases
        $expected = array(
            'ID' => '1',
            'NAME' => 'Daniel',
            'DELETED' => '1'
        );
        $actual = self::$class->old_function(true);
        $this->assertFalse(
            SugarErrorHandler::hasErrors(),
            SugarErrorHandler::getStackTraceMessage()
        );
        $this->assertSame($expected, $actual);

        $expected = array(
            'ID' => '',
            'NAME' => '',
            'DELETED' => ''
        );
        $actual = self::$class->old_function(false);
        $this->assertFalse(
            SugarErrorHandler::hasErrors(),
            SugarErrorHandler::getStackTraceMessage()
        );
        $this->assertSame($expected, $actual);

        //
        // bad cases
        self::$class->old_function(1);
        $this->assertTrue(
            SugarErrorHandler::hasThrownError(new SugarInvalidTypeException()),
            SugarErrorHandler::getStackTraceMessage()
        );

        //
        // empty cases
        self::$class->old_function(null);
        $this->assertTrue(
            SugarErrorHandler::hasThrownError(new SugarEmptyValueException()),
            SugarErrorHandler::getStackTraceMessage()
        );
    }

    // test other methods
}
