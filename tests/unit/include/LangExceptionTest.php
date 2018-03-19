<?php

use SuiteCRM\LangException;
use SuiteCRM\LangText;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LangExceptionTest
 *
 * @author gyula
 */
class LangExceptionTest extends PHPUnit_Framework_TestCase
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

    public function testGetLangMessage()
    {
        global $app_strings;
        $app_strings['LBL_LANG_TEST_LABEL'] = 'Lang text with {variable} in text';
        $e = new LangException('Test message', 123, null, new LangText('LBL_LANG_TEST_LABEL', ['variable' => 'foo']));
        $langMessage = $e->getLangMessage();
        $this->assertEquals('Lang text with foo in text', $langMessage, 'Incorrect translation for LangException message');
    }
}
