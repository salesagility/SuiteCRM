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

 
/**
 * STIC-Custom 20240715 MHP - This "SugarWidget" is based on "SugarWidgetField".
 * This widget will display a link with the file name and a link icon. The link with the file name allows the user 
 * to download the file and the icon allows the user to preview the file.
 * https://github.com/SinergiaTIC/SinergiaCRM/pull/44
 */
class SugarWidgetSubPanelFileDownloadViewLink extends SugarWidgetField
{
    public function displayList(&$layout_def)
    {
        $module = '';
        $record = '';

        if (isset($layout_def['varname'])) {
            $key = strtoupper($layout_def['varname']);
        } else {
            $key = $this->_get_column_alias($layout_def);
            $key = strtoupper($key);
        }

        if (empty($layout_def['fields'][$key])) {
            return "";
        } else {
            $value = $layout_def['fields'][$key];
        }

        if (empty($layout_def['target_record_key'])) {
            $record = $layout_def['fields']['ID'];
        } else {
            $record_key = strtoupper($layout_def['target_record_key']);
            $record = $layout_def['fields'][$record_key];
        }

        if (!empty($layout_def['target_module_key'])) {
            if (!empty($layout_def['fields'][strtoupper($layout_def['target_module_key'])])) {
                $module=$layout_def['fields'][strtoupper($layout_def['target_module_key'])];
            }
        } else {
            if (!empty($layout_def['target_module'])) {
                $module = $layout_def['target_module'];
            } else {
                $module = $layout_def['module'];
            }
        }
        
        global $current_user;
        $groupAccessView = SecurityGroup::groupHasAccess($module,$record,'view');
        if (!empty($record) &&
            ($layout_def['DetailView'] && !$layout_def['owner_module']
            || $layout_def['DetailView'] && !ACLController::moduleSupportsACL($layout_def['owner_module'])
            || ACLController::checkAccess($layout_def['owner_module'], 'view', $layout_def['owner_id'] == $current_user->id, 'module',  $groupAccessView))) {
            $link = ajaxLink("index.php?entryPoint=download&id={$record}&type={$module}");
            return '<a href="' . $link . '" >'.$value.'</a><a href="' . $link . '&preview=yes" target=”_blank”><i class="glyphicon glyphicon-eye-open" style="margin-left: 16px"></i></a>';
        } else {
            return $value;
        }
    }
}
