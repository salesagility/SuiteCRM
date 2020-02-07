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

<form name="themeSettings" method="POST">
	<input type="hidden" name="module" value="Administration">
	<input type="hidden" name="action" value="ThemeSettings">
	<input type="hidden" name="disabled_themes" value="">
	
	<table border="0" cellspacing="1" cellpadding="1" class="actionsContainer">
		<tr>
			<td>
			<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
			<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.themeSettings.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>

	<div class='listViewBody' style='margin-bottom:5px'>
		<table id="themeSettings" class="list view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th data-toggle="true">{$MOD.LBL_UW_TYPE_THEME}</th>
                    <th data-hide="phone,phonelandscape"></th>
					<th>{$MOD.LBL_ENABLED}</th>
					<th>{$MOD.DEFAULT_THEME}</th>
				</tr>
			</thead>
			<tbody>
			{counter start=0 name="colCounter" print=false assign="colCounter"}
			{foreach from=$available_themes key=theme item=themedef}
				<tr>
					<td><b>
					{if $themedef.configurable}<a href="index.php?module=Administration&action=ThemeConfigSettings&theme={$theme}">{$themedef.name}</a>
					{else} {$themedef.name}
					{/if}</b></td>
                    <td><img id="themePreview" style="height: 250px;" src="index.php?entryPoint=getImage&themeName={$theme}&imageName=themePreview.png" border="1"></td>
					<td><input class="disableTheme" name="disabled_themes[{$colCounter}]" value="{$theme}" type="hidden" {if $themedef.enabled && $theme == $default_theme}disabled="disabled"{/if}><input class="disableTheme" type="checkbox" name="disabled_themes[{$colCounter}]" value="" {if $themedef.enabled} {if $theme == $default_theme}disabled="disabled"{/if}  CHECKED{/if}/></td>
					<td><input class="defaultTheme" type="radio" name="default_theme" value="{$theme}" {if $theme == $default_theme}CHECKED{elseif !$themedef.enabled}disabled="disabled"{/if} /></td>
				</tr>
				{counter name="colCounter"}
			{/foreach}
			</tbody>
		</table>
	</div>
	
	<table border="0" cellspacing="1" cellpadding="1" class="actionsContainer">
		<tr>
			<td>
				<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" class="button primary" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
				<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" class="button" onclick="document.themeSettings.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
	{literal}
	$(document).ready(function() {
		$('.disableTheme').change(function() {
			if(!$(this).is(":checked")) {
				$(this).closest('tr').find("input,button,textarea").not(".disableTheme").attr("disabled", "disabled");
			} else {
				$(this).closest('tr').find("input,button,textarea").not(".disableTheme").removeAttr("disabled");
			}

		});
		$('.defaultTheme').change(function() {
			if($(this).is(":checked")) {
				$(".disableTheme").removeAttr("disabled");
				$(this).closest('tr').find(".disableTheme").attr("disabled", "disabled");
			}

		});
	});
	{/literal}
</script>