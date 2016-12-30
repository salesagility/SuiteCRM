<?php
/**
 * SAMPLE Code to demonstrate how to handle a SAML assertion response.
 *
 * The URL of this file will have been given during the SAML authorization.
 * After a successful authorization, the browser will be directed to this
 * link where it will send a certified response via $_POST.
 */

error_reporting(E_ALL);

require_once '../_toolkit_loader.php';

try {
    if (isset($_POST['SAMLResponse'])) {
        $samlSettings = new OneLogin_Saml2_Settings();
        $samlResponse = new OneLogin_Saml2_Response($samlSettings, $_POST['SAMLResponse']);
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
                echo '</tbody></table>';
            }
        } else {
            echo 'Invalid SAML Response';
        }
    } else {
        echo 'No SAML Response found in POST.';
    }
} catch (Exception $e) {
    echo 'Invalid SAML Response: ' . $e->getMessage();
}
