<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

global $theme;
global $mod_strings;
global $app_list_strings;
global $current_user;

$focus = new InboundEmail();
$focus->checkImap();

///////////////////////////////////////////////////////////////////////////////
////	I-E SYSTEM SETTINGS
////	handle saving settings
if(isset($_REQUEST['save']) && $_REQUEST['save'] == 'true') {
	$focus->saveInboundEmailSystemSettings('Case', $_REQUEST['inbound_email_case_macro']);
}
////	END I-E SYSTEM SETTINGS
///////////////////////////////////////////////////////////////////////////////

if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){	
	$ListView->setHeaderText("<a href='index.php?action=index&module=DynamicLayout&from_action=ListView&from_module=".$_REQUEST['module'] ."'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDIT_LAYOUT'])."</a>" );
}

$where = '';
$limit = '0';
$orderBy = 'date_entered';
$varName = $focus->object_name;
$allowByOverride = true;

$listView = new ListView();
$listView->initNewXTemplate('modules/InboundEmail/ListView.html', $mod_strings);
$listView->setHeaderTitle($mod_strings['LBL_MODULE_TITLE']);

echo $focus->getSystemSettingsForm();
$listView->show_export_button = false;
$listView->ignorePopulateOnly = TRUE; //Always show all records, ignore save_query performance setting.
$listView->setQuery($where, $limit, $orderBy, 'InboundEmail', $allowByOverride);
$listView->xTemplateAssign("EDIT_INLINE_IMG", SugarThemeRegistry::current()->getImage('edit_inline','align="absmiddle" border="0"', null,null,'.gif',$app_strings['LNK_EDIT']));
$listView->processListView($focus, "main", "InboundEmail");

