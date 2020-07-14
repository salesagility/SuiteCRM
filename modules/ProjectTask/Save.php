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





$project = new ProjectTask();
if (!empty($_POST['record'])) {
    $project->retrieve($_POST['record']);
}
////
//// save the fields to the ProjectTask object
////

if (isset($_REQUEST['email_id'])) {
    $project->email_id = $_REQUEST['email_id'];
}

require_once('include/formbase.php');
$project = populateFromPost('', $project);
if (!isset($_REQUEST['milestone_flag'])) {
    $project->milestone_flag = '0';
}


$GLOBALS['check_notify'] = false;
if (!empty($_POST['assigned_user_id']) && ($project->assigned_user_id != $_POST['assigned_user_id']) && ($_POST['assigned_user_id'] != $current_user->id)) {
    $GLOBALS['check_notify'] = true;
}

    if (!$project->ACLAccess('Save')) {
        ACLController::displayNoAccess(true);
        sugar_cleanup(true);
    }

if (empty($project->project_id)) {
    $project->project_id = $_POST['relate_id'];
} //quick for 5.1 till projects are revamped for 5.5 nsingh- 7/3/08
$project->save($GLOBALS['check_notify']);

if (isset($_REQUEST['form'])) {
    // we are doing the save from a popup window
    echo '<script>opener.window.location.reload();self.close();</script>';
    die();
}
    // need to refresh the page properly

    $return_module = empty($_REQUEST['return_module']) ? 'ProjectTask'
        : $_REQUEST['return_module'];

    $return_action = empty($_REQUEST['return_action']) ? 'index'
        : $_REQUEST['return_action'];

    $return_id = empty($_REQUEST['return_id']) ? $project->id
        : $_REQUEST['return_id'];
        
    //if this navigation is going to list view, do not show the bean id, it will populate the mass update.
    if ($return_action == 'index') {
        $return_id ='';
    }
    header("Location: index.php?module=$return_module&action=$return_action&record=$return_id");
