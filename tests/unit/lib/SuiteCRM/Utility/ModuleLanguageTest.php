<?php


class ModuleLanguageTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\Utility\ModuleLanguage $paths
     */
    private static $language;


    protected function _before()
    {
        if (self::$language === null) {
            self::$language = new \SuiteCRM\Utility\ModuleLanguage();
        }
    }

    protected function _after()
    {
    }

    public function testGetCurrentLanguage()
    {
        $language = self::$language->getModuleLanguageStrings(new \SuiteCRM\Utility\CurrentLanguage(), 'Accounts');
        $this->assertNotEmpty($language);
        $this->assertArrayHasKey('LBL_MODULE_NAME', $language);
    }
}