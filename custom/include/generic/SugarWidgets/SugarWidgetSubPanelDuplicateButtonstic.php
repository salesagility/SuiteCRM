<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class SugarWidgetSubPanelDuplicateButtonstic extends SugarWidgetField
{
    public function displayHeaderCell($layout_def)
    {
        return '&nbsp;';
    }

    public function displayList(&$layout_def)
    {
        global $app_strings;
        global $subpanel_item_count;

        $unique_id = $layout_def['subpanel_id'] . "_duplicate_" . $subpanel_item_count; 

        $parent_module = $_REQUEST['module'];

        $action = 'DuplicateSubpanelRecord';
        $record = $layout_def['fields']['ID'];
        $current_module=$layout_def['module'];

        $hidebutton=false;
        if ($current_module === 'ACLRoles' && (!ACLController::checkAccess($current_module, 'edit', true))) {
            $hidebutton = true;
        } elseif ($current_module === 'ACLRoles' && (!ACLController::checkAccess($current_module, 'edit', true))) {
            $hidebutton = true;
        }
        
        $subpanel = $layout_def['subpanel_id'];

        $duplicate_text = $app_strings['LBL_DUPLICATE_BUTTON'];
        
        if ($layout_def['ListView'] && !$hidebutton) {
           return "<a href=\"javascript:".
                    "var obj = {".
                        "action: '$action', ".
                        "module: '$parent_module', ".
                        "return_module: '$parent_module', ".
                        "return_action: 'DetailView', ".
                        "main_record: window.document.forms['DetailView'].record.value, ".
                        "subpanel_record: '$record', ".
                        "subpanel_name: '$subpanel', ".
                    "};".
                    "location.href = '?index.php&'+$.param(obj);\" ". 
                    "class='listViewTdToolsS1' ". 
                    "id=$unique_id ". 
                    ">$duplicate_text</a>";
        }
        return '';
    }
}
