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

    function action_create_project(){

        global $current_user, $db;

        $project_name = $_POST['p_name'];
        $template_id = $_POST['template_id'];
        $project_start = $_POST['start_date'];
        //Get project start date
        $dateformat = $current_user->getPreference('datef');
        $startdate = DateTime::createFromFormat($dateformat, $project_start);
        $start = $startdate->format('Y-m-d');

        $duration_unit = 'Days';


        //$GLOBALS['log']->fatal("name:". $project_name." id:".$template_id);

        //Get the project template
        $template = new AM_ProjectTemplates();
        $template->retrieve($template_id);


        //create project from template
        $project = new Project();
        $project->name = $project_name;
        $project->estimated_start_date = $start;
        $project->status = $template->status;
        $project->priority = $template->priority;
        $project->description = $template->description;
        $project->assigned_user_id = $template->assigned_user_id;
        $project->save();

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
            $project_task->priority = $row['priority'];
            $project_task->percent_complete = $row['percent_complete'];
            $project_task->predecessors = $row['predecessors'];
            $project_task->milestone_flag = $row['milestone_flag'];
            $project_task->relationship_type = $row['relationship_type'];
            $project_task->task_number = $row['task_number'];
            $project_task->order_number = $row['order_number'];
            $project_task->estimated_effort = $row['estimated_effort'];
            $project_task->utilization = $row['utilization'];
            $project_task->assigned_user_id = $row['assigned_user_id'];
            $project_task->description = $row['description'];
            $project_task->duration = $row['duration'];
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
        $project->estimated_end_date = $end;
        $project->save();


        //redirct to new project
        SugarApplication::appendErrorMessage('New project created.');
        $params = array(
            'module'=> 'Project',
            'action'=>'DetailView',
            'record' => $project->id,
        );
        SugarApplication::redirect('index.php?' . http_build_query($params));
    }

}
