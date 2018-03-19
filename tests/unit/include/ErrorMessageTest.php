<?php

use SuiteCRM\ErrorMessage;
use SuiteCRM\ErrorMessageException;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorMessageTest
 *
 * @author gyula
 */
class ErrorMessageTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        if (!defined('sugarEntry')) {
            define('sugarEntry', true);
        }

        global $app_strings, $mod_strings;

        include_once __DIR__ . '/../../../include/utils.php';
        include_once __DIR__ . '/../../../include/SugarTheme/SugarTheme.php';
        include_once __DIR__ . '/../../../include/SugarTheme/SugarThemeRegistry.php';
        include __DIR__ . '/../../../include/language/en_us.lang.php';
        include_once __DIR__ . '/../../../include/SugarObjects/SugarConfig.php';
        include_once __DIR__ . '/../../../include/SugarLogger/LoggerManager.php';

        include_once __DIR__ . '/../../../include/ErrorMessageException.php';
        include_once __DIR__ . '/../../../include/ErrorMessage.php';
        include_once __DIR__ . '/../../../include/LangText.php';
        include_once __DIR__ . '/../../../include/JsonApiErrorObject.php';
        include_once __DIR__ . '/../../../include/LangExceptionInterface.php';
        include_once __DIR__ . '/../../../include/LangException.php';
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testLog()
    {
        try {
            ErrorMessage::log('A test error message', 'debug', true, 321);
            $this->assertFalse(true, 'Error handler should throw an exception in this scenario.');
        } catch (ErrorMessageException $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            $this->assertEquals('A test error message', $message, 'Incorrect exception message given.');
            $this->assertEquals(321, $code, 'Incorrect exception code given.');
        }
    }
}
