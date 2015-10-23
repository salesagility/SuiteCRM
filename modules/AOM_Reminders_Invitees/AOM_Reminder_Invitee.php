<?php
class AOM_Reminder_Invitee extends Basic {
    var $name;

    var $new_schema = true;
    var $module_dir = 'AOM_Reminders_Invitees';
    var $object_name = 'AOM_Reminder_Invitee';
    var $table_name = 'aom_reminders_invitees';
    var $importable = false;
    var $disable_row_level_security = true;

    var $reminder_id;
    var $related_invitee_module;
    var $related_invitee_module_id;

    public function __construct() {
        parent::Basic();
    }

    public function bean_implements($interface){
        switch($interface){
            case 'ACL': return true;
        }
        return false;
    }

    public static function saveRemindersInviteesData($reminderId, $inviteesData) {
        $savedInviteeIds = array();
        foreach($inviteesData as $k => $inviteeData) {
            $reminderInviteeBean = BeanFactory::getBean('AOM_Reminders_Invitees', $inviteeData->id);
            $reminderInviteeBean->reminder_id = $reminderId;
            $reminderInviteeBean->related_invitee_module = $inviteeData->module;
            $reminderInviteeBean->related_invitee_module_id = $inviteeData->module_id;
            if(!$inviteeData->id) {
                $reminderInviteeBean->save();
                $savedInviteeIds[] = $reminderInviteeBean->id;
            }
            else {
                $addedInvitees = BeanFactory::getBean('AOM_Reminders_Invitees')->get_full_list("", "aom_reminders_invitees.id != '{$inviteeData->id}' AND aom_reminders_invitees.reminder_id = '{$reminderInviteeBean->reminder_id}' AND aom_reminders_invitees.related_invitee_module = '{$reminderInviteeBean->related_invitee_module}' AND aom_reminders_invitees.related_invitee_module_id = '{$reminderInviteeBean->related_invitee_module_id}'");
                if (!$addedInvitees) {
                    $reminderInviteeBean->save();
                    $savedInviteeIds[] = $reminderInviteeBean->id;
                } else {
                    $savedInviteeIds[] = $inviteeData->id;
                }
            }
        }
        self::deleteRemindersInviteesMultiple($reminderId, $savedInviteeIds);
    }
	
	public static function loadRemindersInviteesData($reminderId) {
		$ret = array();
		$reminderInviteeBeen = new AOM_Reminder_Invitee();
		$reminderInvitees = $reminderInviteeBeen->get_full_list("aom_reminders_invitees.date_entered", "aom_reminders_invitees.reminder_id = '$reminderId'");
        if($reminderInvitees) {
            foreach ($reminderInvitees as $reminderInvitee) {
                $ret[] = array(
                    'id' => $reminderInvitee->id,
                    'module' => $reminderInvitee->related_invitee_module,
                    'module_id' => $reminderInvitee->related_invitee_module_id,
                    'value' => self::getInviteeName($reminderInvitee->related_invitee_module, $reminderInvitee->related_invitee_module_id),
                );
            }
        }
		return $ret;
	}

    private static function getInviteeName($module, $moduleId) {
        $retValue = "unknown";

        $bean = BeanFactory::getBean($module, $moduleId);
        switch($module) {
            case 'Users':
            case 'Contacts':
            case 'Leads':
            default:
                if(isset($bean->first_name) && isset($bean->last_name)) {
                    $retValue = "{$bean->first_name} {$bean->last_name}";
                }
                else if(isset($bean->name)) {
                    $retValue = $bean->name;
                }
                else if(isset($bean->email)) {
                    $retValue = $bean->email;
                }
                if(!$retValue) {
                    $retValue = "$module ($moduleId)";
                }
                break;
        }
        return $retValue;
    }

    public static function deleteRemindersInviteesMultiple($reminderId, $inviteeIds = array()) {
        $invitees = BeanFactory::getBean('AOM_Reminders_Invitees')->get_full_list("", "aom_reminders_invitees.reminder_id = '$reminderId'");
        if($invitees) {
            foreach ($invitees as $invitee) {
                if (!in_array($invitee->id, $inviteeIds)) {
                    $invitee->mark_deleted($invitee->id);
                    $invitee->save();
                }
            }
        }
    }

}
?>