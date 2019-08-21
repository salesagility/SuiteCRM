<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/jjwg_Markers/jjwg_Markers.php');

class jjwg_MarkersDashlet extends DashletGeneric
{
    public function __construct($id, $def = null)
    {
        require('modules/jjwg_Markers/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if (empty($def['title'])) {
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'jjwg_Markers');
        }

        $this->searchFields = $dashletData['jjwg_MarkersDashlet']['searchFields'];
        $this->columns = $dashletData['jjwg_MarkersDashlet']['columns'];

        $this->seedBean = BeanFactory::newBean('jjwg_Markers');
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function jjwg_MarkersDashlet($id, $def = null)
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($id, $def);
    }
}
