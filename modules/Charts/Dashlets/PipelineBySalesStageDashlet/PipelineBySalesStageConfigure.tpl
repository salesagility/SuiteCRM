{*

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




*}


<div style='width: 400px'>
<form name='configure_{$id}' action="index.php" method="post" onSubmit='return SUGAR.dashlets.postForm("configure_{$id}", SUGAR.mySugar.uncoverPage);'>
<input type='hidden' name='id' value='{$id}'>
<input type='hidden' name='module' value='{$module}'>
<input type='hidden' name='action' value='DynamicAction'>
<input type='hidden' name='DynamicAction' value='configureDashlet'>
<input type='hidden' name='to_pdf' value='true'>
<input type='hidden' name='configure' value='true'>
<input type='hidden' id='dashletType' name='dashletType' value='{$dashletType}' />
<table width="400" cellpadding="0" cellspacing="0" border="0" class="edit view" align="center">
<tr>
    <td valign='top' class='dataLabel' nowrap>{$LBL_TITLE} <br /></td>
    <td valign='top' class='dataField'>
    	<input type="text" value="{$dashlet_title}" size="30" name="pbss_dashlet_title"/>
    </td>
</tr>
<tr>
    <td valign='top' nowrap class='dataLabel'>{$LBL_DATE_START} <br><i>{$user_date_format}</i></td>
    <td valign='top' class='dataField'>
    	<input onblur="parseDate(this, '{$cal_dateformat}');" class="text" name="pbss_date_start" size='12' maxlength='10' id='date_start' value='{$date_start}'>
    	{sugar_getimage name="jscalendar" ext=".gif" alt=$LBL_ENTER_DATE other_attributes='align="absmiddle" id="date_start_trigger" '}
    </td>
</tr>
<tr>
    <td valign='top' nowrap class='dataLabel'>{$LBL_DATE_END}<br><i>{$user_date_format}</i></td>
    <td valign='top' class='dataField'>
    	<input onblur="parseDate(this, '{$cal_dateformat}');" class="text" name="pbss_date_end" size='12' maxlength='10' id='date_end' value='{$date_end}'>
    	{sugar_getimage name="jscalendar" ext=".gif" alt=$LBL_ENTER_DATE other_attributes='align="absmiddle" id="date_end_trigger" '}
    </td>
</tr>

    <tr>
    <td valign='top' class='dataLabel' nowrap>{$LBL_SALES_STAGES}</td>
    <td valign='top' class='dataField'>
    	<select name="pbss_sales_stages[]" multiple size='3'>
    		{$selected_datax}
    	</select></td>
    </tr>

<tr>
    <td align="right" colspan="2">
        <input type='submit' onclick="" class='button' value='{$LBL_SUBMIT_BUTTON_LABEL}'>
   	</td>
</tr>
</table>
</form>
{literal}
<script type="text/javascript">
Calendar.setup ({
    inputField : "date_start", ifFormat : "{/literal}{$cal_dateformat}{literal}", showsTime : false, button : "date_start_trigger", singleClick : true, step : 1, weekNumbers:false
});
Calendar.setup ({
    inputField : "date_end", ifFormat : "{/literal}{$cal_dateformat}{literal}", showsTime : false, button : "date_end_trigger", singleClick : true, step : 1, weekNumbers:false
});
{/literal}
</script>
</div>