<?php


use SuiteCRM\Test\SuitePHPUnit_Framework_TestCase;

class ModuleLanguageTest extends SuitePHPUnit_Framework_TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\Utility\ModuleLanguage $paths
     */
    private static $language;

    public function setUp()
    {
        parent::setUp();
        if (self::$language === null) {
            self::$language = new \SuiteCRM\Utility\ModuleLanguage();
        }
    }

    public function testGetCurrentLanguage()
    {
        $language = self::$language->getModuleLanguageStrings(new \SuiteCRM\Utility\CurrentLanguage(), 'Accounts');
        $this->assertNotEmpty($language);
        $this->assertArrayHasKey('LBL_MODULE_NAME', $language);
    }
}
