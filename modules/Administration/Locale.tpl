{*

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




*}


<script type="text/javascript">
	var ERR_NO_SINGLE_QUOTE = '{$APP.ERR_NO_SINGLE_QUOTE}';
	var cannotEq = "{$APP.ERR_DECIMAL_SEP_EQ_THOUSANDS_SEP}";
{literal}
	function verify_data(formName) {
		var f = document.getElementById(formName);

		for(i=0; i<f.elements.length; i++) {
			if(f.elements[i].value == "'") {
				alert(ERR_NO_SINGLE_QUOTE + " " + f.elements[i].name);
				return false;
			}
		}
		// currency syntax
		if (document.ConfigureSettings.default_number_grouping_seperator.value == document.ConfigureSettings.default_decimal_seperator.value) {
			alert(cannotEq);
			return false;
		}
		return true;
	}
</script>
{/literal}
<BR>
<form id="ConfigureSettings" name="ConfigureSettings" enctype='multipart/form-data' method="POST"
	action="index.php?module=Administration&action=Locale&process=true">

<span class='error'>{$error.main}</span>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
<tr>
	<td>
		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}"
			accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
			class="button primary"
			type="submit"
			name="save"
			onclick="return verify_data('ConfigureSettings');"
			value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >
		&nbsp;<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " > </td>
	</tr>
</table>




<table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
	<tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_LOCALE_DEFAULT_SYSTEM_SETTINGS}</h4></th>
	</tr>
	<tr>
		<td  scope="row" width="200">{$MOD.LBL_LOCALE_DEFAULT_DATE_FORMAT}: </td>
		<td  >
			{html_options name='default_date_format' selected=$config.default_date_format options=$config.date_formats}
		</td>
		<td  scope="row" width="200">{$MOD.LBL_LOCALE_DEFAULT_TIME_FORMAT}: </td>
		<td  >
			{html_options name='default_time_format' selected=$config.default_time_format options=$config.time_formats}
		</td>
	</tr><tr>
		<td  scope="row">{$MOD.LBL_LOCALE_DEFAULT_LANGUAGE}: </td>
		<td  >
			{html_options name='default_language' selected=$config.default_language options=$LANGUAGES}
		</td>
	</tr>
	</tr><tr>
		<td  scope="row" valign="top">{$MOD.LBL_LOCALE_DEFAULT_NAME_FORMAT}: </td>
		<td>
            {html_options name='default_locale_name_format' id="default_locale_name_format" selected=$config.default_locale_name_format options=$NAMEFORMATS}
		</td>
        {if isset($upgradeInvalidLocaleNameFormat)}
        <td>
            {$MOD.ERR_INVALID_LOCALE_NAME_FORMAT_UPGRADE}
        </td>
        {/if}
	</tr>

	</table>



<table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
	<tr>
		<th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_LOCALE_DEFAULT_CURRENCY}</h4></th>
	</tr><tr>
		<td  scope="row" width="200">{$MOD.LBL_LOCALE_DEFAULT_CURRENCY_NAME}: </td>
		<td  >
			<input type='text' size='25' name='default_currency_name' value='{$config.default_currency_name}' >
		</td>
		<td  scope="row" width="200">{$MOD.LBL_LOCALE_DEFAULT_CURRENCY_SYMBOL}: </td>
		<td  >
			<input type='text' size='4' name='default_currency_symbol'  value='{$config.default_currency_symbol}' >
		</td>
	</tr><tr>
		<td  scope="row" width="200">{$MOD.LBL_LOCALE_DEFAULT_CURRENCY_ISO4217}: </td>
		<td  >
			<input type='text' size='4' name='default_currency_iso4217' value='{$config.default_currency_iso4217}'>
		</td>
		<td  scope="row">{$MOD.LBL_LOCALE_DEFAULT_NUMBER_GROUPING_SEP}: </td>
		<td  >
			<input type='text' size='3' maxlength='1' name='default_number_grouping_seperator' value='{$config.default_number_grouping_seperator}'>
		</td>
	</tr><tr>
		<td  scope="row">{$MOD.LBL_LOCALE_DEFAULT_DECIMAL_SEP}: </td>
		<td  >
			<input type='text' size='3' maxlength='1' name='default_decimal_seperator'  value='{$config.default_decimal_seperator}'>
		</td>
		<td  scope="row"></td>
		<td  ></td>
	</tr>
</table>



<table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
	<tr><th align="left" scope="row" colspan="4"><h4>{$MOD.EXPORT}</h4></th>
	</tr><tr>
		<td nowrap width="10%" scope="row">{$MOD.EXPORT_DELIMITER}: </td>
		<td width="25%" >
			<input type='text' name='export_delimiter' size="5" value='{$config.export_delimiter}'>
		</td>
		<td nowrap width="10%" scope="row">{$MOD.EXPORT_CHARSET}: </td>
		<td width="25%" >
			<select name="default_export_charset">{$exportCharsets}</select>
		</td>
		</tr><tr>
		<td nowrap width="10%" scope="row">{$MOD.DISABLE_EXPORT}: </td>
		{if !empty($config.disable_export)}
			{assign var='disable_export_checked' value='CHECKED'}
		{else}
			{assign var='disable_export_checked' value=''}
		{/if}
		<td width="25%" ><input type='hidden' name='disable_export' value='false'><input name='disable_export'  type="checkbox" value="true" {$disable_export_checked}></td>
		<td nowrap width="10%" scope="row">{$MOD.ADMIN_EXPORT_ONLY}: </td>
		{if !empty($config.admin_export_only)}
			{assign var='admin_export_only_checked' value='CHECKED'}
		{else}
			{assign var='admin_export_only_checked' value=''}
		{/if}
		<td width="20%" ><input type='hidden' name='admin_export_only' value='false'><input name='admin_export_only'  type="checkbox" value="true" {$admin_export_only_checked}></td>

	</tr>
</table>


{if !empty($collationOptions)}
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
	<tr>
		<th align="left" scope="row" colspan="2">
			<h4>
				{$MOD.LBL_LOCALE_DB_COLLATION_TITLE}
			</h4>
		</th>
	</tr>
	<tr>
		<td scope="row" width="200">
			{$MOD.LBL_LOCALE_DB_COLLATION}
		</td>
		<td scope="row">
			<select name="collation" id="collation">{$collationOptions}</select>
		</td>
	</tr>
</table>


{/if}
<div style="padding-top: 2px;">
<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary"  type="submit" name="save" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " />
		&nbsp;<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " />
</div>
{$JAVASCRIPT}
</form>

<script language="Javascript" type="text/javascript">
{$getNameJs}
</script>
