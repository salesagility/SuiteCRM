<?php

require_once dirname(dirname(dirname(dirname(__DIR__)))). '/include/GoogleSync/GoogleSync.php';

class GoogleSyncTest extends \SuiteCRM\StateCheckerUnitAbstract
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
    
        // Set up object for testing
        global $sugar_config;

        // base64 encoded of {"web":"test"}
        $sugar_config['google_auth_json'] = 'eyJ3ZWIiOiJ0ZXN0In0=';

        $object = new GoogleSync();

        $expectedAuthJson = json_decode(base64_decode('eyJ3ZWIiOiJ0ZXN0In0'), true);
        $actualAuthJson = $object->getAuthJson();

        $this->assertEquals($expectedAuthJson, $actualAuthJson);
        $this->assertArrayHasKey('web', $actualAuthJson);
    }

    public function testAddUser()
    {

        $object = new GoogleSync();
        $return = $object->addUser('ABC123', 'End User');

        $this->assertTrue($return);
        $this->assertArrayHasKey('ABC123', $object->users);

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

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('reminders');

        $object = new GoogleSync();

        date_default_timezone_set('Etc/UTC');

        // BEGIN: Create Google Event Object
        $Google_Event = new Google_Service_Calendar_Event();

        $Google_Event->setSummary('Unit Test Event');
        $Google_Event->setDescription('Unit Test Event');
        $Google_Event->setLocation('123 Seseme Street');

        // Set start date/time
        $startDateTime = new Google_Service_Calendar_EventDateTime;
        $startDateTime->setDateTime(date(DATE_ATOM, strtotime('2018-01-01 01:00:00 UTC')));
        $startDateTime->setTimeZone('Etc/UTC');
        $Google_Event->setStart($startDateTime);

        // Set end date/time
        $endDateTime = new Google_Service_Calendar_EventDateTime;
        $endDateTime->setDateTime(date(DATE_ATOM, strtotime('2018-01-01 02:00:00 UTC')));
        $endDateTime->setTimeZone('Etc/UTC');
        $Google_Event->setEnd($endDateTime);

        // Set extended properties
        $extendedProperties = new Google_Service_Calendar_EventExtendedProperties;
        $private = array();
        $private['suitecrm_id'] = 'RECORD_ID';
        $private['suitecrm_type'] = 'Meeting';
        $extendedProperties->setPrivate($private);
        $Google_Event->setExtendedProperties($extendedProperties);

        // Set popup reminder
        $reminders_remote = new Google_Service_Calendar_EventReminders;
        $reminders_remote->setUseDefault(false);
        $reminders_array = array();
        $reminder_remote = new Google_Service_Calendar_EventReminder;
        $reminder_remote->setMethod('popup');
        $reminder_remote->setMinutes('15');
        $reminders_array[] = $reminder_remote;
        $reminders_remote->setOverrides($reminders_array);
        $Google_Event->setReminders($reminders_remote);

        // END: Create Google Event Object

        // Set id of fake user
        $object->workingUser = new User;
        $object->workingUser->id = 'FAKEUSER';
        $this->assertEquals('FAKEUSER', $object->workingUser->id);

        $return = $object->createSuitecrmMeetingEvent($Google_Event);
        $this->assertEquals('Meeting', get_class($return));
        $this->assertNotNull($return->id);
        $this->assertEquals('0', $return->deleted);
        $this->assertEquals('Unit Test Event', $return->name);
        $this->assertEquals('Unit Test Event', $return->description);
        $this->assertEquals('123 Seseme Street', $return->location);
        $this->assertEquals('01/01/2018 01:00:00am', $return->date_start);
        $this->assertEquals('01/01/2018 02:00:00am', $return->date_end);
        $this->assertEquals('1', $return->duration_hours);
        $this->assertEquals('0', $return->duration_minutes);
        $this->assertEquals('FAKEUSER', $return->assigned_user_id);

        $state->popTable('reminders');
    }

    public function testUpdateGoogleCalendarEvent()
    {
        // This is covered by testCreateGoogleCalendarEvent since is calls this
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
        $object = new GoogleSync();

        // Create SuiteCRM Meeting Object
        $CRM_Meeting = new Meeting();

        $CRM_Meeting->id = create_guid();
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';

        // Create Google Event Object
        $Google_Event = new Google_Service_Calendar_Event();

        $Google_Event->setSummary('Unit Test Event');
        $Google_Event->setDescription('Unit Test Event');

        // Test with just an active Meeting. Should return 'push'
        $this->assertEquals('push', $object->pushPullSkip($CRM_Meeting));

        // Test with just deleted Meeting. Should return 'skip'
        $CRM_Meeting->deleted = '1';
        $this->assertEquals('skip', $object->pushPullSkip($CRM_Meeting));
        

        // Test with just an active Google Event. Should return 'pull'
        $this->assertEquals('pull', $object->pushPullSkip($Google_Event));

        // Test with just a canceled Google Event. Should return 'skip'
        $Google_Event->status = 'cancelled';
        $this->assertEquals('skip', $object->pushPullSkip($Google_Event));

        // Test compare both Meeting & Event, but both deleted. Should return 'skip'
        $this->assertEquals('skip', $object->pushPullSkip($CRM_Meeting, $Google_Event));

        // Set records to active
        $CRM_Meeting->deleted = '0';
        $Google_Event->status = '';

        // Test with newer Meeting. Should return 'push'
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-02 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';
        $this->assertEquals('push', $object->pushPullSkip($CRM_Meeting, $Google_Event));

        // Test with newer Google Event. Should return 'pull'
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-02 12:00:00 UTC';
        $this->assertEquals('pull', $object->pushPullSkip($CRM_Meeting, $Google_Event));

        // Test with newer, deleted meeting. Should return 'push_delete'
        $CRM_Meeting->deleted = '1';
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-03 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-02 12:00:00 UTC');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';
        $this->assertEquals('push_delete', $object->pushPullSkip($CRM_Meeting, $Google_Event));
        $CRM_Meeting->deleted = '0';

        // Test with newer, deleted Google Event Should return 'pull_delete'
        $Google_Event->status = 'cancelled';
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-02 12:00:00 UTC';
        $this->assertEquals('pull_delete', $object->pushPullSkip($CRM_Meeting, $Google_Event));
        $Google_Event->status = '';

        // Set records to active
        $CRM_Meeting->deleted = '0';
        $Google_Event->status = '';

        // Test with synced event
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';
        $this->assertEquals('skip', $object->pushPullSkip($CRM_Meeting, $Google_Event));

    }

    public function testSetUsersGoogleCalendar()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testCreateGoogleCalendarEvent()
    {
        $object = new GoogleSync();
        date_default_timezone_set('Etc/UTC');

        // Create SuiteCRM Meeting Object
        $CRM_Meeting = new Meeting();

        $CRM_Meeting->id = 'FAKE_MEETING_ID';
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';
        $CRM_Meeting->location = '123 Sesame Street';
        $CRM_Meeting->date_start = '2018-01-01 12:00:00';
        $CRM_Meeting->date_end = '2018-01-01 13:00:00';
        $CRM_Meeting->module_name = 'Meeting';

        $return = $object->createGoogleCalendarEvent($CRM_Meeting);

        $this->assertEquals('Google_Service_Calendar_Event', get_class($return));
        $this->assertEquals('Unit Test Event', $return->getSummary());
        $this->assertEquals('Unit Test Event', $return->getDescription());
        $this->assertEquals('123 Sesame Street', $return->getLocation());

        $start = $return->getStart();
        $end = $return->getEnd();
        $this->assertEquals('2018-01-01T12:00:00+00:00', $start->getDateTime());
        $this->assertEquals('Etc/UTC', $start->getTimeZone());
        $this->assertEquals('2018-01-01T13:00:00+00:00', $end->getDateTime());
        $this->assertEquals('Etc/UTC', $end->getTimeZone());

        $props = $return->getExtendedProperties();
        $private = $props->getPrivate();
        $this->assertEquals('FAKE_MEETING_ID', $private['suitecrm_id']);
        $this->assertEquals('Meeting', $private['suitecrm_type']);
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
        $object = new GoogleSync();

        $object->users['ABC123'] = 'End User';
        $return = $object->delUser('ABC123');
        $this->assertTrue($return);
        $this->assertArrayNotHasKey('ABC123', $object->users);
    }

    public function testGetMissingMeeting()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testUpdateSuitecrmMeetingEvent()
    {
       // This is tested by testCreateSuitecrmMeetingEvent, Since that method calls it.
    }

    public function testSetTimezone()
    {
        $object = new GoogleSync();

        $expectedTimezone = 'Etc/GMT';

        $return = $object->setTimezone($expectedTimezone);

        $this->assertTrue($return);
        $this->assertEquals($expectedTimezone, $object->timezone);
        $this->assertEquals($expectedTimezone, date_default_timezone_get());

    }
}
