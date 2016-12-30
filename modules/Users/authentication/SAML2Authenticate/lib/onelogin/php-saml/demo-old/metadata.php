<?php
/**
 * SAMPLE Code to demonstrate how to handle a SAML assertion response.
 *
 * Your IdP will usually want your metadata, you can use this code to generate it once,
 * or expose it on a URL so your IdP can check it periodically.
 */

error_reporting(E_ALL);

$settings = null;
require 'settings.php';

header('Content-Type: text/xml');

$samlMetadata = new OneLogin_Saml_Metadata($settings);
echo $samlMetadata->getXml();
