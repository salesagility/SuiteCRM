<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

/**
 * STIC 20210430 AAM - Custom Calendar
 * STIC#263
 */

require_once('modules/Calendar/Calendar.php');
// STIC-Custom 20220314 AAM - Adding STIC modules to iCal
// STIC#625
require_once('custom/modules/Calendar/CalendarActivity.php');

class CustomCalendar extends Calendar
{

    // Overriding the array to add Shared Day option
    public $views = array("agendaDay" => array(), "basicDay" => array(), "basicWeek" => array(), "agendaWeek" => array(), "month" => array(), "sharedMonth" => array(), "sharedWeek" => array(), "sharedDay" => array());

    // STIC-Custom 20210430 AAM - Exception for stic_Sessions module
    // STIC#438
    // STIC-Custom 20230811 AAM - Adding Color to Sessions and FollowUps
    // STIC#1192
    // STIC-Custom 20240222 MHP - Adding Work Calendar record in Calendar
    // https://github.com/SinergiaTIC/SinergiaCRM/pull/114
    //
    /**
     * This array overrites the original activityList array. It includes the module stic_Sessions, stic_FollowUps y stic_Work_Calendar
     *
     */
    public $activityList = array(
        "Meetings" => array("showCompleted" => true, "start" => "date_start", "end" => "date_end"),
        "Calls" => array("showCompleted" => true, "start" => "date_start", "end" => "date_end"),
        "Tasks" => array("showCompleted" => true, "start" => "date_due", "end" => "date_due"),
        "stic_Sessions" => array("showCompleted" => true, "start" => "start_date", "end" => "end_date"),
        "stic_FollowUps" => array("showCompleted" => true, "start" => "start_date", "end" => "end_date"),
        "stic_Work_Calendar" => array("showCompleted" => true, "start" => "start_date", "end" => "end_date"),
    );
    // END STIC-Custom

    /**
     * loads array of objects
     * @param User $user user object
     * @param string $type
     */
    public function add_activities($user, $type='sugar')
    {
        global $timedate;
        $start_date_time = $this->date_time;
        if ($this->view == 'agendaWeek'|| $this->view == 'basicWeek'  || $this->view == 'sharedWeek') {
            $start_date_time = CalendarUtils::get_first_day_of_week($this->date_time);
            $end_date_time = $start_date_time->get("+7 days");
        } else {
            if ($this->view == 'month' || $this->view == "sharedMonth") {
                $start_date_time = $this->date_time->get_day_by_index_this_month(0);
                $end_date_time = $start_date_time->get("+".$start_date_time->format('t')." days");
                $start_date_time = CalendarUtils::get_first_day_of_week($start_date_time);
                $end_date_time = CalendarUtils::get_first_day_of_week($end_date_time)->get("+7 days");
            } else {
                $end_date_time = $this->date_time->get("+1 day");
            }
        }
        
        $start_date_time = $start_date_time->get("-5 days"); // 5 days step back to fetch multi-day activities that

        $acts_arr = array();
        if ($type == 'vfb') {
            $acts_arr = CustomCalendarActivity::get_freebusy_activities($user, $start_date_time, $end_date_time);
        } else {
            $acts_arr = CustomCalendarActivity::get_activities($this->activityList, $user->id, $this->show_tasks, $start_date_time, $end_date_time, $this->view, $this->show_calls, $this->show_completed);
        }


        //$this->acts_arr[$user->id] = $acts_arr;
        $this->acts_arr[$user->id] = $acts_arr;
    }

    /**
     * Overriding the funcion load_activities(). It includes an exception for the stic_Sessions module regarding
     * the definition of the variables duration_hours and duration_minutes
     */
    public function load_activities()
    {
        // STIC-Custom 20211015 - Filters the $this->act_arr array
        // STIC#438
        // STIC-Custom 20240222 MHP - Adding Work Calendar record in Calendar
        // https://github.com/SinergiaTIC/SinergiaCRM/pull/114
        $this->acts_arr = $this->filterSticSessions($this->acts_arr);
        $this->acts_arr = $this->filterSticFollowUps($this->acts_arr);
        $this->acts_arr = $this->filterSticWorkCalendar($this->acts_arr);

        $field_list = CalendarUtils::get_fields();

        $i = 0;
        foreach ($this->acts_arr as $user_id => $acts) {
            if (isset($acts) && empty($acts)) {
                $shared_calendar_separate = $GLOBALS['current_user']->getPreference('calendar_display_shared_separate');
                if (is_null($shared_calendar_separate)) {
                    $shared_calendar_separate = SugarConfig::getInstance()->get('calendar.calendar_display_shared_separate', true);
                }
                //if no calendar items we add the user to the list.
                if ($shared_calendar_separate) {
                    //$this->items[ $item['user_id'] ][] = $item;
                    $this->items[$user_id][] = array();
                } else {
                    $this->items[$GLOBALS['current_user']->id][] = array();
                }
                continue;
            }
            foreach ($acts as $act) 
            {
                $item = array();
                $item['user_id'] = $user_id;
                $item['module_name'] = $act->sugar_bean->module_dir;
                $item['type'] = strtolower($act->sugar_bean->object_name);
                $item['assigned_user_id'] = $act->sugar_bean->assigned_user_id;
                $item['record'] = $act->sugar_bean->id;

                // STIC-Custom 20230918 - ART - Incorrect names with quotes in the Calendar
                // STIC#1222
                // $item['name'] = $act->sugar_bean->name . ' ' . $act->sugar_bean->assigned_user_name;
                $item['name'] = html_entity_decode($act->sugar_bean->name, ENT_QUOTES) . ' ' . $act->sugar_bean->assigned_user_name;
                // END STIC-Custom 20230919 - ART

                $item['description'] = $act->sugar_bean->description;

                if (isset($act->sugar_bean->duration_hours)) {
                    $item['duration_hours'] = $act->sugar_bean->duration_hours;
                    $item['duration_minutes'] = $act->sugar_bean->duration_minutes;
                }

                $item['detail'] = 0;
                $item['edit'] = 0;

                if ($act->sugar_bean->ACLAccess('DetailView')) {
                    $item['detail'] = 1;
                }
                if ($act->sugar_bean->ACLAccess('Save')) {
                    $item['edit'] = 1;
                }

                if (empty($act->sugar_bean->id)) {
                    $item['detail'] = 0;
                    $item['edit'] = 0;
                }

                if (!empty($act->sugar_bean->repeat_parent_id)) {
                    $item['repeat_parent_id'] = $act->sugar_bean->repeat_parent_id;
                }

                if ($item['detail'] == 1) {
                    if (isset($field_list[$item['module_name']])) {
                        foreach ($field_list[$item['module_name']] as $field) {
                            if (!isset($item[$field]) && isset($act->sugar_bean->$field)) {
                                $item[$field] = $act->sugar_bean->$field;
                                if (empty($item[$field])) {
                                    $item[$field] = "";
                                }
                            }
                        }
                    }
                }

                if (!empty($act->sugar_bean->parent_type) && !empty($act->sugar_bean->parent_id)) {
                    $focus = BeanFactory::getBean($act->sugar_bean->parent_type, $act->sugar_bean->parent_id);
                    // If the bean wasn't loaded, e.g. insufficient permissions
                    if (!empty($focus)) {
                        $item['related_to'] = $focus->name;
                    }
                }

                if (!isset($item['duration_hours']) || empty($item['duration_hours'])) {
                    $item['duration_hours'] = 0;
                }
                if (!isset($item['duration_minutes']) || empty($item['duration_minutes'])) {
                    $item['duration_minutes'] = 0;
                }

                // STIC-Custom 20210430 AAM - Exception for stic_Sessions module
                // STIC#438
                // STIC-Custom 20230811 AAM - Adding Color to Sessions and FollowUps
                // STIC#1192
                // STIC-Custom 20240222 MHP - Adding Work Calendar record in Calendar
                // https://github.com/SinergiaTIC/SinergiaCRM/pull/114
                if ($item['module_name'] == 'stic_Sessions') {
                    $totalMinutes = $act->sugar_bean->duration * 60;
                    $item['duration_hours'] = floor($totalMinutes / 60);
                    $item['duration_minutes'] = round($totalMinutes - $item['duration_hours'] * 60);
                    $item['color'] = $act->sugar_bean->color ? '#'.$act->sugar_bean->color : '';
                }

                if ($item['module_name'] == 'stic_FollowUps') {
                    $totalMinutes = $act->sugar_bean->duration;
                    $item['duration_hours'] = floor($totalMinutes / 60);
                    $item['duration_minutes'] = round($totalMinutes - $item['duration_hours'] * 60);
                    $item['color'] = $act->sugar_bean->color ? '#'.$act->sugar_bean->color : '';
                }
                if ($item['module_name'] == 'stic_Work_Calendar') {
                    $item['event_type'] = $act->sugar_bean->type;
                    $totalMinutes = $act->sugar_bean->duration * 60;
                    $item['duration_hours'] = floor($totalMinutes / 60);
                    $item['duration_minutes'] = round($totalMinutes - $item['duration_hours'] * 60);
                    $item['rendering'] = 'background';
                }
                // END STIC-Custom


                if (isset($this->activityList[$act->sugar_bean->module_name]['start']) && !empty($this->activityList[$act->sugar_bean->module_name]['start'])) {
                    $item = array_merge($item, CalendarUtils::get_time_data($act->sugar_bean, $this->activityList[$act->sugar_bean->module_name]['start'], $this->activityList[$act->sugar_bean->module_name]['end']));
                } else {
                    $item = array_merge($item, CalendarUtils::get_time_data($act->sugar_bean));
                }

                $shared_calendar_separate = $GLOBALS['current_user']->getPreference('calendar_display_shared_separate');
                if (is_null($shared_calendar_separate)) {
                    $shared_calendar_separate = SugarConfig::getInstance()->get('calendar.calendar_display_shared_separate', true);
                }
                //if no calendar items we add the user to the list.
                if ($shared_calendar_separate) {
                    $this->items[$item['user_id']][] = $item;
                } else {
                    $this->items[$GLOBALS['current_user']->id][] = $item;
                }
            }
            $i++;
        }
    }

    /**
     * STIC-Custom 20211015 - Includes/excludes the stic_Sessions records from the activities array according to filters values.
     * Current existing filters:
     * - stic_sessions_stic_centers
     * - stic_sessions_stic_events
     * - stic_sessions_contacts
     * - stic_sessions_projects
     * The filters values are retrieved from the user's configuration
     * STIC#438
     *
     * @return void
     */
    protected function filterSticSessions($activitiesArray)
    {
        global $current_user, $db;
        $userSessionFilters = array(
            'stic_sessions_color' => $current_user->getPreference('calendar_stic_sessions_color'),
            'stic_sessions_activity_type' => $current_user->getPreference('calendar_stic_sessions_activity_type'),
            'stic_sessions_stic_events_type' => $current_user->getPreference('calendar_stic_sessions_stic_events_type'),
            'stic_sessions_stic_events' => $current_user->getPreference('calendar_stic_sessions_stic_events_id'),
            'stic_sessions_stic_centers' => $current_user->getPreference('calendar_stic_sessions_stic_centers_id'),
            'stic_sessions_responsible' => $current_user->getPreference('calendar_stic_sessions_responsible_id'),
            'stic_sessions_contacts' => $current_user->getPreference('calendar_stic_sessions_contacts_id'),
            'stic_sessions_projects' => $current_user->getPreference('calendar_stic_sessions_projects_id'),
        );
        foreach ($activitiesArray as $userKey => $activityArray) {
            foreach ($activityArray as $activityKey => $activity) {
                $bean = $activity->sugar_bean;
                if ($bean->module_name == 'stic_Sessions') {
                    foreach ($userSessionFilters as $filterKey => $filterValue) {
                        if (!empty($filterValue)) {
                            switch ($filterKey) {
                                case 'stic_sessions_color': {
                                    if (!in_array($bean->color, $filterValue)) {
                                        unset($activitiesArray[$userKey][$activityKey]);
                                    }
                                    break;
                                }
                                case 'stic_sessions_activity_type': {
                                    require_once('include/export_utils.php');
                                    $unencodedActivityType = unencodeMultienum($bean->activity_type);
                                    if (empty(array_intersect($filterValue, $unencodedActivityType))) {
                                        unset($activitiesArray[$userKey][$activityKey]);
                                    }
                                    break;
                                }
                                case 'stic_sessions_stic_events_type': {
                                    $relationship = 'stic_sessions_stic_events';
                                    if (!$bean->load_relationship($relationship)) {
                                        $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': Error loading relationship: ' . $relationship);
                                    } else {
                                        $relatedBean = array_pop($bean->$relationship->getBeans());
                                        if (!in_array($relatedBean->type, $filterValue)) {
                                            unset($activitiesArray[$userKey][$activityKey]);
                                        }
                                    }
                                    break;
                                }
                                case 'stic_sessions_responsible': {
                                    // This a Related type field relationship, therefore we don't need to load relationship
                                    $relationship = 'contact_id_c';
                                    if ($bean->$relationship != $filterValue) {
                                        // If the session record does not match the filter value, remove it from the activities array
                                        unset($activitiesArray[$userKey][$activityKey]);
                                    }
                                    break;
                                }
                                case 'stic_sessions_stic_events': {
                                    $relationship = 'stic_sessions_stic_events';
                                    if (!$bean->load_relationship($relationship)) {
                                        $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': Error loading relationship: ' . $relationship);
                                    } else {
                                        $relatedBean = array_pop($bean->$relationship->getBeans());
                                        if ($relatedBean->id != $filterValue) {
                                            // If the session record does not match the filter value, remove it from the activities array
                                            unset($activitiesArray[$userKey][$activityKey]);
                                        }
                                    }
                                    break;
                                }
                                
                                case 'stic_sessions_contacts': {
                                    // A SQL query is used because we need to find the contacts linked to the event registrations
                                    $query = "SELECT
                                    count(srcc.id) as 'contact'
                                from
                                    stic_registrations_contacts_c srcc
                                JOIN stic_registrations sr ON
                                    sr.id = srcc.stic_registrations_contactsstic_registrations_idb
                                JOIN stic_registrations_stic_events_c srsec ON
                                    srsec.stic_registrations_stic_eventsstic_registrations_idb = sr.id
                                JOIN stic_events se ON
                                    se.id = srsec.stic_registrations_stic_eventsstic_events_ida
                                JOIN stic_sessions_stic_events_c sssec ON
                                    sssec.stic_sessions_stic_eventsstic_events_ida = se.id
                                WHERE
                                    sssec.stic_sessions_stic_eventsstic_sessions_idb = '$bean->id'
                                    AND srcc.stic_registrations_contactscontacts_ida = '$filterValue'
                                    AND srcc.deleted = 0
                                    AND sr.deleted = 0
                                    AND srsec.deleted = 0
                                    AND se.deleted = 0
                                    AND sssec.deleted = 0";
                                    $res = $db->query($query);
                                    $row = $db->fetchByAssoc($res);
                                    if (!$row['contact']) {
                                        // If the session record does not match the filter value, remove it from the activities array
                                        unset($activitiesArray[$userKey][$activityKey]);
                                    }
                                    break;
                                }
                                case 'stic_sessions_projects': {
                                    $eventRelationship = 'stic_sessions_stic_events';
                                    $projectRelationship = 'stic_events_project';
                                    if (!$bean->load_relationship($eventRelationship)) {
                                        $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': Error loading stic_sessions_stic_events relationship: ' . $eventRelationship);
                                    } else {
                                        $eventBean = array_pop($bean->$eventRelationship->getBeans());
                                        if (!$eventBean->load_relationship($projectRelationship)) {
                                            $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': Error loading stic_events_project relationship: ' . $projectRelationship);
                                        } else {
                                            $projectBean = array_pop($eventBean->$projectRelationship->getBeans());
                                            if ($projectBean->id != $filterValue) {
                                                // If the session record does not match the filter value, remove it from the activities array
                                                unset($activitiesArray[$userKey][$activityKey]);
                                            }
                                        }
                                    }
                                    break;
                                }
                                case 'stic_sessions_stic_centers': {
                                    $eventRelationship = 'stic_sessions_stic_events';
                                    $centersRelationship = 'stic_centers_stic_events';
                                    if (!$bean->load_relationship($eventRelationship)) {
                                        $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': Error loading stic_sessions_stic_events relationship: ' . $eventRelationship);
                                    } else {
                                        $eventBean = array_pop($bean->$eventRelationship->getBeans());
                                        if (!$eventBean->load_relationship($centersRelationship)) {
                                            $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': Error loading stic_centers_stic_events relationship: ' . $centersRelationship);
                                        } else {
                                            $centersBean = array_pop($eventBean->$centersRelationship->getBeans());
                                            if ($centersBean->id != $filterValue) {
                                                // If the session record does not match the filter value, remove it from the activities array
                                                unset($activitiesArray[$userKey][$activityKey]);
                                            }
                                        }
                                    }
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $activitiesArray;
    }

    /**
     * STIC-Custom 20220301 AAM - Includes/excludes the stic_FollowUps records from the activities array according to filters values.
     * Current existing filters:
     * - stic_followups_type
     * - stic_followups_contacts
     * - stic_followups_projects
     * The filters values are retrieved from the user's configuration
     * STIC#598
     *
     * @return void
     */
    protected function filterSticFollowUps($activitiesArray)
    {
        global $current_user, $db;
        $userSessionFilters = array(
            'stic_followups_color' => $current_user->getPreference('calendar_stic_followups_color'),
            'stic_followups_type' => $current_user->getPreference('calendar_stic_followups_type'),
            'stic_followups_contacts' => $current_user->getPreference('calendar_stic_followups_contacts_id'),
            'stic_followups_projects' => $current_user->getPreference('calendar_stic_followups_projects_id'),
        );
        foreach ($activitiesArray as $userKey => $activityArray) {
            foreach ($activityArray as $activityKey => $activity) {
                $bean = $activity->sugar_bean;
                if ($bean->module_name == 'stic_FollowUps') {
                    foreach ($userSessionFilters as $filterKey => $filterValue) {
                        if (!empty($filterValue)) {
                            switch ($filterKey) {
                                case 'stic_followups_color': {
                                    if (!in_array($bean->color, $filterValue)) {
                                        unset($activitiesArray[$userKey][$activityKey]);
                                    }
                                    break;
                                }
                                case 'stic_followups_type': {
                                        if (!in_array($bean->type, $filterValue)) {
                                            unset($activitiesArray[$userKey][$activityKey]);
                                        }
                                        break;
                                    }
                                case 'stic_followups_contacts': {
                                        $relationship = 'stic_followups_contacts';
                                        if (!$bean->load_relationship($relationship)) {
                                            $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': Error loading relationship: ' . $relationship);
                                        } else {
                                            $relatedBean = array_pop($bean->$relationship->getBeans());
                                            if ($relatedBean->id != $filterValue) {
                                                // If the followup record does not match the filter value, remove it from the activities array
                                                unset($activitiesArray[$userKey][$activityKey]);
                                            }
                                        }
                                        break;
                                    }
                                case 'stic_followups_projects': {
                                        $relationship = 'stic_followups_project';
                                        if (!$bean->load_relationship($relationship)) {
                                            $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': Error loading relationship: ' . $relationship);
                                        } else {
                                            $relatedBean = array_pop($bean->$relationship->getBeans());
                                            if ($relatedBean->id != $filterValue) {
                                                // If the followup record does not match the filter value, remove it from the activities array
                                                unset($activitiesArray[$userKey][$activityKey]);
                                            }
                                        }
                                        break;
                                    }
                            }
                        }
                    }
                }
            }
        }
        return $activitiesArray;
    }

    /**
     * STIC-Custom 20240222 MHP - Includes/excludes the stic_Work_Calendar records from the activities array according to filters values.
     * https://github.com/SinergiaTIC/SinergiaCRM/pull/114
     * 
     * Current existing filters:
     * - stic_work_calendar_type
     * - assigned_user_department
     * The filters values are retrieved from the user's configuration
     *
     * @return void
     */
    protected function filterSticWorkCalendar($activitiesArray)
    {
        global $current_user, $db;
        $userSticWorkCalendarFilters = array(
            'stic_work_calendar_type' => $current_user->getPreference('calendar_stic_work_calendar_type'),
            'stic_work_calendar_assigned_user_department' => $current_user->getPreference('calendar_stic_work_calendar_assigned_user_department'),            
        );
        foreach ($activitiesArray as $userKey => $activityArray) {
            foreach ($activityArray as $activityKey => $activity) {
                $bean = $activity->sugar_bean;
                if ($bean->module_name == 'stic_Work_Calendar') {
                    foreach ($userSticWorkCalendarFilters as $filterKey => $filterValue) {
                        if (!empty($filterValue)) {
                            switch ($filterKey) {
                                case 'stic_work_calendar_type': {
                                    if (!in_array($bean->type, $filterValue)) {
                                        unset($activitiesArray[$userKey][$activityKey]);
                                    }
                                    break;
                                }
                                case 'stic_work_calendar_assigned_user_department': {
                                    $assignedUser = BeanFactory::getBean('Users', $bean->assigned_user_id);
                                    if ($assignedUser->department != $filterValue) {
                                        unset($activitiesArray[$userKey][$activityKey]);
                                    }
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $activitiesArray;
    }

    /**
     * Overriding the function get_neighbor_date_str(), so it can include the sharedDay option in the condition.
     */
    public function get_neighbor_date_str($direction)
    {
        if ($direction == "previous") {
            $sign = "-";
        } else {
            $sign = "+";
        }

        if ($this->view == 'month' || $this->view == "sharedMonth") {
            $day = $this->date_time->get_day_by_index_this_month(0)->get($sign . "1 month")->get_day_begin(1);
        } else {
            if ($this->view == 'agendaWeek' || $this->view == 'sharedWeek' || $this->view == 'basicWeek') {
                $day = CalendarUtils::get_first_day_of_week($this->date_time);
                $day = $day->get($sign . "7 days");
            } else {
                // STIC-Custom 20211026 AAM - Adding sharedDay option
                // STIC#450
                // if ($this->view == 'agendaDay' || $this->view == 'basicDay') {
                if ($this->view == 'agendaDay' || $this->view == 'sharedDay' || $this->view == 'basicDay') {
                    $day = $this->date_time->get($sign . "1 day")->get_day_begin();
                } else {
                    if ($this->view == 'year') {
                        $day = $this->date_time->get($sign . "1 year")->get_day_begin();
                    } else {
                        $calendarStrings = return_module_language($GLOBALS['current_language'], 'Calendar');
                        return $calendarStrings['ERR_NEIGHBOR_DATE'];
                    }
                }
            }
        }
        return $day->get_date_str();
    }
}
