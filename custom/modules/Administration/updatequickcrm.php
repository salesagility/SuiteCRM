<?php
/*********************************************************************************
 * This file is part of QuickCRM Mobile Pro.
 * QuickCRM Mobile Pro is a mobile client for SugarCRM
 * 
 * Author : NS-Team (http://www.quickcrm.fr/mobile)
 * All rights (c) 2011-2012 by NS-Team
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
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/Administration/genJSfromSugar.php');

global $sugar_config;
global $mod_strings;
createMobileFiles();
echo $mod_strings['LBL_UPDATE_MSG']." <strong>".$sugar_config['site_url'].'/mobile</strong>';

?>
