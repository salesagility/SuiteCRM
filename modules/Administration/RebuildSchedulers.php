<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

echo getClassicModuleTitle('Administration', array($mod_strings['LBL_REBUILD_SCHEDULERS_TITLE']), false);

if (isset($_REQUEST['perform_rebuild']) && $_REQUEST['perform_rebuild'] == 'true') {
    require_once('install/install_utils.php');
    $focus = BeanFactory::newBean('Schedulers');
    $focus->rebuildDefaultSchedulers();
    
    $admin_mod_strings = return_module_language($current_language, 'Administration'); ?>
<table cellspacing="{CELLSPACING}" class="otherview">
	<tr> 
		<td scope="row" width="35%"><?php echo $admin_mod_strings['LBL_REBUILD_SCHEDULERS_DESC_SUCCESS']; ?></td>
		<td><a href="index.php?module=Administration&action=Upgrade"><?php echo $admin_mod_strings['LBL_RETURN']; ?></a></td>
	</tr>
</table>
<?php
} else {
        ?>	
<p>
<form name="RebuildSchedulers" method="post" action="index.php">
<input type="hidden" name="module" value="Administration">
<input type="hidden" name="action" value="RebuildSchedulers">
<input type="hidden" name="return_module" value="Administration">
<input type="hidden" name="return_action" value="Upgrade">
<input type="hidden" name="perform_rebuild" value="true">
<table cellspacing="{CELLSPACING}" class="other view">
	<tr>
	    <td scope="row" width="15%"><?php echo $mod_strings['LBL_REBUILD_SCHEDULERS_TITLE']; ?></td>
	    <td><input type="submit" name="button" value="<?php echo $mod_strings['LBL_REBUILD']; ?>"></td>
	</tr>
	<tr> 
		<td colspan="2" scope="row"><?php echo $mod_strings['LBL_REBUILD_SCHEDULERS_DESC']; ?></td>
	</tr>
</table>
</form>
</p>
<?php
    }
?>