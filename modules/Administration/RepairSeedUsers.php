<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

global $current_user;

if(is_admin($current_user)){
    if(count($_POST)){
    	if(!empty($_POST['activate'])){

    		$status = '';
    		if($_POST['activate'] == 'false'){
    			$status = 'Inactive';
    		}else{
    			$status = 'Active';
    		}
    	}
    	$query = "UPDATE users SET status = '$status' WHERE id LIKE 'seed%'";
   		$GLOBALS['db']->query($query);
    }
    	$query = "SELECT status FROM users WHERE id LIKE 'seed%'";
    	$result = $GLOBALS['db']->query($query);
		$row = $GLOBALS['db']->fetchByAssoc($result);
		if(!empty($row['status'])){
			$activate = 'false';
			if($row['status'] == 'Inactive'){
				$activate = 'true';
			}
			?>
				<p>
				<form name="RepairSeedUsers" method="post" action="index.php">
				<input type="hidden" name="module" value="Administration">
				<input type="hidden" name="action" value="RepairSeedUsers">
				<input type="hidden" name="return_module" value="Administration">
				<input type="hidden" name="return_action" value="Upgrade">
				<input type="hidden" name="activate" value="<?php echo $activate; ?>">
				<table cellspacing="{CELLSPACING}" class="otherview">
					<tr>
					    <td scope="row" width="30%"><?php echo $mod_strings['LBL_REPAIR_SEED_USERS_TITLE']; ?></td>
					    <td><input type="submit" name="button" value="<?php if($row['status'] == 'Inactive'){echo $mod_strings['LBL_REPAIR_SEED_USERS_ACTIVATE'];}else{echo $mod_strings['LBL_REPAIR_SEED_USERS_DECACTIVATE'];} ?>"></td>
					</tr>
				</table>
				</form>
				</p>
			<?php

		}else{
			echo 'No seed Users';
		}
}
else{
	sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}
?>