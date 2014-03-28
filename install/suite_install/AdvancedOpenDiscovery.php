<?php
function install_aod() {

    require_once('modules/Configurator/Configurator.php');
    $cfg = new Configurator();

    if(empty($cfg->config['aod'])){
        $cfg->config['aod'] = array('enable_aod'=>true);
    }
    $cfg->saveConfig();

    addAODSchedulers();
}
function addAODSchedulers(){
    require_once('modules/Schedulers/Scheduler.php');

    $scheduler = new Scheduler();
    if(!count($scheduler->get_full_list('','job = "function::aodIndexUnindexed"'))){
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
    if(!count($scheduler->get_full_list('','job = "function::aodOptimiseIndex"'))){
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