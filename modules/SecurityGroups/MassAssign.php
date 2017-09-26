<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('modules/SecurityGroups/SecurityGroup.php');

require_once('include/formbase.php');
global $current_user, $db;


$module = $_REQUEST['return_module'];
$sugarbean = null;

$securitygroup = $_REQUEST['massassign_group'];
if(!isset($module) || empty($securitygroup) || !isset($securitygroup)) return;

if(!empty($GLOBALS['beanList'][$module])){
	$class = $GLOBALS['beanList'][$module];
	if(!empty($GLOBALS['beanFiles'][$class])){
		require_once($GLOBALS['beanFiles'][$class]);
		$sugarbean = new $class();
	}
}

$groupFocus = new SecurityGroup();
$groupFocus->retrieve($securitygroup);





if(!empty($_REQUEST['uid'])) $_POST['mass'] = explode(',', $_REQUEST['uid']); // coming from listview
elseif(isset($_REQUEST['entire'])) {
	if(isset($_SESSION['export_where']) && !empty($_SESSION['export_where'])) { // bug 4679
		$where = $_SESSION['export_where'];
		$whereArr = explode (" ", trim($where));
		if ($whereArr[0] == trim('where')) {
			$whereClean = array_shift($whereArr);
		}
		$where = implode(" ", $whereArr);
	} else {
		$where = '';
	}
	if(empty($order_by))$order_by = '';
	$query = $sugarbean->create_export_query($order_by,$where);
	$result = $db->query($query,true);

	$new_arr = array();
	while($val = $db->fetchByAssoc($result,-1,false))
	{
		$new_arr[] = $val['id'];
	}
	$_POST['mass'] = $new_arr;
}

if(isset($_POST['mass']) && is_array($_POST['mass'])){
	$rel_name = "";
	foreach($_POST['mass'] as $id){
		if(isset($_POST['Delete'])){
			$sugarbean->retrieve($id);

			//if($sugarbean->ACLAccess('Delete')){
				
				$GLOBALS['log']->debug("MassAssign - deleting relationship: $groupFocus->name");
				if($sugarbean->module_dir == 'Users') {
					$rel_name = "SecurityGroups";
				} else if(empty($rel_name) || !isset($rel_name)) {
					$rel_name = $groupFocus->getLinkName($sugarbean->module_dir,"SecurityGroups");
				}
				$sugarbean->load_relationship($rel_name);
				$sugarbean->$rel_name->delete($sugarbean->id,$groupFocus->id);
				
				//As of 6.3.0 many-to-many requires a link field set in both modules...so lets bypass that
				//$groupFocus->removeGroupFromRecord($sugarbean->module_dir, $id, $groupFocus->id);
			//}


		}
		else {
			$sugarbean->retrieve($id);

			//if($sugarbean->ACLAccess('Save')){
				
				$GLOBALS['log']->debug("MassAssign - adding relationship: $groupFocus->name");
				if($sugarbean->module_dir == 'Users') {
					$rel_name = "SecurityGroups";
				} else if(empty($rel_name) || !isset($rel_name)) {
					$rel_name = $groupFocus->getLinkName($sugarbean->module_dir,"SecurityGroups");
				}
				$GLOBALS['log']->debug("MassAssign - adding relationship relationship name: ".$rel_name);
				$sugarbean->load_relationship($rel_name);
				$sugarbean->$rel_name->add($groupFocus->id);
				

				//As of 6.3.0 many-to-many requires a link field set in both modules...so lets bypass that
				/**
				//check existing
				$query = "SELECT * FROM securitygroups_records WHERE securitygroup_id='$groupFocus->id' AND record_id='$id' AND module='$sugarbean->module_dir' AND deleted=0";
				$db = DBManagerFactory::getInstance();
				$result = $db->query($query);
				$row = $db->fetchByAssoc($result);
				if (empty($row))
				{
					$groupFocus->addGroupToRecord($sugarbean->module_dir, $id, $groupFocus->id);
				}
				*/


			//}
		}
	}
}


header("Location: index.php?action={$_POST['return_action']}&module={$_POST['return_module']}");

?>
