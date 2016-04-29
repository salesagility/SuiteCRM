<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/jjwg_Address_Cache/jjwg_Address_Cache.php');

class jjwg_Address_CacheDashlet extends DashletGeneric {

    function __construct($id, $def = null) {

        require('modules/jjwg_Address_Cache/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if (empty($def['title']))
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'jjwg_Address_Cache');

        $this->searchFields = $dashletData['jjwg_Address_CacheDashlet']['searchFields'];
        $this->columns = $dashletData['jjwg_Address_CacheDashlet']['columns'];

        $this->seedBean = new jjwg_Address_Cache();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function jjwg_Address_CacheDashlet($id, $def = null){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($id, $def);
    }


}