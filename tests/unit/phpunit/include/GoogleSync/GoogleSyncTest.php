<?php

use SuiteCRM\StateCheckerPHPUnitTestCaseAbstract;
use SuiteCRM\StateSaver;

require_once __DIR__ . '/../../../../../include/GoogleSync/GoogleSync.php';

class GoogleSyncTest extends StateCheckerPHPUnitTestCaseAbstract
{
    /** @var UnitTester */
    protected $tester;

    /** @var ReflectionClass */
    protected static $reflection;

    /** @var ReflectionProperty */
    protected static $dbProperty;
    
    /**
     * 
     * @param string $googleAuthJson
     * @return string
     */
    protected function getFakeSugarConfig($googleAuthJson) {
        return [
            'google_auth_json' => $this->getFakeGoogleAuthJson($googleAuthJson),
        ];
    }
    
    /**
     * 
     * @param string $googleAuthJson
     * @return string
     */
    protected function getFakeGoogleAuthJson($googleAuthJson) {
        return base64_encode($googleAuthJson);
    }

    public function setUp()
    {
        parent::setUp();

        // Use reflection to access private properties and methods
        if (self::$reflection === null) {
            self::$reflection = new ReflectionClass(GoogleSync::class);
            self::$dbProperty = self::$reflection->getProperty('db');
            self::$dbProperty->setAccessible(true);
        }
    }
    
    // GoogleSyncBase.php

    /**
     * 
     * 
     */
    public function test__construct()
    {

        // Set up object for testing
        
        // base64 encoded of {"web":"test"}
        $sugar_config['google_auth_json'] = 'eyJ3ZWIiOiJ0ZXN0In0=';

        // Set Log Level
        if (!empty($_SERVER['GSYNC_LOGLEVEL'])) {
            $expectedLogLevel = $_SERVER['GSYNC_LOGLEVEL'];
        } else {
            $_SERVER['GSYNC_LOGLEVEL'] = 'debug';
            $expectedLogLevel = 'debug';
        }

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

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

        // Test log level
        $actualLogLevel = LoggerManager::getLogLevel();
        $this->assertEquals($expectedLogLevel, $actualLogLevel);
    }

    /**
     * 
     * 
     */
    public function testGetAuthJson()
    {
        $state = new \SuiteCrm\StateSaver();
        $state->pushGlobals();

        $method = self::$reflection->getMethod('getAuthJson');
        $method->setAccessible(true);
    
        // Set up object for testing
        

        // base64 encoded of {"web":"test"}
        $sugar_config['google_auth_json'] = 'eyJ3ZWIiOiJ0ZXN0In0=';

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        $expectedAuthJson = json_decode(base64_decode('eyJ3ZWIiOiJ0ZXN0In0'), true);
        $actualAuthJson = $method->invoke($object, $this->getFakeSugarConfig('{"web":"test"}'));

        $this->assertEquals($expectedAuthJson, $actualAuthJson);
        $this->assertArrayHasKey('web', $actualAuthJson);

        // cleanup after test
        $state->popGlobals();

    }

    /**
     * 
     * 
     */
    public function testSetClient()
    {
        
        $method = self::$reflection->getMethod('setClient');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $method->invoke($object, null);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INVALID_CLIENT_ID, $e->getCode());
        }
        
    }

    public function testGetClient()
    {
        
        $method = self::$reflection->getMethod('getClient');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $method->invoke($object, null);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INVALID_CLIENT_ID, $e->getCode());
        }
    }

    /**
     * 
     * 
     */
    public function testGetGoogleClient()
    {
        
        $method = self::$reflection->getMethod('getGoogleClient');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test","client_id":"testID"'));
        try {
            $method->invoke($object, null);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals(0, $e->getCode(), 'It should throws an exception with code 0.');
            $this->assertEquals('invalid json token', $e->getMessage(), 'It should throws an exception with a proper message.');
        }
    }

    /**
     * 
     * 
     */
    public function testInitUserService()
    {
        
        $method = self::$reflection->getMethod('initUserService');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $method->invoke($object, null);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INVALID_CLIENT_ID, $e->getCode());
        }        
    }

    /**
     * 
     * 
     */
    public function testGetUserMeetings()
    {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('meetings');
        $state->pushTable('meetings_cstm');
        $state->pushTable('users');
        $state->pushTable('user_preferences');
        $state->pushTable('aod_indexevent');
        $state->pushTable('aod_index');
        $state->pushTable('vcals');
        $state->pushTable('tracker');
        
        

        // Create a User
        $user = new User();
        $user->last_name = 'UNIT_TESTS';
        $user->user_name = 'UNIT_TESTS';
        $user->save();

        // Create three meetings and save them to the DB for testing.
        $meeting1 = BeanFactory::getBean('Meetings');
        $meeting1->name = 'UNIT_TEST_1';
        $meeting1->assigned_user_id = $user->id;
        $meeting1->status = 'Not Held';
        $meeting1->type = 'Sugar';
        $meeting1->description = 'test description';
        $meeting1->duration_hours = 1;
        $meeting1->duration_minutes = 1;
        $meeting1->date_start = '2016-02-11 17:30:00';
        $meeting1->date_end = '2016-02-11 17:30:00';
        $meeting1->save();

        $meeting2 = BeanFactory::getBean('Meetings');
        $meeting2->name = 'UNIT_TEST_2';
        $meeting2->assigned_user_id = $user->id;
        $meeting2->status = 'Not Held';
        $meeting2->type = 'Sugar';
        $meeting2->description = 'test description';
        $meeting2->duration_hours = 1;
        $meeting2->duration_minutes = 1;
        $meeting2->date_start = '2016-02-11 17:30:00';
        $meeting2->date_end = '2016-02-11 17:30:00';
        $meeting2->save();

        $meeting3 = BeanFactory::getBean('Meetings');
        $meeting3->name = 'UNIT_TEST_3';
        $meeting3->assigned_user_id = $user->id;
        $meeting3->status = 'Not Held';
        $meeting3->type = 'Sugar';
        $meeting3->description = 'test description';
        $meeting3->duration_hours = 1;
        $meeting3->duration_minutes = 1;
        $meeting3->date_start = '2016-02-11 17:30:00';
        $meeting3->date_end = '2016-02-11 17:30:00';
        $meeting3->save();

        $method = self::$reflection->getMethod('getUserMeetings');
        $method->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        $return_count = $method->invoke($object, $user->id);

        // Test for invalid user id exception handling
        try {
            $return = $method->invoke($object, 'INVALID');
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INVALID_USER_ID, $e->getCode());
        }
        
        $this->assertEquals(3, count($return_count));

        // clean up after tests
        $state->popTable('meetings');
        $state->popTable('meetings_cstm');
        $state->popTable('users');
        $state->popTable('user_preferences');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
        $state->popTable('vcals');
        $state->popTable('tracker');

    }

    /**
     * 
     * 
     */
    public function testSetUsersGoogleCalendar()
    {
        
        $method = self::$reflection->getMethod('setUsersGoogleCalendar');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $method->invoke($object));
    }

    /**
     * 
     * 
     */
    public function testGetSuiteCRMCalendar()
    {
        
        $method = self::$reflection->getMethod('getSuiteCRMCalendar');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        $result = $method->invoke($object, new Google_Service_Calendar_CalendarList());
        $this->assertEquals(null, $result);
    }

    /**
     * 
     * 
     */
    public function testGetUserGoogleEvents()
    {
        
        $method = self::$reflection->getMethod('getUserGoogleEvents');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $method->invoke($object));
    }

    /**
     * 
     * 
     */
    public function testIsServiceExists()
    {
        
        $method = self::$reflection->getMethod('isServiceExists');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $method->invoke($object));
    }

    /**
     * 
     * 
     */
    public function testIsCalendarExists()
    {
        
        $method = self::$reflection->getMethod('isCalendarExists');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $method->invoke($object));
    }

    /**
     * 
     * 
     */
    public function testGetGoogleEventById()
    {
        
        $method = self::$reflection->getMethod('getGoogleEventById');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $method->invoke($object, null);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::EVENT_ID_IS_EMPTY, $e->getCode());
            $this->assertEquals('event ID is empty', $e->getMessage());
        }
        
    }

    /**
     * 
     * 
     */
    public function testGetMeetingByEventId()
    {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('meetings');
        $state->pushTable('meetings_cstm');
        $state->pushTable('vcals');
        $state->pushTable('aod_indexevent');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        

        $db = DBManagerFactory::getInstance();

        $method = self::$reflection->getMethod('getMeetingByEventId');
        $method->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        // Create three meetings and save them to the DB for testing.
        $meeting1 = BeanFactory::getBean('Meetings');
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

        $meeting2 = BeanFactory::getBean('Meetings');
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

        $meeting3 = BeanFactory::getBean('Meetings');
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
        
        $meetingWithValidGsyncId = BeanFactory::getBean('Meetings');
        $meetingWithValidGsyncId->gsync_id = 'valid_gsync_id';
        $meetingWithValidGsyncId->save();

        // --- separated test
        // Give meeting 1 a gsync_id
        $sql1 = "UPDATE meetings SET gsync_id = 'valid_gsync_id' WHERE id = '{$meeting1_id}'";
        $res1 = $db->query($sql1);
        $this->assertEquals(true, $res1);
        
        // --- separated test
        // Give meetings 2 and 3 a duplicate gsync_id
        $sql2 = "UPDATE meetings SET gsync_id = 'duplicate_gsync_id' WHERE id = '{$meeting2_id}' OR id = '{$meeting3_id}'";
        $res2 = $db->query($sql2);
        $this->assertEquals(true, $res2);
        
        // --- separated test
        try {
            $method->invoke($object, 'valid_gsync_id');
            $this->assertTrue(false);
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::AMBIGUOUS_MEETING_ID, $e->getCode());
        }

        // --- separated test
        try {
            $method->invoke($object, 'duplicate_gsync_id');
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e11) {
            $this->assertEquals(GoogleSyncException::AMBIGUOUS_MEETING_ID, $e->getCode());
            $this->assertEquals('More than one meeting matches Google Id!', $e11->getMessage());
        }

        // --- separated test
        $ret4 = $method->invoke($object, 'NOTHING_MATCHES');
        $this->assertNull($ret4);
        
        // cleanup after tests
        $state->popTable('meetings');
        $state->popTable('meetings_cstm');
        $state->popTable('vcals');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
        $state->popTable('tracker');
    }

    /**
     * 
     * 
     */
    public function testSetGService()
    {
        
        $method = self::$reflection->getMethod('setGService');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $method->invoke($object));
    }

    /**
     * 
     * 
     */
    public function testPushEvent()
    {
        
        $method = self::$reflection->getMethod('pushEvent');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        try {
            $method->invoke($object, BeanFactory::getBean('Meetings'), null);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::NO_GSERVICE_SET, $e->getCode());
        }
    }

    /**
     * 
     * 
     */
    public function testReturnExtendedProperties()
    {
        
        $method = self::$reflection->getMethod('returnExtendedProperties');
        $method->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

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
        $CRM_Meeting = BeanFactory::getBean('Meetings');

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

    /**
     * 
     * 
     */
    public function testPullEvent()
    {
        
        $method = self::$reflection->getMethod('pullEvent');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        
        try {
            $method->invoke($object, new Google_Service_Calendar_Event(), null);
            $this->assertTrue(false, 'It should throws an exception.');
        }
        catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::NO_REMOVE_EVENT_START_IS_NOT_SET, $e->getCode());
        }
    }

    /**
     * 
     * 
     */
    public function testDelMeeting()
    {
        
        $method = self::$reflection->getMethod('delMeeting');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        try {
            $method->invoke($object, BeanFactory::getBean('Meetings'));
            $this->assertTrue(false, 'It should throws an exception.');
        }
        catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INCORRECT_WORKING_USER_TYPE, $e->getCode());
        }
    }

    /**
     * 
     * 
     */
    public function testDelEvent()
    {
        
        $method = self::$reflection->getMethod('delEvent');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        $ret = $method->invoke($object, new Google_Service_Calendar_Event(), null);
        $this->assertFalse($ret);

        // --- separated test
        $Google_Event = new Google_Service_Calendar_Event();
        $Google_Event->setSummary('Unit Test Event');
        $Google_Event->setDescription('Unit Test Event');
        $this->assertEquals(false, $method->invoke($object, $Google_Event, '1234567890'));
    }

    /**
     * 
     * 
     */
    public function testClearPopups()
    {
        
        $method = self::$reflection->getMethod('clearPopups');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $method->invoke($object, null));
    }

    /**
     * 
     * 
     */
    public function testUpdateSuitecrmMeetingEvent()
    {
       // This is tested by testCreateSuitecrmMeetingEvent, Since that method calls it.
    }

    /**
     * 
     * 
     */
    public function testCreateSuitecrmMeetingEvent()
    {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('reminders');
        $state->pushTable('reminders_invitees');
        $state->pushTable('tracker');
        
        

        $method = self::$reflection->getMethod('createSuitecrmMeetingEvent');
        $method->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

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
        $this->assertEquals('2018-01-01 01:00:00', $return->date_start);
        $this->assertEquals('2018-01-01 02:00:00', $return->date_end);
        $this->assertEquals('1', $return->duration_hours);
        $this->assertEquals('0', $return->duration_minutes);
        $this->assertEquals('FAKEUSER', $return->assigned_user_id);

        // clean up after test
        $state->popTable('reminders');
        $state->popTable('reminders_invitees');
        $state->popTable('tracker');
    }

    public function testUpdateGoogleCalendarEvent()
    {
        // This is covered by testCreateGoogleCalendarEvent since is calls this
    }

    /**
     * 
     * 
     */
    public function testCreateGoogleCalendarEvent()
    {
        
        
        $method = self::$reflection->getMethod('createGoogleCalendarEvent');
        $method->setAccessible(true);

        $setTimeZone = self::$reflection->getMethod('setTimeZone');
        $setTimeZone->setAccessible(true);
        
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        $setTimeZone->invoke($object, 'Etc/UTC');
        $testid = create_guid();

        $timedate = new TimeDate;
        $startTime = $timedate->to_display_date_time('2018-01-01 12:00:00');
        $endTime = $timedate->to_display_date_time('2018-01-01 13:00:00');

        // Create SuiteCRM Meeting Object
        $CRM_Meeting = BeanFactory::getBean('Meetings');

        $CRM_Meeting->id = $testid;
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';
        $CRM_Meeting->location = '123 Sesame Street';
        $CRM_Meeting->date_start = $startTime;
        $CRM_Meeting->date_end = $endTime;
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

    /**
     * 
     * 
     */
    public function testSetTimezone()
    {
        
        
        $method = self::$reflection->getMethod('setTimezone');
        $method->setAccessible(true);
        $property = self::$reflection->getProperty('timezone');
        $property->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        $expectedTimezone = 'Etc/GMT';

        $return = $method->invoke($object, $expectedTimezone);

        $this->assertTrue($return);
        $this->assertEquals($expectedTimezone, $property->getValue($object));
        $this->assertEquals($expectedTimezone, date_default_timezone_get());
    }

    /**
     * 
     * 
     */
    public function testSetLastSync()
    {
        
        
        $method = self::$reflection->getMethod('setLastSync');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        try {
            $method->invoke($object, BeanFactory::getBean('Meetings'), null);
            $this->assertTrue(false, 'It should throws an exception.');
        }
        catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INCORRECT_WORKING_USER_TYPE, $e->getCode());
        }
        
    }

    // GoogleSync.php

    /**
     * 
     * 
     */
    public function testGetTitle()
    {
        
        
        $method = self::$reflection->getMethod('getTitle');
        $method->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        // Create SuiteCRM Meeting Object
        $CRM_Meeting = BeanFactory::getBean('Meetings');

        $CRM_Meeting->id = create_guid();
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';

        // Create Google Event Object
        $Google_Event = new Google_Service_Calendar_Event();

        $Google_Event->setSummary('Unit Test Event');
        $Google_Event->setDescription('Unit Test Event');

        $this->assertEquals('Unit Test Event / Unit Test Event', $method->invoke($object, $CRM_Meeting, $Google_Event));
        $this->assertEquals('Unit Test Event', $method->invoke($object, $CRM_Meeting, null));
        $this->assertEquals('Unit Test Event', $method->invoke($object, null, $Google_Event));
        $this->assertEquals('Unit Test Event', $method->invoke($object, $CRM_Meeting, null));
        $this->assertEquals('UNNAMED RECORD', $method->invoke($object, null, null));
    }

    /**
     * 
     * 
     */
    public function testDoAction()
    {
        
        
        $method = self::$reflection->getMethod('doAction');
        $method->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        try {
            $method->invoke($object, 'INVALID');
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INVALID_ACTION, $e->getCode());
        }
        
        
        try {
            $method->invoke($object, 'push');
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true, 'It should be an InvalidArgumentException as a first parameter of GoogleSyncBase::pushEvent() should be an instance of meeting but this test implacate that it is null.');
        }

        
        try {
            $method->invoke($object, 'pull');
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true, 'It should be an InvalidArgumentException as a first parameter of GoogleSyncBase::pullEvent() should be an instance of Google_Service_Calendar_Event but this test implacate that it is null.');
        }

        $CRM_Meeting = BeanFactory::getBean('Meetings');
        $CRM_Meeting->id = 'NOTHINGHERE';
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';

        
        try {
            $method->invoke($object, 'push_delete', $CRM_Meeting, null);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true, 'It should be an InvalidArgumentException as a first parameter of GoogleSyncBase::delEvent() should be an instance of Google_Service_Calendar_Event but this test implacate that it is null.');
        }

        
        try {
            $method->invoke($object, 'pull_delete');
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true, 'It should be an InvalidArgumentException as a first parameter of GoogleSyncBase::delMeeting() should be an instance of Meeting but this test implacate that it is null.');
        }

        $return = $method->invoke($object, 'skip');
        $this->assertEquals(true, $return);

    }

    /**
     * 
     * 
     */
    public function testDoSync()
    {
        
        
        $method = self::$reflection->getMethod('doSync');
        $method->setAccessible(true);
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $method->invoke($object, null);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INVALID_CLIENT_ID, $e->getCode());
        }
        
    }

    /**
     * 
     * 
     */
    public function testAddUser()
    {
        
        
        $method = self::$reflection->getMethod('addUser');
        $method->setAccessible(true);

        $property = self::$reflection->getProperty('users');
        $property->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        $return = $method->invoke($object, 'ABC123', 'End User');

        $this->assertTrue($return);
        $this->assertArrayHasKey('ABC123', $property->getValue($object));

    }

    /**
     * 
     * 
     */
    public function testPushPullSkip()
    {
        $method = self::$reflection->getMethod('pushPullSkip');
        $method->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        // Create SuiteCRM Meeting Object
        $CRM_Meeting = BeanFactory::getBean('Meetings');

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

    /**
     * 
     * 
     */
    public function testSetSyncUsers()
    {
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('user_preferences');

        $method = self::$reflection->getMethod('setSyncUsers');
        $method->setAccessible(true);

        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));

        // base64 encoded of {"web":"test"}
        $json = 'eyJ3ZWIiOiJ0ZXN0In0=';

        $user1 = new User();
        $user1->last_name = 'UNIT_TESTS1';
        $user1->user_name = 'UNIT_TESTS1';
        $user1->full_name = 'UNIT_TESTS1';
        $user1->save(false);
        $user1->setPreference('GoogleApiToken', $json, false, 'GoogleSync');
        $user1->setPreference('syncGCal', 1, 0, 'GoogleSync');
        $user1->savePreferencesToDB();

        $user2 = new User();
        $user2->last_name = 'UNIT_TESTS2';
        $user2->user_name = 'UNIT_TESTS2';
        $user2->full_name = 'UNIT_TESTS2';
        $user2->save(false);
        $user2->setPreference('GoogleApiToken', $json, false, 'GoogleSync');
        $user2->setPreference('syncGCal', 1, 0, 'GoogleSync');
        $user2->savePreferencesToDB();

        $countOfSyncUsers = $method->invoke($object);

        $this->assertGreaterThanOrEqual(0, $countOfSyncUsers); // TODO: check how many user should be counted!?

        // clean up after tests
        $state->popTable('users');
        $state->popTable('user_preferences');
    }

    /**
     * 
     * 
     */
    public function testSyncAllUsers()
    {
        $object = new GoogleSync($this->getFakeSugarConfig('{"web":"test"}'));
        $ret = $object->syncAllUsers();

        $this->assertEquals(true, $ret);
    }

    //GoogleSyncHelper.php

    /**
     * 
     * 
     */
    public function testSingleEventAction()
    {
        $helper = new GoogleSyncHelper;

        $ret1 = $helper->singleEventAction(null, null);
        $this->assertEquals(false, $ret1);
        // The rest of this method is tested by testPushPullSkip
    }

    /**
     * 
     * 
     */
    public function testGetTimeStrings()
    {
        $helper = new GoogleSyncHelper;

        // Create SuiteCRM Meeting Object
        $CRM_Meeting = BeanFactory::getBean('Meetings');

        $CRM_Meeting->id = create_guid();
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';

        // Create Google Event Object
        $Google_Event = new Google_Service_Calendar_Event();

        $Google_Event->setSummary('Unit Test Event');
        $Google_Event->setDescription('Unit Test Event');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';

        // The event needs a start time method to pass
        $startDateTime = new Google_Service_Calendar_EventDateTime;
        $startDateTime->setDateTime(date(DATE_ATOM, strtotime('2018-01-01 12:00:00 UTC')));
        $Google_Event->setStart($startDateTime);

        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 12:00:00 UTC');

        $ret = $helper->getTimeStrings($CRM_Meeting, $Google_Event);

        $this->assertEquals('1514808000', $ret['gModified']);
        $this->assertEquals('1514808000', $ret['sModified']);
        $this->assertEquals('1514808000', $ret['lastSync']);
    }

    /**
     * 
     * 
     */
    public function testGetNewestMeetingResponse()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

    /**
     * 
     * 
     */
    public function testCreateSuitecrmReminders()
    {
        $this->markTestIncomplete('TODO: Implement Tests');
    }

}
