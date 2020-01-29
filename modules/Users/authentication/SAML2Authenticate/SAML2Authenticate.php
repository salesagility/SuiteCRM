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
    die('Not A Valid Entry Point');
}

require_once('modules/Users/authentication/SugarAuthenticate/SugarAuthenticate.php');

/**
 * Class SAML2Authenticate for SAML2 auth
 */
class SAML2Authenticate extends SugarAuthenticate
{
    public $userAuthenticateClass = 'SAML2AuthenticateUser';
    public $authenticationDir = 'SAML2Authenticate';

    /**
     * @var OneLogin_Saml2_Auth
     */
    private $samlLogoutAuth = null;

    /**
     * @var array
     */
    private $samlLogoutArgs = array();

    /**
     * pre login initialization - use SAML2 to authenticate a user login process
     * @throws OneLogin_Saml2_Error
     */
    public function pre_login()
    {
        parent::pre_login();

        require_once dirname(dirname(__FILE__)) . '/SAML2Authenticate/lib/onelogin/settings.php';
        $auth = new OneLogin_Saml2_Auth($settingsInfo);

        if (isset($_REQUEST['SAMLResponse']) && $_REQUEST['SAMLResponse']) {
            if (isset($_SESSION) && isset($_SESSION['AuthNRequestID'])) {
                $requestID = $_SESSION['AuthNRequestID'];
            } else {
                $requestID = null;
            }

            $auth->processResponse($requestID);

            $errors = $auth->getErrors();

            if (!empty($errors)) {
                print_r('<p>' . implode(', ', $errors) . '</p>');
            }

            if (!$auth->isAuthenticated()) {
                SugarApplication::redirect($auth->getSSOurl());
            }

            $_SESSION['samlUserdata'] = $auth->getAttributes();
            $_SESSION['samlNameId'] = $auth->getNameId();
            $_SESSION['samlNameIdFormat'] = $auth->getNameIdFormat();
            $_SESSION['samlSessionIndex'] = $auth->getSessionIndex();
            unset($_SESSION['AuthNRequestID']);

            if (isset($_POST['RelayState']) && OneLogin_Saml2_Utils::getSelfURL() != $_POST['RelayState']) {
                $relayStateUrl = $_POST['RelayState'] . '?action=Login&module=Users';
                $selfurl = OneLogin_Saml2_Utils::getSelfURL();
                if ($selfurl === $relayStateUrl) {
                    // Authenticate with suitecrm
                    $this->redirectToLogin($GLOBALS['app']);
                }
            }
        } else {
            $auth->login();
            exit;
        }
    }

    /**
     * override SugarAuthenticate and use SAML2 authentication
     * @param SugarApplication $app
     * @return bool
     */
    public function redirectToLogin(SugarApplication $app)
    {
        if (isset($_SESSION['samlNameId']) && !empty($_SESSION['samlNameId'])) {
            if ($this->userAuthenticate->loadUserOnLogin($_SESSION['samlNameId'], null)) {
                global $authController;
                $authController->login($_SESSION['samlNameId'], null);
            }
            SugarApplication::redirect('index.php');
        } else {
            return false;
        }
    }

    /**
     * Called when a user requests to logout, and use SAML2 logout
     * @throws OneLogin_Saml2_Error
     */
    public function logout()
    {
        if ($this->samlLogoutAuth && !empty($this->samlLogoutAuth->getSLOurl())) {
            $this->samlLogoutAuth->logout(
                $this->samlLogoutArgs['returnTo'],
                $this->samlLogoutArgs['parameters'],
                $this->samlLogoutArgs['nameId'],
                $this->samlLogoutArgs['sessionIndex'],
                $this->samlLogoutArgs['false'],
                $this->samlLogoutArgs['nameIdFormat']
            );
        } else {
            // TODO: SLO Url need for SAML2, add it to SAML2 authentication settings
            $GLOBALS['log']->debug('SLO Url need for SAML2, add it to SAML2 authentication settings');
            SugarApplication::redirect('index.php');
        }
    }

    /**
     * call before from user logout page clear the session, store logout information for SAML2 logout
     */
    public function preLogout()
    {
        require_once dirname(dirname(__FILE__)) . '/SAML2Authenticate/lib/onelogin/settings.php';
        $auth = new OneLogin_Saml2_Auth($settingsInfo);

        $returnTo = null;
        $paramters = array();
        $nameId = null;
        $sessionIndex = null;
        $nameIdFormat = null;

        if (isset($_SESSION['samlNameId'])) {
            $nameId = $_SESSION['samlNameId'];
        }
        if (isset($_SESSION['samlSessionIndex'])) {
            $sessionIndex = $_SESSION['samlSessionIndex'];
        }
        if (isset($_SESSION['samlNameIdFormat'])) {
            $nameIdFormat = $_SESSION['samlNameIdFormat'];
        }

        $this->samlLogoutAuth = $auth;
        $this->samlLogoutArgs = array('returnTo' => $returnTo, 'parameters' => $paramters, 'nameId' => $nameId, 'sessionIndex' => $sessionIndex, 'false' => false, 'nameIdFormat' => $nameIdFormat);
    }
}
