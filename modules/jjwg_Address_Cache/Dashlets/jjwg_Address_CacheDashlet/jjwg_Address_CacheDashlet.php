<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/jjwg_Address_Cache/jjwg_Address_Cache.php');

class jjwg_Address_CacheDashlet extends DashletGeneric { 

    function jjwg_Address_CacheDashlet($id, $def = null) {
        
        require('modules/jjwg_Address_Cache/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if (empty($def['title']))
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'jjwg_Address_Cache');

        $this->searchFields = $dashletData['jjwg_Address_CacheDashlet']['searchFields'];
        $this->columns = $dashletData['jjwg_Address_CacheDashlet']['columns'];

        $this->seedBean = new jjwg_Address_Cache();        
    }

}