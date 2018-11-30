<?php

require_once 'include/SugarQueue/SugarJobQueue.php';
require_once 'install/install_utils.php';

class SchedulerTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function test__construct()
    {

        //execute the contructor and check for the Object type and  attributes
        $scheduler = new Scheduler();

        $this->assertInstanceOf('Scheduler', $scheduler);
        $this->assertInstanceOf('SugarBean', $scheduler);

        $this->assertAttributeEquals('schedulers', 'table_name', $scheduler);
        $this->assertAttributeEquals('Schedulers', 'module_dir', $scheduler);
        $this->assertAttributeEquals('Scheduler', 'object_name', $scheduler);

        $this->assertAttributeEquals(true, 'new_schema', $scheduler);
        $this->assertAttributeEquals(true, 'process_save_dates', $scheduler);
    }

    public function testinitUser()
    {
        $user = Scheduler::initUser();
        $this->assertInstanceOf('User', $user);
    }

    public function testfireQualified()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $scheduler = new Scheduler();

        //test without setting any attributes
        $result = $scheduler->fireQualified();
        $this->assertEquals(false, $result);

        //test with required attributes set
        $scheduler->id = 1;
        $scheduler->job_interval = '0::3::*::*::*';
        $scheduler->date_time_start = '2015-01-01 10:30:01';

        $result = $scheduler->fireQualified();
        $this->assertEquals(true, $result);
        
        // clean up
    }

    public function testcreateJob()
    {
        $scheduler = new Scheduler();
        $result = $scheduler->createJob();

        $this->assertInstanceOf('SchedulersJob', $result);
    }

    public function testcheckPendingJobs()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('job_queue');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $scheduler = new Scheduler();

        //execute the method and test if it works and does not throws an exception.
        try {
            $scheduler->checkPendingJobs(new SugarJobQueue());
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
        $state->popTable('job_queue');
    }

    public function testderiveDBDateTimes()
    {
        $this->markTestIncomplete('Need to implement!');

//        $scheduler = new Scheduler();
//
//        $scheduler->id = 1;
//        $scheduler->date_time_start = '2016-01-01 10:30:01';
//
//        //execute the method with different job intervals
//
//        $scheduler->job_interval = '0::3::3::*::*';
//        $result = $scheduler->deriveDBDateTimes($scheduler);
//        $this->assertEquals(false, (bool)$result);
//
//        // NOTE: add this valid test case:
//        //$scheduler->job_interval = '*::*::*::*::3';
//        //$result = $scheduler->deriveDBDateTimes($scheduler);
//        //$this->assertEquals(false, (bool)$result);
//
//        $scheduler->job_interval = '0::*::3::*::*';
//        $result = $scheduler->deriveDBDateTimes($scheduler);
//        $this->assertEquals(false, (bool)$result);
    }

    public function testhandleIntervalType()
    {
        $scheduler = new Scheduler();

        //execute the method with different job intervals

        $this->assertEquals('', $scheduler->handleIntervalType('0', '0', '2', '2'));
        $this->assertEquals('00:02', $scheduler->handleIntervalType('1', '0', '2', '2'));
        $this->assertEquals('30th', $scheduler->handleIntervalType('2', '0', '2', '2'));
        $this->assertEquals('December', $scheduler->handleIntervalType('3', '0', '2', '2'));
        $this->assertEquals('', $scheduler->handleIntervalType('4', '0', '2', '2'));
    }

    public function testsetIntervalHumanReadable()
    {
        $scheduler = new Scheduler();

        //execute the method with different job intervals

        $scheduler->job_interval = '0::3::3::*::*';
        $scheduler->parseInterval();
        $scheduler->setIntervalHumanReadable();
        $this->assertEquals('03:00; 3rd', $scheduler->intervalHumanReadable);

        $scheduler->job_interval = '0::3::3::3::3';
        $scheduler->parseInterval();
        $scheduler->setIntervalHumanReadable();
        $this->assertEquals('03:00; 3rd; March', $scheduler->intervalHumanReadable);
    }

    public function testsetStandardArraysAttributes()
    {
        $scheduler = new Scheduler();

        //execute the method and verify related attributes

        $scheduler->setStandardArraysAttributes();

        $this->assertEquals(array('*', 1, 2, 3, 4, 5, 6, 0), $scheduler->dayInt);
        $this->assertEquals(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12), $scheduler->monthsInt);
        $this->assertEquals(array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'), $scheduler->monthsLabel);
        $this->assertEquals(array('*', '/', '-', ','), $scheduler->metricsVar);
        $this->assertEquals(array(' every ', '', ' thru ', ' and '), $scheduler->metricsVal);
    }

    public function testparseInterval()
    {
        $scheduler = new Scheduler();

        $scheduler->job_interval = '0::3::3::*::*';

        $expected = array(
                      'raw' => array('0', '3', '3', '*', '*'),
                      'hours' => '3:::0',
                      'months' => '*:::3',
                    );

        //execute the method and verify related attributes
        $scheduler->parseInterval();

        $this->assertTrue(is_array($scheduler->intervalParsed));
        $this->assertSame($expected, $scheduler->intervalParsed);
    }

    public function testcheckCurl()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $scheduler = new Scheduler();

        //execute the method and test if it works and does not throws an exception.
        try {
            $scheduler->checkCurl();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
    }

    public function testdisplayCronInstructions()
    {
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

        // test
        
        $scheduler = new Scheduler();

        //execute the method and capture the echo output
        ob_start();

        $scheduler->displayCronInstructions();

        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertGreaterThanOrEqual(0, strlen($renderedContent));

        // clean up
        
        $state->popGlobals();
    }

    public function testrebuildDefaultSchedulers()
    {
        self::markTestIncomplete('enviroment dependency');
        
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('schedulers');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $scheduler = new Scheduler();

        //execute the method and test if it works and does not throws an exception.
        try {
            $scheduler->rebuildDefaultSchedulers();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
        $state->popTable('schedulers');
    }

    public function testcreate_export_query()
    {
        self::markTestIncomplete('environment dependency');

        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('schedulers');

        // test
        
        $scheduler = new Scheduler();

        //test with empty string params
        $expected = " SELECT  schedulers.*  , jt0.user_name created_by_name , jt0.created_by created_by_name_owner  , 'Users' created_by_name_mod , jt1.user_name modified_by_name , jt1.created_by modified_by_name_owner  , 'Users' modified_by_name_mod FROM schedulers   LEFT JOIN  users jt0 ON jt0.id=schedulers.created_by AND jt0.deleted=0\n AND jt0.deleted=0  LEFT JOIN  users jt1 ON schedulers.modified_user_id=jt1.id AND jt1.deleted=0\n\n AND jt1.deleted=0 where schedulers.deleted=0";
        $actual = $scheduler->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = " SELECT  schedulers.*  , jt0.user_name created_by_name , jt0.created_by created_by_name_owner  , 'Users' created_by_name_mod , jt1.user_name modified_by_name , jt1.created_by modified_by_name_owner  , 'Users' modified_by_name_mod FROM schedulers   LEFT JOIN  users jt0 ON jt0.id=schedulers.created_by AND jt0.deleted=0\n AND jt0.deleted=0  LEFT JOIN  users jt1 ON schedulers.modified_user_id=jt1.id AND jt1.deleted=0\n\n AND jt1.deleted=0 where (schedulers.name = \"\") AND schedulers.deleted=0";
        $actual = $scheduler->create_export_query('schedulers.id', 'schedulers.name = ""');
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popTable('schedulers');
    }

    public function testfill_in_additional_list_fields()
    {
        self::markTestIncomplete('environment dependency');
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('schedulers');
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $scheduler = new Scheduler();

        //execute the method and test if it works and does not throws an exception.
        try {
            $scheduler->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popTable('schedulers');
    }

    public function testfill_in_additional_detail_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $scheduler = new Scheduler();

        //execute the method and test if it works and does not throws an exception.
        try {
            $scheduler->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        // clean up
    }

    public function testget_list_view_data()
    {
        self::markTestIncomplete('environment dependency');

        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('schedulers');

        // test
        
        $scheduler = new Scheduler();

        //preset required attributes
        $scheduler->job_interval = '0::3::*::*::*';
        $scheduler->date_time_start = '2015-01-01 10:30:01';
        $scheduler->name = 'test';
        $scheduler->created_by = 1;
        $scheduler->modified_user_id = 1;

        $expected = array(
                'DELETED' => '0',
                'CREATED_BY' => 1,
                'MODIFIED_USER_ID' => 1,
                'NAME' => 'test',
                'DATE_TIME_START' => '2015-01-01 10:30:01',
                'JOB_INTERVAL' => '03:00',
                'CATCH_UP' => '1',
                'ENCODED_NAME' => 'test',
                'DATE_TIME_END' => null,
        );

        $actual = $scheduler->get_list_view_data();
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popTable('schedulers');
    }

    public function testget_summary_text()
    {
        self::markTestIncomplete('environment dependency');
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('schedulers');

        // test
        
        $scheduler = new Scheduler();

        //test without setting name
        $this->assertEquals(null, $scheduler->get_summary_text());

        //test with name set
        $scheduler->name = 'test';
        $this->assertEquals('test', $scheduler->get_summary_text());
        
        // clean up
        
        $state->popTable('schedulers');
    }

    public function testgetJobsList()
    {
        self::markTestIncomplete('environment dependency');
        
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('schedulers');

        // test
        
        $result = Scheduler::getJobsList();
        $this->assertTrue(is_array($result));
        
        // clean up
        
        $state->popTable('schedulers');
    }
}
