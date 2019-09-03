<?php


use SuiteCRM\Test\SuitePHPUnit_Framework_TestCase;

class CurrentLanguageTest extends SuitePHPUnit_Framework_TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\Utility\CurrentLanguage $paths
     */
    private static $language;

    public function setUp()
    {
        parent::setUp();
        if (self::$language === null) {
            self::$language = new \SuiteCRM\Utility\CurrentLanguage();
        }
    }

    public function testGetCurrentLanguage()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushFile('config_override.php');
        
        $language = self::$language->getCurrentLanguage();
        $this->assertNotEmpty($language);
        
        $state->popFile('config_override.php');
    }
}
