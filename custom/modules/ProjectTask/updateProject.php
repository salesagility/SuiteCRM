<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * updateProject.php
 * @author SalesAgility (Andrew Mclaughlan) <support@salesagility.com>
 * Date: 24/01/14
 * Comments
 */

class updateEndDate {
//logichook is used to update project end date when task end date exceeds project end date
    function update(&$bean, $event, $arguments){

        if(!$this->IsNullOrEmptyString($bean->project_id)){

            if($this->IsNullOrEmptyString($bean->set_project_end_date)){
                global $current_user;
                $dateformat = $current_user->getPreference('datef');
                $project = new Project();
                $project->retrieve($bean->project_id);
                $projectend = DateTime::createFromFormat($dateformat, $project->estimated_end_date);
                $projectend = $projectend->format('Y-m-d');
                $taskend = $bean->date_finish;
                //if the task end date is after the projects end date, extend the project to fit the new task end date.
                if(strtotime($taskend) > strtotime($projectend))
                {
                    $project->estimated_end_date = $taskend;
                    $project->save();
                }

            }
        }
    }


    //Function for basic field validation (present and neither empty nor only white space
     function IsNullOrEmptyString($question){
        return (!isset($question) || trim($question)==='');
    }

}