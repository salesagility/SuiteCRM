<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/jjwg_Markers/jjwg_Markers.php');

class jjwg_MarkersDashlet extends DashletGeneric { 
    
    function jjwg_MarkersDashlet($id, $def = null) {
        
		require('modules/jjwg_Markers/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'jjwg_Markers');

        $this->searchFields = $dashletData['jjwg_MarkersDashlet']['searchFields'];
        $this->columns = $dashletData['jjwg_MarkersDashlet']['columns'];

        $this->seedBean = new jjwg_Markers();        
    }
    
}