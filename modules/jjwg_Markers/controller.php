<?php

// modules/jjwg_Markers/controller.php

include_once('include/utils.php');

class jjwg_MarkersController extends SugarController {

    function action_marker_edit_map() {

        $this->view = 'marker_edit_map';
        $jjwg_Markers = get_module_info('jjwg_Markers');

        // Get the map object
        if (is_guid($_REQUEST['id'])) {
            $jjwg_Markers->retrieve($_REQUEST['id']);
        }
        $GLOBALS['loc'] = $jjwg_Markers->define_loc();
    }

    function action_marker_detail_map() {

        $this->view = 'marker_detail_map';
        $jjwg_Markers = get_module_info('jjwg_Markers');

        // Get the map object
        if (is_guid($_REQUEST['id'])) {
            $jjwg_Markers->retrieve($_REQUEST['id']);
        }
        $GLOBALS['loc'] = $jjwg_Markers->define_loc();
    }

}
