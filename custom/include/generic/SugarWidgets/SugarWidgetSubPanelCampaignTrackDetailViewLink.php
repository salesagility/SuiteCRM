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
 * STIC-Custom - JBL - 20240722 - This "SugarWidget" is based on "SugarWidgetSubPanelDetailViewLink".
 * This widget will display a link that allows the user to navigate to TrackDetailView of a Camapaign record in a subpanel.
 * If the record is not a Campaign, the link will take the user to DetailView of the record in a subpanel.
 * https://github.com/SinergiaTIC/SinergiaCRM/pull/44
 */
class SugarWidgetSubPanelCampaignTrackDetailViewLink extends SugarWidgetSubPanelDetailViewLink
{
    public function displayList(&$layout_def)
    {
        $module = '';
        if (!empty($layout_def['target_module_key']) &&
            !empty($layout_def['fields'][strtoupper($layout_def['target_module_key'])])) {
            $module = $layout_def['fields'][strtoupper($layout_def['target_module_key'])];
        }

        if (empty($module)) {
            if (empty($layout_def['target_module'])) {
                $module = $layout_def['module'];
            } else {
                $module = $layout_def['target_module'];
            }
        }

        if ($module != "Campaigns" || $layout_def["subpanel_id"] != "stic_campaigns_notification") {
            return parent::displayList($layout_def);
        }

        global $focus;

        if (isset($layout_def['varname'])) {
            $key = strtoupper($layout_def['varname']);
        } else {
            $key = strtoupper($this->_get_column_alias($layout_def));
        }

        if (empty($layout_def['fields'][$key])) {
            return "";
        }
        $value = $layout_def['fields'][$key];

        $record = '';
        if (empty($layout_def['target_record_key'])) {
            $record = $layout_def['fields']['ID'];
        } else {
            $record = $layout_def['fields'][strtoupper($layout_def['target_record_key'])];
        }

        $action = 'TrackDetailView';

        $parent = '';
        if (!empty($layout_def['parent_info'])) {
            if (!empty($focus)) {
                $parent .= "&parent_id={$focus->id}&parent_module={$focus->module_dir}";
            }
        } else {
            if (!empty($layout_def['parent_id']) &&
                isset($layout_def['fields'][strtoupper($layout_def['parent_id'])])) {
                $parent .= "&parent_id={$layout_def['fields'][strtoupper($layout_def['parent_id'])]}";
            }
            if (!empty($layout_def['parent_module']) &&
                isset($layout_def['fields'][strtoupper($layout_def['parent_module'])])) {
                $parent .= "&parent_module={$layout_def['fields'][strtoupper($layout_def['parent_module'])]}";
            }
        }

        // STIC-Custom - JCH - 20220921 - Enable visibility of link to related modules in subpanels if
        // user has access by roles & Security Groups "group"
        // STIC#861
        // global $current_user;
        // if (!empty($record) &&
        //     ($layout_def['DetailView'] && !$layout_def['owner_module']
        //     ||  $layout_def['DetailView'] && !ACLController::moduleSupportsACL($layout_def['owner_module'])
        //     || ACLController::checkAccess($layout_def['owner_module'], 'view', $layout_def['owner_id'] == $current_user->id))) {
        //     $link = ajaxLink("index.php?module=$module&action=$action&record={$record}{$parent}");
        //     if ($module == 'EAPM') {
        //         $link = "index.php?module=$module&action=$action&record={$record}{$parent}";
        //     }
        //     return '<a href="' . $link . '" >'."$value</a>";
        // } else {
        //     return $value;
        // }

        global $current_user;
        $groupAccessView = SecurityGroup::groupHasAccess($module, $record, 'view');
        if (!empty($record) &&
            ($layout_def['DetailView'] && !$layout_def['owner_module']
                || $layout_def['DetailView'] && !ACLController::moduleSupportsACL($layout_def['owner_module'])
                || ACLController::checkAccess($layout_def['owner_module'], 'view', $layout_def['owner_id'] == $current_user->id, 'module', $groupAccessView))) {
            $link = ajaxLink("index.php?module={$module}&action={$action}&record={$record}{$parent}");
            if ($module == 'EAPM') {
                $link = "index.php?module={$module}&action={$action}&record={$record}{$parent}";
            }
            return "<a href=\"{$link}\">{$value}</a>";
        } else {
            return $value;
        }
        // END STIC-Custom
    }
}
