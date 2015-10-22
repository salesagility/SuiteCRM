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
        foreach($inviteesData as $inviteeData) {
            $reminderInviteeBean = new AOM_Reminder_Invitee();
            $reminderInviteeBean->reminder_id = $reminderId;
            $reminderInviteeBean->related_invitee_module = $inviteeData->module;
            $reminderInviteeBean->related_invitee_module_id = $inviteeData->id;
            $reminderInviteeBean->save();
        }
    }
	
	public static function loadRemindersInviteesData($reminderId) {
		$ret = array();
		$reminderInviteeBeen = new AOM_Reminder_Invitee();
		$reminderInvitees = $reminderInviteeBeen->get_full_list("aom_reminders_invitees.date_entered", "aom_reminders_invitees.reminder_id = '$reminderId'");
		foreach($reminderInvitees as $reminderInvitee) {
			$ret[] = array(
				'module' => $reminderInvitee->related_invitee_module,
				'id' => $reminderInvitee->related_invitee_module_id,
			);
		}
		return $ret;
	}

}
?>