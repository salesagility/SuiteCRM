<?php

class OneLogin_Saml_XmlSecTest extends PHPUnit_Framework_TestCase
{
    private $_settings;

    public function setUp()
    {
        $this->_settings = new OneLogin_Saml_Settings;

        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $this->_settings->spIssuer = $settingsInfo['sp']['entityId'];
        $this->_settings->spReturnUrl = $settingsInfo['sp']['assertionConsumerService']['url'];
        $this->_settings->idpSingleSignOnUrl = $settingsInfo['idp']['singleSignOnService']['url'];
        $this->_settings->idpSingleLogOutUrl = $settingsInfo['idp']['singleLogoutService']['url'];

        $cert = $settingsInfo['idp']['x509cert'];

        $x509cert = str_replace(array("\x0D", "\r", "\n"), "", $cert);
        if (!empty($x509cert)) {
            $x509cert = str_replace('-----BEGIN CERTIFICATE-----', "", $x509cert);
            $x509cert = str_replace('-----END CERTIFICATE-----', "", $x509cert);
            $x509cert = str_replace(' ', '', $x509cert);

            $x509cert = "-----BEGIN CERTIFICATE-----\n".chunk_split($x509cert, 64, "\n")."-----END CERTIFICATE-----\n";
        }

        $this->_settings->idpPublicCertificate = $x509cert;
    }

    public function testValidateNumAssertions()
    {
        $assertion = file_get_contents(TEST_ROOT . '/data/responses/response1.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $assertion);

        $xmlSec = new OneLogin_Saml_XmlSec($this->_settings, $response);

        $this->assertTrue($xmlSec->validateNumAssertions());
    }

    public function testValidateTimestampsInvalid()
    {
        $assertion = file_get_contents(TEST_ROOT . '/data/responses/invalids/not_before_failed.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $assertion);

        $xmlSec = new OneLogin_Saml_XmlSec($this->_settings, $response);

        $this->assertFalse($xmlSec->validateTimestamps());


        $assertion2 = file_get_contents(TEST_ROOT . '/data/responses/invalids/not_after_failed.xml.base64');
        $response2 = new OneLogin_Saml_Response($this->_settings, $assertion2);

        $xmlSec2 = new OneLogin_Saml_XmlSec($this->_settings, $response2);

        $this->assertFalse($xmlSec2->validateTimestamps());
    }

    public function testValidateTimestampsValid()
    {
        $assertion = file_get_contents(TEST_ROOT . '/data/responses/valid_response.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $assertion);

        $xmlSec = new OneLogin_Saml_XmlSec($this->_settings, $response);

        $this->assertTrue($xmlSec->validateTimestamps());
    }

    public function testValidateAssertionUnsigned()
    {
        $assertionUnsigned = file_get_contents(TEST_ROOT . '/data/responses/invalids/no_signature.xml.base64');
        $responseUnsigned = new OneLogin_Saml_Response($this->_settings, $assertionUnsigned);
        $xmlSecUnsigned = new OneLogin_Saml_XmlSec($this->_settings, $responseUnsigned);
        try {
            $this->assertFalse($xmlSecUnsigned->isValid());
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('Cannot locate Signature Node', $e->getMessage());
        }
    }

    public function testValidateAssertionBadReference()
    {
        $assertionBadReference = file_get_contents(TEST_ROOT . '/data/responses/invalids/bad_reference.xml.base64');
        $responseBadReference = new OneLogin_Saml_Response($this->_settings, $assertionBadReference);
        $xmlSecBadReference = new OneLogin_Saml_XmlSec($this->_settings, $responseBadReference);
        try {
            $this->assertFalse($xmlSecBadReference->isValid());
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals('Reference Validation Failed', $e->getMessage());
        }
    }

    public function testValidateAssertionMultiple()
    {
        $assertionMulti = file_get_contents(TEST_ROOT . '/data/responses/invalids/multiple_assertions.xml.base64');
        $responseMulti = new OneLogin_Saml_Response($this->_settings, $assertionMulti);
        $xmlSecMulti = new OneLogin_Saml_XmlSec($this->_settings, $responseMulti);
        try {
            $this->assertFalse($xmlSecMulti->isValid());
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('Multiple assertions are not supported', $e->getMessage());
        }
    }

    public function testValidateAssertionExpired()
    {
        $assertionExpired = file_get_contents(TEST_ROOT . '/data/responses/expired_response.xml.base64');
        $responseExpired = new OneLogin_Saml_Response($this->_settings, $assertionExpired);
        $xmlSecExpired = new OneLogin_Saml_XmlSec($this->_settings, $responseExpired);
        try {
            $this->assertFalse($xmlSecExpired->isValid());
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('Timing issues (please check your clock settings)', $e->getMessage());
        }
    }

    public function testValidateAssertionNoKey()
    {
        $assertionNoKey = file_get_contents(TEST_ROOT . '/data/responses/invalids/no_key.xml.base64');
        $responseNoKey = new OneLogin_Saml_Response($this->_settings, $assertionNoKey);
        $xmlSecNoKey = new OneLogin_Saml_XmlSec($this->_settings, $responseNoKey);
        try {
            $this->assertFalse($xmlSecNoKey->isValid());
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('We have no idea about the key', $e->getMessage());
        }
    }

    public function testValidateAssertionValid()
    {
        $assertion = file_get_contents(TEST_ROOT . '/data/responses/valid_response.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $assertion);

        $xmlSec = new OneLogin_Saml_XmlSec($this->_settings, $response);

        $this->assertTrue($xmlSec->isValid());
    }
}
