The example requires that SP and IdP are well configured before test it.

SP setup
--------

This demo uses the old style of the version 1 of the toolkit.
An object of the class OneLogin_Saml_Settings must be provided to the
constructor of the AuthRequest.

You will find an example_settings.php file at the demo-old's folder that
could be used as a template for you settings.php file.

In that template, SAML settings are divided into two parts, the application
specific (const_assertion_consumer_service_url, const_issuer,
const_name_identifier_format) and the user/account specific
idp_sso_target_url, x509certificate). You’ll need to add your own code here
to identify the user or user origin (e.g. by subdomain, ip_address etc.).


IdP setup
---------

Once the SP is configured, the metadata of the SP is published at the
metadata.php file. Based on that info, configure the IdP.


How it works
------------

At the metadata.php view is published the metadata of the SP.

The index.php file acts as an initiater for the SAML conversation, if it should
should be initiated by the application. This is called Service Service Provider
Initiated SAML. The service provider creates a SAML Authentication Request and
sends it to the identity provider (IdP).

The consume.php is the ACS endpoint. Receives the SAML assertion. After Response
validation, the userdata and the nameID will be available, using getNameId() or
getAttributes() we obtain them.


Since the version 1 of the php toolkit does not support SLO we don't show how
handle SLO in this demo-old.
