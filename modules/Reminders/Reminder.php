<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/**
 * Reminder class
 *
 */
class Reminder extends Basic
{

    const UPGRADE_VERSION = '7.4.3';

    public $name;

    public $new_schema = true;
    public $module_dir = 'Reminders';
    public $object_name = 'Reminder';
    public $table_name = 'reminders';
    public $tracker_visibility = false;
    public $importable = false;
    public $disable_row_level_security = true;

    public $popup;
    public $email;
    public $email_sent = false;
    public $timer_popup;
    public $timer_email;
    public $related_event_module;
    public $related_event_module_id;

    private static $remindersData = array();

    // ---- save and load remainders on EditViews

    /**
     * Save multiple reminders data from clients Meetings/Calls EditView.
     * Call this static function in save action.
     *
     * @param string $eventModule Event Bean module name (e.g. Meetings, Calls)
     * @param string $eventModuleId Event Bean GUID
     * @param string $remindersDataJson Remainders data as Json string from POST data.
     * @throws Exception throw an Exception if json format is invalid.
     */
    public static function saveRemindersDataJson($eventModule, $eventModuleId, $remindersDataJson)
    {
        $reminderData = json_decode($remindersDataJson);
        if (!json_last_error()) {
            Reminder::saveRemindersData($eventModule, $eventModuleId, $reminderData);
        } else {
            throw new Exception(json_last_error_msg());
        }
    }

    private static function saveRemindersData($eventModule, $eventModuleId, $remindersData)
    {
        $savedReminderIds = array();
        foreach ($remindersData as $reminderData) {
            if (isset($_POST['isDuplicate']) && $_POST['isDuplicate']) {
                $reminderData->id = '';
            }
            $reminderBean = BeanFactory::getBean('Reminders', $reminderData->id);
            $reminderBean->popup = $reminderData->popup;
            $reminderBean->email = $reminderData->email;
            $reminderBean->timer_popup = $reminderData->timer_popup;
            $reminderBean->timer_email = $reminderData->timer_email;
            $reminderBean->related_event_module = $eventModule;
            $reminderBean->related_event_module_id = $eventModuleId;
            $reminderBean->save();
            $savedReminderIds[] = $reminderBean->id;
            $reminderId = $reminderBean->id;
            Reminder_Invitee::saveRemindersInviteesData($reminderId, $reminderData->invitees);
        }
        $reminders = BeanFactory::getBean('Reminders')->get_full_list("",
            "reminders.related_event_module = '$eventModule' AND reminders.related_event_module_id = '$eventModuleId'");
        if ($reminders) {
            foreach ($reminders as $reminder) {
                if (!in_array($reminder->id, $savedReminderIds)) {
                    Reminder_Invitee::deleteRemindersInviteesMultiple($reminder->id);
                    $reminder->mark_deleted($reminder->id);
                    $reminder->save();
                }
            }
        }
        unset(self::$remindersData[$eventModule][$eventModuleId]);
    }

    /**
     * Load multiple reminders JSON data for related Event module EditViews.
     * Call this function in module display function.
     *
     * @param string $eventModule Related event module name (Meetings/Calls)
     * @param string $eventModuleId Related event GUID
     * @return string JSON string contains the remainders
     * @throws Exception
     */
    public static function loadRemindersDataJson($eventModule, $eventModuleId, $isDuplicate = false)
    {
        $remindersData = self::loadRemindersData($eventModule, $eventModuleId, $isDuplicate);
        $remindersDataJson = json_encode($remindersData);
        if (!$remindersDataJson && json_last_error()) {
            throw new Exception(json_last_error_msg());
        }

        return $remindersDataJson;
    }

    /**
     * Load multiple reminders data for related Event module EditViews.
     * Call this function in module display function.
     *
     * @param string $eventModule Related event module name (Meetings/Calls)
     * @param string $eventModuleId Related event GUID
     * @return array contains the remainders
     * @throws Exception
     */
    public static function loadRemindersData($eventModule, $eventModuleId, $isDuplicate = false)
    {
        if (!isset(self::$remindersData[$eventModule][$eventModuleId]) || !$eventModuleId || $isDuplicate) {
            $ret = array();
            $reminders = BeanFactory::getBean('Reminders')->get_full_list("reminders.date_entered",
                "reminders.related_event_module = '$eventModule' AND reminders.related_event_module_id = '$eventModuleId'");
            if ($reminders) {
                foreach ($reminders as $reminder) {
                    $ret[] = array(
                        'id' => $isDuplicate ? null : $reminder->id,
                        'popup' => $reminder->popup,
                        'email' => $reminder->email,
                        'timer_popup' => $reminder->timer_popup,
                        'timer_email' => $reminder->timer_email,
                        'invitees' => Reminder_Invitee::loadRemindersInviteesData($reminder->id, $isDuplicate),
                    );
                }
            }
            self::$remindersData[$eventModule][$eventModuleId] = $ret;
        }

        return self::$remindersData[$eventModule][$eventModuleId];
    }

    // ---- sending email reminders

    /**
     * Sending multiple email reminders.
     * Call in EmainReminder and use original EmailRemainder class for sending.
     *
     * @param EmailReminder $emailReminder Caller EmailReminder
     * @param Administration $admin Administration module for EmailRemainder->sendReminders() function
     * @param boolean $checkDecline (optional) Send email if user accept status is not decline. Default is TRUE.
     */
    public static function sendEmailReminders(EmailReminder $emailReminder, Administration $admin, $checkDecline = true)
    {
        if ($reminders = self::getUnsentEmailReminders()) {
            foreach ($reminders as $reminderId => $reminder) {
                $recipients = self::getEmailReminderInviteesRecipients($reminderId, $checkDecline);
                $eventBean = BeanFactory::getBean($reminder->related_event_module, $reminder->related_event_module_id);
                if ($eventBean && $emailReminder->sendReminders($eventBean, $admin, $recipients)) {
                    $reminder->email_sent = 1;
                    $reminder->save();
                }
            }
        }
    }

    private static function getEmailReminderInviteesRecipients($reminderId, $checkDecline = true)
    {
        $emails = array();
        $reminder = BeanFactory::getBean('Reminders', $reminderId);
        $eventModule = $reminder->related_event_module;
        $eventModuleId = $reminder->related_event_module_id;
        $event = BeanFactory::getBean($eventModule, $eventModuleId);
        if ($event && (!isset($event->status) || $event->status != 'Held')) {
            $invitees = BeanFactory::getBean('Reminders_Invitees')->get_full_list('',
                "reminders_invitees.reminder_id = '$reminderId'");
            foreach ($invitees as $invitee) {
                $inviteeModule = $invitee->related_invitee_module;
                $inviteeModuleId = $invitee->related_invitee_module_id;
                $personBean = BeanFactory::getBean($inviteeModule, $inviteeModuleId);
                // The original email reminders check the accept_status field in related users/leads/contacts etc. and filtered these users who not decline this event.
                if ($checkDecline && !self::isDecline($event, $personBean)) {
                    if (!empty($personBean->email1)) {
                        $arr = array(
                            'type' => $inviteeModule,
                            'name' => $personBean->full_name,
                            'email' => $personBean->email1,
                        );
                        $emails[] = $arr;
                    }
                }
            }
        }

        return $emails;
    }

    private static function getUnsentEmailReminders()
    {
        global $timedate;
        $reminders = array();
        $reminderBeans = BeanFactory::getBean('Reminders')->get_full_list('',
            "reminders.email = 1 AND reminders.email_sent = 0");
        if (!empty($reminderBeans)) {
            foreach ($reminderBeans as $reminderBean) {
                $eventBean = BeanFactory::getBean($reminderBean->related_event_module,
                    $reminderBean->related_event_module_id);
                if ($eventBean) {
                    $remind_ts = $timedate->fromUser($eventBean->date_start)->modify("-{$reminderBean->timer_email} seconds")->ts;
                    $now_ts = $timedate->getNow()->ts;
                    if ($now_ts >= $remind_ts) {
                        $reminders[$reminderBean->id] = $reminderBean;
                    }
                } else {
                    $reminderBean->mark_deleted($reminderBean->id);
                }
            }
        }

        return $reminders;
    }

    // ---- popup and alert reminders

    /**
     * Show a popup and/or desktop notification alert for related users with related Event information.
     * Call in jsAlerts class and use original jsAlerts for show notifications.
     *
     * @global ??? $current_user
     * @global ??? $timedate
     * @global ??? $app_list_strings
     * @global ??? $db
     * @global ??? $sugar_config
     * @global ??? $app_strings
     * @param jsAlerts $alert caller jsAlerts object
     * @param boolean $checkDecline (optional) Send email if user accept status is not decline. Default is TRUE.
     * @return ???
     */
    public static function addNotifications(jsAlerts $alert, $checkDecline = true)
    {
        global $current_user, $timedate, $app_list_strings, $db, $sugar_config, $app_strings;

        if (empty($current_user->id)) {
            return;
        }

        // Create separate variable to hold timedate value
        // These timedates need to be in the user time zone as the
        // datetime returned by the Bean below is in the user time zone
        $alertDateTimeNow = $timedate->getNow(true)->asDb(false);

        // cn: get a boundary limiter
        $dateTimeMax = $timedate->getNow(true)->modify("+{$app_list_strings['reminder_max_time']} seconds")->asDb(false);
        $dateTimeNow = $timedate->getNow(true)->asDb(false);

        $dateTimeNow = $db->convert($db->quoted($dateTimeNow), 'datetime');
        $dateTimeMax = $db->convert($db->quoted($dateTimeMax), 'datetime');

        // Original jsAlert used to a meeting integration.
        // TODO: Remove as meeting integration is never implemented
        ///////////////////////////////////////////////////////////////////////
        ////	MEETING INTEGRATION
        $meetingIntegration = null;
        if (isset($sugar_config['meeting_integration']) && !empty($sugar_config['meeting_integration'])) {
            if (!class_exists($sugar_config['meeting_integration'])) {
                require_once("modules/{$sugar_config['meeting_integration']}/{$sugar_config['meeting_integration']}.php");
            }
            $meetingIntegration = new $sugar_config['meeting_integration']();
        }
        ////	END MEETING INTEGRATION
        ///////////////////////////////////////////////////////////////////////

        // Pre-calculated values in seconds
        $_24hours = 24;
        $_1hour = 3600;

        /**
         * In case the user changes the duration dom dropdown
         * We need to ensure that we know how many calendar slots there can be in a day.
         * This is used to limit the query the default should be 96 possible calendar slots in a day.
         */
        $_smallestEventPeriod = array_reduce(
            array_keys($app_list_strings['duration_dom']),
            function ($carry, $item) {

                if (empty($carry) && empty($item)) {
                    $carry = $item;
                } elseif (empty($carry) && !empty($item) && is_numeric($item)) {
                    $carry = $item;
                } elseif ($item < $carry) {
                    $carry = $item;
                }

                return $carry;
            }
        );

        $_maxReminderPeriod = $app_list_strings['reminder_max_time'];
        // By default: There are 96 possible slots in 24hours that a reminder can refer to.
        $_maxEventsInADay = ceil(($_1hour / $_smallestEventPeriod) * $_24hours);
        $userNOW = $alertDateTimeNow;

        /**
         * Optimisation:
         * Use a single query with a limit to get all the information needed.
         *
         * Starting with the current user id with the following table relationships
         * $current_user->id: Reminder Invitees -< Reminders -< Reminder -< [Meeting/Call] -< [Meeting/Call]_user
         *
         * Returns Meetings_<field> or Calls_<field> depending if the reminder_related_event_module is set to Meetings
         * or Calls.
         *
         * It limited by the total number of slots that can be in a calendar day. Since the user is only interested in
         * alerts which are a day ahead. It is reasonable to assume that a user will not need more than the 96 by
         * default.
         *
         * This means we can optimise the how many results need to be processed each time the user requests the meeting
         *
         */
        // Generate Related to (parent)queries
        $callParentSelect = PHP_EOL;
        $callParentJoin = PHP_EOL;
        $meetingParentSelect = PHP_EOL;
        $meetingParentJoin = PHP_EOL;
        foreach ($app_list_strings['parent_type_display'] as $module => $label) {
            $f = BeanFactory::getBean($module);
            $table = $f->table_name;
            if (is_subclass_of($f, 'Person')) {
                $callParentSelect .= "\t" . " CONCAT(CONCAT(c_" . $table . ".first_name, ' '), c_" . $table . ".last_name) as Calls_parent_name_" . $table . "," . PHP_EOL;
                $meetingParentSelect .= "\t" . " CONCAT(CONCAT(m_" . $table . ".first_name, ' '), m_" . $table . ".last_name) as Meetings_parent_name_" . $table . "," . PHP_EOL;

            } else {
                $callParentSelect .= "\t" . "c_" . $table . ".name as Calls_parent_name_" . $table . "," . PHP_EOL;
                $meetingParentSelect .= "\t" . "m_" . $table . ".name as Meetings_parent_name_" . $table . "," . PHP_EOL;
            }
            $callParentJoin .= "\t" . "LEFT JOIN " . $table . " " . "c_" . $table . " ON c.parent_id = " . "c_" . $table . ".id" . PHP_EOL;
            $meetingParentJoin .= "\t" . "LEFT JOIN " . $table . " " . "m_" . $table . " ON m.parent_id = " . "m_" . $table . ".id" . PHP_EOL;

        }

        $popupReminders = $db->query("
SELECT 
	m.name as Meetings_name, 
	m.description as Meetings_description, 
	m.date_start as Meetings_date_start, 
	m.duration_hours as Meetings_duration_hours, 
	m.duration_minutes as Meetings_duration_minutes, 
	m.location as Meetings_location, 
	m.status as Meetings_status, 
	m.parent_type as Meetings_parent_type, 
	m.parent_id as Meetings_parent_id, 
    {$meetingParentSelect}
	c.name as Calls_name, 
	c.description as Calls_description, 
	c.date_start as Calls_date_start, 
	c.duration_hours as Calls_duration_hours, 
	c.duration_minutes as Calls_duration_minutes, 
	c.status as Calls_status,
	c.parent_type as Calls_parent_type, 
	c.parent_id as Calls_parent_id, 
    {$callParentSelect} 
	ri.related_invitee_module as reminder_invitees_related_invitee_module, 
	ri.related_invitee_module_id as reminder_invitees_related_invitee_module_id, 
	r.id as reminder_id, 
	r.timer_popup as reminder_timer_popup,
	r.related_event_module as reminder_related_event_module,
	r.related_event_module_id as reminder_related_event_module_id 
FROM 
	reminders_invitees ri 
	JOIN reminders r ON r.id = ri.reminder_id 
	AND r.popup = 1 
	LEFT JOIN meetings m ON m.id = r.related_event_module_id 
	AND r.related_event_module = 'Meetings'
	AND m.status = 'Planned'
	LEFT JOIN meetings_users mu ON mu.meeting_id = m.id
	{$meetingParentJoin}
    AND ri.related_invitee_module = 'Users' 
    AND mu.user_id = ri.related_invitee_module_id
    AND mu.accept_status LIKE 'accept'
	LEFT JOIN calls c ON c.id = r.related_event_module_id 
	AND r.related_event_module = 'Calls' 
	AND c.status = 'Planned'
	LEFT JOIN calls_users cu ON cu.call_id = c.id
    AND ri.related_invitee_module = 'Users' 
    AND cu.user_id = ri.related_invitee_module_id
    AND cu.accept_status LIKE 'accept'
    {$callParentJoin}
WHERE 
	ri.related_invitee_module = 'Users' 
	AND ri.related_invitee_module_id = '{$current_user->id}' 
	AND r.deleted != 1 
	AND 
	(
		(
			m.date_start > DATE_SUB(CAST('{$userNOW}' AS datetime), INTERVAL {$_maxReminderPeriod} SECOND) 
			AND m.deleted != 1
		) 
		OR (
			c.date_start > DATE_SUB(CAST('{$userNOW}' AS datetime), INTERVAL {$_maxReminderPeriod} SECOND) 
			AND c.deleted != 1
		)
	)
ORDER BY 
	m.date_start, c.date_start ASC 
LIMIT 
	{$_maxEventsInADay}
");
        if (!empty($popupReminders->num_rows) && $popupReminders->num_rows > 0) {
            while ($row = $db->fetchByAssoc($popupReminders)) {

                switch ($row['reminder_related_event_module']) {
                    case 'Calls':
                        $date_start =& $row['Calls_date_start'];
                        $name =& $row['Calls_name'];
                        $description =& $row['Calls_description'];
                        $duration_hours =& $row['Calls_duration_hours'];
                        $duration_minutes =& $row['Calls_duration_minutes'];
                        $duration_duration_minutes =& $row['Calls_duration_minutes'];
                        $status =& $row['Calls_status'];
                        $event_parent_type =& $row['Calls_parent_type'];
                        $event_parent_id =& $row['Calls_parent_id'];
                        $f = BeanFactory::getBean($event_parent_type);
                        $table = $f->table_name;
                        $event_parent_name =& $row['Calls_parent_name_' . $table];
                        break;
                    case 'Meetings':
                        $date_start =& $row['Meetings_date_start'];
                        $name =& $row['Meetings_name'];
                        $description =& $row['Meetings_description'];
                        $duration_hours =& $row['Meetings_duration_hours'];
                        $duration_minutes =& $row['Meetings_duration_minutes'];
                        $duration_location =& $row['Meetings_location'];
                        $status =& $row['Meetings_status'];
                        $event_parent_type =& $row['Meetings_parent_type'];
                        $event_parent_id =& $row['Meetings_parent_id'];
                        $f = BeanFactory::getBean($event_parent_type);
                        $table = $f->table_name;
                        $event_parent_name =& $row['Meetings_parent_name_' . $table];
                        break;
                    default:
                        return;
                }

                $timeStart = strtotime(
                    $db->fromConvert(isset($date_start) ? $date_start : date(TimeDate::DB_DATETIME_FORMAT),
                        'datetime')
                );
                $timeRemind = $row['reminder_timer_popup'];
                $timeStart -= $timeRemind;

                $url = 'index.php?action=DetailView&module=' . $row['reminder_related_event_module'] . '&record=' . $row['reminder_related_event_module_id'];
                $instructions = $app_strings['MSG_JS_ALERT_MTG_REMINDER_MEETING_MSG'];

                if ($row['reminder_related_event_module'] == 'Meetings') {
                    // TODO: Remove as meeting integration is never implemented
                    ///////////////////////////////////////////////////////////////////
                    ////	MEETING INTEGRATION
                    if (!empty($meetingIntegration) && $meetingIntegration->isIntegratedMeeting($row['reminder_related_event_module_id'])) {
                        $url = $meetingIntegration->miUrlGetJsAlert((array)BeanFactory::getBean('Reminders',
                            $row['reminder_id']));
                        $instructions = $meetingIntegration->miGetJsAlertInstructions();
                    }
                    ////	END MEETING INTEGRATION
                    ///////////////////////////////////////////////////////////////////
                }

                $meetingName = from_html(isset($name) ? $name : $app_strings['MSG_JS_ALERT_MTG_REMINDER_NO_EVENT_NAME']);
                $desc1 = from_html(isset($description) ? $description : $app_strings['MSG_JS_ALERT_MTG_REMINDER_NO_DESCRIPTION']);
                $location = from_html(isset($location) ? $location : $app_strings['MSG_JS_ALERT_MTG_REMINDER_NO_LOCATION']);

                $relatedToMeeting = $event_parent_name;

                $description = empty($desc1) ? '' : $app_strings['MSG_JS_ALERT_MTG_REMINDER_AGENDA'] . $desc1 . "\n";
                $description = $description . "\n" . $app_strings['MSG_JS_ALERT_MTG_REMINDER_STATUS'] . (isset($status) ? $status : '') . "\n" . $app_strings['MSG_JS_ALERT_MTG_REMINDER_RELATED_TO'] . $relatedToMeeting;


                if (isset($date_start)) {
                    $time_dbFromConvert = $db->fromConvert($date_start, 'datetime');
                    $time = $timedate->to_display_date_time($time_dbFromConvert);
                    if (!$time) {
                        $time = $date_start;
                    }
                    if (!$time) {
                        $time = $app_strings['MSG_JS_ALERT_MTG_REMINDER_NO_START_DATE'];
                    }
                } else {
                    $time = $app_strings['MSG_JS_ALERT_MTG_REMINDER_NO_START_DATE'];
                }

                // standard functionality
                $alert->addAlert($app_strings['MSG_JS_ALERT_MTG_REMINDER_MEETING'], $meetingName,
                    $app_strings['MSG_JS_ALERT_MTG_REMINDER_TIME'] . $time,
                    $app_strings['MSG_JS_ALERT_MTG_REMINDER_LOC'] . $location .
                    $description .
                    $instructions,
                    $timeStart - strtotime($alertDateTimeNow),
                    $url
                );
            }
        } elseif (!empty($db->lastError())) {
            $GLOBALS['log']->fatal($db->lastError());
        }
    }

    private static function unQuoteTime($timestr)
    {
        $ret = '';
        for ($i = 0; $i < strlen($timestr); $i++) {
            if ($timestr[$i] != "'") {
                $ret .= $timestr[$i];
            }
        }

        return $ret;
    }

    // --- test for accept status decline is?

    private static function isDecline(SugarBean $event, SugarBean $person)
    {
        return self::testEventPersonAcceptStatus($event, $person, 'decline');
    }

    private static function testEventPersonAcceptStatus(SugarBean $event, SugarBean $person, $acceptStatus = 'decline')
    {
        if ($acceptStats = self::getEventPersonAcceptStatus($event, $person)) {
            $acceptStatusLower = strtolower($acceptStatus);
            foreach ((array)$acceptStats as $acceptStat) {
                if (strtolower($acceptStat) == $acceptStatusLower) {
                    return true;
                }
            }
        }

        return false;
    }

    private static function getEventPersonAcceptStatus(SugarBean $event, SugarBean $person)
    {
        global $db;
        $rel_person_table_Key = "rel_{$person->table_name}_table";
        $rel_person_table_Value = "{$event->table_name}_{$person->table_name}";
        if (isset($event->$rel_person_table_Key) && $event->$rel_person_table_Key == $rel_person_table_Value) {
            $query = self::getEventPersonQuery($event, $person);
            $re = $db->query($query);
            $ret = array();
            while ($row = $db->fetchByAssoc($re)) {
                if (!isset($row['accept_status'])) {
                    return null;
                }
                $ret[] = $row['accept_status'];
            }

            return $ret;
        }

        return null;
    }

    private function upgradeEventPersonQuery(SugarBean $event, $person_table)
    {
        $eventIdField = strtolower($event->object_name) . '_id';
        $query = "
			SELECT * FROM {$event->table_name}_{$person_table}
			WHERE
				{$eventIdField} = '{$event->id}' AND
				deleted = 0
		";

        return $query;
    }

    private static function getEventPersonQuery(SugarBean $event, SugarBean $person)
    {
        $eventIdField = array_search($event->table_name, $event->relationship_fields);
        if (!$eventIdField) {
            $eventIdField = strtolower($event->object_name . '_id');
        }
        $personIdField = strtolower($person->object_name) . '_id';
        $query = "
			SELECT * FROM {$event->table_name}_{$person->table_name}
			WHERE
				{$eventIdField} = '{$event->id}' AND
				{$personIdField} = '{$person->id}' AND
				deleted = 0
		";

        return $query;
    }

    // --- user preferences as default values in reminders

    /**
     * Default values for Reminders from User Preferences
     * @return string JSON encoded default values
     * @throws Exception on json_encode error
     */
    public static function loadRemindersDefaultValuesDataJson()
    {
        $ret = json_encode(self::loadRemindersDefaultValuesData());
        if (!$ret && json_last_error()) {
            throw new Exception(json_last_error_msg());
        }

        return $ret;
    }

    /**
     * Default values for Reminders from User Preferences
     * @return array default values
     */
    public static function loadRemindersDefaultValuesData()
    {
        global $current_user;

        $preferencePopupReminderTime = $current_user->getPreference('reminder_time');
        $preferenceEmailReminderTime = $current_user->getPreference('email_reminder_time');
        $preferencePopupReminderChecked = $current_user->getPreference('reminder_checked');
        $preferenceEmailReminderChecked = $current_user->getPreference('email_reminder_checked');

        return array(
            'popup' => $preferencePopupReminderChecked,
            'email' => $preferenceEmailReminderChecked,
            'timer_popup' => $preferencePopupReminderTime,
            'timer_email' => $preferenceEmailReminderTime,
        );
    }

    // --- upgrade

    /**
     * Reminders upgrade, old reminders migrate to multiple-reminders.
     * @throws Exception unknown event type or any error
     */
    public static function upgrade()
    {
        self::upgradeUserPreferences();
        self::upgradeEventReminders('Calls');
        self::upgradeEventReminders('Meetings');
        self::upgradeRestoreReminders();
    }

    private static function upgradeRestoreReminders()
    {
        if ($reminders = BeanFactory::getBean('Reminders')->get_full_list('', 'reminders.deleted = 1')) {
            foreach ($reminders as $reminder) {
                $reminder->deleted = 0;
                $reminder->save();
            }
        }
        if ($reminderInvitees = BeanFactory::getBean('Reminders_Invitees')->get_full_list('',
            'reminders_invitees.deleted = 1')
        ) {
            foreach ($reminderInvitees as $invitee) {
                $invitee->deleted = 0;
                $invitee->save();
            }
        }
        global $db;
        $q = "UPDATE reminders SET deleted = 0";
        $db->query($q);
        $q = "UPDATE reminders_invitees SET deleted = 0";
        $db->query($q);
    }

    private static function upgradeUserPreferences()
    {
        $users = User::getActiveUsers();
        foreach ($users as $user_id => $user_name) {
            $user = new User();
            $user->retrieve($user_id);

            $preferencePopupReminderTime = $user->getPreference('reminder_time');
            $preferenceEmailReminderTime = $user->getPreference('email_reminder_time');

            $preferencePopupReminderChecked = $preferencePopupReminderTime > -1;
            $preferenceEmailReminderChecked = $preferenceEmailReminderTime > -1;
            $user->setPreference('reminder_checked', $preferencePopupReminderChecked);
            $user->setPreference('email_reminder_checked', $preferenceEmailReminderChecked);

        }
    }

    /**
     * @param string $eventModule 'Calls' or 'Meetings'
     */
    private static function upgradeEventReminders($eventModule)
    {
        global $db;

        $eventBean = BeanFactory::getBean($eventModule);
        $events = $eventBean->get_full_list('',
            "{$eventBean->table_name}.date_start >  {$db->convert('', 'today')} AND ({$eventBean->table_name}.reminder_time != -1 OR ({$eventBean->table_name}.email_reminder_time != -1 AND {$eventBean->table_name}.email_reminder_sent != 1))");
        if ($events) {
            foreach ($events as $event) {

                $oldReminderPopupChecked = false;
                $oldReminderPopupTimer = null;
                if ($event->reminder_time != -1) {
                    $oldReminderPopupChecked = true;
                    $oldReminderPopupTimer = $event->reminder_time;
                }

                $oldReminderEmailChecked = false;
                $oldReminderEmailTimer = null;
                if ($event->email_reminder_time != -1) {
                    $oldReminderEmailChecked = true;
                    $oldReminderEmailTimer = $event->email_reminder_time;
                }

                $oldReminderEmailSent = $event->email_reminder_sent;

                if (($oldInvitees = self::getOldEventInvitees($event)) && ($event->reminder_time != -1 || ($event->email_reminder_time != -1 && $event->email_reminder_sent != 1))) {

                    self::migrateReminder(
                        $eventModule,
                        $event->id,
                        $oldReminderPopupChecked,
                        $oldReminderPopupTimer,
                        $oldReminderEmailChecked,
                        $oldReminderEmailTimer,
                        $oldReminderEmailSent,
                        $oldInvitees
                    );

                }
            }
        }

    }


    private static function getOldEventInvitees(SugarBean $event)
    {
        global $db;
        $ret = array();
        $persons = array('users', 'contacts', 'leads');
        foreach ($persons as $person) {
            $query = self::upgradeEventPersonQuery($event, $person);
            $re = $db->query($query);
            while ($row = $db->fetchByAssoc($re)) {
                $ret[] = $row;
            }
        }

        return $ret;
    }

    /**
     * @param string $eventModule 'Calls' or 'Meetings'
     * @param string $eventModuleId
     * @param bool $oldReminderPopupChecked
     * @param int $oldReminderPopupTimer
     * @param bool $oldReminderEmailChecked
     * @param int $oldReminderEmailTimer
     * @param array $oldInvitees
     */
    private static function migrateReminder(
        $eventModule,
        $eventModuleId,
        $oldReminderPopupChecked,
        $oldReminderPopupTimer,
        $oldReminderEmailChecked,
        $oldReminderEmailTimer,
        $oldReminderEmailSent,
        $oldInvitees
    ) {

        $reminder = BeanFactory::getBean('Reminders');
        $reminder->popup = $oldReminderPopupChecked;
        $reminder->email = $oldReminderEmailChecked;
        $reminder->email_sent = $oldReminderEmailSent;
        $reminder->timer_popup = $oldReminderPopupTimer;
        $reminder->timer_email = $oldReminderEmailTimer;
        $reminder->related_event_module = $eventModule;
        $reminder->related_event_module_id = $eventModuleId;
        $reminder->save();
        $reminderId = $reminder->id;
        self::migrateReminderInvitees($reminderId, $oldInvitees);

        self::removeOldReminder($eventModule, $eventModuleId);
    }

    private static function migrateReminderInvitees($reminderId, $invitees)
    {
        $ret = array();
        foreach ((array)$invitees as $invitee) {
            $newInvitee = BeanFactory::getBean('Reminders_Invitees');
            $newInvitee->reminder_id = $reminderId;
            $newInvitee->related_invitee_module = self::getRelatedInviteeModuleFromInviteeArray($invitee);
            $newInvitee->related_invitee_module_id = self::getRelatedInviteeModuleIdFromInviteeArray($invitee);
            $newInvitee->save();
        }

        return $ret;
    }

    private static function getRelatedInviteeModuleFromInviteeArray($invitee)
    {
        if (array_key_exists('user_id', $invitee)) {
            return 'Users';
        }
        if (array_key_exists('lead_id', $invitee)) {
            return 'Leads';
        }
        if (array_key_exists('contact_id', $invitee)) {
            return 'Contacts';
        }
        // TODO:!!!!
        throw new Exception('Unknown invitee module type');
        //return null;
    }

    private static function getRelatedInviteeModuleIdFromInviteeArray($invitee)
    {
        if (array_key_exists('user_id', $invitee)) {
            return $invitee['user_id'];
        }
        if (array_key_exists('lead_id', $invitee)) {
            return $invitee['lead_id'];
        }
        if (array_key_exists('contact_id', $invitee)) {
            return $invitee['contact_id'];
        }
        // TODO:!!!!
        throw new Exception('Unknown invitee type');
        //return null;
    }

    /**
     * @param string $eventModule 'Calls' or 'Meetings'
     * @param string $eventModuleId
     */
    private static function removeOldReminder($eventModule, $eventModuleId)
    {
        $event = BeanFactory::getBean($eventModule, $eventModuleId);
        $event->reminder_time = -1;
        $event->email_reminder_time = -1;
        $event->email_reminder_sent = 0;
        $event->save();
    }

    // --- reminders list on detail views

    /**
     * Return a list of related reminders for specified event (Calls/Meetings). Call it from DetailViews.
     * @param SugarBean $event a Call or Meeting Bean
     * @return mixed|string|void output of list (html)
     * @throws Exception on json error in Remainders
     */
    public static function getRemindersListView(SugarBean $event)
    {
        global $mod_strings, $app_list_strings;
        $tpl = new Sugar_Smarty();
        $tpl->assign('MOD', $mod_strings);
        $tpl->assign('reminder_time_options', $app_list_strings['reminder_time_options']);
        $tpl->assign('remindersData', Reminder::loadRemindersData($event->module_name, $event->id));
        $tpl->assign('remindersDataJson', Reminder::loadRemindersDataJson($event->module_name, $event->id));
        $tpl->assign('remindersDefaultValuesDataJson', Reminder::loadRemindersDefaultValuesDataJson());
        $tpl->assign('remindersDisabled', json_encode(true));

        return $tpl->fetch('modules/Reminders/tpls/reminders.tpl');
    }

    /*
     * @todo implenent it
     */
    public static function getRemindersListInlineEditView(SugarBean $event)
    {
        // TODO: getEditFieldHTML() function in InlineEditing.php:218 doesn't pass the Bean ID to this custom inline edit view function but we have to know which Bean are in the focus to editing.
        if (!$event->id) {
            throw new Exception("No GUID for edit.");
        }
    }

}

?>
