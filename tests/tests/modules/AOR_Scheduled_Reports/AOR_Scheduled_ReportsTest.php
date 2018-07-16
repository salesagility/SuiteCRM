<?php

class AOR_Scheduled_ReportsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

	public function testSaveAndGet_email_recipients(){
            
            $state = new SuiteCRM\StateSaver();
            $state->pushTable('aor_scheduled_reports');
            $state->pushTable('tracker');
            $state->pushTable('aod_index');
            $state->pushGlobals();

		$aorScheduledReports = new AOR_Scheduled_Reports();
		$aorScheduledReports->name = "test";
		$aorScheduledReports->description = "test description";
		$_POST['email_recipients']= Array('email_target_type'=> array('Email Address','all','Specify User')  ,'email' =>array('test@test.com','','1') );


		//test save and test for record ID to verify that record is saved
		$aorScheduledReports->save();
		$this->assertTrue(isset($aorScheduledReports->id));
		$this->assertEquals(36, strlen($aorScheduledReports->id));



		//test get_email_recipients
		$expected = array('test@test.com','','1');
		$aorScheduledReports->retrieve($aorScheduledReports->id);
		$emails = $aorScheduledReports->get_email_recipients();

		$this->assertTrue(is_array($emails));
		$this->assertEquals('test@test.com',$emails[0]);


		$aorScheduledReports->mark_deleted($aorScheduledReports->id);
		unset($aorScheduledReports);

            // clean up
                
            $state->popGlobals();
            $state->popTable('tracker');
            $state->popTable('aod_index');
            $state->popTable('aor_scheduled_reports');
    }
    
	public function testAOR_Scheduled_Reports(){

		//execute the contructor and check for the Object type and  attributes
		$aorScheduledReports = new AOR_Scheduled_Reports();
		$this->assertInstanceOf('AOR_Scheduled_Reports',$aorScheduledReports);
		$this->assertInstanceOf('Basic',$aorScheduledReports);
		$this->assertInstanceOf('SugarBean',$aorScheduledReports);

		$this->assertAttributeEquals('AOR_Scheduled_Reports', 'module_dir', $aorScheduledReports);
		$this->assertAttributeEquals('AOR_Scheduled_Reports', 'object_name', $aorScheduledReports);
		$this->assertAttributeEquals('aor_scheduled_reports', 'table_name', $aorScheduledReports);
		$this->assertAttributeEquals(true, 'new_schema', $aorScheduledReports);
		$this->assertAttributeEquals(true, 'disable_row_level_security', $aorScheduledReports);
		$this->assertAttributeEquals(false, 'importable', $aorScheduledReports);

	}

	public function testbean_implements(){
            
        $state = new SuiteCRM\StateSaver();
        
        

		//error_reporting(E_ERROR | E_PARSE);

		$aorScheduledReports = new AOR_Scheduled_Reports();
		$this->assertEquals(false, $aorScheduledReports->bean_implements('')); //test with blank value
		$this->assertEquals(false, $aorScheduledReports->bean_implements('test')); //test with invalid value
		$this->assertEquals(true, $aorScheduledReports->bean_implements('ACL')); //test with valid value
        
        // clean up
        
        

    }




	public function testshouldRun(){


		$aorScheduledReports = new AOR_Scheduled_Reports();
		$aorScheduledReports->schedule = " 8 * * * *";

		//test without a last_run date
        //@todo: NEEDS FIXING - are we sure?
		//$this->assertFalse($aorScheduledReports->shouldRun(new DateTime()) );

		//test without a older last_run date
		$aorScheduledReports->last_run = date("d-m-y H:i:s", mktime(0,0,0,10,3,2014));
		$this->assertTrue($aorScheduledReports->shouldRun(new DateTime()));


		//test without a current last_run date
		$aorScheduledReports->last_run = new DateTime();
		$this->assertFalse($aorScheduledReports->shouldRun(new DateTime()));

    }


}
