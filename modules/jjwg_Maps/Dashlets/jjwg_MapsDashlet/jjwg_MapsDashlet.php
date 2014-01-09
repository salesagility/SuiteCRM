<?php if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/jjwg_Maps/jjwg_Maps.php');

class jjwg_MapsDashlet extends DashletGeneric { 

    function jjwg_MapsDashlet($id, $def = null) {
        
        require('modules/jjwg_Maps/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if (empty($def['title']))
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'jjwg_Maps');

        $this->searchFields = $dashletData['jjwg_MapsDashlet']['searchFields'];
        $this->columns = $dashletData['jjwg_MapsDashlet']['columns'];

        $this->seedBean = new jjwg_Maps();        
    }

}