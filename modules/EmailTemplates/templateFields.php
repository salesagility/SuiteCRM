<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

function generateFieldDefsJS2()
{
    global $app_list_strings, $beanList, $beanFiles;


    $badFields = array(
        'account_description',
        'contact_id',
        'lead_id',
        'opportunity_amount',
        'opportunity_id',
        'opportunity_name',
        'opportunity_role_id',
        'opportunity_role_fields',
        'opportunity_role',
        'campaign_id',
        // User objects
        'id',
        'user_preferences',
        'accept_status',
        'user_hash',
        'authenticate_id',
        'sugar_login',
        'reports_to_id',
        'reports_to_name',
        'is_admin',
        'receive_notifications',
        'modified_user_id',
        'modified_by_name',
        'created_by',
        'created_by_name',
        'accept_status_id',
        'accept_status_name',
    );

    $loopControl = array();
    $prefixes = array();

    foreach ($app_list_strings['moduleList'] as $key => $name) {
        if (isset($beanList[$key]) && isset($beanFiles[$beanList[$key]]) && !str_begin($key, 'AOW_')) {

            require_once($beanFiles[$beanList[$key]]);
            $focus = new $beanList[$key];
            $loopControl[$key][$key] = $focus;
            $prefixes[$key] = strtolower($focus->object_name) . '_';
            if ($focus->object_name == 'Case') {
                $prefixes[$key] = 'a' . strtolower($focus->object_name) . '_';
            }
        }
    }

    $contact = new Contact();
    $lead = new Lead();
    $prospect = new Prospect();

    $loopControl['Contacts'] = array(
        'Contacts' => $contact,
        'Leads' => $lead,
        'Prospects' => $prospect,
    );

    $prefixes['Users'] = 'contact_user_';


    $collection = array();
    foreach ($loopControl as $collectionKey => $beans) {
        $collection[$collectionKey] = array();
        foreach ($beans as $beankey => $bean) {

            foreach ($bean->field_defs as $key => $field_def) {
                if (    /*($field_def['type'] == 'relate' && empty($field_def['custom_type'])) ||*/
                    ($field_def['type'] == 'assigned_user_name' || $field_def['type'] == 'link') ||
                    ($field_def['type'] == 'bool') ||
                    (in_array($field_def['name'], $badFields))
                ) {
                    continue;
                }
                if (!isset($field_def['vname'])) {
                    //echo $key;
                }
                // valid def found, process
                $optionKey = strtolower("{$prefixes[$collectionKey]}{$key}");
                if (isset($field_def['vname'])) {
                    $optionLabel = preg_replace('/:$/', "", translate($field_def['vname'], $beankey));
                } else {
                    $optionLabel = preg_replace('/:$/', "", $field_def['name']);
                }
                $dup = 1;
                foreach ($collection[$collectionKey] as $value) {
                    if ($value['name'] == $optionKey) {
                        $dup = 0;
                        break;
                    }
                }
                if ($dup) {
                                    $collection[$collectionKey][] = array("name" => $optionKey, "value" => $optionLabel);
                }
            }
        }
    }

    $json = getJSONobj();
    $ret = "var field_defs = ";
    $ret .= $json->encode($collection, false);
    $ret .= ";";
    return $ret;
}

function genDropDownJS2()
{
    global $app_list_strings, $beanList, $beanFiles;

    $lblContactAndOthers = implode('/', array(
        isset($app_list_strings['moduleListSingular']['Contacts']) ? $app_list_strings['moduleListSingular']['Contacts'] : 'Contact',
        isset($app_list_strings['moduleListSingular']['Leads']) ? $app_list_strings['moduleListSingular']['Leads'] : 'Lead',
        isset($app_list_strings['moduleListSingular']['Prospects']) ? $app_list_strings['moduleListSingular']['Prospects'] : 'Target',
    ));

    $dropdown = '';

    array_multisort($app_list_strings['moduleList'], SORT_ASC, $app_list_strings['moduleList']);

    foreach ($app_list_strings['moduleList'] as $key => $name) {
        if (isset($beanList[$key]) && isset($beanFiles[$beanList[$key]]) && !str_begin($key, 'AOW_') && !str_begin($key, 'zr2_')) {

            if ($key == 'Contacts') {
                $dropdown .= "<option value='" . $key . "'>
						" . $lblContactAndOthers . "
		  	       </option>";
            } else if (isset($app_list_strings['moduleListSingular'][$key])) {
                $dropdown .= "<option value='" . $key . "'>
						" . $app_list_strings['moduleListSingular'][$key] . "
		  	       </option>";
            } else {
                $dropdown .= "<option value='" . $key . "'>
						" . $app_list_strings['moduleList'][$key] . "
		  	       </option>";
            }
        }
    }


    return $dropdown;
}
