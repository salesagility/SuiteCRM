<?php
function install_aow() {
		AddScheduler();
}

function AddScheduler(){
	include_once('install/install_utils.php');
	require_once('modules/Schedulers/Scheduler.php');
	$scheduler = new Scheduler();
	$scheduler->retrieve_by_string_fields(array('job' => 'function::processAOW_Workflow'));
	if($scheduler->id == ''){
		$scheduler->name = 'Run AOW WorkFlow';
		$scheduler->job = 'function::processAOW_Workflow';
		$scheduler->date_time_start	= create_date(2005,1,1) . ' ' . create_time(0,0,1);
		$scheduler->date_time_end = create_date(2020,12,31) . ' ' . create_time(23,59,59);
		$scheduler->job_interval = '*::*::*::*::*';
		$scheduler->status = 'Active';
		$scheduler->created_by = '1';
		$scheduler->modified_user_id = '1';
		$scheduler->catch_up = '0';
		$scheduler->save();
	}
}
?>
