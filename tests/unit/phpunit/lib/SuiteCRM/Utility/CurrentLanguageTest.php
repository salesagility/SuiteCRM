<?php


class CurrentLanguageTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\Utility\CurrentLanguage $paths
     */
    private static $language;


    protected function setUp()
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
