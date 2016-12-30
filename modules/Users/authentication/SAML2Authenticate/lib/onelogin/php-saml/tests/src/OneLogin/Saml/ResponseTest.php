<?php

class OneLogin_Saml_ResponseTest extends PHPUnit_Framework_TestCase
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

    public function testReturnNameId()
    {
        $xml = file_get_contents(TEST_ROOT . '/data/responses/response1.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $xml);

        $this->assertEquals('support@onelogin.com', $response->getNameId());

        $this->assertEquals('support@onelogin.com', $response->get_nameid());
    }

    public function testGetAttributes()
    {
        $xml = file_get_contents(TEST_ROOT . '/data/responses/response1.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $xml);

        $expectedAttributes = array(
            'uid' => array(
                'demo'
            ),
            'another_value' => array(
                'value'
            ),
        );
        $this->assertEquals($expectedAttributes, $response->getAttributes());

        $this->assertEquals($response->getAttributes(), $response->get_saml_attributes());

        // An assertion that has no attributes should return an empty array when asked for the attributes
        $assertion = file_get_contents(TEST_ROOT . '/data/responses/response2.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $assertion);

        $this->assertEmpty($response->getAttributes());
    }

    public function testOnlyRetrieveAssertionWithIDThatMatchesSignatureReference()
    {
        $xml = file_get_contents(TEST_ROOT . '/data/responses/wrapped_response_2.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $xml);
        try {
            $nameId = $response->getNameId();
            $this->assertNotEquals('root@example.com', $nameId);
        } catch (Exception $e) {
            $this->assertNotEmpty($e->getMessage(), 'Trying to get NameId on an unsigned assertion fails');
        }
    }

    public function testDoesNotAllowSignatureWrappingAttack()
    {
        $xml = file_get_contents(TEST_ROOT . '/data/responses/response4.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $xml);

        $this->assertEquals('test@onelogin.com', $response->getNameId());
    }

    public function testGetSessionNotOnOrAfter()
    {
        $xml = file_get_contents(TEST_ROOT . '/data/responses/response1.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $xml);

        $this->assertEquals(1290203857, $response->getSessionNotOnOrAfter());
        
        // An assertion that do not specified Session timeout should return NULL
        
        $xml = file_get_contents(TEST_ROOT . '/data/responses/response2.xml.base64');
        $response = new OneLogin_Saml_Response($this->_settings, $xml);

        $this->assertNull($response->getSessionNotOnOrAfter());
    }
}
