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


    public function _before()
    {
        parent::_before();
        if (self::$language === null) {
            self::$language = new \SuiteCRM\Utility\CurrentLanguage();
        }
    }



    public function testGetCurrentLanguage()
    {
        $this->markTestIncomplete('Call to a member function getCurrentLanguage() on null');
        $language = self::$language->getCurrentLanguage();
        $this->assertNotEmpty($language);
    }
}