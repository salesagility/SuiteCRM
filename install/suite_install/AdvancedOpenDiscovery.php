<?php
function install_aod() {

    require_once('modules/Administration/Administration.php');

    global $sugar_config;

    $sugar_config['aod']['enable_aod'] = true;

    ksort($sugar_config);
    write_array_to_file('sugar_config', $sugar_config, 'config.php');

    addAODSchedulers();
}
function addAODSchedulers(){
    require_once('modules/Schedulers/Scheduler.php');

    $scheduler = new Scheduler();
    $scheduler->retrieve_by_string_fields(array('job' => 'function::aodIndexUnindexed'));
    if($scheduler->id == ''){
        $scheduler->name = "Perform Lucene Index";
        $scheduler->date_time_start = "2005-01-01 11:15:00";
        $scheduler->date_time_end = null;
        $scheduler->job_interval = "0::0::*::*::*";
        $scheduler->job = "function::aodIndexUnindexed";
        $scheduler->status = "Active";
        $scheduler->catch_up = 1;
        $scheduler->save();
    }


    $scheduler = new Scheduler();
    $scheduler->retrieve_by_string_fields(array('job' => 'function::aodOptimiseIndex'));
    if($scheduler->id == ''){
        $scheduler->name = "Optimise AOD Index";
        $scheduler->date_time_start = "2005-01-01 11:15:00";
        $scheduler->date_time_end = null;
        $scheduler->job_interval = "0::*/3::*::*::*";
        $scheduler->job = "function::aodOptimiseIndex";
        $scheduler->status = "Active";
        $scheduler->catch_up = 1;
        $scheduler->save();
    }
}