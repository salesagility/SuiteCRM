<?php

// custom/modules/Prospects/ProspectsJjwg_MapsLogicHook.php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class ProspectsJjwg_MapsLogicHook {

    function updateGeocodeInfo(&$bean, $event, $arguments) {
        // before_save
        $jjwg_Maps = get_module_info('jjwg_Maps');
        if ($jjwg_Maps->settings['logic_hooks_enabled']) {
        $jjwg_Maps->updateGeocodeInfo($bean);
    }
    }
    
    function updateRelatedMeetingsGeocodeInfo(&$bean, $event, $arguments) {
        // after_save
        $jjwg_Maps = get_module_info('jjwg_Maps');
        if ($jjwg_Maps->settings['logic_hooks_enabled']) {
        $jjwg_Maps->updateRelatedMeetingsGeocodeInfo($bean);
    }
    }

}
