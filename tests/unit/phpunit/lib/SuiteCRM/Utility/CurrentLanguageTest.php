<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class CurrentLanguageTest extends SuitePHPUnitFrameworkTestCase
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
        $language = self::$language->getCurrentLanguage();
        $this->assertNotEmpty($language);
    }
}
