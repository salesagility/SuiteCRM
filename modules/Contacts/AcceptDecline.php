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


global $sugar_config, $dbconfig, $beanList, $beanFiles, $app_strings, $app_list_strings, $current_user;

global $currentModule, $focus;

if (!empty($_REQUEST['user_id'])) {
    $current_user = new User();
    $result = $current_user->retrieve($_REQUEST['user_id']);
    if ($result == null) {
        session_destroy();
        sugar_cleanup();
        die("The user id doesn't exist");
    }
    $current_entity = $current_user;
} else {
    if (! empty($_REQUEST['contact_id'])) {
        $current_entity = new Contact();
        $current_entity->disable_row_level_security = true;
        $result = $current_entity->retrieve($_REQUEST['contact_id']);
        if ($result == null) {
            session_destroy();
            sugar_cleanup();
            die("The contact id doesn't exist");
        }
    } else {
        if (! empty($_REQUEST['lead_id'])) {
            $current_entity = new Lead();
            $current_entity->disable_row_level_security = true;
            $result = $current_entity->retrieve($_REQUEST['lead_id']);
            if ($result == null) {
                session_destroy();
                sugar_cleanup();
                die("The lead id doesn't exist");
            }
        }
    }
}

$bean = $beanList[clean_string($_REQUEST['module'])];
require_once($beanFiles[$bean]);
$focus = new $bean;
$focus->disable_row_level_security = true;
$result = $focus->retrieve($_REQUEST['record']);

if ($result == null) {
    session_destroy();
    sugar_cleanup();
    die("The focus id doesn't exist");
}

$focus->set_accept_status($current_entity, $_REQUEST['accept_status']);

print $app_strings['LBL_STATUS_UPDATED']."<BR><BR>";
print $app_strings['LBL_STATUS']. " ". $app_list_strings['dom_meeting_accept_status'][$_REQUEST['accept_status']];
print "<BR><BR>";

print "<a href='?module=$currentModule&action=DetailView&record=$focus->id'>".$app_strings['LBL_MEETING_GO_BACK']."</a><br>";
sugar_cleanup();
exit;
