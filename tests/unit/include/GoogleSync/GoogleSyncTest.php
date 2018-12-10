<?php

require_once dirname(dirname(dirname(dirname(__DIR__)))). '/include/GoogleSync/GoogleSync.php';

class GoogleSyncTest extends \SuiteCRM\StateCheckerUnitAbstract
{
    /** @var UnitTester */
    protected $tester;

    /** @var ReflectionClass */
    protected static $reflection;

    /** @var ReflectionProperty */
    protected static $dbProperty;

    public function _before()
    {
        parent::_before();

        // Use reflection to access private properties and methods
        if (self::$reflection === null) {
            self::$reflection = new ReflectionClass(GoogleSync::class);
            self::$dbProperty = self::$reflection->getProperty('db');
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
        $timezone = self::$reflection->getProperty('timezone');
        $timezone->setAccessible(true);
        $this->assertNotEmpty($timezone->getValue($object));
        $this->assertEquals("string", gettype($timezone->getValue($object)));

        // Test GoogleSync::authJson
        $authJson = self::$reflection->getProperty('authJson');
        $authJson->setAccessible(true);
        $this->assertNotEmpty($authJson->getValue($object));
        $this->assertEquals("array", gettype($authJson->getValue($object)));

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
        $state = new \SuiteCrm\StateSaver();
        $state->pushGlobals();

        $method = self::$reflection->getMethod('getAuthJson');
        $method->setAccessible(true);
    
        // Set up object for testing
        global $sugar_config;

        // base64 encoded of {"web":"test"}
        $sugar_config['google_auth_json'] = 'eyJ3ZWIiOiJ0ZXN0In0=';

        $object = new GoogleSync();

        $expectedAuthJson = json_decode(base64_decode('eyJ3ZWIiOiJ0ZXN0In0'), true);
        $actualAuthJson = $method->invoke($object);

        $this->assertEquals($expectedAuthJson, $actualAuthJson);
        $this->assertArrayHasKey('web', $actualAuthJson);

        $state->popGlobals();
    }

    public function testAddUser()
    {
        $method = self::$reflection->getMethod('addUser');
        $method->setAccessible(true);

        $property = self::$reflection->getProperty('users');
        $property->setAccessible(true);

        $object = new GoogleSync();
        $return = $method->invoke($object, 'ABC123', 'End User');

        $this->assertTrue($return);
        $this->assertArrayHasKey('ABC123', $property->getValue($object));

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
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('meetings');
        $state->pushTable('meetings_cstm');
        $state->pushTable('users');
        $state->pushTable('user_preferences');
        $state->pushTable('aod_indexevent');
        $state->pushTable('vcals');

        // Create a User
        $user = new User();
        $user->last_name = 'UNIT_TESTS';
        $user->user_name = 'UNIT_TESTS';
        $user->save();

        // Create three meetings and save them to the DB for testing.
        $meeting1 = new Meeting();
        $meeting1->name = 'test1';
        $meeting1->assigned_user_id = $user->id;
        $meeting1->status = 'Not Held';
        $meeting1->type = 'Sugar';
        $meeting1->description = 'test description';
        $meeting1->duration_hours = 1;
        $meeting1->duration_minutes = 1;
        $meeting1->date_start = '2016-02-11 17:30:00';
        $meeting1->date_end = '2016-02-11 17:30:00';
        $meeting1_id = $meeting1->save();

        $meeting2 = new Meeting();
        $meeting2->name = 'test2';
        $meeting2->assigned_user_id = $user->id;
        $meeting2->status = 'Not Held';
        $meeting2->type = 'Sugar';
        $meeting2->description = 'test description';
        $meeting2->duration_hours = 1;
        $meeting2->duration_minutes = 1;
        $meeting2->date_start = '2016-02-11 17:30:00';
        $meeting2->date_end = '2016-02-11 17:30:00';
        $meeting2_id = $meeting2->save();

        $meeting3 = new Meeting();
        $meeting3->name = 'test3';
        $meeting3->assigned_user_id = $user->id;
        $meeting3->status = 'Not Held';
        $meeting3->type = 'Sugar';
        $meeting3->description = 'test description';
        $meeting3->duration_hours = 1;
        $meeting3->duration_minutes = 1;
        $meeting3->date_start = '2016-02-11 17:30:00';
        $meeting3->date_end = '2016-02-11 17:30:00';
        $meeting3_id = $meeting3->save();

        $method = self::$reflection->getMethod('getUserMeetings');
        $method->setAccessible(true);

        $property = self::$reflection->getProperty('workingUser');
        $property->setAccessible(true);

        $object = new GoogleSync();
        $property->setValue($object, $user);
        //$object->workingUser = $user;

        $return = $method->invoke($object);

        //$return = $object->getUserMeetings();

        $this->assertEquals(3, count($return));

        // Test for invalid user id exception handling
        $user->id = 'INVALID';
        $property->setValue($object, $user);
        try {
            $caught = false;
            $return = $method->invoke($object);
        } catch (Exception $e) {
            $caught = true;
        }
        $this->assertTrue($caught);

        $state->popTable('meetings');
        $state->popTable('meetings_cstm');
        $state->popTable('users');
        $state->popTable('user_preferences');
        $state->popTable('aod_indexevent');
        $state->popTable('vcals');
    }

    public function testGetUserGoogleEvents()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testCreateSuitecrmMeetingEvent()
    {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('reminders');
        $state->pushTable('reminders_invitees');

        $method = self::$reflection->getMethod('createSuitecrmMeetingEvent');
        $method->setAccessible(true);

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
        $property = self::$reflection->getProperty('workingUser');
        $property->setAccessible(true);
        $user = new User;
        $user->id = 'FAKEUSER';
        $property->setValue($object, $user);

        $return = $method->invoke($object, $Google_Event);
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
        $state->popTable('reminders_invitees');
    }

    public function testUpdateGoogleCalendarEvent()
    {
        // This is covered by testCreateGoogleCalendarEvent since is calls this
    }

    public function testGetMeetingByEventId()
    {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('meetings');
        $state->pushTable('meetings_cstm');
        $state->pushTable('vcals');
        $state->pushTable('aod_indexevent');

        $db = DBManagerFactory::getInstance();

        $method = self::$reflection->getMethod('getMeetingByEventId');
        $method->setAccessible(true);

        $object = new GoogleSync();

        // Create three meetings and save them to the DB for testing.
        $meeting1 = new Meeting();
        $meeting1->name = 'test1';
        $meeting1->assigned_user_id = '666';
        $meeting1->status = 'Not Held';
        $meeting1->type = 'Sugar';
        $meeting1->description = 'test description';
        $meeting1->duration_hours = 1;
        $meeting1->duration_minutes = 1;
        $meeting1->date_start = '2016-02-11 17:30:00';
        $meeting1->date_end = '2016-02-11 17:30:00';
        $meeting1_id = $meeting1->save();

        $meeting2 = new Meeting();
        $meeting2->name = 'test2';
        $meeting2->assigned_user_id = '666';
        $meeting2->status = 'Not Held';
        $meeting2->type = 'Sugar';
        $meeting2->description = 'test description';
        $meeting2->duration_hours = 1;
        $meeting2->duration_minutes = 1;
        $meeting2->date_start = '2016-02-11 17:30:00';
        $meeting2->date_end = '2016-02-11 17:30:00';
        $meeting2_id = $meeting2->save();

        $meeting3 = new Meeting();
        $meeting3->name = 'test3';
        $meeting3->assigned_user_id = '666';
        $meeting3->status = 'Not Held';
        $meeting3->type = 'Sugar';
        $meeting3->description = 'test description';
        $meeting3->duration_hours = 1;
        $meeting3->duration_minutes = 1;
        $meeting3->date_start = '2016-02-11 17:30:00';
        $meeting3->date_end = '2016-02-11 17:30:00';
        $meeting3_id = $meeting3->save();


        // Give meeting 1 a gsync_id
        $sql = "UPDATE meetings SET gsync_id = 'valid_gsync_id' WHERE id = '{$meeting1_id}'";
        $res = $db->query($sql);
        $this->assertEquals(true, $res);

        // Give meetings 2 and 3 a duplicate gsync_id
        $sql = "UPDATE meetings SET gsync_id = 'duplicate_gsync_id' WHERE id = '{$meeting2_id}' OR id = '{$meeting3_id}'";
        $res = $db->query($sql);
        $this->assertEquals(true, $res);


        $return = $method->invoke($object, 'valid_gsync_id');
        $this->assertInstanceOf('Meeting', $return);
        $this->assertInstanceOf('SugarBean', $return);
        $this->assertEquals($meeting1_id, $return->id);

        $return = $method->invoke($object, 'duplicate_gsync_id');
        $this->assertEquals(false, $return);

        $return = $method->invoke($object, 'NOTHING_MATCHES');
        $this->assertEquals(null, $return);

        $state->popTable('meetings');
        $state->popTable('meetings_cstm');
        $state->popTable('vcals');
        $state->popTable('aod_indexevent');
    }

    public function testDelEvent()
    {

    }

    public function testPushPullSkip()
    {
        $method = self::$reflection->getMethod('pushPullSkip');
        $method->setAccessible(true);

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

        // The event needs a start time method to pass
        $startDateTime = new Google_Service_Calendar_EventDateTime;
        $startDateTime->setDateTime(date(DATE_ATOM, strtotime('2018-01-01 13:00:00 UTC')));
        $Google_Event->setStart($startDateTime);

        // Test with just an active Meeting. Should return 'push'
        $this->assertEquals('push', $method->invoke($object, $CRM_Meeting, null));

        // Test with just deleted Meeting. Should return 'skip'
        $CRM_Meeting->deleted = '1';
        $this->assertEquals('skip', $method->invoke($object, $CRM_Meeting, null));
        

        // Test with just an active Google Event. Should return 'pull'
        $this->assertEquals('pull', $method->invoke($object, null, $Google_Event));

        // Test with just a canceled Google Event. Should return 'skip'
        $Google_Event->status = 'cancelled';
        $this->assertEquals('skip', $method->invoke($object, null, $Google_Event));

        // Test compare both Meeting & Event, but both deleted. Should return 'skip'
        $this->assertEquals('skip', $method->invoke($object, $CRM_Meeting, $Google_Event));

        // Set records to active
        $CRM_Meeting->deleted = '0';
        $Google_Event->status = '';

        // Test with newer Meeting. Should return 'push'
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-02 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';
        $this->assertEquals('push', $method->invoke($object, $CRM_Meeting, $Google_Event));

        // Test with newer Google Event. Should return 'pull'
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-02 12:00:00 UTC';
        $this->assertEquals('pull', $method->invoke($object, $CRM_Meeting, $Google_Event));

        // Test with newer, deleted meeting. Should return 'push_delete'
        $CRM_Meeting->deleted = '1';
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-03 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-02 12:00:00 UTC');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';
        $this->assertEquals('push_delete', $method->invoke($object, $CRM_Meeting, $Google_Event));
        $CRM_Meeting->deleted = '0';

        // Test with newer, deleted Google Event Should return 'pull_delete'
        $Google_Event->status = 'cancelled';
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-02 12:00:00 UTC';
        $this->assertEquals('pull_delete', $method->invoke($object, $CRM_Meeting, $Google_Event));
        $Google_Event->status = '';

        // Set records to active
        $CRM_Meeting->deleted = '0';
        $Google_Event->status = '';

        // Test with synced event
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';
        $this->assertEquals('skip', $method->invoke($object, $CRM_Meeting, $Google_Event));

    }

    public function testSetUsersGoogleCalendar()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testCreateGoogleCalendarEvent()
    {
        $method = self::$reflection->getMethod('createGoogleCalendarEvent');
        $method->setAccessible(true);

        $setTimeZone = self::$reflection->getMethod('setTimeZone');
        $setTimeZone->setAccessible(true);
        
        $object = new GoogleSync();

        $setTimeZone->invoke($object, 'Etc/UTC');
        $testid = create_guid();

        // Create SuiteCRM Meeting Object
        $CRM_Meeting = new Meeting();

        $CRM_Meeting->id = $testid;
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';
        $CRM_Meeting->location = '123 Sesame Street';
        $CRM_Meeting->date_start = '2018-01-01 12:00:00';
        $CRM_Meeting->date_end = '2018-01-01 13:00:00';
        $CRM_Meeting->module_name = 'Meeting';

        $return = $method->invoke($object, $CRM_Meeting);

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
        $this->assertEquals($testid, $private['suitecrm_id']);
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
        $method = self::$reflection->getMethod('setTimezone');
        $method->setAccessible(true);
        $property = self::$reflection->getProperty('timezone');
        $property->setAccessible(true);

        $object = new GoogleSync();

        $expectedTimezone = 'Etc/GMT';

        $return = $method->invoke($object, $expectedTimezone);

        $this->assertTrue($return);
        $this->assertEquals($expectedTimezone, $property->getValue($object));
        $this->assertEquals($expectedTimezone, date_default_timezone_get());
    }

    public function testReturnExtendedProperties()
    {
        $method = self::$reflection->getMethod('returnExtendedProperties');
        $method->setAccessible(true);

        $object = new GoogleSync();

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
        $private['suitecrm_id'] = 'INVALID';
        $private['suitecrm_type'] = 'INVALID';
        $private['remain_unchanged'] = 'VALID';
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

        // Create SuiteCRM Meeting Object
        $CRM_Meeting = new Meeting();

        $CRM_Meeting->id = 'FAKE_MEETING_ID';
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';
        $CRM_Meeting->location = '123 Sesame Street';
        $CRM_Meeting->date_start = '2018-01-01 12:00:00';
        $CRM_Meeting->date_end = '2018-01-01 13:00:00';
        $CRM_Meeting->module_name = 'Meeting';

        $return = $method->invoke($object, $Google_Event, $CRM_Meeting);
        $returnPrivate = $return->getPrivate();

        $this->assertEquals('FAKE_MEETING_ID', $returnPrivate['suitecrm_id']);
        $this->assertEquals('Meeting', $returnPrivate['suitecrm_type']);
        $this->assertEquals('VALID', $returnPrivate['remain_unchanged']);
    }
}
