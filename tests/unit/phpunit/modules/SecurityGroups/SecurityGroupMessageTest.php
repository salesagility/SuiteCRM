<?php

require_once __DIR__ . '/../../../../../modules/SecurityGroups/SecurityGroupMessage.php';

/**
 * Class SecurityGroupMessageTest
 */
class SecurityGroupMessageTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    private $securityGroupMessage;

    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();

        $this->securityGroupMessage = new SecurityGroupMessage();
    }

    public function testGetTimeLapse()
    {
        $GLOBALS['log']->reset();
        /** @noinspection PhpDeprecationInspection */
        $this->securityGroupMessage->getTimeLapse('2016-01-15 11:16:02');
        self::assertCount(1, $GLOBALS['log']->calls['deprecated']);
    }

    public function testBean_implements()
    {
        $this->assertEquals(false, $this->securityGroupMessage->bean_implements(''));
    }
}

