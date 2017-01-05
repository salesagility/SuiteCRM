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
 * @Package Project templates
 * @copyright Andrew Mclaughlan 2014
 * @author Andrew Mclaughlan <andrew@mclaughlan.info>
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class AM_ProjectTemplatesController extends SugarController {

    //Loads the gantt view
    function action_view_GanttChart() {
        $this->view = 'GanttChart';
    }


    function action_create_project(){

        global $current_user, $db, $mod_strings;

        $project_name = $_POST['p_name'];
        $template_id = $_POST['template_id'];
        $project_start = $_POST['start_date'];
        $copy_all = isset($_POST['copy_all_tasks']) ? 1 : 0;
		$copy_tasks = isset($_POST['tasks']) ? $_POST['tasks'] : array() ;
			
		//Get project start date
        if($project_start!='')
		{
			$dateformat = $current_user->getPreference('datef');
			$startdate = DateTime::createFromFormat($dateformat, $project_start);
			$start = $startdate->format('Y-m-d');
		}

        $duration_unit = 'Days';

        //Get the project template
        $template = new AM_ProjectTemplates();
        $template->retrieve($template_id);

        //create project from template
        $project = new Project();
        $project->name = $project_name;
        $project->estimated_start_date = $start;
		$project->status = $template->status;
        $project->priority = strtolower($template->priority);
        $project->description = $template->description;
        $project->assigned_user_id = $template->assigned_user_id;
        $project->save();


		//copy all resources from template to project
		$template->load_relationship('am_projecttemplates_users_1');
		$template_users = $template->get_linked_beans('am_projecttemplates_users_1','User');

		$template->load_relationship('am_projecttemplates_contacts_1');
		$template_contacts = $template->get_linked_beans('am_projecttemplates_contacts_1','Contact');
		
		$project->load_relationship('project_users_1');
		foreach($template_users as $user){
			$project->project_users_1->add($user->id);
		}
		
		$project->load_relationship('project_contacts_1');
		foreach($template_contacts as $contact){
			$project->project_contacts_1->add($contact->id);
		}


        $template->load_relationship('am_projecttemplates_project_1');
        $template->am_projecttemplates_project_1->add($project->id);

        //Get related project template tasks. Using sql query so that the results can be ordered.
        $get_tasks = "SELECT * FROM am_tasktemplates
                        WHERE id
                        IN (
                            SELECT am_tasktemplates_am_projecttemplatesam_tasktemplates_idb
                            FROM am_tasktemplates_am_projecttemplates_c
                            WHERE am_tasktemplates_am_projecttemplatesam_projecttemplates_ida = '".$template_id."'
                            AND deleted =0
                        )
                        AND deleted =0
                        ORDER BY am_tasktemplates.order_number ASC";
        $tasks = $db->query($get_tasks);
        //Create new project tasks from the template tasks
        $count=1;
        while($row = $db->fetchByAssoc($tasks))
        {
            $project_task = new ProjectTask();
            $project_task->name = $row['name'];
            $project_task->status = $row['status'];
            $project_task->priority = strtolower($row['priority']);
            $project_task->percent_complete = $row['percent_complete'];
            $project_task->predecessors = $row['predecessors'];
            $project_task->milestone_flag = $row['milestone_flag'];
            $project_task->relationship_type = $row['relationship_type'];
            $project_task->task_number = $row['task_number'];
            $project_task->order_number = $row['order_number'];
            $project_task->estimated_effort = $row['estimated_effort'];
            $project_task->utilization = $row['utilization'];
            
			if($copy_all == 0 && !in_array( $row['id'],$copy_tasks))
				$project_task->assigned_user_id = NULL;
            else
				$project_task->assigned_user_id = $row['assigned_user_id'];

			$project_task->description = $row['description'];
            $project_task->duration = $row['duration'];
			$project_task->duration_unit = $duration_unit;
            $project_task->project_task_id = $count;
            //Flag to prevent after save logichook running when project_tasks are created (see custom/modules/ProjectTask/updateProject.php)
            $project_task->set_project_end_date = 0;

            if($count == '1'){
                $project_task->date_start = $start;
                $enddate = $startdate->modify('+'.$row['duration'].' '.$duration_unit);
                $end = $enddate->format('Y-m-d');
                $project_task->date_finish = $end;
                $enddate_array[$count] = $end;
                $GLOBALS['log']->fatal("DATE:". $end);
            }
            else {
                $start_date = $count - 1;
                $startdate = DateTime::createFromFormat('Y-m-d', $enddate_array[$start_date]);
                $GLOBALS['log']->fatal("DATE:". $enddate_array[$start_date]);
                $start = $startdate->format('Y-m-d');
                $project_task->date_start = $start;
                $enddate = $startdate->modify('+'.$row['duration'].' '.$duration_unit);
                $end = $enddate->format('Y-m-d');
                $project_task->date_finish = $end;
                $enddate = $end;
                $enddate_array[$count] = $end;
            }
            $project_task->save();
            //link tasks to the newly created project
            $project_task->load_relationship('projects');
            $project_task->projects->add($project->id);
            //Add assinged users from each task to the project resourses subpanel
            $project->load_relationship('project_users_1');
            $project->project_users_1->add($row['assigned_user_id']);
            $count++;
        }

        //set project end date to the same as end date of the last task
        $GLOBALS['log']->fatal("project end -- DATE:". $end);
		$project->estimated_end_date = $end;
        $project->save();


        //redirct to new project
        SugarApplication::appendErrorMessage($mod_strings["LBL_NEW_PROJECT_CREATED"]);
        $params = array(
            'module'=> 'Project',
            'action'=>'DetailView',
            'record' => $project->id,
        );
        SugarApplication::redirect('index.php?' . http_build_query($params));
    }


    function action_generate_chart(){
        global $db;

        include_once('modules/AM_ProjectTemplates/gantt.php');
        include_once('modules/AM_ProjectTemplates/project_table.php');

        $project_template = new AM_ProjectTemplates();
        $project_template->retrieve($_POST["pid"]);
        
		//Get project tasks
		$project_template->load_relationship('am_tasktemplates_am_projecttemplates');
		$tasks = $project_template->get_linked_beans('am_tasktemplates_am_projecttemplates','AM_TaskTemplates');

		$start_date =  Date('Y-m-d');
		$end_date = Date('Y-m-d', strtotime("+30 days"));

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
                <?php new AM_ProjectTemplatesTable($project_template->id, $tasks);?>
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
		$override_business_hours = intval($_POST['override_business_hours']);
        $task_id = $_POST['task_id'];
        $predecessor = $_POST['predecessor'];
        $rel_type = $_POST['rel_type'];
        $resource = $_POST['resource'];
        $percent = $_POST['percent'];
        $note = $_POST['note'];
        //$actual_duration = $_POST['actual_duration'];

        if($_POST['milestone'] == 'Milestone'){
            $milestone_flag = '1';
        }
        else if($_POST['milestone'] == 'Task'){
            $milestone_flag = '0';
        }

        $project_template = new AM_ProjectTemplates();
        $project_template->retrieve($project_id);


        $dateformat = $current_user->getPreference('datef');

        $startdate = DateTime::createFromFormat($dateformat, "01/01/2016");
        $start = $startdate->format('Y-m-d');

        //Take 1 off duration so that task displays in correct number of table cells in gantt chart.
        $duration = $_POST['duration'] -1;

        $duration_unit = $_POST['unit'];
		$actual_duration = 0;
        //Compensate for resulting negative number when a 0 duration is passed in above
        if($duration < 0){
            $duration = 0;
        }

		//
		//code block to calculate end date based on user's business hours
		//
		$enddate = $startdate->modify('+'.$duration.' '.$duration_unit);
		$enddate = $enddate->modify('-1 Days');//readjust it back to remove 1 additional day added
		$enddate = $enddate->format('Y-m-d');
		
		//---------------

        if($percent > 0){

            $status = 'In Progress';
        }
        else {
            $status = 'Not Started';
        }


        //count tasks
		$project_template->load_relationship('am_tasktemplates_am_projecttemplates');
		$tasks = $project_template->get_linked_beans('am_tasktemplates_am_projecttemplates','AM_TaskTemplates');		
		
		$tid = count($tasks) + 1 ;

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
        $task = new AM_TaskTemplates();
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

            $task = new AM_TaskTemplates();
            $task->retrieve($id);
            $task->order_number = $order_number;
            $task->save();

        }
    }
   //returns tasks for predecessor in the add task pop-up form
    function action_get_predecessors(){
        global $mod_strings;
        $project_template = new AM_ProjectTemplates();
        $project_template->retrieve($_REQUEST["project_id"]);

		//Get tasks
		$project_template->load_relationship('am_tasktemplates_am_projecttemplates');
		$tasks = $project_template->get_linked_beans('am_tasktemplates_am_projecttemplates','AM_TaskTemplates');
		echo '<option rel="0" value="0">'.$mod_strings["LBL_NONE"].'</option>';
        foreach ($tasks as $task) {
            echo '<option rel="'.$task->task_number.'" value="'.$task->task_number.'">'.$task->name.'</opion>';
        }
        die();
    }


    function create_task($name, $start, $end, $project_id, $milestone_flag, $status, $project_task_id, $predecessors, $rel_type, $duration, $duration_unit, $resource, $percent_complete, $description,$actual_duration,$order_number){

        $task = new AM_TaskTemplates();
        $task->name = $name;
        //$task->date_start = $start;
        //$task->date_finish = $end;
        //$task->project_id = $project_id;
        $task->milestone_flag = $milestone_flag;
        $task->status = $status;
        $task->task_number = $project_task_id;
        $task->predecessors = $predecessors;
        $task->relationship_type = $rel_type;
        $task->duration = $duration + 1; //+1 to make duration appear correct in project table
        //$task->duration_unit = $duration_unit;
        $task->assigned_user_id = $resource;
        $task->percent_complete = $percent_complete;
        $task->description = $description;
        //$task->actual_duration = $actual_duration;
        $task->order_number = $order_number;
        $task_id = $task->save();

        $project_template = new AM_ProjectTemplates();
        $project_template->retrieve($project_id);
		$project_template->load_relationship('am_tasktemplates_am_projecttemplates');
		$project_template->get_linked_beans('am_tasktemplates_am_projecttemplates','AM_TaskTemplates');
		$project_template->am_tasktemplates_am_projecttemplates->add($task_id);

    }

    function update_task($id, $name, $start, $end, $project_id, $milestone_flag, $status, $predecessors, $rel_type, $duration, $duration_unit, $resource, $percent_complete, $description,$actual_duration){

        $task = new AM_TaskTemplates();
		
        $task->retrieve($id);
		$task->name = $name;
        //$task->date_start = $start;
        //$task->date_finish = $end;
        //$task->project_id = $project_id;
        $task->milestone_flag = $milestone_flag;
        $task->status = $status;
        // $task->parent_task_id = $parent_task_id;
        $task->predecessors = $predecessors;
        $task->relationship_type = $rel_type;
        $task->duration = $duration + 1; //+1 to make duration appear correct in project table
        //$task->duration_unit = $duration_unit;
        $task->assigned_user_id = $resource;
        $task->percent_complete = $percent_complete;
        //$task->actual_duration = $actual_duration;
        $task->description = $description;
        $task->save();

    }



    // Function for basic field validation (present and neither empty nor only white space
    public function IsNullOrEmptyString($question){
        return (!isset($question) || trim($question)==='');
    }


}
