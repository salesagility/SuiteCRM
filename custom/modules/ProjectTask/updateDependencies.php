<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 24/07/14
 * Time: 17:15
 * Updates Finish to start (FS) and Start to Start (SS) dependencies
 * If the a task's start date is updated any dependant tasks should have their start date updated to reflect this.
 */

class updateDependencies {

    function update_dependency(&$bean, $event, $arguments){
        //Get all tasks that are dependant on the current task being saved.
        $Task = BeanFactory::getBean('ProjectTask');
        $tasks = $Task->get_full_list("", "project_task.project_id = '".$bean->project_id."' AND project_task.predecessors = '".$bean->project_task_id."'");

        if($bean->date_finish != $bean->fetched_row['date_finish']){ //if the end date of a current task is changed

            $diff = $this->count_days($bean->date_finish, $bean->fetched_row['date_finish']); //Gets the difference in days

            foreach($tasks as $task){ //loop through all dependant tasks

                $rel_type = $task->relationship_type;//Determine their dependency type

                if($rel_type == 'FS'){//if its a Finish to start
                    //Modify the task's start and end date dependant on the difference in days
                    $start = new DateTime($task->date_start);
                    $start = $start->modify($diff);
                    $startdate = $start->format('Y-m-d');

                    $duration = $task->duration - 1;//take one off to maintain correct gantt bar length

                    $enddate = $start->modify('+'.$duration.' days');
                    $enddate = $enddate->format('Y-m-d');

                    $task->date_start = $startdate;
                    $task->date_finish = $enddate;
                    $task->save();

                }
                else if($rel_type == 'SS'){//if its a start to start
                    //check if the tasks duration has not been changed so that it does not update when the parent tasks duration is changed
                    if($bean->fetched_row['duration'] == $bean->duration){

                        $start = new DateTime($task->date_start);
                        $start = $start->modify($diff);
                        $startdate = $start->format('Y-m-d');

                        $duration = $task->duration - 1;

                        $enddate = $start->modify('+'.$duration.' days');
                        $enddate = $enddate->format('Y-m-d');

                        $task->date_start = $startdate;
                        $task->date_finish = $enddate;
                        $task->save();

                    }

                }

            }

        }
    }

    //Gets the difference in days between two dates
    function count_days($start_date, $end_date){

        $d1 = new DateTime($start_date);
        $d2 = new DateTime($end_date);
        $difference = $d1->diff($d2);
        if ($difference->invert == 1) {
            return '+'.$difference->d.' days'; //returns positive days
        } else {
            return -$difference->d.' days';//returns negative days
        }

    }
} 