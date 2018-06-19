<?php

class SchedulersJobTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testSchedulersJob()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('email_addresses');
        
        
        $schedulersJob = new SchedulersJob();

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
        
        
        
        $state->popTable('email_addresses');
    }

    public function testcheck_date_relationships_load()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $schedulersJob = new SchedulersJob();
        $schedulersJob->execute_time = '2015-01-01 00:00:00';

        $schedulersJob->check_date_relationships_load();

        $this->assertEquals('2015-01-01 00:00:00', $schedulersJob->execute_time_db);
        
        
        
        
    }

    public function testhandleDateFormat()
    {
        $schedulersJob = new SchedulersJob();

        
        $result = $schedulersJob->handleDateFormat();
        $this->assertGreaterThan(0, strlen($result));

        
        $result = $schedulersJob->handleDateFormat('2015-01-01');
        $this->assertEquals('2015-01-01 00:00:00', $result);
    }

    public function testfireUrl()
    {
        self::markTestIncomplete('environment dependency: curl_setopt(): CURLOPT_DNS_USE_GLOBAL_CACHE cannot be activated when thread safety is enabled ');
        
        $schedulersJob = new SchedulersJob();

        
        $result = $schedulersJob->fireUrl('');
        $this->assertEquals(false, $result);

        
        self::markTestIncomplete();
        
        
    }

    public function testget_list_view_data()
    {
        $schedulersJob = new SchedulersJob();

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
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $schedulersJob = new SchedulersJob();

        
        try {
            $schedulersJob->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testfailJob()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        
        
        $schedulersJob = new SchedulersJob();

        $result = $schedulersJob->failJob();
        $this->assertEquals(true, $result);

        
        $this->assertTrue(isset($schedulersJob->id));
        $this->assertEquals(36, strlen($schedulersJob->id));

        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_FAILURE, $schedulersJob->resolution);

        $schedulersJob->mark_deleted($schedulersJob->id);
        
        
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
    }

    public function testsucceedJob()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        
        
        $schedulersJob = new SchedulersJob();

        $result = $schedulersJob->succeedJob();
        $this->assertEquals(true, $result);

        
        $this->assertTrue(isset($schedulersJob->id));
        $this->assertEquals(36, strlen($schedulersJob->id));

        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_SUCCESS, $schedulersJob->resolution);

        $schedulersJob->mark_deleted($schedulersJob->id);
        
        
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
    }

    public function testonFailureRetry()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $schedulersJob = new SchedulersJob();

        
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
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $schedulersJob = new SchedulersJob();

        
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
        
        
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        
        
        
        $schedulersJob = new SchedulersJob();

        
        $result = $schedulersJob->resolveJob(SchedulersJob::JOB_FAILURE, 'test');
        $this->assertEquals(true, $result);

        
        $this->assertTrue(isset($schedulersJob->id));
        $this->assertEquals(36, strlen($schedulersJob->id));

        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_FAILURE, $schedulersJob->resolution);

        
        $result = $schedulersJob->resolveJob(SchedulersJob::JOB_SUCCESS, 'test');
        $this->assertEquals(true, $result);

        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_SUCCESS, $schedulersJob->resolution);

        $schedulersJob->mark_deleted($schedulersJob->id);
        
        
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
        
        
    }

    public function testpostponeJobAndMark_deleted()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        
        
        $schedulersJob = new SchedulersJob();

        $result = $schedulersJob->postponeJob('test message', 1);
        $this->assertEquals(true, $result);

        
        $this->assertTrue(isset($schedulersJob->id));
        $this->assertEquals(36, strlen($schedulersJob->id));

        
        $this->assertEquals(SchedulersJob::JOB_STATUS_QUEUED, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_PARTIAL, $schedulersJob->resolution);

        
        $schedulersJob->mark_deleted($schedulersJob->id);
        $result = $schedulersJob->retrieve($schedulersJob->id);
        $this->assertEquals(null, $result);
        
        
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
    }

    public function testunexpectedExit()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        
        
        $schedulersJob = new SchedulersJob();

        
        $schedulersJob->client = 'test';
        $schedulersJob->status = SchedulersJob::JOB_STATUS_RUNNING;
        $schedulersJob->save();
        $result = SchedulersJob::runJobId($schedulersJob->id, 'test');

        
        $schedulersJob->unexpectedExit();
        $schedulersJob->retrieve($schedulersJob->id);
        $this->assertEquals(SchedulersJob::JOB_STATUS_DONE, $schedulersJob->status);
        $this->assertEquals(SchedulersJob::JOB_FAILURE, $schedulersJob->resolution);

        $schedulersJob->mark_deleted($schedulersJob->id);
        
        
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
    }

    public function testrunJobId()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        
        

        
        $result = SchedulersJob::runJobId('1','');
        $this->assertEquals('Job 1 not found.', $result);

        
        $schedulersJob = new SchedulersJob();
        $schedulersJob->status = SchedulersJob::JOB_STATUS_DONE;
        $schedulersJob->save();

        $result = SchedulersJob::runJobId($schedulersJob->id, '');
        $this->assertEquals('Job '.$schedulersJob->id.' is not marked as running.', $result);

        
        $schedulersJob->client = 'client';
        $schedulersJob->status = SchedulersJob::JOB_STATUS_RUNNING;
        $schedulersJob->save();

        $result = SchedulersJob::runJobId($schedulersJob->id, 'test_client');

        $this->assertEquals('Job '.$schedulersJob->id.' belongs to another client, can not run as test_client.', $result);

        $schedulersJob->mark_deleted($schedulersJob->id);
        
        
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
    }

    public function testerrorHandler()
    {
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        
        
        

        $schedulersJob = new SchedulersJob();

        

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
        
        
        
        $state->popTable('aod_index');
    }

    public function testrunJob()
    {

        
        $schedulersJob = new SchedulersJob();
        $schedulersJob->target = 'function::processAOW_Workflow';
        $result = $schedulersJob->runJob();
        $this->assertEquals(false, $result);
        $schedulersJob->mark_deleted($schedulersJob->id);

        
        $schedulersJob = new SchedulersJob();
        $schedulersJob->assigned_user_id = 1;

        $schedulersJob->target = 'function::processAOW_Workflow';
        $result = $schedulersJob->runJob();
        $this->assertEquals(false, $result);
        $schedulersJob->mark_deleted($schedulersJob->id);

        
        $schedulersJob = new SchedulersJob();
        $schedulersJob->assigned_user_id = 1;

        self::markTestIncomplete();




    }
}
