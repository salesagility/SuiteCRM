<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2020 SalesAgility Ltd.
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

function display_conflict_between_objects($object_1, $object_2, $field_defs, $module_dir, $display_name)
{
    global $timedate;

    $mod_strings = return_module_language($GLOBALS['current_language'], 'OptimisticLock');
    $title = '<tr><td >&nbsp;</td>';
    $object1_row = '<tr class="oddListRowS1"><td><b>' . $mod_strings['LBL_YOURS'] . '</b></td>';
    $object2_row = '<tr class="evenListRowS1"><td><b>' . $mod_strings['LBL_IN_DATABASE'] . '</b></td>';
    $exists = false;

    $skip = ['team_name', 'date_entered', 'date_modified'];

    foreach ($field_defs as $name => $att) {
        $value = $object_1[$name];
        $compare = $object_2->$name;

        if (!is_scalar($value) || $compare instanceof Link || in_array($name, $skip)) {
            continue;
        }

        switch ($att['type']) {
            case 'date':
            case 'datetime':
            case 'datetimecombo':
                $ob1Date = $timedate->fromUserType($value, $att['type']) ?: $timedate->fromDbType($value, $att['type']);
                $ob2Date = $timedate->fromUserType($compare, $att['type']) ?: $timedate->fromDbType($compare, $att['type']);
                $value = !empty($ob1Date) ? $timedate->asUserType($ob1Date, $att['type']) : '';
                $compare = !empty($ob2Date) ? $timedate->asUserType($ob2Date, $att['type']) : '';
                $match = $value === $compare;
                break;
            case 'bool':
                $match = (bool)$value === (bool)$compare;
                break;
            Default:
                $value = SugarCleaner::cleanHtml($value, true);
                $compare = SugarCleaner::cleanHtml($compare, true);
                $match = $value == $compare;
                break;
        }

        if (!$match) {
            $title .= '<td ><b>&nbsp;' . translate($att['vname'], $module_dir) . '</b></td>';
            $object1_row .= '<td>&nbsp;' . $value . '</td>';
            $object2_row .= '<td>&nbsp;' . $compare . '</td>';
            $exists = true;
        }
    }

    if ($exists) {
        echo "<b>{$mod_strings['LBL_CONFLICT_EXISTS']}<a href='index.php?action=DetailView&module=$module_dir&record={$object_1['id']}'  target='_blank'>$display_name</a> </b> <br><table  class='list view' border='0' cellspacing='0' cellpadding='2'>$title<td  >&nbsp;</td></tr>$object1_row<td><a href='index.php?&module=OptimisticLock&action=LockResolve&save=true'>{$mod_strings['LBL_ACCEPT_YOURS']}</a></td></tr>$object2_row<td><a href='index.php?&module=$object_2->module_dir&action=DetailView&record=$object_2->id'>{$mod_strings['LBL_ACCEPT_DATABASE']}</a></td></tr></table><br>";
    } else {
        SugarApplication::redirect('index.php?&module=OptimisticLock&action=LockResolve&save=true');
    }
}

if (isset($_SESSION['o_lock_object'])) {
    $object = $_SESSION['o_lock_object'];
    $module = $_SESSION['o_lock_module'];
    $currentState = BeanFactory::getBean($module, $object['id']);

    if (isset($_REQUEST['save'])) {
        $_SESSION['o_lock_fs'] = true;
        echo $_SESSION['o_lock_save'];
        die();
    }
    display_conflict_between_objects($object, $currentState, $currentState->field_defs, $currentState->module_dir, $_SESSION['o_lock_class']);
} else {
    echo $mod_strings['LBL_NO_LOCKED_OBJECTS'];
}
