<?php

/**
 * Class TimeDateTest
 */
class TimeDateTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    /**
     * @var TimeDate
     */
    private $timeDate;

    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();

        $this->timeDate = new TimeDate();
    }

    public function testGetTimeLapse()
    {
        $result = $this->timeDate->getTimeLapse('2016-01-15 11:16:02');
        $this->assertTrue(isset($result));
        $this->assertInternalType('string', $result);
    }
}
