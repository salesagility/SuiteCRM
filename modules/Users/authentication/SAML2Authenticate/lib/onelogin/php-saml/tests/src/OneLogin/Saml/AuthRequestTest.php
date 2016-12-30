<?php

/**
 * Unit tests for AuthN Request
 */
class OneLogin_Saml_AuthRequestTest extends PHPUnit_Framework_TestCase
{
    private $_settings;

    /**
    * Initializes the Test Suite
    */
    public function setUp()
    {
        $settings = new OneLogin_Saml_Settings;
        $settings->idpSingleSignOnUrl = 'http://stuff.com';
        $settings->spReturnUrl = 'http://sp.stuff.com';
        $this->_settings = $settings;
    }

    /**
    * Tests the OneLogin_Saml_AuthRequest Constructor and
    * the getRedirectUrl method
    * The creation of a deflated SAML Request
    *
    * @covers OneLogin_Saml_AuthRequest
    * @covers OneLogin_Saml_AuthRequest::getRedirectUrl
    */
    public function testCreateDeflatedSAMLRequestURLParameter()
    {
        $request = new OneLogin_Saml_AuthRequest($this->_settings);
        $authUrl = $request->getRedirectUrl();
        $this->assertRegExp('#^http://stuff\.com\?SAMLRequest=#', $authUrl);
        parse_str(parse_url($authUrl, PHP_URL_QUERY), $exploded);
        // parse_url already urldecode de params so is not required.
        $payload = $exploded['SAMLRequest'];
        $decoded = base64_decode($payload);
        $inflated = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:AuthnRequest#', $inflated);

        $request2 = new OneLogin_Saml_AuthRequest($this->_settings);
        $authUrl2 = $request2->getRedirectUrl('http://sp.example.com');
        $this->assertRegExp('#^http://stuff\.com\?SAMLRequest=#', $authUrl2);
        parse_str(parse_url($authUrl2, PHP_URL_QUERY), $exploded2);
        // parse_url already urldecode de params so is not required.
        $this->assertEquals('http://sp.example.com', $exploded2['RelayState']);
        $payload2 = $exploded2['SAMLRequest'];
        $decoded2 = base64_decode($payload2);
        $inflated2 = gzinflate($decoded2);
        $this->assertRegExp('#^<samlp:AuthnRequest#', $inflated2);
    }

    /**
    * Tests the protected method _getTimestamp of the OneLogin_Saml_AuthRequest
    *
    * @covers OneLogin_Saml_AuthRequest::_getTimestamp
    */
    public function testGetMetadataValidTimestamp()
    {
        if (class_exists('ReflectionClass')) {
            $reflectionClass = new ReflectionClass("OneLogin_Saml_AuthRequest");
            $method = $reflectionClass->getMethod('_getTimestamp');
 
            if (method_exists($method, 'setAccessible')) {
                $method->setAccessible(true);

                $settingsDir = TEST_ROOT .'/settings/';
                include $settingsDir . 'settings1.php';

                $metadata = new OneLogin_Saml_AuthRequest($settingsInfo);

                $time = time();
                $timestamp = $method->invoke($metadata);
                $this->assertEquals(strtotime($timestamp), $time);
            }
        }
    }

    /**
    * Tests the protected method _generateUniqueID of the OneLogin_Saml_AuthRequest
    *
    * @covers OneLogin_Saml_AuthRequest::_generateUniqueID
    */
    public function testGenerateUniqueID()
    {
        if (class_exists('ReflectionClass')) {
            $reflectionClass = new ReflectionClass("OneLogin_Saml_AuthRequest");
            $method = $reflectionClass->getMethod('_generateUniqueID');

            if (method_exists($method, 'setAccessible')) {
                $method->setAccessible(true);

                $settingsDir = TEST_ROOT .'/settings/';
                include $settingsDir . 'settings1.php';

                $metadata = new OneLogin_Saml_AuthRequest($settingsInfo);

                $id = $method->invoke($metadata);
                $id2 = $method->invoke($metadata);
                $this->assertNotEmpty($id);
                $this->assertNotEmpty($id2);
                $this->assertNotEquals($id, $id2);
                $this->assertContains('ONELOGIN', $id);
            }
        }
    }
}
