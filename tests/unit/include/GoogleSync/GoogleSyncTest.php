<?php

require_once dirname(dirname(dirname(dirname(__DIR__)))). '/include/GoogleSync/GoogleSync.php';

class GoogleSyncTest extends \Codeception\Test\Unit
{
    /** @var UnitTester */
    protected $tester;

    /** @var ReflectionClass */
    protected static $relection;

    /** @var ReflectionProperty */
    protected static $dbProperty;

    protected function _before()
    {
        parent::_before();

        // Use reflection to access private properties and methods
        if (self::$relection === null) {
            self::$relection = new ReflectionClass(GoogleSync::class);
            self::$dbProperty = self::$relection->getProperty('db');
            self::$dbProperty->setAccessible(true);
        }
    }

    public function test__construct()
    {

        // Set up object for testing
        global $sugar_config;
        // base64 encoded of {"web":"test"}
        $sugar_config['google_auth_json'] = 'eyJ3ZWIiOiJ0ZXN0In0=';

        $object = new GoogleSync();

        // Test GoogleSync::timezone
        $this->assertNotEmpty($object->timezone);
        $this->assertEquals("string", gettype($object->timezone));

        // Test GoogleSync::authJson
        $this->assertNotEmpty($object->authJson);
        $this->assertEquals("array", gettype($object->authJson));

        // Test GoogleSync::db
        $expectedClass = DBManager::class;
        $actualClass = self::$dbProperty->getValue($object);
        $this->assertInstanceOf($expectedClass, $actualClass);

        // Test setting log level
        $_SERVER['GSYNC_LOGLEVEL'] = 'debug';
        $object = new GoogleSync();
        $expectedLogLevel = 'debug';
        $actualLogLevel = LoggerManager::getLogLevel();
        $this->assertEquals($expectedLogLevel, $actualLogLevel);
    }

    public function testGetGoogleEventById()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetClient()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetAuthJson()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testAddUser()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testPullEvent()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testSetGService()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetUserMeetings()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetUserGoogleEvents()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetGoogleEventByMeetingId()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testCreateSuitecrmMeetingEvent()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testUpdateGoogleCalendarEvent()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetMeetingByEventId()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testDelEvent()
    {

    }

    public function testPushPullSkip()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testSetUsersGoogleCalendar()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testCreateGoogleCalendarEvent()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testSetSyncUsers()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testDelMeeting()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testSetClient()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testSyncAllUsers()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testDoSync()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testPushEvent()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testDelUser()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetMissingMeeting()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testUpdateSuitecrmMeetingEvent()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testSetTimezone()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }
}
