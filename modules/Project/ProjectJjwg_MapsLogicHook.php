<?php

// custom/modules/Project/ProjectJjwg_MapsLogicHook.php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class ProjectJjwg_MapsLogicHook
{
    public $jjwg_Maps;
    public function __construct()
    {
        $this->jjwg_Maps = get_module_info('jjwg_Maps');
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function ProjectJjwg_MapsLogicHook()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    public function updateGeocodeInfo(&$bean, $event, $arguments)
    {
        // before_save
        if ($this->jjwg_Maps->settings['logic_hooks_enabled']) {
            $this->jjwg_Maps->updateGeocodeInfo($bean);
        }
    }

    public function updateRelatedMeetingsGeocodeInfo(&$bean, $event, $arguments)
    {
        // after_save
        if ($this->jjwg_Maps->settings['logic_hooks_enabled']) {
            $this->jjwg_Maps->updateRelatedMeetingsGeocodeInfo($bean);
        }
    }

    public function addRelationship(&$bean, $event, $arguments)
    {
        // after_relationship_add
        // $arguments['module'], $arguments['related_module'], $arguments['id'] and $arguments['related_id']
        $focus = get_module_info($arguments['module']);
        if ($this->jjwg_Maps->settings['logic_hooks_enabled']) {
            if (!empty($arguments['id'])) {
                $focus->retrieve($arguments['id']);
                $focus->custom_fields->retrieve();
                $this->jjwg_Maps->updateGeocodeInfo($focus, true);
                if ($focus->jjwg_maps_address_c != $focus->fetched_row['jjwg_maps_address_c']) {
                    $focus->save(false);
                }
            }
        }
    }

    public function deleteRelationship(&$bean, $event, $arguments)
    {
        // after_relationship_delete
        // $arguments['module'], $arguments['related_module'], $arguments['id'] and $arguments['related_id']
        if ($this->jjwg_Maps->settings['logic_hooks_enabled']) {
            $focus = get_module_info($arguments['module']);
            if (!empty($arguments['id'])) {
                $focus->retrieve($arguments['id']);
                $focus->custom_fields->retrieve();
                $this->jjwg_Maps->updateGeocodeInfo($focus, true);
                if ($focus->jjwg_maps_address_c != $focus->fetched_row['jjwg_maps_address_c']) {
                    $focus->save(false);
                }
            }
        }
    }
}
