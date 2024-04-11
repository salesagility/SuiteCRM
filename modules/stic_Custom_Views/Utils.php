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

/**
 * Get an related bean from the $bean module
 *
 *
 * @param Object $bean of the module from which we make the request
 * @param String $relationshipName Name of the relationships from which we want to get the $relatedBean
 * @return Object relatedModule Bean
 */
function getRelatedBeanObject($bean, $relationshipName)
{
    if (!$bean->load_relationship($relationshipName)) {
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ': : Failed retrieve contacts relationship data');
        return false;
    }
    $relatedBeans = $bean->$relationshipName->getBeans();
    $relatedBean = array_pop($relatedBeans);
    return !($relatedBean) ? false : $relatedBean;
}

/**
 * Get an array with related beans from the $bean module
 *
 *
 * @param Object $bean of the module from which we make the request
 * @param String $relationshipName Name of the relationships from which we want to get the $relatedBean
 * @return Array array with relatedModule Beans
 */
function getRelatedBeanObjectArray($bean, $relationshipName)
{
    if (!$bean->load_relationship($relationshipName)) {
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ': : Failed retrieve relationship data array');
        return false;
    }
    $relatedBeans = $bean->$relationshipName->getBeans();
    return $relatedBeans ?? false;
}

/**
 * Fills dynamic generic lists for roles and security groups.
 *
 * This function populates dynamic lists for roles and security groups
 * It internally calls functions to fill the dynamic lists: fillDynamicRoleList() and fillDynamicSecurityGroupList().
 *
 * @return void
 */
function fillDynamicGenericLists()
{
    fillDynamicRoleList();
    fillDynamicSecurityGroupList();
}

/**
 * Fills the dynamic_role_list with roles.
 *
 * This function fills the list $GLOBALS['app_list_strings']['dynamic_role_list'] with roles.
 * If the role list has already been populated, it returns early without performing any action.
 *
 * @return void
 */
function fillDynamicRoleList()
{
    if (isset($GLOBALS['app_list_strings']['dynamic_role_list'])) {
        return;
    }

    $rolFocus = BeanFactory::newBean('ACLRoles');
    $roles = $rolFocus->get_list("name", "", 0, -99, -99);

    $dynamic_role_list = array("" => "");
    foreach ($roles['list'] as $role) {
        $dynamic_role_list[$role->id] = $role->name;
    }

    $GLOBALS['app_list_strings']['dynamic_role_list'] = $dynamic_role_list;
}

/**
 * Fills the dynamic_security_group_list with Security Groups.
 *
 * This function fills the list $GLOBALS['app_list_strings']['dynamic_security_group_list'] with Security Groups.
 * If the Security Groups list has already been populated, it returns early without performing any action.
 *
 * @return void
 */
function fillDynamicSecurityGroupList()
{
    if (isset($GLOBALS['app_list_strings']['dynamic_security_group_list'])) {
        return;
    }

    $groupFocus = BeanFactory::newBean('SecurityGroups');
    $groups = $groupFocus->get_list("name", "", 0, -99, -99);

    $dynamic_security_group_list = array("" => "");
    foreach ($groups['list'] as $group) {
        $dynamic_security_group_list[$group->id] = $group->name;
    }

    $GLOBALS['app_list_strings']['dynamic_security_group_list'] = $dynamic_security_group_list;
}

/**
 * Retrieves JavaScript variables related to a specified view module and view type.
 *
 * This function fetches JavaScript variables required for client-side operations based on the provided view module and view type.
 * It constructs JavaScript variables for various actions, action types, action editors, field conditions, and field types.
 *
 * @param string $viewModule The module associated with the view.
 * @param string $viewType The type of view.
 * @return string The HTML containing JavaScript variables.
 */
function getJsVars($viewModule, $viewType)
{
    require_once 'modules/stic_Custom_Views/stic_Custom_Views_ModuleView.php';
    global $app_list_strings;

    $moduleView = new stic_Custom_Views_ModuleView($viewModule, $viewType);

    $html =
    "<script>" .
        "var view_module = \"" . $viewModule . "\";" .
        "var view_type = \"" . $viewType . "\";";
    $html .=
        "var view_module_action_map = {" .
            "actionTypes: {" .
                "options: \"" . $moduleView->getActionTypes_as_select_options() . "\",";
    foreach ($moduleView->getActionTypes() as $actionTypeKey => $actionTypeName) {
        $html .=
                $actionTypeKey . ": {" .
                    "elements: {" .
                        "options: \"" . $moduleView->getValidElements_as_select_options($actionTypeKey) . "\"," .
                    "}," .
                    "actions: {" .
                        "options: \"" . $moduleView->getValidActions_as_select_options($actionTypeKey) . "\",";
        foreach ($moduleView->getValidActions($actionTypeKey) as $actionKey => $actionName) {
            $html .=
                        $actionKey . ": {" .
                            "sections: {" .
                                "options: \"" . $moduleView->getValidSections_as_select_options($actionTypeKey, $actionKey) . "\"," .
                            "}," .
                        "},";
        }
        $html .=
                    "}," .
                "},";
    }
    $html .=
            "}," .
        "};";
    $html .=
        "var view_action_editor_map = {";
    foreach ($app_list_strings['stic_custom_views_action_list'] as $actionKey => $actionName) {
        $html .=
            $actionKey . ": {" .
                "editor_base64: \"" . $moduleView->getEditorForCommonAction_Base64($actionKey, $actionKey . "_editor") . "\"," .
            "},";
    }
    $html .=
        "};";
    $html .=
        "var view_field_map = {";
    foreach ($moduleView->getOnlyViewFields() as $fieldKey => $fieldName) {
        $html .=
            $fieldKey . ": {" .
                "condition_operators: {" .
                    "options: \"" . $moduleView->getViewFieldOperators_as_select_options($fieldKey) . "\"," .
                "}," .
                "condition_types: {" .
                    "options: \"" . $moduleView->getViewFieldConditionTypes_as_select_options($fieldKey) . "\"," .
                "}, " .
                "type: \"" . $moduleView->getFieldType($fieldKey) . "\"," .
                "list: \"" . $moduleView->getFieldListOption($fieldKey) . "\",";
        foreach ($moduleView->getAllFieldConditionTypeMap()[$fieldKey] as $typeKey => $typeName) {
            if ($typeKey != "value") {
                $html .=
                "condition_values_" . $typeKey . ": {" .
                    "options: \"" . $moduleView->getViewFieldConditionValueList_as_select_options($fieldKey, $typeKey) . "\"," .
                "}";
            }
        }
        $html .=
            "},";
    }
    $html .=
        "};";

    $html .=
    "</script>";
    return $html;
}
