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

if(!$GLOBALS['current_user']->isAdminForModule('Users')){
	sugar_die('No Access');
}
$record = '';
if(isset($_REQUEST['record'])) $record = $_REQUEST['record'];
?>
<form action="index.php" method="post" name="DetailView" id="form">

			<input type="hidden" name="module" value="Users">
			<input type="hidden" name="user_id" value="">
			<input type="hidden" name="record" value="<?php echo $record; ?>">
			<input type="hidden" name="isDuplicate" value=''>
			
			
			<input type="hidden" name="action">
</form>

<?php

$users = get_user_array(true, "Active", $record);
echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'],array($mod_strings['LBL_MODULE_NAME']), true);
echo "<form name='Users'>
<input type='hidden' name='action' value='ListRoles'>
<input type='hidden' name='module' value='Users'>
<select name='record' onchange='document.Users.submit();'>";
echo get_select_options_with_id($users, $record);
echo "</select></form>";
if(!empty($record)){
    $hideTeams = true; // to not show the teams subpanel in the following file
	require_once('modules/ACLRoles/DetailUserRole.php');
}


?>