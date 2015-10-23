<?php
class AOM_Reminder extends Basic {
    var $name;

    var $new_schema = true;
    var $module_dir = 'AOM_Reminders';
    var $object_name = 'AOM_Reminder';
    var $table_name = 'aom_reminders';
    var $importable = false;
    var $disable_row_level_security = true;

    var $popup;
    var $popup_sent = false;
    var $popup_read = false;
    var $email;
    var $email_sent = false;
    var $email_read = false;
    var $duration;
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
        $reminderDataIds = array();
        foreach($remindersData as $reminderData) {
            $reminderDataIds[] = $reminderData->id;
            $reminderBean = BeanFactory::getBean('AOM_Reminders', $reminderData->id);
            $reminderBean->popup = $reminderData->popup;
            $reminderBean->email = $reminderData->email;
            $reminderBean->duration = $reminderData->duration;
            $reminderBean->related_event_module = $eventModule;
            $reminderBean->related_event_module_id = $eventModuleId;
            $reminderBean->save();
            $reminderId = $reminderBean->id;
            AOM_Reminder_Invitee::saveRemindersInviteesData($reminderId, $reminderData->invitees);
        }
        $reminders = BeanFactory::getBean('AOM_Reminders')->get_full_list("", "aom_reminders.related_event_module = '$eventModule' AND aom_reminders.related_event_module_id = '$eventModuleId'");
        foreach($reminders as $reminder) {
            if(!in_array($reminder->id, $reminderDataIds)) {
                AOM_Reminder_Invitee::deleteRemindersInviteesMultiple($reminder->id);
                $reminder->mark_deleted();
                $reminder->save();
            }
        }
    }

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
                    'duration' => $reminder->duration,
                    'invitees' => AOM_Reminder_Invitee::loadRemindersInviteesData($reminder->id),
                );
            }
        }
		return $ret;
	}

}
?>