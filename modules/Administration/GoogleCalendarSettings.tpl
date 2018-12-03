{*
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
*}

{$PAGE_TITLE}

<form name="gcAuthentication"
      enctype='multipart/form-data'
      method="post"
      action="index.php?module=Administration&action=GoogleCalendarSettings&do=save"
      onSubmit="return (add_checks(document.gcAuthentication) && check_form('gcAuthentication'));"
>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
      <tr>
          <td>
              <input title="{$APP.LBL_SAVE_BUTTON_TITLE}"
                     accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
                     class="button primary"
                     type="submit"
                     name="save"
                     onclick="return check_form('ConfigureSettings');"
                     value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " />
                     &nbsp;
              <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"
                     onclick="document.location.href='index.php?module=Administration&action=index'"
                     class="button"
                     type="button"
                     name="cancel"
                     value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " />
          </td>
      </tr>
    </table>


    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
    	<tr>
    		<th style="padding: 15px" align="left" scope="row" colspan="4"><h4>{$MOD.LBL_GOOGLE_CALENDAR_SETTINGS_TITLE}</h4></th>
    	</tr>
    	<tr>
    		<td style="padding-left: 15px" width="25%" scope="row" valign='middle'>
    			{$MOD.LBL_GOOGLE_CALENDAR_SETTINGS_JSON}&nbsp{sugar_help text=$MOD.LBL_GOOGLE_CALENDAR_SETTINGS_JSON_HELP}
    		</td>
    		<td style="padding-bottom: 15px" id="google_json" width="75%" align="left"  valign='middle' colspan='3'>
    			<script type='text/javascript'>
    				{literal}
        				var openGoogleJson = function(event) {
        					var input = event.target;
        					var reader = new FileReader();
        					var parent_td = document.getElementById('google_json');
        					reader.onload = function(){
        						console.log(reader.result.substring(0, 1024));
        						var json_input = document.getElementById("google_auth_json");
        						if (json_input == null) {
        							var json_input_text = document.createElement('span');
        							json_input_text.innerHTML = '<input type="hidden" id="google_auth_json" name="google_auth_json" />';
        							parent_td.appendChild(json_input_text);
        						}
        						document.getElementById('google_auth_json').value = btoa(reader.result.substring(0, 1024));
        					};
        					reader.readAsText(input.files[0]);
        				};
    				{/literal}
    			</script>
    			JSON file is: <span style="color:{$GOOGLE_JSON_CONF.color}">{$GOOGLE_JSON_CONF.status}</span><input type="file" accept="text/plain" onchange="openGoogleJson(event)">
    		</td>
    	</tr>
        <tr>
            <td></td>
            <td><a href="https://developers.google.com/calendar/quickstart/php" target="_blank">{$MOD.LBL_GOOGLE_CALENDAR_GET_API_KEY}</a></td>
        </tr>

    </table>

    <div style="padding-top: 2px;">
        <input title="{$APP.LBL_SAVE_BUTTON_TITLE}"
               accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
               class="button primary"
               type="submit"
               name="save"
               onclick="return check_form('ConfigureSettings');"
               value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " />
               &nbsp;
        <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"
               onclick="document.location.href='index.php?module=Administration&action=index'"
               class="button"
               type="button"
               name="cancel"
               value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " />
    </div>

    {$JAVASCRIPT}

</form>
