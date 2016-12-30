<?php
/**
 * SAMPLE Code to demonstrate how to handle a SAML assertion response.
 *
 * The URL of this file will have been given during the SAML authorization.
 * After a successful authorization, the browser will be directed to this
 * link where it will send a certified response via $_POST.
 */

error_reporting(E_ALL);

$settings = null;
require 'settings.php';

$samlResponse = new OneLogin_Saml_Response($settings, $_POST['SAMLResponse']);

try {
    if ($samlResponse->isValid()) {
        echo 'You are: ' . $samlResponse->getNameId() . '<br>';
        $attributes = $samlResponse->getAttributes();
        if (!empty($attributes)) {
            echo 'You have the following attributes:<br>';
            echo '<table><thead><th>Name</th><th>Values</th></thead><tbody>';
            foreach ($attributes as $attributeName => $attributeValues) {
                echo '<tr><td>' . htmlentities($attributeName) . '</td><td><ul>';
                foreach ($attributeValues as $attributeValue) {
                    echo '<li>' . htmlentities($attributeValue) . '</li>';
                }
                echo '</ul></td></tr>';
            }
            echo '</tbody></table><br><br>';
            echo "The v.1 of the Onelogin's PHP SAML Tookit does not support SLO.";
        }
    } else {
        echo 'Invalid SAML response.';
    }
} catch (Exception $e) {
    echo 'Invalid SAML response: ' . $e->getMessage();
}
