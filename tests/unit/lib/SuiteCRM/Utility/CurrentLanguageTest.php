<?php


class CurrentLanguageTest extends SuiteCRM\StateCheckerUnitAbstract
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
        $language = self::$language->getCurrentLanguage();
        $this->assertNotEmpty($language);
    }
}