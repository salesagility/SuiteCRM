<?php

use SuiteCRM\LangText;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LangTextTest
 *
 * @author gyula
 */
class LangTextTest extends PHPUnit_Framework_TestCase
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

    public function testConstruct()
    {
        global $app_strings, $mod_strings;
        $app_strings['LBL_TEST_APP_STRING'] = 'test app string {foo} {bar}';
        $mod_strings['LBL_TEST_MOD_STRING'] = 'test mod string {foo} {bar}';

        $text = new LangText('LBL_TEST_APP_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_APP_STRINGS);
        $output = $text->getText();
        $this->assertEquals('test app string bar baz', $output, 'Incorrect translation (1)');

        try {
            $text = new LangText('LBL_TEST_MOD_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_APP_STRINGS);
            $output = $text->getText();
            $this->assertTrue(false, 'Incorrect translation (2) - A language key should not found: [LBL_TEST_MOD_STRING] (1)');
        } catch (\SuiteCRM\ErrorMessageException $e) {
            $this->assertTrue(true, 'Incorrect translation (2) - A language key should not found: [LBL_TEST_MOD_STRING] (2)');
        }

        try {
            $text = new LangText('LBL_TEST_APP_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_MOD_STRINGS);
            $output = $text->getText();
            $this->assertTrue(false, 'Incorrect translation (3) - A language key should not found: [LBL_TEST_APP_STRING] (1)');
        } catch (\SuiteCRM\ErrorMessageException $e) {
            $this->assertTrue(true, 'Incorrect translation (3) - A language key should not found: [LBL_TEST_APP_STRING] (2)');
        }

        $text = new LangText('LBL_TEST_MOD_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_MOD_STRINGS);
        $output = $text->getText();
        $this->assertEquals('test mod string bar baz', $output, 'Incorrect translation (4)');

        $text = new LangText('LBL_TEST_APP_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_ALL_STRINGS);
        $output = $text->getText();
        $this->assertEquals('test app string bar baz', $output, 'Incorrect translation (5)');

        $text = new LangText('LBL_TEST_MOD_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_ALL_STRINGS);
        $output = $text->getText();
        $this->assertEquals('test mod string bar baz', $output, 'Incorrect translation (6)');


        $text = new LangText();
        $output = $text->getText('LBL_TEST_APP_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_APP_STRINGS);
        $this->assertEquals('test app string bar baz', $output, 'Incorrect translation (7)');

        try {
            $text = new LangText();
            $output = $text->getText('LBL_TEST_MOD_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_APP_STRINGS);
            $this->assertTrue(false, 'Incorrect translation (8) - A language key should not found: [LBL_TEST_MOD_STRING] (1)');
        } catch (\SuiteCRM\ErrorMessageException $e) {
            $this->assertTrue(true, 'Incorrect translation (8) - A language key should not found: [LBL_TEST_MOD_STRING] (2)');
        }

        try {
            $text = new LangText();
            $output = $text->getText('LBL_TEST_APP_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_MOD_STRINGS);
            $this->assertTrue(false, 'Incorrect translation (9) - A language key should not found: [LBL_TEST_APP_STRING] (1)');
        } catch (\SuiteCRM\ErrorMessageException $e) {
            $this->assertTrue(true, 'Incorrect translation (9) - A language key should not found: [LBL_TEST_APP_STRING] (2)');
        }

        $text = new LangText();
        $output = $text->getText('LBL_TEST_MOD_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_MOD_STRINGS);
        $this->assertEquals('test mod string bar baz', $output, 'Incorrect translation (10)');

        $text = new LangText();
        $output = $text->getText('LBL_TEST_APP_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_ALL_STRINGS);
        $this->assertEquals('test app string bar baz', $output, 'Incorrect translation (11)');

        $text = new LangText();
        $output = $text->getText('LBL_TEST_MOD_STRING', ['foo' => 'bar', 'bar' => 'baz'], LangText::USING_ALL_STRINGS);
        $this->assertEquals('test mod string bar baz', $output, 'Incorrect translation (12)');
    }
}
