<?php

// modules/jjwg_Areas/controller.php

include_once('include/utils.php');

class jjwg_AreasController extends SugarController {

    function action_area_edit_map() {

        $this->view = 'area_edit_map';
        global $loc;
        global $polygon;
        $jjwg_Areas = get_module_info('jjwg_Areas');

        // Get the map object
        if (is_guid($_REQUEST['id'])) {
            $jjwg_Areas->retrieve($_REQUEST['id']);
        }
        $loc = $jjwg_Areas->define_area_loc();
        $polygon = $jjwg_Areas->define_polygon();
    }

    function action_area_detail_map() {

        $this->view = 'area_detail_map';
        global $loc;
        global $polygon;
        $jjwg_Areas = get_module_info('jjwg_Areas');

        // Get the map object
        if (is_guid($_REQUEST['id'])) {
            $jjwg_Areas->retrieve($_REQUEST['id']);
        }
        $loc = $jjwg_Areas->define_area_loc();
        $polygon = $jjwg_Areas->define_polygon();
    }

}
