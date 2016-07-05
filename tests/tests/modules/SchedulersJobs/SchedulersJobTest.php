<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**
 * Class SchedulersJobTest
 */
class SchedulersJobTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testSchedulersJob()
    {
        //execute the contructor and check for the Object type and  attributes
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
    }
    
    public function testcheck_date_relationships_load()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $schedulersJob = new SchedulersJob();
        $schedulersJob->execute_time = '2015-01-01 00:00:00';
    
        $schedulersJob->check_date_relationships_load();
    
        $this->assertEquals('2015-01-01 00:00:00', $schedulersJob->execute_time_db);
    }
    
    public function testhandleDateFormat()
    {
        $schedulersJob = new SchedulersJob();
    
        //test with default params
        $result = $schedulersJob->handleDateFormat();
        $this->assertGreaterThan(0, strlen($result));
    
        //test with a valid date param
        $result = $schedulersJob->handleDateFormat('2015-01-01');
        $this->assertEquals('2015-01-01 00:00:00', $result);
    }
    
    public function testfireUrl()
    {
        $schedulersJob = new SchedulersJob();
    
        //test with invalid param
        $result = $schedulersJob->fireUrl('');
        $this->assertEquals(false, $result);
    
        //test with valid param
        $result = $schedulersJob->fireUrl('https://suitecrm.com/');
        $this->assertEquals(true, $result);
    }
    
    public function testget_list_view_data()
    {
        $schedulersJob = new SchedulersJob();
    
        $schedulersJob->job_name = 'test';
        $schedulersJob->job = 'function::test';
    
        $expected = array(
            'DELETED'   => '0',
            'REQUEUE'   => '0',
            'JOB_DELAY' => 0,
            'JOB_NAME'  => 'test',
            'JOB'       => 'function::test',
        );
        $actual = $schedulersJob->get_list_view_data();
    
        $this->assertSame($expected, $actual);
    }
    
    public function testfill_in_additional_list_fields()
    {
        $schedulersJob = new SchedulersJob();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $schedulersJob->fill_in_additional_list_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testfailJob()
    {
        $schedulersJob = new SchedulersJob();
    
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
        $schedulersJob = new SchedulersJob();
    
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
        $schedulersJob = new SchedulersJob();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $schedulersJob->onFailureRetry();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation: logic hooks not defined');
    }
    
    public function testonFinalFailure()
    {
        $schedulersJob = new SchedulersJob();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $schedulersJob->onFinalFailure();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation: logic hooks not defined');
    }
    
    public function testresolveJob()
    {
        $schedulersJob = new SchedulersJob();
    
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
        $schedulersJob = new SchedulersJob();
    
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
        $schedulersJob = new SchedulersJob();
    
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
        $result = SchedulersJob::runJobId('1');
        $this->assertEquals('Job 1 not found.', $result);
    
        //test with valid job id
        $schedulersJob = new SchedulersJob();
        $schedulersJob->status = SchedulersJob::JOB_STATUS_DONE;
        $schedulersJob->save();
    
        $result = SchedulersJob::runJobId($schedulersJob->id);
        $this->assertEquals('Job ' . $schedulersJob->id . ' is not marked as running.', $result);
        
        //test with valid job id and status but mismatch client
        $schedulersJob->client = 'client';
        $schedulersJob->status = SchedulersJob::JOB_STATUS_RUNNING;
        $schedulersJob->save();
    
        $result = SchedulersJob::runJobId($schedulersJob->id, 'test_client');
    
        $this->assertEquals('Job ' . $schedulersJob->id . ' belongs to another client, can not run as test_client.',
                            $result);
        
        $schedulersJob->mark_deleted($schedulersJob->id);
    }
    
    public function testerrorHandler()
    {
        $schedulersJob = new SchedulersJob();
    
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
        $schedulersJob = new SchedulersJob();
        $schedulersJob->target = 'function::processAOW_Workflow';
        $result = $schedulersJob->runJob();
        $this->assertEquals(false, $result);
        $schedulersJob->mark_deleted($schedulersJob->id);
    
        //test with valid user
        $schedulersJob = new SchedulersJob();
        $schedulersJob->assigned_user_id = 1;
    
        $schedulersJob->target = 'function::processAOW_Workflow';
        $result = $schedulersJob->runJob();
        $this->assertEquals(true, $result);
        $schedulersJob->mark_deleted($schedulersJob->id);
    
        //test with valid user
        $schedulersJob = new SchedulersJob();
        $schedulersJob->assigned_user_id = 1;
    
        $schedulersJob->target = 'url::https://suitecrm.com/';
        $result = $schedulersJob->runJob();
        $this->assertEquals(true, $result);
        $schedulersJob->mark_deleted($schedulersJob->id);
    }
}
