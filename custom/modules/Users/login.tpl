<!--
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*********************************************************************************

 ********************************************************************************/
-->
<script type='text/javascript'>
var LBL_LOGIN_SUBMIT = '{sugar_translate module="Users" label="LBL_LOGIN_SUBMIT"}';
var LBL_REQUEST_SUBMIT = '{sugar_translate module="Users" label="LBL_REQUEST_SUBMIT"}';
var LBL_SHOWOPTIONS = '{sugar_translate module="Users" label="LBL_SHOWOPTIONS"}';
var LBL_HIDEOPTIONS = '{sugar_translate module="Users" label="LBL_HIDEOPTIONS"}';
</script>

<!--SuiteCRM customised login form-->
<div id="suite_login">
    <div class="login">
        {$LOGIN_IMAGE}
        <form action="index.php" method="post" name="DetailView" id="form" onsubmit="return document.getElementById('cant_login').value == ''">
            <span class="error" id="browser_warning" style="display:none">
			    {sugar_translate label="WARN_BROWSER_VERSION_WARNING"}
			</span>

			<span class="error" id="ie_compatibility_mode_warning" style="display:none">
			    {sugar_translate label="WARN_BROWSER_IE_COMPATIBILITY_MODE_WARNING"}
			</span>

			{if $LOGIN_ERROR !=''}
			    <span class="error">{$LOGIN_ERROR}</span>

			{if $WAITING_ERROR !=''}
                <span class="error">{$WAITING_ERROR}</span>
			{/if}

			{else}
			    <span id='post_error' class="error"></span>
            {/if}

			    <input type="hidden" name="module" value="Users">
				<input type="hidden" name="action" value="Authenticate">
				<input type="hidden" name="return_module" value="Users">
				<input type="hidden" name="return_action" value="Login">
				<input type="hidden" id="cant_login" name="cant_login" value="">

				{foreach from=$LOGIN_VARS key=key item=var}
				    <input type="hidden" name="{$key}" value="{$var}">
				{/foreach}

                <div id="logininput"><i class="icon-user"></i><input type="text" size='35' tabindex="1" id="user_name" name="user_name"  value='{$LOGIN_USER_NAME}' placeholder="Username" /></div>
                <div id="logininput"><i class="icon-lock"></i><input type="password" size='26' tabindex="2" id="user_password" name="user_password" value='{$LOGIN_PASSWORD}' placeholder="Password"/></div>
                <div id="langselect">
                {if !empty($SELECT_LANGUAGE)}

                    <select style='width: 152px' name='login_language' onchange="switchLanguage(this.value)">{$SELECT_LANGUAGE}</select>
                {/if}
                <input title="{sugar_translate module="Users" label="LBL_LOGIN_BUTTON_TITLE"}"  class="button primary" class="button primary" type="submit" tabindex="3" id="login_button" name="Login" value="{sugar_translate module="Users" label="LBL_LOGIN_BUTTON_LABEL"}">
            </div>
        </form>
    </div>
</div>

<!--SuiteCRM customised password reset form-->
<div id="forgot_pass_link">
    <div style="cursor: hand; cursor: pointer; display:{$DISPLAY_FORGOT_PASSWORD_FEATURE};" onclick='toggleDisplay("forgot_password_dialog");'>
        <a href='javascript:void(0)' id="forgot_password_dialog_options"><i class="icon-lock-open-alt"></i>{sugar_translate module="Users" label="LBL_LOGIN_FORGOT_PASSWORD"}</a>
    </div>
</div>
<div class="password">
    <form action="index.php" method="post" name="fp_form" id="fp_form" >

        <div id="forgot_password_dialog" style="display:none" >
            <div id="suite_password">
            <p>Reset your SuiteCRM password.</p>
            <input type="hidden" name="entryPoint" value="GeneratePassword">
            <div id="generate_success" class='error' style="display:inline;"></div>
            <div id="logininput"><i class="icon-user"></i><input type="text"  id="fp_user_name" name="fp_user_name"  value='{$LOGIN_USER_NAME}' placeholder="Username" /></div>
            <div id="logininput"><i class="icon-user"></i><input type="text" id="fp_user_mail" name="fp_user_mail"  value='' placeholder="Email Address" ></div>
            {$CAPTCHA}
            <div id='wait_pwd_generation'></div>
            <input title="Email Temp Password" class="button" type="button" style="display:inline; float:right; margin-right:10px;" onclick="validateAndSubmit();  return document.getElementById('cant_login').value == ''" id="generate_pwd_button" name="fp_login" value="{sugar_translate module="Users" label="LBL_LOGIN_SUBMIT"}">
        </div>
        </div>
    </form>
</div>