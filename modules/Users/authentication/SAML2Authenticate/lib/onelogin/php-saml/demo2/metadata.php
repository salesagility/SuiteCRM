<?php
/**
 * SAMPLE Code to demonstrate how to handle a SAML assertion response.
 *
 * Your IdP will usually want your metadata, you can use this code to generate it once,
 * or expose it on a URL so your IdP can check it periodically.
 */

error_reporting(E_ALL);

require_once '../_toolkit_loader.php';

header('Content-Type: text/xml');

$samlSettings = new OneLogin_Saml2_Settings();
$sp = $samlSettings->getSPData();

$samlMetadata = OneLogin_Saml2_Metadata::builder($sp);
echo $samlMetadata;
