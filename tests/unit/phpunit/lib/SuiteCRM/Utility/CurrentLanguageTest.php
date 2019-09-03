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
        $language = self::$language->getCurrentLanguage();
        $this->assertNotEmpty($language);
    }
}
