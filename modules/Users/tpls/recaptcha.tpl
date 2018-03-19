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
      return document.getElementById('generate_pwd_button');
    };

    /**
     * Allow user from submitting password reset form
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
     * Callback to handle when the recapcha has response to the user
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
     * Send recaptcha response to SuiteCRM with the user's details
     * @see verifySuiteCrmUserCallback
     */
    var validateAndSubmit = function () {
      if(!hasRecaptchaResponse()) {
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
{/literal}
</script>