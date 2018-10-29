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


require_once('modules/AOW_Actions/actions/actionBase.php');

require_once __DIR__ . '/../../AOW_WorkFlow/aow_utils.php';

class actionAccessLevel extends actionBase
{

    /**
     * 
     * @return array
     */
    public function loadJS()
    {
        return array('modules/SharedSecurityRulesActions/actions/actionAccessLevel.js');
    }

    /**
     * 
     * @global array $app_list_strings
     * @param string $line
     * @param SugarBean $bean
     * @param array $params
     * @return string
     */
    public function edit_display($line, SugarBean $bean = null, $params = array())
    {
        global $app_list_strings;
        
        if (!isset($bean) || null === $bean || !is_object($bean)) {
            LoggerManager::getLogger()->warn('bean is not set or not an object for actionAccessLevel::edit_display()');
        }

        if ($bean && !in_array($bean->module_dir, getEmailableModules())) {
            unset($app_list_strings['shared_email_type_list']['Record Email']);
        }
        $targetOptions = getRelatedEmailableFields($bean instanceof SugarBean ? $bean->module_dir : null);
        if (empty($targetOptions)) {
            unset($app_list_strings['shared_email_type_list']['Related Field']);
        }

        $html = '<input type="hidden" name="aow_email_type_list" id="aow_email_type_list" value="' . get_select_options_with_id($app_list_strings['shared_email_type_list'], '') . '">
				  <input type="hidden" name="aow_email_to_list" id="aow_email_to_list" value="' . get_select_options_with_id($app_list_strings['aow_email_to_list'], '') . '">
				  <input type="hidden" name="sharedGroupRule" id="sharedGroupRule" value="' . get_select_options_with_id($app_list_strings['sharedGroupRule'], '') . '">';

        $checked = '';
        if (isset($params['individual_email']) && $params['individual_email']) {
            $checked = 'CHECKED';
        }

        $html .= "<table border='0' cellpadding='0' cellspacing='0' width='100%' data-workflow-action='setRule'>";
        $html .= "<tr>";
        $html .= '<td id="name_label" scope="row" valign="top"><label>' . translate("LBL_OPTIONS", "SharedSecurityRulesActions") . ':<span class="required">*</span></label></td>';
        $html .= '<td valign="top" scope="row">';

        $html .= '<button type="button" onclick="add_emailLine(' . $line . ')"><img src="' . SugarThemeRegistry::current()->getImageURL('id-ff-add.png') . '"></button>';
        $html .= '<table id="emailLine' . $line . '_table" width="100%" class="email-line"></table>';
        $html .= '</td>';
        $html .= "</tr>";
        $html .= "</table>";

        $html .= "<script id ='aow_script" . $line . "'>";

        if (isset($params['email_target_type'])) {
            $keys = array_keys($params['email_target_type']);
            foreach ($keys as $key) {
                if (is_array($params['email'][$key])) {
                    $params['email'][$key] = json_encode($params['email'][$key]);
                }
                $html .= "load_emailline('" . $line . "','" . $params['accesslevel'][$key] . "','"
                        . $params['email_target_type'][$key] . "','" . $params['email'][$key] . "');";
            }
        }
        $html .= "</script>";

        return $html;
    }
}
