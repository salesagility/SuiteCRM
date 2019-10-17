<?php

use SuiteCRM\StateCheckerPHPUnitTestCaseAbstract;
use SuiteCRM\StateSaver;
use SuiteCRM\Utility\SuiteValidator;

require_once __DIR__ . '/../../../../../include/GoogleSync/GoogleSync.php';
require_once __DIR__ . '/GoogleSyncMock.php';

class GoogleSyncTest extends StateCheckerPHPUnitTestCaseAbstract
{
    /** @var UnitTester */
    protected $tester;
    
    /**
     *
     * @var StateSaver
     */
    protected $state;
    
    protected function setUp()
    {
        parent::setUp();
        $this->state = new StateSaver();
        $this->state->pushGlobals();
        $this->state->pushTable('aod_indexevent');
        $this->state->pushTable('meetings');
        $this->state->pushTable('meetings_cstm');
        $this->state->pushTable('vcals');
        $this->state->pushTable('aod_index');
        $this->state->pushTable('users');
        $this->state->pushTable('user_preferences');
        $this->state->pushTable('reminders');
        $this->state->pushTable('reminders_invitees');
    }
    
    protected function tearDown()
    {
        $this->state->popTable('reminders_invitees');
        $this->state->popTable('reminders');
        $this->state->popTable('user_preferences');
        $this->state->popTable('users');
        $this->state->popTable('aod_index');
        $this->state->popTable('vcals');
        $this->state->popTable('meetings_cstm');
        $this->state->popTable('meetings');
        $this->state->popTable('aod_indexevent');
        $this->state->popGlobals();
        parent::tearDown();
    }
    
    /**
     *
     * @param string $googleAuthJson
     * @return string
     */
    protected function getFakeSugarConfig($googleAuthJson = null)
    {
        return [
            'google_auth_json' => $this->getFakeGoogleAuthJson($googleAuthJson),
        ];
    }
    
    /**
     *
     * @param string $googleAuthJson
     * @return string
     */
    protected function getFakeGoogleAuthJson($googleAuthJson)
    {
        return base64_encode($googleAuthJson);
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

        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        // Test GoogleSync::timezone
        $timezone = $object->getProperty('timezone');
        $this->assertNotEmpty($timezone);
        $this->assertEquals("string", gettype($timezone));

        // Test GoogleSync::authJson
        $authJson = $object->getProperty('authJson');
        $this->assertNotEmpty($authJson);
        $this->assertEquals("array", gettype($authJson));

        // Test GoogleSync::db
        $expectedClass = DBManager::class;
        $actualClass = $object->getProperty('db');
        $this->assertInstanceOf($expectedClass, $actualClass);
    }

    /**
     *
     *
     */
    public function testGetAuthJson()
    {
        $state = new \SuiteCrm\StateSaver();
        $state->pushGlobals();

    
        // base64 encoded of {"web":"test"}
        $sugar_config['google_auth_json'] = 'eyJ3ZWIiOiJ0ZXN0In0=';

        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        $expectedAuthJson = json_decode(base64_decode('eyJ3ZWIiOiJ0ZXN0In0'), true);
        $actualAuthJson = $object->callMethod('getAuthJson', [$this->getFakeSugarConfig('{"web":"test"}')]);

        $this->assertEquals($expectedAuthJson, $actualAuthJson);
        $this->assertArrayHasKey('web', $actualAuthJson);

        try {
            $object->callMethod('getAuthJson', [['google_auth_json' => 'INVALID']]);
            $this->assertTrue(false);
        } catch (GoogleSyncException $e) {
            $this->assertTrue(true);
            $this->assertEquals(GoogleSyncException::JSON_CORRUPT, $e->getCode());
        }

        try {
            $object->callMethod('getAuthJson', [$this->getFakeSugarConfig('{"foo":"bar"}')]);
            $this->assertTrue(false);
        } catch (GoogleSyncException $e) {
            $this->assertTrue(true);
            $this->assertEquals(GoogleSyncException::JSON_KEY_MISSING, $e->getCode());
        }

        $ret = $object->callMethod('getAuthJson', [null]);
        $this->assertFalse($ret);
        
        // cleanup after test
        $state->popGlobals();
    }

    /**
     *
     *
     */
    public function testSetClient()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $object->callMethod('setClient', [null]);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INVALID_CLIENT_ID, $e->getCode());
        }
    }

    public function testGetClient()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $object->callMethod('getClient', [null]);
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
        try {
            $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test","client_id":"testID"'));
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::JSON_CORRUPT, $e->getCode(), 'It should throws an exception with code 0.');
            $this->assertEquals('google_auth_json not vaild json', $e->getMessage(), 'It should throws an exception with a proper message.');
        }
        
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test","client_id":"testID"}'));
        try {
            $object->callMethod('getGoogleClient', [null]);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::ACCSESS_TOKEN_PARAMETER_MISSING, $e->getCode(), 'It should throws an exception with code 0.');
            $this->assertEquals('Access Token Parameter Missing', $e->getMessage(), 'It should throws an exception with a proper message.');
        }
    }

    /**
     *
     *
     */
    public function testInitUserService()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $object->callMethod('initUserService', [null]);
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
        $state = new StateSaver();
        $state->pushTable('meetings');
        $state->pushTable('meetings_cstm');
        $state->pushTable('users');
        $state->pushTable('user_preferences');
        $state->pushTable('aod_indexevent');
        $state->pushTable('aod_index');
        $state->pushTable('vcals');
        $state->pushTable('tracker');
        
        

        // Create a User
        $user = BeanFactory::getBean('Users');
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

        

        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        $return_count = $object->callMethod('getUserMeetings', [$user->id]);

        // Test for invalid user id exception handling
        try {
            $return = $object->callMethod('getUserMeetings', ['INVALID']);
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
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $object->callMethod('setUsersGoogleCalendar'));
    }

    /**
     *
     *
     */
    public function testGetSuiteCRMCalendar()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        $result = $object->callMethod('getSuiteCRMCalendar', [new Google_Service_Calendar_CalendarList()]);
        $this->assertEquals(null, $result);
    }

    /**
     *
     *
     */
    public function testGetUserGoogleEvents()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $object->callMethod('getUserGoogleEvents'));
    }

    /**
     *
     *
     */
    public function testIsServiceExists()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $object->callMethod('isServiceExists'));
    }

    /**
     *
     *
     */
    public function testIsCalendarExists()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        $this->assertEquals(false, $object->callMethod('isCalendarExists'));
    }

    /**
     *
     *
     */
    public function testGetGoogleEventById()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $object->callMethod('getGoogleEventById', [null]);
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
        $state = new StateSaver();
        $state->pushTable('meetings');
        $state->pushTable('meetings_cstm');
        $state->pushTable('vcals');
        $state->pushTable('aod_indexevent');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        

        $db = DBManagerFactory::getInstance();


        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

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
        $meeting = $object->callMethod('getMeetingByEventId', ['valid_gsync_id']);
        $this->assertEquals($meeting1_id, $meeting->id);

        // --- separated test
        try {
            $object->callMethod('getMeetingByEventId', ['duplicate_gsync_id']);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e11) {
            $this->assertEquals(GoogleSyncException::AMBIGUOUS_MEETING_ID, $e11->getCode());
            $this->assertEquals('More than one meeting matches Google Id!', $e11->getMessage());
        }

        // --- separated test
        $ret4 = $object->callMethod('getMeetingByEventId', ['NOTHING_MATCHES']);
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
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $object->callMethod('setGService');
            $this->assertTrue(false);
        } catch (GoogleSyncException $e) {
            $this->assertTrue(true);
            $this->assertEquals(GoogleSyncException::NO_GCLIENT_SET, $e->getCode());
        }
    }

    /**
     *
     *
     */
    public function testPushEvent()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        try {
            $object->callMethod('pushEvent', [BeanFactory::getBean('Meetings'), null]);
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
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

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

        $return = $object->callMethod('returnExtendedProperties', [$Google_Event, $CRM_Meeting]);
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
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
   
        try {
            $object->callMethod('pullEvent', [new Google_Service_Calendar_Event(), null]);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::NO_REMOVE_EVENT_START_IS_NOT_SET, $e->getCode());
        }
    }

    /**
     *
     *
     */
    public function testDelMeeting()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        try {
            $object->callMethod('delMeeting', [BeanFactory::getBean('Meetings')]);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INCORRECT_WORKING_USER_TYPE, $e->getCode());
        }
    }

    /**
     *
     *
     */
    public function testDelEvent()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        try {
            $object->callMethod('delEvent', [new Google_Service_Calendar_Event(), null]);
            $this->assertTrue(false);
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::NO_GSERVICE_SET, $e->getCode());
        }
        

        // --- separated test
        $Google_Event = new Google_Service_Calendar_Event();
        $Google_Event->setSummary('Unit Test Event');
        $Google_Event->setDescription('Unit Test Event');
        
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        $object->setProperty('gService', true);
        
        try {
            $object->callMethod('delEvent', [new Google_Service_Calendar_Event(), null]);
            
            $this->assertTrue(false, 'It should throw an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::MEETING_ID_IS_EMPTY, $e->getCode());
        }
        // -- another test
        try {
            $object->callMethod('delEvent', [$Google_Event, 'INVALID_ID']);
            $this->assertTrue(false, 'It should throw an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::RECORD_VALIDATION_FAILURE, $e->getCode());
        }
    }

    /**
     *
     *
     */
    public function testClearPopups()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $object->callMethod('clearPopups', [null]);
            $this->assertTrue(false, 'It should throw an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true);
            $this->assertEquals(0, $e->getCode());
        }
        $ret = $object->callMethod('clearPopups', '123456');
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
        $state = new StateSaver();
        $state->pushTable('reminders');
        $state->pushTable('reminders_invitees');
        $state->pushTable('tracker');
        
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

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
        $user = BeanFactory::getBean('Users');
        $user->id = 'FAKEUSER';
        $object->setProperty('workingUser', $user);

        $return = $object->callMethod('createSuitecrmMeetingEvent', [$Google_Event]);

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
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        $ret = $object->callMethod('setTimeZone', ['Etc/UTC']);
        $this->assertTrue($ret);
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

        $return = $object->callMethod('createGoogleCalendarEvent', [$CRM_Meeting]);

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
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        $property = $object->getProperty('timezone');
        $this->assertEquals('Etc/UTC', $property);

        $expectedTimezone = 'Etc/GMT';

        $return = $object->callMethod('setTimezone', [$expectedTimezone]);
        $property = $object->getProperty('timezone');

        $this->assertTrue($return);
        $this->assertEquals($expectedTimezone, $property);
        $this->assertEquals($expectedTimezone, date_default_timezone_get());
    }

    /**
     *
     *
     */
    public function testSetLastSync()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        try {
            $object->callMethod('setLastSync', [BeanFactory::getBean('Meetings'), null]);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
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
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        // Create SuiteCRM Meeting Object
        $CRM_Meeting = BeanFactory::getBean('Meetings');

        $CRM_Meeting->id = create_guid();
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';

        // Create Google Event Object
        $Google_Event = new Google_Service_Calendar_Event();

        $Google_Event->setSummary('Unit Test Event');
        $Google_Event->setDescription('Unit Test Event');

        $this->assertEquals('Unit Test Event / Unit Test Event', $object->callMethod('getTitle', [$CRM_Meeting, $Google_Event]));
        $this->assertEquals('Unit Test Event', $object->callMethod('getTitle', [$CRM_Meeting, null]));
        $this->assertEquals('Unit Test Event', $object->callMethod('getTitle', [null, $Google_Event]));
        $this->assertEquals('Unit Test Event', $object->callMethod('getTitle', [$CRM_Meeting, null]));
        $this->assertEquals('UNNAMED RECORD', $object->callMethod('getTitle', [null, null]));
    }

    /**
     *
     *
     */
    public function testDoAction()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

        try {
            $object->callMethod('doAction', ['INVALID']);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (GoogleSyncException $e) {
            $this->assertEquals(GoogleSyncException::INVALID_ACTION, $e->getCode());
        }
        
        
        try {
            $object->callMethod('doAction', ['push']);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true, 'It should be an InvalidArgumentException as a first parameter of GoogleSyncBase::pushEvent() should be an instance of meeting but this test implacate that it is null.');
        }

        
        try {
            $object->callMethod('doAction', ['pull']);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true, 'It should be an InvalidArgumentException as a first parameter of GoogleSyncBase::pullEvent() should be an instance of Google_Service_Calendar_Event but this test implacate that it is null.');
        }

        $CRM_Meeting = BeanFactory::getBean('Meetings');
        $CRM_Meeting->id = 'NOTHINGHERE';
        $CRM_Meeting->name = 'Unit Test Event';
        $CRM_Meeting->description = 'Unit Test Event';

        
        try {
            $object->callMethod('doAction', ['push_delete', $CRM_Meeting, null]);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true, 'It should be an InvalidArgumentException as a first parameter of GoogleSyncBase::delEvent() should be an instance of Google_Service_Calendar_Event but this test implacate that it is null.');
        }

        
        try {
            $object->callMethod('doAction', ['pull_delete']);
            $this->assertTrue(false, 'It should throws an exception.');
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true, 'It should be an InvalidArgumentException as a first parameter of GoogleSyncBase::delMeeting() should be an instance of Meeting but this test implacate that it is null.');
        }

        $return = $object->callMethod('doAction', ['skip']);
        $this->assertEquals(true, $return);
    }

    /**
     *
     *
     */
    public function testDoSync()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        try {
            $object->callMethod('doSync', [null]);
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
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        $return = $object->callMethod('addUser', ['ABC123', 'End User']);

        $this->assertTrue($return);
        $this->assertArrayHasKey('ABC123', $object->getProperty('users'));
    }

    /**
     *
     *
     */
    public function testPushPullSkip()
    {
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));

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
        $this->assertEquals('push', $object->callMethod('pushPullSkip', [$CRM_Meeting, null]));

        // Test with just deleted Meeting. Should return 'skip'
        $CRM_Meeting->deleted = '1';
        $this->assertEquals('skip', $object->callMethod('pushPullSkip', [$CRM_Meeting, null]));
        

        // Test with just an active Google Event. Should return 'pull'
        $this->assertEquals('pull', $object->callMethod('pushPullSkip', [null, $Google_Event]));

        // Test with just a canceled Google Event. Should return 'skip'
        $Google_Event->status = 'cancelled';
        $this->assertEquals('skip', $object->callMethod('pushPullSkip', [null, $Google_Event]));

        // Test compare both Meeting & Event, but both deleted. Should return 'skip'
        $this->assertEquals('skip', $object->callMethod('pushPullSkip', [$CRM_Meeting, $Google_Event]));

        // Set records to active
        $CRM_Meeting->deleted = '0';
        $Google_Event->status = '';

        // Test with newer Meeting. Should return 'push'
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-02 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';
        $this->assertEquals('push', $object->callMethod('pushPullSkip', [$CRM_Meeting, $Google_Event]));

        // Test with newer Google Event. Should return 'pull'
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-02 12:00:00 UTC';
        $this->assertEquals('pull', $object->callMethod('pushPullSkip', [$CRM_Meeting, $Google_Event]));

        // Test with newer, deleted meeting. Should return 'push_delete'
        $CRM_Meeting->deleted = '1';
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-03 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-02 12:00:00 UTC');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';
        $this->assertEquals('push_delete', $object->callMethod('pushPullSkip', [$CRM_Meeting, $Google_Event]));
        $CRM_Meeting->deleted = '0';

        // Test with newer, deleted Google Event Should return 'pull_delete'
        $Google_Event->status = 'cancelled';
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-02 12:00:00 UTC';
        $this->assertEquals('pull_delete', $object->callMethod('pushPullSkip', [$CRM_Meeting, $Google_Event]));
        $Google_Event->status = '';

        // Set records to active
        $CRM_Meeting->deleted = '0';
        $Google_Event->status = '';

        // Test with synced event
        $CRM_Meeting->fetched_row['date_modified'] = '2018-01-01 12:00:00';
        $CRM_Meeting->fetched_row['gsync_lastsync'] = strtotime('2018-01-01 13:00:00 UTC');
        $Google_Event->updated = '2018-01-01 12:00:00 UTC';
        $this->assertEquals('skip', $object->callMethod('pushPullSkip', [$CRM_Meeting, $Google_Event]));
    }

    /**
     *
     *
     */
    public function testSetSyncUsers()
    {
        $state = new StateSaver();
        $state->pushTable('users');
        $state->pushTable('user_preferences');


        // base64 encoded of {"web":"test"}
        $json = 'eyJ3ZWIiOiJ0ZXN0In0=';
        
        
        
        $query = "SELECT COUNT(*) AS cnt FROM users";
        $db = DBManagerFactory::getInstance();
        $results = $db->query($query);
        while ($row = $db->fetchByAssoc($results)) {
            $cnt = $row['cnt'];
            break;
        }
        $this->assertEquals(1, $cnt);

        $user1 = BeanFactory::getBean('Users');
        $user1->last_name = 'UNIT_TESTS1';
        $user1->user_name = 'UNIT_TESTS1';
        $user1->full_name = 'UNIT_TESTS1';
        $user1->save(false);
        $validator = new SuiteValidator();
        $this->assertTrue($validator->isValidId($id1 = $user1->id));
        $user1->setPreference('GoogleApiToken', $json, false, 'GoogleSync');
        $user1->setPreference('syncGCal', 1, 0, 'GoogleSync');
        $user1->savePreferencesToDB();
        
        
        $query = "SELECT COUNT(*) AS cnt FROM users";
        $db = DBManagerFactory::getInstance();
        $results = $db->query($query);
        while ($row = $db->fetchByAssoc($results)) {
            $cnt = $row['cnt'];
            break;
        }
        $this->assertEquals(2, $cnt);

        $user2 = BeanFactory::getBean('Users');
        $user2->last_name = 'UNIT_TESTS2';
        $user2->user_name = 'UNIT_TESTS2';
        $user2->full_name = 'UNIT_TESTS2';
        $user2->save(false);
        $this->assertTrue($validator->isValidId($id2 = $user2->id));
        $user2->setPreference('GoogleApiToken', $json, false, 'GoogleSync');
        $user2->setPreference('syncGCal', 1, 0, 'GoogleSync');
        $user2->savePreferencesToDB();
        
        $this->assertNotSame($id1, $id2);
        
        $query = "SELECT COUNT(*) AS cnt FROM users";
        $db = DBManagerFactory::getInstance();
        $results = $db->query($query);
        while ($row = $db->fetchByAssoc($results)) {
            $cnt = $row['cnt'];
            break;
        }
        $this->assertEquals(3, $cnt);

        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        $tempData = [];
        $countOfSyncUsers = $object->callMethod('setSyncUsers', [&$tempData]);
        $this->assertSame([
            'founds' => 3,
            'results' => [
                ['notEmpty' => false],
                [
                    'syncPref' => 1,
                    'decoded' => true,
                    'notEmpty' => true,
                    'added' => true,
                ],
                [
                    'syncPref' => 1,
                    'decoded' => true,
                    'notEmpty' => true,
                    'added' => true,
                ],
            ],
        ], $tempData);

        $this->assertGreaterThanOrEqual(2, $countOfSyncUsers); // TODO: check how many user should be counted!?

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
        $object = new GoogleSyncMock($this->getFakeSugarConfig('{"web":"test"}'));
        $ret = $object->syncAllUsers();
        // TODO: it needs more test
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
//        $this->markTestIncomplete('TODO: Implement Tests');
    }

    /**
     *
     *
     */
    public function testCreateSuitecrmReminders()
    {
//        $this->markTestIncomplete('TODO: Implement Tests');
    }

    /**
     *
     *
     */
    public function testWipeLocalSyncData()
    {
        $state = new StateSaver();
        $state->pushTable('meetings');
        $state->pushTable('meetings_cstm');
        $state->pushTable('users');
        $state->pushTable('user_preferences');
        $state->pushTable('aod_indexevent');
        $state->pushTable('aod_index');
        $state->pushTable('vcals');
        $state->pushTable('tracker');

        // Create a User
        $user = BeanFactory::getBean('Users');
        $user->last_name = 'UNIT_TESTS';
        $user->user_name = 'UNIT_TESTS';
        $user->save();

        // Create a meeting with gsync fields populated and save it to the DB for testing.
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
        $meeting1->gsync_id = 'GSYNCID';
        $meeting1->gsync_lastsync = '1234567890';
        $meeting_id = $meeting1->save();

        // Get a DB object
        $db = DBManagerFactory::getInstance();

        // Make sure the values we set are saved in the DB
        $query = "SELECT gsync_id, gsync_lastsync FROM meetings WHERE id = {$db->quoted($meeting_id)}";
        $result = $db->query($query);
        $row = $db->fetchByAssoc($result);
        $this->assertEquals('GSYNCID', $row['gsync_id']);
        $this->assertEquals('1234567890', $row['gsync_lastsync']);

        // Call the tested function to wipe the gsync data
        $helper = new GoogleSyncHelper;
        $helper->wipeLocalSyncData($user->id);

        // Check the raw DB values
        $result = $db->query($query);
        $row = $db->fetchByAssoc($result);
        $this->assertEquals('', $row['gsync_id']);
        $this->assertEquals('', $row['gsync_lastsync']);

        $state->popTable('meetings');
        $state->popTable('meetings_cstm');
        $state->popTable('users');
        $state->popTable('user_preferences');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
        $state->popTable('vcals');
        $state->popTable('tracker');
    }
}
