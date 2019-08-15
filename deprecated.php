<?php
/**
 * Backwards compatibility for OneLogin\Saml2
 */
$saml2_class_names = [
    'Auth',
    'AuthnRequest',
    'Constants',
    'Error',
    'ValidationError',
    'IdPMetadataParser',
    'LogoutRequest',
    'LogoutResponse',
    'Metadata',
    'Response',
    'Settings',
    'Utils',
];

foreach ($saml2_class_names as $name) {
    class_alias("OneLogin\\Saml2\\" . $name, 'OneLogin_Saml2_' . $name);
}
