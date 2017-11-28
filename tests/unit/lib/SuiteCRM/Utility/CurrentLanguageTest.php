<?php


class CurrentLanguageTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\Utility\CurrentLanguage $paths
     */
    private static $language;


    protected function _before()
    {
        if (self::$language === null) {
            self::$language = new \SuiteCRM\Utility\CurrentLanguage();
        }
    }

    protected function _after()
    {
    }

    public function testGetCurrentLanguage()
    {
        $language = self::$language->getCurrentLanguage();
        $this->assertNotEmpty($language);
    }
}