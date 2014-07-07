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

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

	
if(!empty($_REQUEST['saved_search_action'])) {

	$ss = new SavedSearch();
	
	switch($_REQUEST['saved_search_action']) {
        case 'update': // save here
        	$savedSearchBean = loadBean($_REQUEST['search_module']);
            $ss->handleSave('', true, false, $_REQUEST['saved_search_select'], $savedSearchBean);
            break;
		case 'save': // save here
			$savedSearchBean = loadBean($_REQUEST['search_module']);
			$ss->handleSave('', true, false, null, $savedSearchBean);
			break;
		case 'delete': // delete here
			$ss->handleDelete($_REQUEST['saved_search_select']);
			break;			
	}
}
elseif(!empty($_REQUEST['saved_search_select'])) { // requesting a search here.
    if(!empty($_REQUEST['searchFormTab'])) // where is the request from  
        $searchFormTab = $_REQUEST['searchFormTab'];
    else 
        $searchFormTab = 'saved_views';

	if($_REQUEST['saved_search_select'] == '_none') { // none selected
		$_SESSION['LastSavedView'][$_REQUEST['search_module']] = '';
        $current_user->setPreference('ListViewDisplayColumns', array(), 0, $_REQUEST['search_module']);
        $ajaxLoad = empty($_REQUEST['ajax_load']) ? "" : "&ajax_load=" . $_REQUEST['ajax_load'];
        header("Location: index.php?action=index&module={$_REQUEST['search_module']}&searchFormTab={$searchFormTab}&query=true&clear_query=true$ajaxLoad");
		die();
	}
	else {
		
		$ss = new SavedSearch();
        $show='no';
        if(isset($_REQUEST['showSSDIV'])){$show = $_REQUEST['showSSDIV'];}
		$ss->returnSavedSearch($_REQUEST['saved_search_select'], $searchFormTab, $show);
	}
}
else {
	include('modules/SavedSearch/ListView.php');
}

?>