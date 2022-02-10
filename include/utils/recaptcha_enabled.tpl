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
<div id='recaptcha-container' class="g-recaptcha"></div>
<input type="hidden" id="recaptcha_response_field" name="recaptcha_response_field">
<script src="https://www.google.com/recaptcha/api.js?onload=onloadRecaptchaCallback&render=explicit" async defer>
</script>
<script>
{literal}
    /**
     * Display recaptcha widget
     * @return {string} id of the recaptcha widget
     */
{/literal}
    var renderRecaptcha = function () {ldelim}
        var widgetId = grecaptcha.render(
          'recaptcha-container',
          {ldelim}
            'sitekey': '{$SITE_KEY}',
            'callback': verifyRecaptchaCallback
          {rdelim}
        );
        getRecaptchaContainer().setAttribute('data-widget-id', widgetId);
        return widgetId;
    {rdelim};
{literal}

    /**
     * @return {Element} recapcha container
     */
    var getRecaptchaContainer = function () {
      return document.getElementById('recaptcha-container');
    };

    /**
     * @return {string} id of recaptcha response field
     */
    var getRecaptchaResponseFieldId = function () {
      return 'recaptcha_response_field';
    };

    /**
     * @return {Element} hidden recaptcha response field
     */
    var getRecaptchaResponseField = function () {
      return document.getElementById(getRecaptchaResponseFieldId());
    };

    /**
     * @return {Element} password reset button
     */
    var getResetPasswordSubmit = function () {
      // "submit" button in the login screen
      if (document.getElementById('generate_pwd_button')) {
        return document.getElementById('generate_pwd_button');
      }

      // "login" button in the change new password screen
      if (document.getElementById('login_button')) {
        return document.getElementById('login_button');
      }
    };

    /**
     * Allow user to submit password reset form
     */
    var enableResetPasswordSubmit = function () {
      getResetPasswordSubmit().removeAttribute('disabled');
    };

    /**
     * Prevent user from submitting password reset form
     */
    var disableResetPasswordSubmit = function () {
      getResetPasswordSubmit().setAttribute('disabled', '');
    };

    /**
     * Reset recaptcha to force user to validate themselves again
     */
    var resetRecaptcha = function () {
      getRecaptchaResponseField().value = '';
      disableResetPasswordSubmit();
      grecaptcha.reset(getRecaptchaContainer().getAttribute('data-widget-id'));
    };

    /**
     * Does the recaptcha contain a valid and a successful response?
     * @return {boolean}
     */
    var hasRecaptchaResponse = function () {
      var recaptchaResponse = grecaptcha.getResponse();
      getRecaptchaResponseField().value = recaptchaResponse;
      return recaptchaResponse !== '';
    };

    /**
     * Callback to handle when the recapcha loads
     */
    var onloadRecaptchaCallback = function () {
      disableResetPasswordSubmit();
      renderRecaptcha();
    };

    /**
     * Callback to handle when the recapcha has responsed to the user
     */
    var verifyRecaptchaCallback = function () {
      if (hasRecaptchaResponse()) {
        enableResetPasswordSubmit();
      } else {
        disableResetPasswordSubmit();
      }
    };

    /**
     * Callback to handle when SuiteCRM has responded to the browser
     * @param {XMLHttpRequest} request
     */
    var verifySuiteCrmUserCallback = function (request) {
      if (
        request.responseText !== undefined
        && request.responseText === 'Success'
      ) {
        generatepwd();
      }

      resetRecaptcha();
    };

    var callback2 = {
      success: verifySuiteCrmUserCallback,
      failure: verifySuiteCrmUserCallback
    };

    /**
     * Send recaptcha response to SuiteCRM with the user's details from the login screen
     * @see verifySuiteCrmUserCallback
     * @return {boolean}
     */
    var validateAndSubmit = function () {
      if (!hasRecaptchaResponse()) {
        disableResetPasswordSubmit();
        return false;
      }

      var url =
        '&to_pdf=1' +
        '&module=Home' +
        '&action=index' +
        '&entryPoint=Changenewpassword' +
        '&recaptcha_challenge_field=' + getRecaptchaResponseFieldId() +
        '&recaptcha_response_field=' + getRecaptchaResponseField().value;

      YAHOO.util.Connect.asyncRequest(
        'POST',
        'index.php',
        callback2,
        url
      );
    };

    /**
     * Send recaptcha response to SuiteCRM with the user's details from the change password screen
     * @return {boolean}
     */
    var validateCaptchaAndSubmit = function() {
      if (!hasRecaptchaResponse()) {
        disableResetPasswordSubmit();
        return false;
      }
      document.getElementById('username_password').value = document.getElementById('new_password').value;
      document.getElementById('ChangePasswordForm').submit();
    };
{/literal}
</script>