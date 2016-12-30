<?php

/**
 * Unit tests for AuthN Request
 */
class OneLogin_Saml2_AuthnRequestTest extends PHPUnit_Framework_TestCase
{
    private $_settings;

    /**
    * Initializes the Test Suite
    */
    public function setUp()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $this->_settings = $settings;
    }

    /**
    * Tests the OneLogin_Saml2_AuthnRequest Constructor.
    * The creation of a deflated SAML Request
    *
    * @covers OneLogin_Saml2_AuthnRequest
    */
    public function testCreateDeflatedSAMLRequestURLParameter()
    {
        $authnRequest = new OneLogin_Saml2_AuthnRequest($this->_settings);
        $parameters = array('SAMLRequest' => $authnRequest->getRequest());
        $authUrl = OneLogin_Saml2_Utils::redirect('http://idp.example.com/SSOService.php', $parameters, true);
        $this->assertRegExp('#^http://idp\.example\.com\/SSOService\.php\?SAMLRequest=#', $authUrl);
        parse_str(parse_url($authUrl, PHP_URL_QUERY), $exploded);
        // parse_url already urldecode de params so is not required.
        $payload = $exploded['SAMLRequest'];
        $decoded = base64_decode($payload);
        $inflated = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:AuthnRequest#', $inflated);
    }

    /**
    * Tests the OneLogin_Saml2_AuthnRequest Constructor.
    * The creation of a deflated SAML Request with AuthNContext
    *
    * @covers OneLogin_Saml2_AuthnRequest
    */
    public function testAuthNContext()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest = new OneLogin_Saml2_AuthnRequest($settings);
        $encodedRequest = $authnRequest->getRequest();
        $decoded = base64_decode($encodedRequest);
        $request = gzinflate($decoded);
        $this->assertContains('<samlp:RequestedAuthnContext Comparison="exact">', $request);
        $this->assertContains('<saml:AuthnContextClassRef>urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport</saml:AuthnContextClassRef>', $request);

        $settingsInfo['security']['requestedAuthnContext']= true;
        $settings2 = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest2 = new OneLogin_Saml2_AuthnRequest($settings2);
        $encodedRequest2 = $authnRequest2->getRequest();
        $decoded2 = base64_decode($encodedRequest2);
        $request2 = gzinflate($decoded2);
        $this->assertContains('<samlp:RequestedAuthnContext Comparison="exact">', $request2);
        $this->assertContains('<saml:AuthnContextClassRef>urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport</saml:AuthnContextClassRef>', $request2);

        $settingsInfo['security']['requestedAuthnContext'] = false;
        $settings3 = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest3 = new OneLogin_Saml2_AuthnRequest($settings3);
        $encodedRequest3 = $authnRequest3->getRequest();
        $decoded3 = base64_decode($encodedRequest3);
        $request3 = gzinflate($decoded3);
        $this->assertNotContains('<samlp:RequestedAuthnContext Comparison="exact">', $request3);
        $this->assertNotContains('<saml:AuthnContextClassRef>urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport</saml:AuthnContextClassRef>', $request3);

        $settingsInfo['security']['requestedAuthnContext']= array ('urn:oasis:names:tc:SAML:2.0:ac:classes:Password', 'urn:oasis:names:tc:SAML:2.0:ac:classes:X509');
        $settings4 = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest4 = new OneLogin_Saml2_AuthnRequest($settings4);
        $encodedRequest4 = $authnRequest4->getRequest();
        $decoded4 = base64_decode($encodedRequest4);
        $request4 = gzinflate($decoded4);
        $this->assertContains('<samlp:RequestedAuthnContext Comparison="exact">', $request4);
        $this->assertNotContains('<saml:AuthnContextClassRef>urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport</saml:AuthnContextClassRef>', $request4);
        $this->assertContains('<saml:AuthnContextClassRef>urn:oasis:names:tc:SAML:2.0:ac:classes:Password</saml:AuthnContextClassRef>', $request4);
        $this->assertContains('<saml:AuthnContextClassRef>urn:oasis:names:tc:SAML:2.0:ac:classes:X509</saml:AuthnContextClassRef>', $request4);

        $settingsInfo['security']['requestedAuthnContextComparison'] = 'minimum';
        $settings5 = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest5 = new OneLogin_Saml2_AuthnRequest($settings5);
        $encodedRequest5 = $authnRequest5->getRequest();
        $decoded5 = base64_decode($encodedRequest5);
        $request5 = gzinflate($decoded5);
        $this->assertContains('<samlp:RequestedAuthnContext Comparison="minimum">', $request5);
    }

    /**
    * Tests the OneLogin_Saml2_AuthnRequest Constructor.
    * The creation of a deflated SAML Request with ForceAuthn
    *
    * @covers OneLogin_Saml2_AuthnRequest
    */
    public function testForceAuthN()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest = new OneLogin_Saml2_AuthnRequest($settings);
        $encodedRequest = $authnRequest->getRequest();
        $decoded = base64_decode($encodedRequest);
        $request = gzinflate($decoded);
        $this->assertNotContains('ForceAuthn="true"', $request);

        $authnRequest2 = new OneLogin_Saml2_AuthnRequest($settings, false, false);
        $encodedRequest2 = $authnRequest2->getRequest();
        $decoded2 = base64_decode($encodedRequest2);
        $request2 = gzinflate($decoded2);
        $this->assertNotContains('ForceAuthn="true"', $request2);

        $authnRequest3 = new OneLogin_Saml2_AuthnRequest($settings, true, false);
        $encodedRequest3 = $authnRequest3->getRequest();
        $decoded3 = base64_decode($encodedRequest3);
        $request3 = gzinflate($decoded3);
        $this->assertContains('ForceAuthn="true"', $request3);
    }

    /**
    * Tests the OneLogin_Saml2_AuthnRequest Constructor.
    * The creation of a deflated SAML Request with isPassive
    *
    * @covers OneLogin_Saml2_AuthnRequest
    */
    public function testIsPassive()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest = new OneLogin_Saml2_AuthnRequest($settings);
        $encodedRequest = $authnRequest->getRequest();
        $decoded = base64_decode($encodedRequest);
        $request = gzinflate($decoded);
        $this->assertNotContains('IsPassive="true"', $request);

        $authnRequest2 = new OneLogin_Saml2_AuthnRequest($settings, false, false);
        $encodedRequest2 = $authnRequest2->getRequest();
        $decoded2 = base64_decode($encodedRequest2);
        $request2 = gzinflate($decoded2);
        $this->assertNotContains('IsPassive="true"', $request2);

        $authnRequest3 = new OneLogin_Saml2_AuthnRequest($settings, false, true);
        $encodedRequest3 = $authnRequest3->getRequest();
        $decoded3 = base64_decode($encodedRequest3);
        $request3 = gzinflate($decoded3);
        $this->assertContains('IsPassive="true"', $request3);
    }

    /**
    * Tests the OneLogin_Saml2_AuthnRequest Constructor.
    * The creation of a deflated SAML Request with and without NameIDPolicy
    *
    * @covers OneLogin_Saml2_AuthnRequest
    */
    public function testNameIDPolicy()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest = new OneLogin_Saml2_AuthnRequest($settings, false, false, false);
        $encodedRequest = $authnRequest->getRequest();
        $decoded = base64_decode($encodedRequest);
        $request = gzinflate($decoded);
        $this->assertNotContains('<samlp:NameIDPolicy', $request);

        $authnRequest2 = new OneLogin_Saml2_AuthnRequest($settings, false, false, true);
        $encodedRequest2 = $authnRequest2->getRequest();
        $decoded2 = base64_decode($encodedRequest2);
        $request2 = gzinflate($decoded2);
        $this->assertContains('<samlp:NameIDPolicy', $request2);

        $authnRequest3 = new OneLogin_Saml2_AuthnRequest($settings);
        $encodedRequest3 = $authnRequest3->getRequest();
        $decoded3 = base64_decode($encodedRequest3);
        $request3 = gzinflate($decoded3);
        $this->assertContains('<samlp:NameIDPolicy', $request3);
    }

    /**
    * Tests the OneLogin_Saml2_AuthnRequest Constructor.
    * The creation of a deflated SAML Request
    *
    * @covers OneLogin_Saml2_AuthnRequest
    */
    public function testCreateEncSAMLRequest()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settingsInfo['organization'] = array (
            'es' => array (
                'name' => 'sp_prueba',
                'displayname' => 'SP prueba',
                'url' => 'http://sp.example.com'
            )
        );
        $settingsInfo['security']['wantNameIdEncrypted'] = true;

        $settings = new OneLogin_Saml2_Settings($settingsInfo);

        $authnRequest = new OneLogin_Saml2_AuthnRequest($settings);
        $parameters = array('SAMLRequest' => $authnRequest->getRequest());
        $authUrl = OneLogin_Saml2_Utils::redirect('http://idp.example.com/SSOService.php', $parameters, true);
        $this->assertRegExp('#^http://idp\.example\.com\/SSOService\.php\?SAMLRequest=#', $authUrl);
        parse_str(parse_url($authUrl, PHP_URL_QUERY), $exploded);
        // parse_url already urldecode de params so is not required.
        $payload = $exploded['SAMLRequest'];
        $decoded = base64_decode($payload);
        $message = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:AuthnRequest#', $message);
        $this->assertRegExp('#AssertionConsumerServiceURL="http://stuff.com/endpoints/endpoints/acs.php">#', $message);
        $this->assertRegExp('#<saml:Issuer>http://stuff.com/endpoints/metadata.php</saml:Issuer>#', $message);
        $this->assertRegExp('#Format="urn:oasis:names:tc:SAML:2.0:nameid-format:encrypted"#', $message);
        $this->assertRegExp('#ProviderName="SP prueba"#', $message);
    }

    /**
    * Tests that a 'true' value for compress => requests gets honored when we
    * try to obtain the request payload from getRequest()
    *
    * @covers OneLogin_Saml2_AuthnRequest::getRequest()
    */
    public function testWeCanChooseToCompressARequest()
    {
        //Test that we can compress.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest = new OneLogin_Saml2_AuthnRequest($settings);
        $payload = $authnRequest->getRequest();
        $decoded = base64_decode($payload);
        $decompressed = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:AuthnRequest#', $decompressed);
    }

    /**
    * Tests that a 'false' value for compress => requests gets honored when we
    * try to obtain the request payload from getRequest()
    *
    * @covers OneLogin_Saml2_AuthnRequest::getRequest()
    */
    public function testWeCanChooseNotToCompressARequest()
    {
        //Test that we can choose not to compress the request payload.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings2.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest = new OneLogin_Saml2_AuthnRequest($settings);
        $payload = $authnRequest->getRequest();
        $decoded = base64_decode($payload);
        $this->assertRegExp('#^<samlp:AuthnRequest#', $decoded);
    }

    /**
     * Tests that we can pass a boolean value to the getRequest()
     * method to choose whether it should 'gzdeflate' the body
     * of the request.
     *
     * @covers OneLogin_Saml2_AuthnRequest::getRequest()
     */
    public function testWeCanChooseToDeflateARequestBody()
    {
        //Test that we can choose not to compress the request payload.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        //Compression is currently turned on in settings.
        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest = new OneLogin_Saml2_AuthnRequest($settings);
        $payload = $authnRequest->getRequest(false);
        $decoded = base64_decode($payload);
        $this->assertRegExp('#^<samlp:AuthnRequest#', $decoded);

        //Test that we can choose not to compress the request payload.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings2.php';

        //Compression is currently turned off in settings.
        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $authnRequest = new OneLogin_Saml2_AuthnRequest($settings);
        $payload = $authnRequest->getRequest(true);
        $decoded = base64_decode($payload);
        $decompressed = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:AuthnRequest#', $decompressed);
    }
}
