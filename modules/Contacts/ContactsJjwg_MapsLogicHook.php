<?php

// custom/modules/Contacts/ContactsJjwg_MapsLogicHook.php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Class ContactsJjwg_MapsLogicHook
 */
class ContactsJjwg_MapsLogicHook
{

    /**
     * @var void
     */
    public $jjwg_Maps;

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8,
     *     please update your code, use __construct instead
     */
    public function ContactsJjwg_MapsLogicHook()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, ' .
            'please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    /**
     * ContactsJjwg_MapsLogicHook constructor.
     */
    public function __construct()
    {
        $this->jjwg_Maps = get_module_info('jjwg_Maps');
    }

    /**
     * @param $bean
     * @param $event
     * @param $arguments
     */
    public function updateGeocodeInfo(&$bean, $event, $arguments)
    {
        // before_save
        if ($this->jjwg_Maps->settings['logic_hooks_enabled']) {
            $this->jjwg_Maps->updateGeocodeInfo($bean);
        }
    }

    /**
     * @param $bean
     * @param $event
     * @param $arguments
     */
    public function updateRelatedMeetingsGeocodeInfo(&$bean, $event, $arguments)
    {
        // after_save
        if ($this->jjwg_Maps->settings['logic_hooks_enabled']) {
            $this->jjwg_Maps->updateRelatedMeetingsGeocodeInfo($bean);
        }
    }
}
