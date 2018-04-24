<?php
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

if (!defined('sugarEntry') || !sugarEntry) {
       die('Not A Valid Entry Point');
}

use \ReCaptcha\ReCaptcha as ReCaptcha;
use \ReCaptcha\Response as Response;
use SuiteCRM\Utility\SuiteLogger as SuiteLogger;

/**
 * @return array|null
 */
function getRecaptchaSettings()
{
    $administration = new Administration();
    $administration->retrieveSettings('captcha');

    return $administration->settings;
}

/**
 * @param array $settings
 * @see getRecaptchaSettings()
 * @return bool|string false if setting is not found
 */
function getRecaptchaSiteKey(array $settings)
{
    return isset($settings['captcha_public_key']) ? $settings['captcha_public_key'] : false;
}

/**
 * @return bool|string
 */
function getRecaptchaChallengeField()
{
    return isset($_REQUEST['recaptcha_challenge_field']) ? $_REQUEST['recaptcha_challenge_field'] : false;
}

/**
 * @param array $settings
 * @see getRecaptchaSettings()
 * @return bool|string false if setting is not found
 */
function getRecaptchaPrivateKey(array $settings)
{
    return isset($settings['captcha_private_key']) ? $settings['captcha_private_key'] : false;
}

/**
 * @param array $settings
 * @see getRecaptchaSettings()
 * @return bool|string false if setting is not found
 */
function getRecaptchaEnabled(array $settings)
{
    return isset($settings['captcha_on']) ? $settings['captcha_on'] : false;
}

/**
 * @param array $settings
 * @see getRecaptchaSettings()
 * @return bool
 */
function isRecaptchaEnabled(array $settings)
{
    return getRecaptchaEnabled($settings) === '1';
}

/**
 * @return string|null
 */
function getRecapthaResponse()
{
    return $_REQUEST['recaptcha_response_field'];
}

/**
 * @return string|null
 */
function getRemoteIpAddress()
{
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * @param ReCaptcha $reCaptcha
 * @param string $response
 * @param string $remoteIpAddress
 * @return Response
 */
function verifyRecapthaResponse(ReCaptcha $reCaptcha, $response, $remoteIpAddress)
{
    return $reCaptcha->verify($response, $remoteIpAddress);
}

/**
 * @param Response $response
 * @return bool
 */
function isRecapthaResponseVerified(Response $response)
{
    return $response->isSuccess();
}

/**
 * @param Response $response
 * @return string
 */
function getRecaptchaErrors(Response $response)
{
    $errors = '';

    foreach ($response->getErrorCodes() as $code) {
        $errors .= '<kbd>' . $code . '</kbd>';
    }

    return $errors;
}

/**
 * @return string Success or the error(s) found
 */
function displayRecaptchaValidation()
{
    $log = new SuiteLogger();
    /** @var array $settings */
    $settings = getRecaptchaSettings();

    if (
        !isRecaptchaEnabled($settings)
        || empty(getRecaptchaSiteKey($settings))
        || empty(getRecaptchaPrivateKey($settings))
    ) {
        $msg = 'Missing Captcha Settings';
        $log->error($msg);

        return $msg;
    }

    /** @var Response $response */
    $response = verifyRecapthaResponse(
        new ReCaptcha(getRecaptchaPrivateKey($settings)),
        getRecapthaResponse(),
        getRemoteIpAddress()
    );

    if (!isRecapthaResponseVerified($response)) {
        $log->warning(
            'FAILED TO VERIFY RECAPCHA, ip[{remoteIpAddress}]',
            array(
                'remoteIpAddress' => getRemoteIpAddress()
            )
        );

        return getRecaptchaErrors($response);
    }

    return 'Success';
}

/**
 * @return string recaptcha enabled template or the recaptcha disabled template
 */
function displayRecaptcha()
{
    $captchaContentTemplate = new Sugar_Smarty();
    $log = new SuiteLogger();
    /** @var array $settings */
    $settings = getRecaptchaSettings();

    if (
        !isRecaptchaEnabled($settings)
        || empty(getRecaptchaSiteKey($settings))
        || empty(getRecaptchaPrivateKey($settings))
    ) {
        $log->info('Captcha Settings are disabled');
        return $captchaContentTemplate->fetch(__DIR__ . '/recaptcha_disabled.tpl');
    }

    $captchaContentTemplate->assign('SITE_KEY', getRecaptchaSiteKey($settings));
    $captchaContentTemplate->assign('SECRET', getRecaptchaPrivateKey($settings));

    return $captchaContentTemplate->fetch(__DIR__ . '/recaptcha_enabled.tpl');
}