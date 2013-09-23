<!--
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

/*********************************************************************************

 ********************************************************************************/
-->
<!-- BEGIN: main -->
<div class="dashletPanelMenu" style="width: 500px; margin: 20px auto;">
<div class="hd"><div class="tl"></div><div class="hd-center"></div><div class="tr"></div></div>
<div class="bd" style="padding-top: 0px; padding-bottom: 0;">
<div class="ml"></div>
<div class="bd-center">
<form name="EditView" method="POST" action="index.php?module=Users&action=SaveTimezone&SaveTimezone=True">
	<input type="hidden" value="{$USER_ID}" name="record">
	<input type="hidden" name="module" value="Users">
	<input type="hidden" name="action" value="SaveTimezone">
	<input type="hidden" name="SaveTimezone" value="true">

<table class="subMenuTD" style="padding: 8px; border: 2px solid #999; background-color: #fff;" cellpadding="0" cellspacing="2" border="0" align="center" width="440">
	<tr>
		<td colspan="2" width="100%"></td>
	</tr>
	<tr>
		<td colspan="2" width="100%" style="font-size: 12px; padding-bottom: 5px;">
			<table width="100%" border="0">
			<tr>
				<td colspan="2"><slot>{$MOD.LBL_PICK_TZ_DESCRIPTION}</slot></td>
			</tr>
			</table>
			<br><br>
			<slot><select tabindex='3' name='timezone'>{html_options options=$TIMEZONEOPTIONS selected=$TIMEZONE_CURRENT}</select></slot>
			<input	title="{$APP.LBL_SAVE_BUTTON_TITLE}"
					accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
					class="button primary"
					type="submit"
					name="button"
					value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " ><br />
			{* <span class="dateFormat">{$MOD.LBL_DST_INSTRUCTIONS}</span> *}
		</td>
	</tr>
</table>
</form>
</div>
<div class="mr"></div>
</div>
<div class="ft"><div class="bl"></div><div class="ft-center"></div><div class="br"></div></div>
</div>
{literal}
<script type="text/javascript" language="JavaScript">
<!--
lookupTimezone = function() {
    var success = function(data) {
        eval(data.responseText);
        if(typeof userTimezone != 'undefined') {
            document.EditView.timezone.value = userTimezone;
        }
    }

    var now = new Date();
    now = new Date(now.toString()); // reset milliseconds
    var nowGMTString = now.toGMTString();
    var nowGMT = new Date(nowGMTString.substring(0, nowGMTString.lastIndexOf(' ')));
    offset = ((now - nowGMT) / (1000 * 60));
    url = 'index.php?module=Users&action=SetTimezone&to_pdf=1&userOffset=' + offset;
    var cObj = YAHOO.util.Connect.asyncRequest('GET', url, {success: success, failure: success});
}
YAHOO.util.Event.addListener(window, 'load', lookupTimezone);
-->
</script>
{/literal}