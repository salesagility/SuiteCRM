<?php


class ModuleLanguageTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\Utility\ModuleLanguage $paths
     */
    private static $language;


    public function _before()
    {
        parent::_before();
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