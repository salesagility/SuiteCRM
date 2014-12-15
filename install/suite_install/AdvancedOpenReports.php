<?php
function install_aor() {
    require_once('modules/Schedulers/Scheduler.php');
    $scheduler = new Scheduler();
    $scheduler->retrieve_by_string_fields(array('job' => 'function::aorRunScheduledReports'));
    if($scheduler->id == ''){
        $scheduler->name = "Run Scheduled Reports";
        $scheduler->date_time_start = "2005-01-01 11:15:00";
        $scheduler->date_time_end = null;
        $scheduler->job_interval = "*::*::*::*::*";
        $scheduler->job = "function::aorRunScheduledReports";
        $scheduler->status = "Active";
        $scheduler->catch_up = 1;
        $scheduler->save();
    }
}
