<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class SchedulersJobTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testSchedulersJob()
    {
        // Execute the constructor and check for the Object type and  attributes
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        $this->assertInstanceOf('SchedulersJob', $schedulersJob);
        $this->assertInstanceOf('Basic', $schedulersJob);
        $this->assertInstanceOf('SugarBean', $schedulersJob);

        $this->assertAttributeEquals('job_queue', 'table_name', $schedulersJob);
        $this->assertAttributeEquals('SchedulersJobs', 'module_dir', $schedulersJob);
        $this->assertAttributeEquals('SchedulersJob', 'object_name', $schedulersJob);

        $this->assertAttributeEquals(true, 'new_schema', $schedulersJob);
        $this->assertAttributeEquals(true, 'process_save_dates', $schedulersJob);
        $this->assertAttributeEquals(30, 'min_interval', $schedulersJob);
        $this->assertAttributeEquals(true, 'job_done', $schedulersJob);
    }

    public function testcheck_date_relationships_load()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');
        $schedulersJob->execute_time = '2015-01-01 00:00:00';

        $schedulersJob->check_date_relationships_load();

        $this->assertEquals('2015-01-01 00:00:00', $schedulersJob->execute_time_db);
    }

    public function testhandleDateFormat()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        //test with default params
        $result = $schedulersJob->handleDateFormat();
        $this->assertGreaterThan(0, strlen($result));

        //test with a valid date param
        $result = $schedulersJob->handleDateFormat('2015-01-01');
        $this->assertEquals('2015-01-01 00:00:00', $result);
    }

    public function testfireUrl()
    {
        self::markTestIncomplete('environment dependency: curl_setopt(): CURLOPT_DNS_USE_GLOBAL_CACHE cannot be activated when thread safety is enabled ');
        
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        //test with invalid param
        $result = $schedulersJob->fireUrl('');
        $this->assertEquals(false, $result);

        //test with valid param
        self::markTestIncomplete();
        //$result = $schedulersJob->fireUrl('https://suitecrm.com/');
        //$this->assertEquals(true, $result);
    }

    public function testget_list_view_data()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        $schedulersJob->job_name = 'test';
        $schedulersJob->job = 'function::test';

        $expected = array(
                'DELETED' => '0',
                'REQUEUE' => '0',
                'JOB_DELAY' => 0,
                'JOB_NAME' => 'test',
                'JOB' => 'function::test',
        );
        $actual = $schedulersJob->get_list_view_data();

        $this->assertSame($expected, $actual);
    }

    public function testfill_in_additional_list_fields()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $schedulersJob->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testfailJob()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        $result = $schedulersJob->failJob();
        $this->assertEquals(true, $result);

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($schedulersJob->id));
        $this->assertEquals(36, strlen($schedulersJob->id));

        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_FAILURE, $schedulersJob->resolution);

        $schedulersJob->mark_deleted($schedulersJob->id);
    }

    public function testsucceedJob()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        $result = $schedulersJob->succeedJob();
        $this->assertEquals(true, $result);

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($schedulersJob->id));
        $this->assertEquals(36, strlen($schedulersJob->id));

        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_SUCCESS, $schedulersJob->resolution);

        $schedulersJob->mark_deleted($schedulersJob->id);
    }

    public function testonFailureRetry()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $schedulersJob->onFailureRetry();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation: logic hooks not defined');
    }

    public function testOnFinalFailure()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $schedulersJob->onFinalFailure();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation: logic hooks not defined');
    }

    public function testresolveJob()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        //test for JOB_FAILURE
        $result = $schedulersJob->resolveJob(SchedulersJob::JOB_FAILURE, 'test');
        $this->assertEquals(true, $result);

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($schedulersJob->id));
        $this->assertEquals(36, strlen($schedulersJob->id));

        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_FAILURE, $schedulersJob->resolution);

        //tst for JOB_SUCCESS
        $result = $schedulersJob->resolveJob(SchedulersJob::JOB_SUCCESS, 'test');
        $this->assertEquals(true, $result);

        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_SUCCESS, $schedulersJob->resolution);

        $schedulersJob->mark_deleted($schedulersJob->id);
    }

    public function testpostponeJobAndMark_deleted()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        $result = $schedulersJob->postponeJob('test message', 1);
        $this->assertEquals(true, $result);

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($schedulersJob->id));
        $this->assertEquals(36, strlen($schedulersJob->id));

        //verify the related attributes
        $this->assertEquals(SchedulersJob::JOB_STATUS_QUEUED, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_PARTIAL, $schedulersJob->resolution);

        //test mark deleted method and verify record doesn't exist after deletion
        $schedulersJob->mark_deleted($schedulersJob->id);
        $result = $schedulersJob->retrieve($schedulersJob->id);
        $this->assertEquals(null, $result);
    }

    public function testunexpectedExit()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        //create conditions to mark job_done as false
        $schedulersJob->client = 'test';
        $schedulersJob->status = SchedulersJob::JOB_STATUS_RUNNING;
        $schedulersJob->save();
        $result = SchedulersJob::runJobId($schedulersJob->id, 'test');

        //execute the method
        $schedulersJob->unexpectedExit();
        $schedulersJob->retrieve($schedulersJob->id);
        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_FAILURE, $schedulersJob->resolution);

        $schedulersJob->mark_deleted($schedulersJob->id);
    }

    public function testrunJobId()
    {
        //test with invalid job id
        $result = SchedulersJob::runJobId('1', '');
        $this->assertEquals('Job 1 not found.', $result);

        //test with valid job id
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');
        $schedulersJob->status = SchedulersJob::JOB_STATUS_DONE;
        $schedulersJob->save();

        $result = SchedulersJob::runJobId($schedulersJob->id, '');
        $this->assertEquals('Job '.$schedulersJob->id.' is not marked as running.', $result);

        //test with valid job id and status but mismatch client
        $schedulersJob->client = 'client';
        $schedulersJob->status = SchedulersJob::JOB_STATUS_RUNNING;
        $schedulersJob->save();

        $result = SchedulersJob::runJobId($schedulersJob->id, 'test_client');

        $this->assertEquals('Job '.$schedulersJob->id.' belongs to another client, can not run as test_client.', $result);

        $schedulersJob->mark_deleted($schedulersJob->id);
    }

    public function testerrorHandler()
    {
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');

        //execute the method with different Error Types
        $schedulersJob->errors = '';
        $schedulersJob->errorHandler(E_USER_WARNING, 'test err', 'testfile', '1');
        $this->assertEquals("Warning [512]: test err in testfile on line 1\n", $schedulersJob->errors);

        $schedulersJob->errors = '';
        $schedulersJob->errorHandler(E_ERROR, 'test err', 'testfile', '1');
        $this->assertEquals("Fatal Error [1]: test err in testfile on line 1\n", $schedulersJob->errors);

        $schedulersJob->errors = '';
        $schedulersJob->errorHandler(E_PARSE, 'test err', 'testfile', '1');
        $this->assertEquals("Parse Error [4]: test err in testfile on line 1\n", $schedulersJob->errors);

        $schedulersJob->errors = '';
        $schedulersJob->errorHandler(E_RECOVERABLE_ERROR, 'test err', 'testfile', '1');
        $this->assertEquals("Recoverable Error [4096]: test err in testfile on line 1\n", $schedulersJob->errors);
    }

    public function testrunJob()
    {
        //test without a valid user
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');
        $schedulersJob->target = 'function::processAOW_Workflow';
        $result = $schedulersJob->runJob();
        $this->assertEquals(false, $result);
        $schedulersJob->mark_deleted($schedulersJob->id);

        //test with valid user
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');
        $schedulersJob->assigned_user_id = 1;

        $schedulersJob->target = 'function::processAOW_Workflow';
        $result = $schedulersJob->runJob();
        $this->assertEquals(true, $result);
        $schedulersJob->mark_deleted($schedulersJob->id);

        //test with valid user
        $schedulersJob = BeanFactory::newBean('SchedulersJobs');
        $schedulersJob->assigned_user_id = 1;

        self::markTestIncomplete();
//        $schedulersJob->target = 'url::https://suitecrm.com/';
//        $result = $schedulersJob->runJob();
//        $this->assertEquals(true, $result);
//        $schedulersJob->mark_deleted($schedulersJob->id);
    }
}
