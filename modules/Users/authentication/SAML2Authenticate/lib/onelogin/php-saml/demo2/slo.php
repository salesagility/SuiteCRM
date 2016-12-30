<?php
/**
 * SAMPLE Code to demonstrate how to initiate a SAML Single Log Out request
 *
 * When the user visits this URL, the browser will be redirected to the SLO
 * IdP with an SLO request.
 */

session_start();

require_once '../_toolkit_loader.php';

$samlSettings = new OneLogin_Saml2_Settings();

$idpData = $samlSettings->getIdPData();
if (isset($idpData['singleLogoutService']) && isset($idpData['singleLogoutService']['url'])) {
    $sloUrl = $idpData['singleLogoutService']['url'];
} else {
    throw new Exception("The IdP does not support Single Log Out");
}

if (isset($_SESSION['IdPSessionIndex']) && !empty($_SESSION['IdPSessionIndex'])) {
    $logoutRequest = new OneLogin_Saml2_LogoutRequest($samlSettings, null, $_SESSION['IdPSessionIndex']);
} else {
    $logoutRequest = new OneLogin_Saml2_LogoutRequest($samlSettings);
}

$samlRequest = $logoutRequest->getRequest();

$parameters = array('SAMLRequest' => $samlRequest);

$url = OneLogin_Saml2_Utils::redirect($sloUrl, $parameters, true);

header("Location: $url");
