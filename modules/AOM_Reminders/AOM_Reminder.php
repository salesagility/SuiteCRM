<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * AOM_Reminder class
 * 
 * @author Gyula Madarasz <gyula.madarasz@salesagility.com>
 */
class AOM_Reminder extends Basic {
    var $name;

    var $new_schema = true;
    var $module_dir = 'AOM_Reminders';
    var $object_name = 'AOM_Reminder';
    var $table_name = 'aom_reminders';
    var $importable = false;
    var $disable_row_level_security = true;

    var $popup;
    var $email;
    var $email_sent = false;
    var $timer;
    var $related_event_module;
    var $related_event_module_id;

    public function __construct() {
        parent::Basic();
    }

    public function bean_implements($interface){
        switch($interface){
            case 'ACL': return true;
        }
        return false;
    }

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
    public static function saveRemindersDataJson($eventModule, $eventModuleId, $remindersDataJson) {
        $reminderData = json_decode($remindersDataJson);
        if(!json_last_error()) {
            AOM_Reminder::saveRemindersData($eventModule, $eventModuleId, $reminderData);
        }
        else {
            throw new Exception(json_last_error_msg());
        }
    }
	
    private static function saveRemindersData($eventModule, $eventModuleId, $remindersData) {
        $savedReminderIds = array();
        foreach($remindersData as $reminderData) {
            $reminderBean = BeanFactory::getBean('AOM_Reminders', $reminderData->id);
            $reminderBean->popup = $reminderData->popup;
            $reminderBean->email = $reminderData->email;
            $reminderBean->timer = $reminderData->timer;
            $reminderBean->related_event_module = $eventModule;
            $reminderBean->related_event_module_id = $eventModuleId;
            $reminderBean->save();
            $savedReminderIds[] = $reminderBean->id;
            $reminderId = $reminderBean->id;
            AOM_Reminder_Invitee::saveRemindersInviteesData($reminderId, $reminderData->invitees);
        }
        $reminders = BeanFactory::getBean('AOM_Reminders')->get_full_list("", "aom_reminders.related_event_module = '$eventModule' AND aom_reminders.related_event_module_id = '$eventModuleId'");
        if($reminders) {
            foreach ($reminders as $reminder) {
                if (!in_array($reminder->id, $savedReminderIds)) {
                    AOM_Reminder_Invitee::deleteRemindersInviteesMultiple($reminder->id);
                    $reminder->mark_deleted($reminder->id);
                    $reminder->save();
                }
            }
        }
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
    public static function loadRemindersDataJson($eventModule, $eventModuleId) {
        $remindersData = self::loadRemindersData($eventModule, $eventModuleId);
        $remindersDataJson = json_encode($remindersData);
        if(!$remindersDataJson && json_last_error()) {
            throw new Exception(json_last_error_msg());
        }
        return $remindersDataJson;
    }

	private static function loadRemindersData($eventModule, $eventModuleId) {
		$ret = array();
		$reminders = BeanFactory::getBean('AOM_Reminders')->get_full_list("aom_reminders.date_entered", "aom_reminders.related_event_module = '$eventModule' AND aom_reminders.related_event_module_id = '$eventModuleId'");
        if($reminders) {
            foreach ($reminders as $reminder) {
                $ret[] = array(
                    'id' => $reminder->id,
                    'popup' => $reminder->popup,
                    'email' => $reminder->email,
                    'timer' => $reminder->timer,
                    'invitees' => AOM_Reminder_Invitee::loadRemindersInviteesData($reminder->id),
                );
            }
        }
		return $ret;
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
	public static function sendEmailReminders(EmailReminder $emailReminder, Administration $admin, $checkDecline = true) {
        if($reminders = self::getUnsentEmailReminders()) {
            foreach($reminders as $reminderId => $reminder) {
				$recipients = self::getEmailReminderInviteesRecipients($reminderId, $checkDecline);
				$eventBean = BeanFactory::getBean($reminder->related_event_module, $reminder->related_event_module_id);
				if ( $emailReminder->sendReminders($eventBean, $admin, $recipients) ) {
					$reminder->email_sent = 1;
					$reminder->save();
				}
            }
        }
    }
	
	private static function getEmailReminderInviteesRecipients($reminderId, $checkDecline = true) {
		$emails = array();
		$reminder = BeanFactory::getBean('AOM_Reminders', $reminderId);		
		$eventModule = $reminder->related_event_module;
		$eventModuleId = $reminder->related_event_module_id;		
		$event = BeanFactory::getBean($eventModule, $eventModuleId);
		if(!isset($event->status) || $event->status != 'Held') {
			$invitees = BeanFactory::getBean('AOM_Reminders_Invitees')->get_full_list('', "aom_reminders_invitees.reminder_id = '$reminderId'");
			foreach($invitees as $invitee) {
				$inviteeModule = $invitee->related_invitee_module;
				$inviteeModuleId = $invitee->related_invitee_module_id;
				$personBean = BeanFactory::getBean($inviteeModule, $inviteeModuleId);
				// The original email reminders check the accept_status field in related users/leads/contacts etc. and filtered these users who not decline this event.
				if($checkDecline && !self::isDecline($event, $personBean)) {
					if ( !empty($personBean->email1) ) {
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

    private static function getUnsentEmailReminders() {
        global $db;		
		$reminderBeans = BeanFactory::getBean('AOM_Reminders')->get_full_list('', "aom_reminders.email = 1 AND aom_reminders.email_sent = 0");
		foreach($reminderBeans as $reminderBean) {
			$eventBean = BeanFactory::getBean($reminderBean->related_event_module, $reminderBean->related_event_module_id);
			$dateStart = $eventBean->date_start;
			$time = strtotime($db->fromConvert($dateStart,'datetime'));
			$dateStart = date(TimeDate::DB_DATETIME_FORMAT, $time);
			$remind_ts = $GLOBALS['timedate']->fromDb($db->fromConvert($dateStart,'datetime'))->modify("-{$reminderBean->timer} seconds")->ts;
            $now_ts = $GLOBALS['timedate']->getNow()->ts;
            if ( $now_ts >= $remind_ts ) {
                $reminders[$reminderBean->id] = $reminderBean;
            }
		}
        return $reminders;
    }
	
	// ---- popup and alert reminers
	
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
	public static function addNotifications(jsAlerts $alert, $checkDecline = true) {
		global $current_user, $timedate, $app_list_strings, $db, $sugar_config, $app_strings;

		if (empty($current_user->id)) {
            return;
		}
		
		//Create separate variable to hold timedate value
        $alertDateTimeNow = $timedate->nowDb();

		// cn: get a boundary limiter
		$dateTimeMax = $timedate->getNow()->modify("+{$app_list_strings['reminder_max_time']} seconds")->asDb();
		$dateTimeNow = $timedate->nowDb();

		$dateTimeNow = $db->convert($db->quoted($dateTimeNow), 'datetime');
		$dateTimeMax = $db->convert($db->quoted($dateTimeMax), 'datetime');
		
		// Original jsAlert used to a meeting integration.
		
		///////////////////////////////////////////////////////////////////////
		////	MEETING INTEGRATION
		$meetingIntegration = null;
		if(isset($sugar_config['meeting_integration']) && !empty($sugar_config['meeting_integration'])) {
			if(!class_exists($sugar_config['meeting_integration'])) {
				require_once("modules/{$sugar_config['meeting_integration']}/{$sugar_config['meeting_integration']}.php");
			}
			$meetingIntegration = new $sugar_config['meeting_integration']();
		}
		////	END MEETING INTEGRATION
		///////////////////////////////////////////////////////////////////////
		
		$popupReminders = BeanFactory::getBean('AOM_Reminders')->get_full_list('', "aom_reminders.popup = 1");
		
		if($popupReminders) {
			foreach($popupReminders as $popupReminder) {
				$relatedEvent = BeanFactory::getBean($popupReminder->related_event_module, $popupReminder->related_event_module_id);
				if(
					(!isset($relatedEvent->status) || $relatedEvent->status == 'Planed') && 
					(!isset($relatedEvent->date_start) || ($relatedEvent->date_start >= $dateTimeNow && $relatedEvent->date_start <= $dateTimeMax) ) && 
					(!$checkDecline || ($checkDecline && !self::isDecline($relatedEvent, BeanFactory::getBean('Users', $current_user->is))))
				) {
					// The original popup/alert reminders check the accept_status field in related users/leads/contacts etc. and filtered these users who not decline this event.
					$iniviees = BeanFactory::getBean('AOM_Reminders_Invitees')->get_full_list('', "aom_reminders_invitees.reminder_id = '{$popupReminder->id}' AND aom_reminders_invitees.related_invitee_module_id = '{$current_user->id}'");
					if($invitees) {
						foreach($invitees as $invitee) {
							// need to concatenate since GMT times can bridge two local days
							$timeStart = strtotime($db->fromConvert(isset($relatedEvent->date_start) ? $relatedEvent->date_start : date(TimeDate::DB_DATETIME_FORMAT), 'datetime'));
							$timeRemind = $popupReminders->timer;
							$timeStart -= $timeRemind;

							$url = 'index.php?action=DetailView&module=' . $popupReminder->related_event_module . '&record=' . $popupReminder->related_event_module_id;
							$instructions = $app_strings['MSG_JS_ALERT_MTG_REMINDER_MEETING_MSG'];

							if($popupReminder->related_event_module == 'Meetings') {
								///////////////////////////////////////////////////////////////////
								////	MEETING INTEGRATION
								if(!empty($meetingIntegration) && $meetingIntegration->isIntegratedMeeting($popupReminder->related_event_module_id)) {
									$url = $meetingIntegration->miUrlGetJsAlert($this->toArray($popupReminder));
									$instructions = $meetingIntegration->miGetJsAlertInstructions();
								}
								////	END MEETING INTEGRATION
								///////////////////////////////////////////////////////////////////								
							}
							
							$meetingName = from_html(isset($relatedEvent->name) ? $relatedEvent->name : $app_strings['MSG_JS_ALERT_MTG_REMINDER_NO_EVENT_NAME']);
							$desc1 = from_html(isset($relatedEvent->description) ? $relatedEvent->description : $app_strings['MSG_JS_ALERT_MTG_REMINDER_NO_DESCRIPTION']);
							$location = from_html(isset($relatedEvent->location) ? $relatedEvent->location : $app_strings['MSG_JS_ALERT_MTG_REMINDER_NO_LOCATION']);
							
							$relatedToMeeting = $alert->getRelatedName($popupReminder->related_event_module, $popupReminder->related_event_module_id);
							
							$description = empty($desc1) ? '' : $app_strings['MSG_JS_ALERT_MTG_REMINDER_AGENDA'].$desc1."\n";
							$description = $description  ."\n" .$app_strings['MSG_JS_ALERT_MTG_REMINDER_STATUS'] . (isset($relatedEvent->status) ? $relatedEvent->status : '') ."\n". $app_strings['MSG_JS_ALERT_MTG_REMINDER_RELATED_TO']. $relatedToMeeting;
							
							// standard functionality
							$alert->addAlert($app_strings['MSG_JS_ALERT_MTG_REMINDER_MEETING'], $meetingName,
								$app_strings['MSG_JS_ALERT_MTG_REMINDER_TIME'].$timedate->to_display_date_time($db->fromConvert(  (isset($relatedEvent->date_start) ? $relatedEvent->date_start : $app_strings['MSG_JS_ALERT_MTG_REMINDER_NO_START_DATE'])  , 'datetime')),
								$app_strings['MSG_JS_ALERT_MTG_REMINDER_LOC'].$location.
								$description.
								$instructions,
								$timeStart - strtotime($alertDateTimeNow),
								$url
							);
						}
					}
				}
			}
		}
	}
	
	// --- test for accept status decline is?
	
	private static function isDecline(SugarBean $event, SugarBean $person) {
		return self::testEventPersonAcceptStatus($event, $person, 'decline');
	}
	
	private static function testEventPersonAcceptStatus(SugarBean $event, SugarBean $person, $acceptStatus = 'decline') {
		if($acceptStats = self::getEventPersonAcceptStatus($event, $person)) {
			$acceptStatusLower = strtolower($acceptStatus);
			foreach((array) $acceptStats as $acceptStat) {
				if(strtolower($acceptStat) == $acceptStatusLower) {
					return true;
				}
			}
		}
		return false;
	}
	
	private static function getEventPersonAcceptStatus(SugarBean $event, SugarBean $person) {
		global $db;
		$rel_person_table_Key = "rel_{$person->table_name}_table";
		$rel_person_table_Value = "{$event->table_name}_{$person->table_name}";
		if(isset($event->$rel_person_table_Key) && $event->$rel_person_table_Key == $rel_person_table_Value) {
			$eventIdField = array_search($event->table_name, $event->relationship_fields);
			$personIdField = strtolower($person->object_name) . '_id';
			$query = "
				SELECT * FROM {$event->table_name}_{$person->table_name} 
				WHERE 
					{$eventIdField} = '{$event->id}' AND 
					{$personIdField} = '{$person->id}' AND 
					deleted = 0
			";
			$re = $db->query($query);
			$ret = array();
			while($row = $db->fetchByAssoc($re) ) {
				if(!isset($row['accept_status'])) {
					return null;
				}
				$ret[] = $row['accept_status'];
			}
			return $ret;
		}
		return null;
	}
	
}
?>