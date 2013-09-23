<?php

// custom/modules/Meetings/MeetingsJjwg_MapsLogicHook.php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class MeetingsJjwg_MapsLogicHook {

    function updateMeetingGeocodeInfo(&$bean, $event, $arguments) {
        // after_save
        $jjwg_Maps = get_module_info('jjwg_Maps');
        if ($jjwg_Maps->settings['logic_hooks_enabled']) {
            $jjwg_Maps->updateMeetingGeocodeInfo($bean);
        }
    }

}
