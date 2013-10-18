<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
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


/*
 ARGS:

 $_REQUEST['module'] : the module associated with this Bean instance (will be used to get the class name)
 $_REQUEST['prospect_lists'] : the id of the prospect list
 $_REQUEST['uids'] : the ids of the records to be added to the prospect list, separated by ','

 */

require_once 'include/formbase.php';

global $beanFiles,$beanList;
$bean_name = $beanList[$_REQUEST['module']];
require_once($beanFiles[$bean_name]);
$focus = new $bean_name();

$uids = array();
if($_REQUEST['select_entire_list'] == '1'){
	$order_by = '';

	require_once('include/MassUpdate.php');
	$mass = new MassUpdate();
	$mass->generateSearchWhere($_REQUEST['module'], $_REQUEST['current_query_by_page']);
	$ret_array = create_export_query_relate_link_patch($_REQUEST['module'], $mass->searchFields, $mass->where_clauses);
	/* BEGIN - SECURITY GROUPS */
	//need to hijack the $ret_array['where'] of securitygorup required
	if($focus->bean_implements('ACL') && ACLController::requireSecurityGroup($focus->module_dir, 'list') )
	{
		require_once('modules/SecurityGroups/SecurityGroup.php');
		global $current_user;
		$owner_where = $focus->getOwnerWhere($current_user->id);
		$group_where = SecurityGroup::getGroupWhere($focus->table_name,$focus->module_dir,$current_user->id);
		if(!empty($owner_where)){
			if(empty($ret_array['where']))
			{
				$ret_array['where'] = " (".  $owner_where." or ".$group_where.") ";
			} else {
				$ret_array['where'] .= " AND (".  $owner_where." or ".$group_where.") ";
			}
		} else {
			$ret_array['where'] .= ' AND '.  $group_where;
		}
	}
	/* END - SECURITY GROUPS */
	$query = $focus->create_export_query($order_by, $ret_array['where'], $ret_array['join']);
	$result = $GLOBALS['db']->query($query,true);
	$uids = array();
	while($val = $GLOBALS['db']->fetchByAssoc($result,false))
	{
		array_push($uids, $val['id']);
	}
}
else{
	$uids = explode ( ',', $_POST['uids'] );
}

// find the relationship to use
$relationship = '';
foreach($focus->get_linked_fields() as $field => $def) {
    if ($focus->load_relationship($field)) {
        if ( $focus->$field->getRelatedModuleName() == 'ProspectLists' ) {
            $relationship = $field;
            break;
        }
    }
}

if ( $relationship != '' ) {
    foreach ( $uids as $id) {
        $focus->retrieve($id);
        $focus->load_relationship($relationship);
        $focus->prospect_lists->add( $_REQUEST['prospect_list'] );
    }
}
handleRedirect();
exit;
?>
