<?php

class jjwg_Areas_sugar extends Basic {

    var $new_schema = true;
    var $module_dir = 'jjwg_Areas';
    var $object_name = 'jjwg_Areas';
    var $table_name = 'jjwg_areas';
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
    var $city;
    var $state;
    var $country;
    var $coordinates;

    function jjwg_Areas_sugar() {
        parent::Basic();
    }

    function bean_implements($interface) {
        switch ($interface) {
            case 'ACL': return true;
        }
        return false;
    }

}
