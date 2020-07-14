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








$focus = BeanFactory::newBean('Roles');

$tabs_def = urldecode($_REQUEST['display_tabs_def']);
$tabs_hide = urldecode($_REQUEST['hide_tabs_def']);

$allow_modules = explode(':::', $tabs_def);
$disallow_modules = explode(':::', $tabs_hide);

$focus->retrieve($_POST['record']);
print_r($_POST);
unset($_POST['id']);


foreach ($focus->column_fields as $field) {
    if (isset($_POST[$field])) {
        $value = $_POST[$field];
        $focus->$field = $value;
    }
}


$check_notify = false;

$focus->save($check_notify);
$return_id = $focus->id;

$focus->clear_module_relationship($return_id);
$focus->set_module_relationship($return_id, $allow_modules, 1);
$focus->set_module_relationship($return_id, $disallow_modules, 0);



if (isset($_POST['return_module']) && $_POST['return_module'] != "") {
    $return_module = $_POST['return_module'];
} else {
    $return_module = "Roles";
}
if (isset($_POST['return_action']) && $_POST['return_action'] != "") {
    $return_action = $_POST['return_action'];
} else {
    $return_action = "DetailView";
}
if (isset($_POST['return_id']) && $_POST['return_id'] != "") {
    $return_id = $_POST['return_id'];
}

    $GLOBALS['log']->debug("Saved record with id of ".$return_id);
    header("Location: index.php?action=$return_action&module=$return_module&record=$return_id");
