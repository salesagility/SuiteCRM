<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/




class SugarWidgetFieldDatePicker extends SugarWidgetFieldDateTime
{
	function displayInput($layout_def)
    {
        global $timedate;

        $cal_dateformat = $timedate->get_cal_date_format();
        $LBL_ENTER_DATE = translate('LBL_ENTER_DATE', 'Charts');
        $jscalendarImage = SugarThemeRegistry::current()->getImageURL('jscalendar.gif');
        $value = $timedate->swap_formats($layout_def['input_name0'], $timedate->dbDayFormat, $timedate->get_date_format());
        $str = <<<EOHTML
<input onblur="parseDate(this, '{$cal_dateformat}');" class="text" name="{$layout_def['name']}" size='12' maxlength='10' id='{$layout_def['name']}' value='{$value}'>
<!--not_in_theme!--><img src="$jscalendarImage" alt="{$LBL_ENTER_DATE}" id="{$layout_def['name']}_trigger" align="absmiddle">
<script type="text/javascript">
Calendar.setup ({
    inputField : "{$layout_def['name']}", ifFormat : "{$cal_dateformat}", showsTime : false, button : "{$layout_def['name']}_trigger", singleClick : true, step : 1, weekNumbers:false
});
</script>
EOHTML;

        return $str;
    }
}

