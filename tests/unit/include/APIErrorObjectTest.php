<?php

use SuiteCRM\JsonApiErrorObject;
use SuiteCRM\LangException;
use SuiteCRM\LangText;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JsonApiErrorObjectTest
 *
 * @author gyula
 */
class JsonApiErrorObjectTest extends PHPUnit_Framework_TestCase {
    
    public function setUp() {
        parent::setUp();
        if(!defined('sugarEntry')) {
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
    
    public function tearDown() {
        parent::tearDown();
    }
    
    public function testConstruct() {
        
        $error = new JsonApiErrorObject();
        $expected = [
            'id' => '1',
            'links' => ['about' => null],
            'status' => '200',
            'code' => '1',
            'title' => 'JSON API Error',
            'detail' => 'JSON API Error occured.',
            'source' => ['pointer' => null, 'parameter' => null],
            'meta' => [], 
        ];
        $actual = $error->export();
        $this->assertEquals($expected, $actual, 'API Error Object constructor error: Incorrect default state.');
        
        global $app_strings;
        $app_strings['LBL_TEST_LABEL_TITLE'] = 'A title';
        $app_strings['LBL_TEST_LABEL_DETAIL'] = 'A detail';
        
        $error = new JsonApiErrorObject(new LangText('LBL_TEST_LABEL_TITLE'), new LangText('LBL_TEST_LABEL_DETAIL'), 123, 234, 345, ['about' => 'test123'], ['pointer' => '/test/foo/bar', 'parameter' => 'wrong'], ['some' => 'meta info']);
        $expected = [
            'id' => '123',
            'links' => ['about' => 'test123'],
            'status' => '345',
            'code' => '234',
            'title' => 'A title',
            'detail' => 'A detail',
            'source' => ['pointer' => '/test/foo/bar', 'parameter' => 'wrong'],
            'meta' => ['some' => 'meta info'], 
        ];
        $actual = $error->export();
        $this->assertEquals($expected, $actual, 'API Error Object constructor error: Incorrect state set.');
        
    }
    
    public function testRetrieveFromException() {
        
        $error = new JsonApiErrorObject();
        
        global $app_strings;
        $app_strings['LBL_TEST_LANG_TEXT'] = 'Test text with variable {foo}.';
        
        $prev = new Exception('Test basic exception', 555);
        $error->retrieveFromException(new LangException('test exception message', 123, $prev, new LangText('LBL_TEST_LANG_TEXT', ['foo' => 'bar'])));
        $expected = [
            'id' => '1',
            'links' => ['about' => null],
            'status' => '200',
            'title' => 'JSON API Error',
            'detail' => 'JSON API Error occured.',
            'source' => ['pointer' => null, 'parameter' => null],
            'meta' => [
                'about' => 'Exception',
                'class' => 'SuiteCRM\\LangException',
                'code' => '123',
                'langMessage' => 'Test text with variable bar.',
            ],
            'code' => '123',
        ];
        $actual = $error->export();
        
        $this->assertEquals($expected, $actual, 'API Error Object retrive error from exception.');
        
    }
    
}
