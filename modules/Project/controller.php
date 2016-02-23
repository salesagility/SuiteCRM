<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 * @copyright Andrew Mclaughlan 2014
 * @author Andrew Mclaughlan <andrew@mclaughlan.info>
 */


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ProjectController extends SugarController {
    //Loads the gantt view
    function action_view_GanttChart() {
        $this->view = 'GanttChart';
    }

    function action_generate_chart(){
        global $db;

        include_once('modules/Project/gantt.php');
        include_once('modules/Project/project_table.php');

        $project = new Project();
        $project->retrieve($_POST["pid"]);
        //Get project tasks
        $Task = BeanFactory::getBean('ProjectTask');
        $tasks = $Task->get_full_list("order_number", "project_task.project_id = '".$project->id."'");
        //Get the start and end date of the project in database format
        $query = "SELECT estimated_start_date FROM project WHERE id = '{$project->id}'";
        $start_date = $db->getOne($query);
        $query = "SELECT estimated_end_date FROM project WHERE id = '{$project->id}'";
        $end_date = $db->getOne($query);
?>

        <script type="text/javascript">
            //Get the height if the #gantt div and add 18px
            var size = $('#gantt').height() +18;
            //Call jquery splitter function
            $('#project').splitter({
                outline: true
            });
            //Set height of gantt wrapping divs to make sure it shows
            $('#project').css('height', size+'px');
            $('.splitter-bar').css('height', size+'px');

        </script>
        <div id="project">
            <div id="left_pane">
                <?php new ProjectTable($tasks);?>
            </div>
            <div id="right_pane">
                <div id="gantt">
                    <?php new Gantt($start_date, $end_date, $tasks);?>
                </div>
                <div id="arrow_divs" style=""></div>
            </div>
        </div>

<?php
        die();
    }

    //Create new project task
    function action_update_GanttChart(){

        global $current_user, $db;

        $task_name = $_POST['task_name'];
        $project_id = $_POST['project_id'];
        $task_id = $_POST['task_id'];
        $predecessor = $_POST['predecessor'];
        $rel_type = $_POST['rel_type'];
        $resource = $_POST['resource'];
        $percent = $_POST['percent'];
        $note = $_POST['note'];
        $actual_duration = $_POST['actual_duration'];

        if($_POST['milestone'] == 'Milestone'){
            $milestone_flag = '1';
        }
        else if($_POST['milestone'] == 'Task'){
            $milestone_flag = '0';
        }

        $dateformat = $current_user->getPreference('datef');

        $startdate = DateTime::createFromFormat($dateformat, $_POST['start']);
        $start = $startdate->format('Y-m-d');

        //Take 1 off duration so that task displays in correct number of table cells in gantt chart.
        $duration = $_POST['duration'] -1;

        $duration_unit = $_POST['unit'];

        //$GLOBALS['log']->fatal("Duration:".$duration );

        //Compensate for resulting negative number when a 0 duration is passed in above
        if($duration < 0){
            $duration = 0;
        }

        $enddate = $startdate->modify('+'.$duration.' '.$duration_unit);
        $enddate = $enddate->format('Y-m-d');


        if($percent > 0){

            $status = 'In Progress';
        }
        else {
            $status = 'Not Started';
        }

        //count tasks
        $query = "SELECT COUNT(*) FROM project_task WHERE project_id = '{$project_id}' AND deleted = '0'";
        $count = $db->getOne($query);
        $tid = $count+1;

        if($this->IsNullOrEmptyString($task_id)){
            $this->create_task($task_name,$start,$enddate,$project_id, $milestone_flag,$status, $tid, $predecessor, $rel_type, $duration,$duration_unit,$resource,$percent,$note,$actual_duration,$tid);
        }
        else {
            $this->update_task($task_id,$task_name,$start,$enddate,$project_id, $milestone_flag,$status, $predecessor, $rel_type, $duration,$duration_unit,$resource,$percent,$note,$actual_duration);
        }
    }

    //mark project task as deleted
    function action_delete_task(){
        $id = $_POST['task_id'];
        $task = new ProjectTask();
        $task->retrieve($id);
        $task->deleted = '1';
        $task->save();
    }

    //Returns new task start date including any lag via ajax call
    function action_get_end_date(){
        global $db,  $timeDate;

        $timeDate = new TimeDate();
        $id = $_POST['task_id'];
        $lag = $_POST['lag'];

        //Get the end date of the projectTask in raw database format
        $query = "SELECT date_finish FROM project_task WHERE id = '{$id}'";
        $end_date = $db->getOne($query);
        //Add 1 day onto end date for first day of new task
        $start_date = date('Y-m-d', strtotime($end_date. ' + 1 days'));
        //Add lag onto start date
        $start_date = date('Y-m-d', strtotime($start_date. ' + '.$lag.' days'));

        echo $timeDate->to_display_date($start_date, true);
        die();

    }


    //updates the order of the tasks
    function action_update_order(){

       //convert quotes in json string back to normal
        $jArray = htmlspecialchars_decode($_POST['orderArray']);

        //create object/array from json data
        $orderArray = json_decode($jArray, true);

        foreach($orderArray as $id => $order_number){

            $task = new ProjectTask();
            $task->retrieve($id);
            $task->order_number = $order_number;
            $task->save();

        }
    }
   //returns tasks for predecessor in the add task pop-up form
    function action_get_predecessors(){

        $project = new Project();
        $project->retrieve($_REQUEST["project_id"]);
        //Get project tasks
        $Task = BeanFactory::getBean('ProjectTask');
        $tasks = $Task->get_full_list("order_number", "project_task.project_id = '".$project->id."'");
        echo '<option rel="0" value="0">None</option>';
        foreach ($tasks as $task) {
            echo '<option rel="'.$task->id.'" value="'.$task->project_task_id.'">'.$task->name.'</opion>';
        }
        die();
    }


    function create_task($name, $start, $end, $project_id, $milestone_flag, $status, $project_task_id, $predecessors, $rel_type, $duration, $duration_unit, $resource, $percent_complete, $description,$actual_duration,$order_number){

        $task = new ProjectTask();
        $task->name = $name;
        $task->date_start = $start;
        $task->date_finish = $end;
        $task->project_id = $project_id;
        $task->milestone_flag = $milestone_flag;
        $task->status = $status;
        $task->project_task_id = $project_task_id;
        $task->predecessors = $predecessors;
        $task->relationship_type = $rel_type;
        $task->duration = $duration + 1; //+1 to make duration appear correct in project table
        $task->duration_unit = $duration_unit;
        $task->assigned_user_id = $resource;
        $task->percent_complete = $percent_complete;
        $task->description = $description;
        $task->actual_duration = $actual_duration;
        $task->order_number = $order_number;
        $task->save();
    }

    function update_task($id, $name, $start, $end, $project_id, $milestone_flag, $status, $predecessors, $rel_type, $duration, $duration_unit, $resource, $percent_complete, $description,$actual_duration){

        $task = new ProjectTask();
        $task->retrieve($id);
        $task->name = $name;
        $task->date_start = $start;
        $task->date_finish = $end;
        $task->project_id = $project_id;
        $task->milestone_flag = $milestone_flag;
        $task->status = $status;
        // $task->parent_task_id = $parent_task_id;
        $task->predecessors = $predecessors;
        $task->relationship_type = $rel_type;
        $task->duration = $duration + 1; //+1 to make duration appear correct in project table
        $task->duration_unit = $duration_unit;
        $task->assigned_user_id = $resource;
        $task->percent_complete = $percent_complete;
        $task->actual_duration = $actual_duration;
        $task->description = $description;
        $task->save();
    }


    /*********************************** Resource chart functions **************************************/

    //Loads the resource chart view
    function action_ResourceList(){

        $this->view = 'ResourceList';
    }

    //Updates the resource chart based on specified dates and users
    function action_update_chart(){
        global $db;
        include('modules/Project/chart.php');

        //Get  specified dates and users
        $start = $_POST['start'];
        //$end = $_POST['end'];
        $users = $_POST['resources'];
        $month = $_POST['month'];
        $flag = $_POST['flag'];
        $type = $_POST['type'];

        $start = new DateTime($start);

        if($month == '-1'){
            $start->modify($month.' month');
            $start->modify('+2 week');
        }
        elseif($month == '1'){
            $start->modify($month.' month');
            $start->modify('+1 week');
        }

        if($flag == '0'){
            $start->sub(new DateInterval('P1W'));
        }

        $first_day = $start->modify('this week');
        $start = $start->format('Y-m-d');

        $end = $first_day->add(new DateInterval('P66D'));
        $end->modify('this week');
        $end->add(new DateInterval('P1D'));
        $end = $end->format('Y-m-d');

        //set query to get all users
        if($users == 'all'){

            //Get the users data from the database
            $resource_query = "SELECT project_users_1users_idb as id, first_name, last_name, 'project_users_1_c' AS type
                                  FROM project_users_1_c
                                  JOIN users ON users.id = project_users_1users_idb
                                  WHERE project_users_1_c.deleted =0
                               UNION
                               SELECT project_contacts_1contacts_idb AS id, first_name, last_name, 'project_contacts_1_c' AS type
                                  FROM project_contacts_1_c
                                  JOIN contacts ON contacts.id = project_contacts_1contacts_idb
                                  WHERE project_contacts_1_c.deleted =0";
        }
        else {//get specified user

            if($type == 'project_users_1_c'){
                $resource_query = "SELECT DISTINCT project_users_1users_idb as id, first_name, last_name, 'project_users_1_c' AS type
                                    FROM project_users_1_c
                                    JOIN users ON users.id = project_users_1users_idb
                                    WHERE project_users_1_c.deleted =0 AND project_users_1users_idb ='".$users."'";

            }
            else if($type == 'project_contacts_1_c'){
                $resource_query = "SELECT DISTINCT project_contacts_1contacts_idb AS id, first_name, last_name, 'project_contacts_1_c' AS type
                                    FROM project_contacts_1_c
                                    JOIN contacts ON contacts.id = project_contacts_1contacts_idb
                                    WHERE project_contacts_1_c.deleted =0 AND project_contacts_1contacts_idb='".$users."'";
            }
        }

        $resources = $db->query($resource_query);


        //create array to hold the users
        $resource_list = array();
        //Loop through users
        while($row = $db->fetchByAssoc($resources))
        {  //get each users associated project tasks
            $Task = BeanFactory::getBean('ProjectTask');
            $tasks = $Task->get_full_list("date_start", "project_task.assigned_user_id = '".$row['id']."'");
            //put users tasks in an array
            $taskarr = array();
            $t = 0;
            if(!is_null($tasks)){
                foreach($tasks as $task){
                    $taskarr[$t]['id'] = $task->id;
                    $taskarr[$t]['name'] = $task->name;
                    $taskarr[$t]['status'] = $task->status;
                    $taskarr[$t]['% cpl'] = $task->percent_complete;
                    $taskarr[$t]['start_day'] = $this->count_days($start, $task->date_start);//Works out how many days into the chart the task starts
                    $taskarr[$t]['duration'] = $task->duration;//how many days long is the task
                    $taskarr[$t]['end_day'] = $this->count_days($start, $task->date_finish);//Works out how many days from start of the chart the task end day is.
                    $taskarr[$t]['start_date'] = $task->date_start;
                    $taskarr[$t]['end_date'] = $task->date_finish;
                    $taskarr[$t]['project_id'] = $task->project_id;//parent projects id
                    //get the project name (don't think this is really necessary)
                    $project = new Project();
                    $project->retrieve($task->project_id);
                    $taskarr[$t]['project_name'] = $project->name;//parent projects id
                    $t ++;
                }
            }
            $row['task_count'] = $t;//the number of tasks for the user
            $row['tasks'] = $taskarr;//add users tasks to main user array
            //convert user array to an array of user objects
            $resource_list[] = (object)$row;
        }

        //Generate the resource chart by passing in the start date, end date and the array of user objects
        new chart($start, $end, $resource_list);
      /* echo '<pre>';
        print_r($resource_list);
        echo '</pre>';*/
        die();
    }


    //Get tasks for resource chart tooltips
    function action_Tooltips(){

        global $mod_strings;

        $start_date = $_REQUEST['start_date'];
        $resource_id = $_REQUEST['resource_id'];
        //$resource_type = $_REQUEST['type'];

        $Task = BeanFactory::getBean('ProjectTask');
        $tasks = $Task->get_full_list("date_start", "project_task.assigned_user_id = '".$resource_id."' AND project_task.date_start <= '".$start_date."' AND project_task.date_finish >= '".$start_date."'");

        echo '<table class="qtip_table">';
        echo '<tr><th>'.$mod_strings['LBL_TOOLTIP_PROJECT_NAME'].'</th><th>'.$mod_strings['LBL_TOOLTIP_TASK_NAME'].'</th><th>'.$mod_strings['LBL_TOOLTIP_TASK_DURATION'].'</th></tr>';

        foreach($tasks as $task){

            echo '<tr><td><a target="_blank" href="index.php?module=Project&action=DetailView&record='.$task->project_id.'">'.$task->project_name.'</a></td><td>'.$task->name.'</td><td>'.$task->duration.' '.$task->duration_unit.'</td></tr>';
        }
        echo '</table>';

        die();
    }

    /*********************************** Utility functions **************************************/


    //Returns the total number of days between two dates
    function count_days($start_date, $end_date){
        $d1 = new DateTime($start_date);
        $d2 = new DateTime($end_date);
        //If the task's end date is before chart's start date return -1 to make sure task starts on first day of the chart
        if($d2 < $d1){
            return -1;
        }
        $difference = $d1->diff($d2);
        return $difference->days;
    }

    // Function for basic field validation (present and neither empty nor only white space
    public function IsNullOrEmptyString($question){
        return (!isset($question) || trim($question)==='');
    }

}