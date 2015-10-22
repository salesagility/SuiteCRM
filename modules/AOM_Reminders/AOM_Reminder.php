<?php
class AOM_Reminder extends Basic {
    var $new_schema = true;
    var $module_dir = 'AOM_Reminders';
    var $object_name = 'Reminder';
    var $table_name = 'aom_reminders';
    var $importable = false;
    var $disable_row_level_security = true;

    public function __construct() {
        parent::Basic();
    }

    public function bean_implements($interface){
        switch($interface){
            case 'ACL': return true;
        }
        return false;
    }


}
?>