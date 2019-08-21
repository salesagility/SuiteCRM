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








$sugarbean = BeanFactory::newBean('Project');

// perform the delete if given a record to delete

if (empty($_REQUEST['record'])) {
    $GLOBALS['log']->info('delete called without a record id specified');
} else {
    $record = $_REQUEST['record'];
    $sugarbean->retrieve($record);
    if (!$sugarbean->ACLAccess('Delete')) {
        ACLController::displayNoAccess(true);
        sugar_cleanup(true);
    }
    $GLOBALS['log']->info("deleting record: $record");
    $sugarbean->mark_deleted($record);
}

// handle the return location variables

$return_module = empty($_REQUEST['return_module']) ? 'Project'
    : $_REQUEST['return_module'];

$return_action = empty($_REQUEST['return_action']) ? 'index'
    : $_REQUEST['return_action'];

$return_id = empty($_REQUEST['return_id']) ? ''
    : $_REQUEST['return_id'];

$return_location = "index.php?module=$return_module&action=$return_action";

// append the return_id if given
if (!empty($return_id)) {
    $return_location .= "&record=$return_id";
}

// now that the delete has been performed, return to given location

header("Location: $return_location");
