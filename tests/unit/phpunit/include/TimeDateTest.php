<?php

use TimeDate;

/**
 * Class TimeDateTest
 */
class TimeDateTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    private $timeDate;

    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();

        $this->timeDate = new \TimeDate();
    }

    public function testGetTimeLapse()
    {
        $GLOBALS['log']->reset();
        /** @noinspection PhpDeprecationInspection */
        $result = $this->timeDate->getTimeLapse('2016-01-15 11:16:02');
        self::assertCount(1, $GLOBALS['log']->calls['deprecated']);
        $this->assertTrue(isset($result));
        $this->assertGreaterThanOrEqual(0, strlen($result));
    }
}
