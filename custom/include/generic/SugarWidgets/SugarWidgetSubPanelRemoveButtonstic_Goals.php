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


/**
 * This custom class, cloned from SugarWidgetSubPanelRemoveButton, allows you to create a button in each record of the subpanel
 * which calls the custom functions defined to handle the many2many auto relation between goals.
 */
class SugarWidgetSubPanelRemoveButtonstic_Goals extends SugarWidgetField
{
    public function displayHeaderCell($layout_def)
    {
        return '&nbsp;';
    }

    public function displayList(&$layout_def)
    {
        global $app_strings;
        global $subpanel_item_count;

        $unique_id = $layout_def['subpanel_id'] . "_remove_" . $subpanel_item_count; //bug 51512

        $parent_record_id = $_REQUEST['record'];
        $parent_module = $_REQUEST['module'];

        $action = 'DeleteRelationship';
        $record = $layout_def['fields']['ID'];
        $current_module=$layout_def['module'];
        //in document revisions subpanel ,users are now allowed to
        //delete the latest revsion of a document. this will be tested here
        //and if the condition is met delete button will be removed.
        $hideremove=false;
        if ($current_module==='DocumentRevisions') {
            if ($layout_def['fields']['ID']===$layout_def['fields']['LATEST_REVISION_ID']) {
                $hideremove=true;
            }
        } elseif ($_REQUEST['module'] === 'Teams' && $current_module === 'Users') {
            // Implicit Team-memberships are not "removeable"

            if ($layout_def['fields']['UPLINE'] !== translate('LBL_TEAM_UPLINE_EXPLICIT', 'Users')) {
                $hideremove = true;
            }

            //We also cannot remove the user whose private team is set to the parent_record_id value
            $user = BeanFactory::newBean('Users');
            $user->retrieve($layout_def['fields']['ID']);
            if ($parent_record_id === $user->getPrivateTeamID()) {
                $hideremove = true;
            }
        } elseif ($current_module === 'ACLRoles' && (!ACLController::checkAccess($current_module, 'edit', true))) {
            $hideremove = true;
        } elseif ($current_module === 'ACLRoles' && (!ACLController::checkAccess($current_module, 'edit', true))) {
            $hideremove = true;
        }
        
        $return_module = $_REQUEST['module'];
        $return_action = 'SubPanelViewer';
        $subpanel = $layout_def['subpanel_id'];
        $return_id = $_REQUEST['record'];
        if (isset($layout_def['linked_field_set']) && !empty($layout_def['linked_field_set'])) {
            $linked_field= $layout_def['linked_field_set'] ;
        } else {
            $linked_field = $layout_def['linked_field'];
        }
        $refresh_page = 1;
        if (!empty($layout_def['refresh_page'])) {
            $refresh_page = 1;
        }
        $return_url = "index.php?module=$return_module&action=$return_action&subpanel=$subpanel&record=$return_id&sugar_body_only=1&inline=1";

        $icon_remove_text = $app_strings['LBL_ID_FF_REMOVE'];

        if ($linked_field === 'get_emails_by_assign_or_link') {
            $linked_field = 'emails';
        }
        
        //based on listview since that lets you select records
        if ($layout_def['ListView'] && !$hideremove) {
            $retStr = "<a href=\"javascript:removeCustomRelationManyToMany('$subpanel', '$record', $refresh_page);\""
                . ' class="listViewTdToolsS1"'
                . "id=$unique_id"
                . " onclick=\"return sp_rem_conf();\""
                . ">$icon_remove_text</a>";

            return $retStr;
        }

        return '';
    }
}
