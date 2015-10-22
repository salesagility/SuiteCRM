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
    var $related_module;
    var $related_module_id;

    public function __construct() {
        parent::Basic();
    }

    public function bean_implements($interface){
        switch($interface){
            case 'ACL': return true;
        }
        return false;
    }

    public static function saveRemindersData($senderModule, $senderModuleId, $remindersData) {
        echo '<pre>';
        foreach($remindersData as $reminderData) {
            print_r($reminderData);
            $reminderBean = new AOM_Reminder();
            $reminderBean->popup = $reminderData->popup;
            $reminderBean->email = $reminderData->email;
            $reminderBean->duration = $reminderData->duration;
            // todo invitees...
            $reminderBean->related_module = $senderModule;
            $reminderBean->related_module_id = $senderModuleId;
            $reminderBean->save();
        }
        exit;
    }

}
?>