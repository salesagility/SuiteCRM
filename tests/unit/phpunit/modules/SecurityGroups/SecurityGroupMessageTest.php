<?php

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
        /** @noinspection PhpDeprecationInspection */
        $result = $this->securityGroupMessage->getTimeLapse('2016-01-15 11:16:02');
        self::assertCount(1, $GLOBALS['log']->calls['deprecated']);
        $this->assertTrue(isset($result));
        $this->assertGreaterThanOrEqual(0, strlen($result));
    }

    public function testBean_implements()
    {
        $this->assertEquals(false, $this->securityGroupMessage->bean_implements(''));
        $this->assertEquals(false, $this->securityGroupMessage->bean_implements('test'));
        $this->assertEquals(true, $this->securityGroupMessage->bean_implements('ACL'));
    }
}

