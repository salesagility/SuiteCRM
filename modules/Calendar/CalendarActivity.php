<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/




require_once('include/utils/activity_utils.php');

class CalendarActivity {
	var $sugar_bean;
	var $start_time;
	var $end_time;

	function __construct($args){
		// if we've passed in an array, then this is a free/busy slot
		// and does not have a sugarbean associated to it
		global $timedate;

		if ( is_array ( $args )){
			$this->start_time = clone $args[0];
			$this->end_time = clone $args[1];
			$this->sugar_bean = null;
			$timedate->tzGMT($this->start_time);
			$timedate->tzGMT($this->end_time);
			return;
		}

	    // else do regular constructor..

	    	$sugar_bean = $args;
		$this->sugar_bean = $sugar_bean;


        if ($sugar_bean->object_name == 'Task'){
            if (!empty($this->sugar_bean->date_start))
            {
                $this->start_time = $timedate->fromUser($this->sugar_bean->date_start);
            }
            else {
                $this->start_time = $timedate->fromUser($this->sugar_bean->date_due);
            }
            if ( empty($this->start_time)){
                return;
            }
            $this->end_time = $timedate->fromUser($this->sugar_bean->date_due);
        }else{
            $this->start_time = $timedate->fromUser($this->sugar_bean->date_start);
            if ( empty($this->start_time)){
                return;
            }
			$hours = $this->sugar_bean->duration_hours;
			if(empty($hours)){
			    $hours = 0;
			}
			$mins = $this->sugar_bean->duration_minutes;
			if(empty($mins)){
			    $mins = 0;
			}
			$this->end_time = $this->start_time->get("+$hours hours $mins minutes");
		}
		// Convert it back to database time so we can properly manage it for getting the proper start and end dates
		$timedate->tzGMT($this->start_time);
		$timedate->tzGMT($this->end_time);
	}

	/**
	 * Get where clause for fetching entried from DB
	 * @param string $table_name t
	 * @param string $rel_table table for accept status, not used in Tasks
	 * @param SugarDateTime $start_ts_obj start date
	 * @param SugarDateTime $end_ts_obj end date
	 * @param string $field_name date field in table
	 * @param string $view view; not used for now, left for compatibility
	 * @return string
	 */
	function get_occurs_within_where_clause($table_name, $rel_table, $start_ts_obj, $end_ts_obj, $field_name='date_start', $view){
		global $timedate;

		$start = clone $start_ts_obj;
		$end = clone $end_ts_obj;

		$field_date = $table_name.'.'.$field_name;
		$start_day = $GLOBALS['db']->convert("'{$start->asDb()}'",'datetime');
		$end_day = $GLOBALS['db']->convert("'{$end->asDb()}'",'datetime');

		$where = "($field_date >= $start_day AND $field_date < $end_day";
		if($rel_table != ''){
			$where .= " AND $rel_table.accept_status != 'decline'";
		}

		$where .= ")";
		return $where;
	}

	function get_freebusy_activities($user_focus, $start_date_time, $end_date_time){
		$act_list = array();
		$vcal_focus = new vCal();
		$vcal_str = $vcal_focus->get_vcal_freebusy($user_focus);

		$lines = explode("\n",$vcal_str);
		$utc = new DateTimeZone("UTC");
	 	foreach ($lines as $line){
			if ( preg_match('/^FREEBUSY.*?:([^\/]+)\/([^\/]+)/i',$line,$matches)){
			  $dates_arr = array(SugarDateTime::createFromFormat(vCal::UTC_FORMAT, $matches[1], $utc),
				              SugarDateTime::createFromFormat(vCal::UTC_FORMAT, $matches[2], $utc));
			  $act_list[] = new CalendarActivity($dates_arr);
			}
		}
		return $act_list;
	}

	/**
	 * Get array of activities
	 * @param string $user_id
	 * @param boolean $show_tasks
	 * @param SugarDateTime $view_start_time start date
	 * @param SugarDateTime $view_end_time end date
	 * @param string $view view; not used for now, left for compatibility
	 * @param boolean $show_calls
	 * @param boolean $show_completed use to allow filtering completed events 
	 * @return array
	 */
 	function get_activities($user_id, $show_tasks, $view_start_time, $view_end_time, $view, $show_calls = true, $show_completed = true)
 	{
		global $current_user;
		$act_list = array();
		$seen_ids = array();
		
		$completedCalls = '';
		$completedMeetings = '';
		$completedTasks = '';
		if (!$show_completed)
		{
		    $completedCalls = " AND calls.status = 'Planned' ";
		    $completedMeetings = " AND meetings.status = 'Planned' ";
		    $completedTasks = " AND tasks.status != 'Completed' ";
		}
		
		// get all upcoming meetings, tasks due, and calls for a user
		if(ACLController::checkAccess('Meetings', 'list', $current_user->id == $user_id)) {
			$meeting = new Meeting();

			if($current_user->id  == $user_id) {
				$meeting->disable_row_level_security = true;
			}

			$where = CalendarActivity::get_occurs_within_where_clause($meeting->table_name, $meeting->rel_users_table, $view_start_time, $view_end_time, 'date_start', $view);
			$where .= $completedMeetings;
			$focus_meetings_list = build_related_list_by_user_id($meeting, $user_id, $where);
			foreach($focus_meetings_list as $meeting) {
				if(isset($seen_ids[$meeting->id])) {
					continue;
				}

				$seen_ids[$meeting->id] = 1;
				$act = new CalendarActivity($meeting);

				if(!empty($act)) {
					$act_list[] = $act;
				}
			}
		}

		if($show_calls){
			if(ACLController::checkAccess('Calls', 'list',$current_user->id  == $user_id)) {
				$call = new Call();

				if($current_user->id  == $user_id) {
					$call->disable_row_level_security = true;
				}

				$where = CalendarActivity::get_occurs_within_where_clause($call->table_name, $call->rel_users_table, $view_start_time, $view_end_time, 'date_start', $view);
				$where .= $completedCalls;
				$focus_calls_list = build_related_list_by_user_id($call, $user_id, $where);

				foreach($focus_calls_list as $call) {
					if(isset($seen_ids[$call->id])) {
						continue;
					}
					$seen_ids[$call->id] = 1;

					$act = new CalendarActivity($call);
					if(!empty($act)) {
						$act_list[] = $act;
					}
				}
			}
		}


		if($show_tasks){
			if(ACLController::checkAccess('Tasks', 'list',$current_user->id == $user_id)) {
				$task = new Task();

				$where = CalendarActivity::get_occurs_within_where_clause('tasks', '', $view_start_time, $view_end_time, 'date_due', $view);
				$where .= " AND tasks.assigned_user_id='$user_id' ";
				$where .= $completedTasks;

				$focus_tasks_list = $task->get_full_list("", $where, true);

				if(!isset($focus_tasks_list)) {
					$focus_tasks_list = array();
				}

				foreach($focus_tasks_list as $task) {
					$act = new CalendarActivity($task);
					if(!empty($act)) {
						$act_list[] = $act;
					}
				}
			}
		}
		return $act_list;
	}
}

?>
