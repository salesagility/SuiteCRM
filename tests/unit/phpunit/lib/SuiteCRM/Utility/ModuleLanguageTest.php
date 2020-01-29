<?php


class ModuleLanguageTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\Utility\ModuleLanguage $paths
     */
    private static $language;


    protected function setUp()
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
