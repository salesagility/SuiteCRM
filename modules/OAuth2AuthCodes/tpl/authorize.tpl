{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2020 SalesAgility Ltd.
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
<div class="p_login">
    <div class="p_login_top">
        <a title="SuiteCRM" href="index.php" style="background-image:url('{$LOGO_IMAGE}');background-size:auto 40px;width:auto;">SuiteCRM</a>
    </div>
    <div class="p_login_middle bootstrap-container">
        <div class="row">
            <div class="center-block col-md-5" style="float:none;background-color:white;padding:2em;">
                <p>{sugar_translate module="OAuth2AuthCodes" label="LBL_OAUTH_INFO"}</p>
                <form name="OAuthAuthorizeForm" method="POST" action="index.php" >
                    <input type='hidden' name='action' value='authorize'/>
                    <input type='hidden' name='module' value='OAuth2AuthCodes'/>
                    <input type='hidden' name='oauth2authcode_logout' value='{$oauth2authcode_logout}'/>
                    <input type='hidden' name='session_id' value='{$session_id}'/>
                    <input type='hidden' name='oauth2authcode_hash' value='{$oauth2authcode_hash}'/>
                    <input type='hidden' name='confirmed' value=''/>

                    <p><strong>{sugar_translate module="OAuth2AuthCodes" label="LBL_OAUTH_CLIENT"}: {$client.name}</strong></p>
                    <p><strong>{sugar_translate module="OAuth2AuthCodes" label="LBL_OAUTH_REDIRECT"}: {$client.redirectUri}</strong></p>

                    <p class="text-center">
                        <input type="button" class="button" value="{sugar_translate module='OAuth2AuthCodes' label='LBL_OAUTH_AUTHORIZE_AND_SAVE'}"
                        class="btn btn-lg btn-primary btn-block" style="white-space: normal;height:auto;"
                        onclick="document.OAuthAuthorizeForm.confirmed.value='always'; document.OAuthAuthorizeForm.submit();">
                        <input type="button" class="button" value="{sugar_translate module='OAuth2AuthCodes' label='LBL_OAUTH_AUTHORIZE_ONCE'}"
                        class="btn btn-lg btn-primary btn-block" style="white-space: normal;height:auto;"
                        onclick="document.OAuthAuthorizeForm.confirmed.value='once'; document.OAuthAuthorizeForm.submit();">
                        <input type="button" class="button" value="{sugar_translate module='OAuth2AuthCodes' label='LBL_OAUTH_ABORT'}"
                        class="btn btn-lg btn-secondary btn-block" style="white-space: normal;height:auto;"
                        onclick="document.OAuthAuthorizeForm.confirmed.value='abort'; document.OAuthAuthorizeForm.submit();">
                    </p>
                </form>
                <p>
                    <br/>
                    <a title="Homepage" href="index.php">{sugar_translate module="OAuth2AuthCodes" label="LBL_OAUTH_BACK_TO_HOME"}</a>
                </p>
            </div>
        </div>
    </div>
    <div class="p_login_bottom">
        <a id="admin_options">&copy; Supercharged by SuiteCRM</a>
        <a id="powered_by">&copy; Powered By SugarCRM</a>
    </div>
</div>
