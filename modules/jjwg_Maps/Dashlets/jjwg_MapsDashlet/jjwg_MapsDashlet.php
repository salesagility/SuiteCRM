<?php if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/jjwg_Maps/jjwg_Maps.php');

class jjwg_MapsDashlet extends DashletGeneric
{
    public function __construct($id, $def = null)
    {
        require('modules/jjwg_Maps/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if (empty($def['title'])) {
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'jjwg_Maps');
        }

        $this->searchFields = $dashletData['jjwg_MapsDashlet']['searchFields'];
        $this->columns = $dashletData['jjwg_MapsDashlet']['columns'];

        $this->seedBean = new jjwg_Maps();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function jjwg_MapsDashlet($id, $def = null)
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
