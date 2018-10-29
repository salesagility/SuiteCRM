<?php
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * 
 * @global array $mod_strings
 * @global string $current_language
 * @param SugarBean $focus
 * @param string $field
 * @param mixed $value
 * @param string $view
 * @return string
 */
function display_action_lines(SugarBean $focus, $field, $value, $view)
{
    global $mod_strings, $current_language;

    $html = '';

    if (!is_file('cache/jsLanguage/SharedSecurityRulesActions/' . $current_language . '.js')) {
        require_once('include/language/jsLanguage.php');
        jsLanguage::createModuleStringsCache('SharedSecurityRulesActions', $current_language);
    }
    $html .= '<script src="cache/jsLanguage/SharedSecurityRulesActions/' . $current_language . '.js"></script>';
    $html .= '<style>
                    .sqsEnabled {
                        width: 25%!important;
                    }
                    </style>';
    if ($view == 'EditView') {
        $html .= '<script src="modules/SharedSecurityRulesActions/actionLines.js"></script>';

        $aow_actions_list = array();

        include_once('modules/SharedSecurityRulesActions/actions.php');

        $app_list_actions[''] = '';
        foreach ($aow_actions_list as $action_value) {
            $action_name = 'action' . $action_value;

            if (file_exists('custom/modules/_SharedSecurityRulesActions/actions/' . $action_name . '.php')) {
                require_once('custom/modules/SharedSecurityRulesActions/actions/' . $action_name . '.php');
            } elseif (file_exists('modules/SharedSecurityRulesActions/actions/' . $action_name . '.php')) {
                require_once('modules/SharedSecurityRulesActions/actions/' . $action_name . '.php');
            } else {
                continue;
            }

            $action = new $action_name();
            foreach ($action->loadJS() as $js_file) {
                $html .= '<script src="' . $js_file . '"></script>';
            }

            $app_list_actions[$action_value] = translate('LBL_' . strtoupper($action_value), 'SharedSecurityRulesActions');
        }

        $html .= '<input type="hidden" name="app_list_actions" id="app_list_actions" value="' . get_select_options_with_id($app_list_actions, '') . '">';

        $html .= "<table style='padding-top: 10px; padding-bottom:10px;' id='actionLines'></table>";

        $html .= "<div style='padding-top: 10px; padding-bottom:10px;'>";
        $html .= "<input type=\"button\" tabindex=\"116\" class=\"button\" value=\"" . $mod_strings['LBL_ADD_ACTION'] . "\" id=\"btn_ActionLine\" onclick=\"insertActionLine()\" disabled/>";
        $html .= "</div>";

        if (isset($focus->flow_module) && $focus->flow_module != '') {
            $html .= "<script>document.getElementById('btn_ActionLine').disabled = '';</script>";
            if ($focus->id != '') {
                $sql = "SELECT id FROM sharedsecurityrulesactions WHERE sa_shared_security_rules_id = '" . $focus->id . "' AND deleted = 0 ORDER BY action_order ASC";
                $result = $focus->db->query($sql);

                while ($row = $focus->db->fetchByAssoc($result)) {
                    $action_name = new SharedSecurityRulesActions();
                    $action_name->retrieve($row['id']);
                    $action_item = json_encode($action_name->toArray());

                    $html .= "<script>
                            loadActionLine(" . $action_item . ");
                        </script>";
                }
            }
        }
    } elseif ($view == 'DetailView') {
        $html .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        $sql = "SELECT id FROM sharedsecurityrulesactions WHERE sa_shared_security_rules_id = '" . $focus->id . "' AND deleted = 0 ORDER BY action_order ASC";
        $result = $focus->db->query($sql);

        while ($row = $focus->db->fetchByAssoc($result)) {
            $action_name = new SharedSecurityRulesActions();
            $action_name->retrieve($row['id']);

            $html .= "<tr><td>" . $action_name->action_order . "</td><td>" . $action_name->name . "</td><td>" . translate('LBL_' . strtoupper($action_name->action), 'SharedSecurityRulesActions') . "</td></tr>";
        }
        $html .= "</table>";
    }
    return $html;
}
