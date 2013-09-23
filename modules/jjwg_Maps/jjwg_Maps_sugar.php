<?php

class jjwg_Maps_sugar extends Basic {

    var $new_schema = true;
    var $module_dir = 'jjwg_Maps';
    var $object_name = 'jjwg_Maps';
    var $table_name = 'jjwg_maps';
    var $importable = true;
    var $disable_row_level_security = true;
    var $id;
    var $name;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description;
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $assigned_user_id;
    var $assigned_user_name;
    var $assigned_user_link;
    var $distance;
    var $unit_type;
    var $module_type;
    var $parent_name;
    var $parent_type;
    var $parent_id;

    function jjwg_Maps_sugar() {
        parent::Basic();
    }

    function bean_implements($interface) {
        switch ($interface) {
            case 'ACL': return true;
        }
        return false;
    }

}
