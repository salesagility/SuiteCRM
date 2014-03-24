<?php
/*********************************************************************************
 * This file is part of QuickCRM Mobile CE.
 * QuickCRM Mobile CE is a mobile client for SugarCRM
 *
 * Author : NS-Team (http://www.ns-team.fr)
 *
 * QuickCRM Mobile CE is licensed under GNU General Public License v3 (GPLv3)
 *
 * You can contact NS-Team at NS-Team - 55 Chemin de Mervilla - 31320 Auzeville - France
 * or via email at infos@ns-team.fr
 *
 ********************************************************************************/

$admin_option_defs=array();
$admin_option_defs['Administration']['quickcrm_update']= array('Administration','LBL_UPDATE_QUICKCRM_TITLE','LBL_UPDATE_QUICKCRM','./index.php?module=Administration&action=updatequickcrm');


$admin_option_defs['Administration'] = array_merge((array)$admin_group_header[1][3]['Administration'],(array)$admin_option_defs['Administration']);

$admin_group_header[1]= array('LBL_ADMINISTRATION_HOME_TITLE','',false,$admin_option_defs, 'LBL_ADMINISTRATION_HOME_DESC');



?>