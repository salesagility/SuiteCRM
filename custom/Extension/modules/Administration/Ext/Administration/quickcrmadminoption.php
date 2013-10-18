<?php
/*********************************************************************************
 * This file is part of QuickCRM Mobile Pro.
 * QuickCRM Mobile Pro is a mobile client for SugarCRM
 * 
 * Author : NS-Team (http://www.quickcrm.fr/mobile)
 * All rights (c) 2011 by NS-Team
 *
 * This Version of the QuickCRM Mobile Pro is licensed software and may only be used in 
 * alignment with the License Agreement received with this Software.
 * This Software is copyrighted and may not be further distributed without
 * witten consent of NS-Team
 * 
 * You can contact NS-Team at NS-Team - 55 Chemin de Mervilla - 31320 Auzeville - France
 * or via email at quickcrm@ns-team.fr
 * 
 ********************************************************************************/

$admin_option_defs=array();
$admin_option_defs['Administration']['quickcrm_update']= array('Administration','LBL_UPDATE_QUICKCRM_TITLE','LBL_UPDATE_QUICKCRM','./index.php?module=Administration&action=updatequickcrm');


$admin_option_defs['Administration'] = array_merge((array)$admin_group_header[1][3]['Administration'],(array)$admin_option_defs['Administration']);

$admin_group_header[1]= array('LBL_ADMINISTRATION_HOME_TITLE','',false,$admin_option_defs, 'LBL_ADMINISTRATION_HOME_DESC');


?>