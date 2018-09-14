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


class SugarWidgetFieldBool extends SugarWidgetReportField
{
    public function queryFilterEquals(&$layout_def)
    {
        $bool_val = $layout_def['input_name0'][0];
        if ($bool_val == 'yes' || $bool_val == '1') {
            return "(".$this->_get_column_select($layout_def)." LIKE 'on' OR ".$this->_get_column_select($layout_def)."='1')\n";
        }
        //return "(".$this->_get_column_select($layout_def)." is null OR ".$this->_get_column_select($layout_def)."='0' OR ".$this->_get_column_select($layout_def)."='off')\n";
        return "(".$this->_get_column_select($layout_def)." is null OR ". $this->_get_column_select($layout_def)."='0')\n";
    }

    public function displayListPlain($layout_def)
    {
        $value = $this->_get_list_value($layout_def);
        $name = $layout_def['name'];
        $layout_def['name'] = 'id';
        $key = $this->_get_column_alias($layout_def);
        $key = strtoupper($key);
        
        if (empty($layout_def['fields'][$key])) {
            $layout_def['name'] = $name;
            global $app_list_strings;
            if (empty($value)) {
                $value = $app_list_strings['dom_switch_bool']['off'];
            } else {
                $value = $app_list_strings['dom_switch_bool']['on'];
            }
            return $value;
        }

        $on_or_off = 'CHECKED';
        if (empty($value) ||  $value == 'off') {
            $on_or_off = '';
        }
        $cell = "<input name='checkbox_display' class='checkbox' type='checkbox' disabled $on_or_off>";
        return  $cell;
    }
    
    public function queryFilterStarts_With(&$layout_def)
    {
        return $this->queryFilterEquals($layout_def);
    }
 
    public function displayInput($layout_def)
    {
        global $app_strings;
        
        $yes = $no = $default = '';
        if (isset($layout_def['input_name0']) && $layout_def['input_name0'] == 1) {
            $yes = ' selected="selected"';
        } elseif (isset($layout_def['input_name0']) && $layout_def['input_name0'] == 'off') {
            $no = ' selected="selected"';
        } else {
            $default = ' selected="selected"';
        }
        
        $str = <<<EOHTML
<select id="{$layout_def['name']}" name="{$layout_def['name']}">
 <option value="" {$default}></option>
 <option value = "off" {$no}> {$app_strings['LBL_SEARCH_DROPDOWN_NO']}</option>
 <option value = "1" {$yes}> {$app_strings['LBL_SEARCH_DROPDOWN_YES']}</option>
</select>
EOHTML;
        
        return $str;
    }
}
