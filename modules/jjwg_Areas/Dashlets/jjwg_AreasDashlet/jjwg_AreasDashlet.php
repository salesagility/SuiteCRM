<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/jjwg_Areas/jjwg_Areas.php');

class jjwg_AreasDashlet extends DashletGeneric
{
    public function __construct($id, $def = null)
    {
        require('modules/jjwg_Areas/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if (empty($def['title'])) {
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'jjwg_Areas');
        }

        $this->searchFields = $dashletData['jjwg_AreasDashlet']['searchFields'];
        $this->columns = $dashletData['jjwg_AreasDashlet']['columns'];

        $this->seedBean = BeanFactory::newBean('jjwg_Areas');
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function jjwg_AreasDashlet($id, $def = null)
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
