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
 * @Package Gantt chart
 * @copyright Andrew Mclaughlan 2014
 * @author Andrew Mclaughlan <andrew@mclaughlan.info>
 */

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');


class ProjectViewGanttChart extends SugarView {

    //Constructor
    public function __construct() {
        parent::SugarView();
    }


    public function display() {

        global $db, $mod_strings, $app_list_strings;

        echo '<link rel="stylesheet" type="text/css" href="modules/Project/css/style.css" />';
        echo '<link rel="stylesheet" type="text/css" href="modules/Project/qtip/jquery.qtip.min.css" />';
        echo '<script type="text/javascript" src="modules/Project/js/main_lib.js"></script>';
        echo '<script type="text/javascript" src="modules/Project/js/splitter.js"></script>';
        echo '<script type="text/javascript" src="modules/Project/js/jquery.blockUI.js"></script>';
        echo '<script type="text/javascript" src="modules/Project/js/jquery.validate.min.js"></script>';

        $project = new Project();
        $project->retrieve($_REQUEST["project_id"]);
        //Get project resources (users & contacts)
        $resources1 = $project->get_linked_beans('project_users_1','User');
        $resources2 = $project->get_linked_beans('project_contacts_1','Contact');
        //Combine resources into array of objects
        $resource_array = array();
        foreach($resources1 as $user){
            $resource = new stdClass;
            $resource->id = $user->id;
            $resource->name = $user->name;
            $resource->type = 'user';
            $resource_array[] = $resource;
        }
        foreach($resources2 as $contact){
            $resource = new stdClass;
            $resource->id = $contact->id;
            $resource->name = $contact->name;
            $resource->type = 'contact';
            $resource_array[] = $resource;
        }


        //Get the start and end date of the project in database format
        $query = "SELECT estimated_start_date FROM project WHERE id = '{$project->id}'";
        $start_date = $db->getOne($query);
        $query = "SELECT estimated_end_date FROM project WHERE id = '{$project->id}'";
        $end_date = $db->getOne($query);
?>
        <!--Create task pop-up-->
        <div style="display: none;">
            <div id="dialog"  title="<?php echo $mod_strings['LBL_ADD_NEW_TASK']; ?>">
                <p>
                    <?php echo $mod_strings['LBL_EDIT_TASK_PROPERTIES']; ?>
                </p>
                <form id="popup_form">
                    <fieldset>
                        <input type="hidden" name="project_id" id="project_id" value="<?php echo $project->id; ?>">
                        <input type="text" style="display: none;" name="task_id" id="task_id" value="">
                        <input type="radio" name="Milestone" value="Subtask" checked="checked" id="Subtask" />
                        <label id="Subtask_label" for="Subtask"><?php echo $mod_strings['LBL_SUBTASK'];?></label>
                        <input type="radio" name="Milestone" value="Milestone" id="Milestone" />
                        <label id="Milestone_label" for="Milestone"><?php echo $mod_strings['LBL_MILESTONE_FLAG'];?></label>&nbsp;<br /><br />
                        <label id="parent_task_id" for="parent_task" style="display: none;"><?php echo $mod_strings['LBL_PARENT_TASK_ID']; ?></label>
                        <input id="parent_task" class="text ui-widget-content ui-corner-all" style="display: none;" type="text" name="parent_task" value="" />
                        <label for="name"><?php echo $mod_strings['LBL_TASK_NAME']; ?></label>
                        <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
                        <label for="Predecessor"><?php echo $mod_strings['LBL_PREDECESSORS'];?></label>
                        <?php
                        echo '<select id="Predecessor" name="Predecessor" class="text ui-widget-content ui-corner-all" />';
                       /* foreach ($tasks as $task) {
                            echo '<option rel="'.$task->id.'" value="'.$task->order_number.'">'.$task->name.'</opion>';
                        }*/
                        echo '</select>';
                        ?>
                        <label for="relation_type"><?php echo $mod_strings['LBL_RELATIONSHIP_TYPE'];?></label>
                        <?php
                        echo '<select id="relation_type" name="relation_type" class="text ui-widget-content ui-corner-all">
                                '.get_select_options_with_id($app_list_strings['relationship_type_list'],'').'
                        </select>';

                        ?>
                        <label for="Lag"><?php echo $mod_strings['LBL_LAG'];?></label>
                        <input type="text" name="Lag" value="0" id="Lag" class="text ui-widget-content ui-corner-all" />
                        <select id="Lag_unit" name="Lag_unit" class="text ui-widget-content ui-corner-all" />
                        <option value="Days"><?php echo $mod_strings['LBL_DAYS'];?></option>
                        <!-- <option value="Hours">--><?php //echo $mod_strings['LBL_HOURS'];?><!--</option>-->
                        </select>
                        <label for="start"><?php echo $mod_strings['LBL_START'];?></label>
                        <input type="text" name="Start" id="Start" value="" class="text ui-widget-content ui-corner-all" />
                        <script type="text/javascript">
                            var now = new Date();
                            Calendar.setup ({
                                inputField : "Start",
                                ifFormat : cal_date_format,
                                daFormat : "%m/%d/%Y %I:%M%P",
                                button : "Start",
                                singleClick : true,
                                step : 1,
                                weekNumbers: false,
                                startWeekday: 0
                            });
                        </script>
                        <label for="Duration"><?php echo $mod_strings['LBL_DURATION_TITLE'];?></label>
                        <input type="text" name="Duration" id="Duration" class="text ui-widget-content ui-corner-all" />
                        <select id="Duration_unit" name="Duration_unit" class="text ui-widget-content ui-corner-all" />
                        <?php
                        echo get_select_options_with_id($app_list_strings['duration_unit_dom'],'');
                        ?>
                        </select>
                        <label for="Resources"><?php echo $mod_strings['LBL_ASSIGNED_USER_ID'];?></label>
                        <?php
                        echo '<select id="Resources" name="Resources" class="text ui-widget-content ui-corner-all" />';
                        echo '<option value="0">'.$mod_strings['LBL_UNASSIGNED'].'</option>';
                        foreach ($resource_array as $resource) {
                            echo '<option rel="'.$resource->type.'" value="'.$resource->id.'">'.$resource->name.'</opion>';
                        }
                        echo '</select>';
                        ?>
                        <label for="%Complete"><?php echo $mod_strings['LBL_PERCENT_COMPLETE'];?></label>
                        <input type="text" name="Complete" id="Complete" value="0" class="text ui-widget-content ui-corner-all" />
                        <label for="Actual_duration"><?php echo $mod_strings['LBL_ACTUAL_DURATION'];?></label>
                        <input type="text" name="Actual_duration" id="Actual_duration" value="" class="text ui-widget-content ui-corner-all" />
                        <label for="Notes"><?php echo $mod_strings['LBL_DESCRIPTION'];?></label>
                        <textarea id="Notes" cols="34" name="Notes" class="text ui-widget-content ui-corner-all"></textarea>
                    </fieldset>
                </form>
            </div>
            <!--Delete task pop-up-->
            <div id="delete_dialog" title="<?php echo $mod_strings['LBL_DELETE_TASK']; ?>">
                <p>
                    Are you sure you want to delete this task?
                </p>
            </div>
        </div>
        <!-- Pop-up End -->


        <!--Mark-up for the main body of the view-->
        <div id="wrapper">
            <table id="header_table">
                <tr>
                    <td colspan="4"><h2><a title="<?php echo $mod_strings['LBL_PROJECT_TITLE_HOVER'];?>" href="index.php?module=Project&action=DetailView&record=<?php echo $project->id;?>"><?php echo $project->name;?></a></h2></td>
                </tr>
                <tr>
                    <td class="heading"><?php echo $mod_strings['LBL_START'];?></td>
                    <td><?php echo $project->estimated_start_date;?></td>
                    <td class="heading"><?php echo $mod_strings['LBL_FINISH'];?></td>
                    <td><?php echo $project->estimated_end_date;?></td>
                </tr>
                <tr>
                    <td class="heading"><?php echo $mod_strings['LBL_VIEW_GANTT_DURATION'];?></td>
                    <td><?php echo $this->time_range($start_date, $end_date);?></td>
                    <td class="heading"><?php echo $mod_strings['LBL_STATUS'];?></td>
                    <td><?php echo $app_list_strings['project_status_dom'][$project->status];?></td>
                </tr>
                <tr>
                    <td class="heading"><?php echo $mod_strings['LBL_ASSIGNED_USER_NAME'];?></td>
                    <td><?php echo $project->assigned_user_name;?></td>
                    <td class="heading"><?php echo $mod_strings['LBL_PRIORITY'];?></td>
                    <td><?php echo $app_list_strings['projects_priority_options'][$project->priority];?></td>
                </tr>
                <tr>
                    <td class="heading"><?php echo $mod_strings['LBL_DESCRIPTION'];?></td>
                    <td colspan="3"><?php echo $project->description;?></td>
                </tr>
                <tr>
                    <td class="header_gap" colspan="4">
                        <span id="exportToPDFSpan">
                            <?php
                                if(ACLController::checkAccess('Project', 'edit', true)){
                                    echo '<button id="add_button" class="gantt_button">Add New Task</button>';
                                    echo '<input id="is_editable" name="is_editable" type="hidden" value="1" >';
                                }
                            ?>
                        </span>
                    </td>
                </tr>
            </table>
            <input id="project_id" type="hidden" name="project_id" value="<?php echo $_REQUEST["project_id"];?>" />
            <div id="project_wrapper">


            </div>
        </div>
        <!--Main body end-->
<?php

    }

    //Returns the time span between two dates in years  months and days
    function time_range($start_date, $end_date){
        global $mod_strings;

        $datetime1 = new DateTime($start_date);
        $datetime2 = new DateTime($end_date);
        $datetime2->add(new DateInterval('P1D')); //Add 1 day to include the end date as a day
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%m '.$mod_strings['LBL_MONTHS'].', %d '.$mod_strings['LBL_DAYS']);
    }
}