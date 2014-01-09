<?php

class jjwg_Markers_sugar extends Basic {

    var $new_schema = true;
    var $module_dir = 'jjwg_Markers';
    var $object_name = 'jjwg_Markers';
    var $table_name = 'jjwg_markers';
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
    var $jjwg_maps_lat;
    var $jjwg_maps_lng;
    var $marker_image;

    function jjwg_Markers_sugar() {
        parent::Basic();
    }

    function bean_implements($interface) {
        switch ($interface) {
            case 'ACL': return true;
        }
        return false;
    }

}
