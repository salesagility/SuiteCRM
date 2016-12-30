<?php

/**
 * Unit tests for Logout Response
 */
class OneLogin_Saml2_LogoutResponseTest extends PHPUnit_Framework_TestCase
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
    * Tests the OneLogin_Saml2_LogoutResponse Constructor.
    *
    * @covers OneLogin_Saml2_LogoutResponse
    */
    public function testConstructor()
    {
        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64');
        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);
        $this->assertRegExp('#<samlp:LogoutResponse#', $response->document->saveXML());
    }

    /**
    * Tests the OneLogin_Saml2_LogoutResponse Constructor.
    * The creation of a deflated SAML Logout Response
    *
    * @covers OneLogin_Saml2_LogoutResponse
    */
    public function testCreateDeflatedSAMLLogoutResponseURLParameter()
    {
        $inResponseTo = 'ONELOGIN_21584ccdfaca36a145ae990442dcd96bfe60151e';
        $responseBuilder = new OneLogin_Saml2_LogoutResponse($this->_settings);
        $responseBuilder->build($inResponseTo);
        $parameters = array('SAMLResponse' => $responseBuilder->getResponse());

        $logoutUrl = OneLogin_Saml2_Utils::redirect('http://idp.example.com/SingleLogoutService.php', $parameters, true);

        $this->assertRegExp('#^http://idp\.example\.com\/SingleLogoutService\.php\?SAMLResponse=#', $logoutUrl);
        parse_str(parse_url($logoutUrl, PHP_URL_QUERY), $exploded);
        // parse_url already urldecode de params so is not required.
        $payload = $exploded['SAMLResponse'];
        $decoded = base64_decode($payload);
        $inflated = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:LogoutResponse#', $inflated);
    }

    /**
    * Tests the getStatus method of the OneLogin_Saml2_LogoutResponse
    *
    * @covers OneLogin_Saml2_LogoutResponse::getStatus
    */
    public function testGetStatus()
    {
        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64');
        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);
        $status = $response->getStatus();
        $this->assertEquals($status, OneLogin_Saml2_Constants::STATUS_SUCCESS);

        $message2 = file_get_contents(TEST_ROOT . '/data/logout_responses/invalids/no_status.xml.base64');
        $response2 = new OneLogin_Saml2_LogoutResponse($this->_settings, $message2);
        $this->assertNULL($response2->getStatus());
    }

    /**
    * Tests the getIssuer of the OneLogin_Saml2_LogoutResponse
    *
    * @covers OneLogin_Saml2_LogoutResponse::getIssuer
    */
    public function testGetIssuer()
    {
        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64');
        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);

        $issuer = $response->getIssuer($response);
        $this->assertEquals('http://idp.example.com/', $issuer);
    }

    /**
    * Tests the private method _query of the OneLogin_Saml2_LogoutResponse
    *
    */
    public function testQuery()
    {
        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64');
        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);

        $issuer = $response->getIssuer($response);
        $this->assertEquals('http://idp.example.com/', $issuer);
    }

    /**
    * Tests the getError method of the OneLogin_Saml2_LogoutResponse
    *
    * @covers OneLogin_Saml2_LogoutResponse::getError
    */
    public function testGetError()
    {
        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64');
        $requestId = 'invalid_request_id';
        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);
        $this->_settings->setStrict(true);
        $this->assertFalse($response->isValid($requestId));
        $this->assertEquals($response->getError(), 'The InResponseTo of the Logout Response: ONELOGIN_21584ccdfaca36a145ae990442dcd96bfe60151e, does not match the ID of the Logout request sent by the SP: invalid_request_id');

    }

   /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutResponse
    * Case invalid request Id
    *
    * @covers OneLogin_Saml2_LogoutResponse::isValid
    */
    public function testIsInValidRequestId()
    {
        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64');

        $plainMessage = gzinflate(base64_decode($message));
        $currentURL = OneLogin_Saml2_Utils::getSelfURLNoQuery();
        $plainMessage = str_replace('http://stuff.com/endpoints/endpoints/sls.php', $currentURL, $plainMessage);
        $message = base64_encode(gzdeflate($plainMessage));

        $requestId = 'invalid_request_id';

        $this->_settings->setStrict(false);
        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);
        $this->assertTrue($response->isValid($requestId));

        $this->_settings->setStrict(true);
        $response2 = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);

        $this->assertTrue($response2->isValid());

        $this->assertFalse($response2->isValid($requestId));
        $this->assertContains('The InResponseTo of the Logout Response:', $response2->getError());
    }

   /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutResponse
    * Case invalid Issuer
    *
    * @covers OneLogin_Saml2_LogoutResponse::isValid
    */
    public function testIsInValidIssuer()
    {
        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64');

        $plainMessage = gzinflate(base64_decode($message));
        $currentURL = OneLogin_Saml2_Utils::getSelfURLNoQuery();
        $plainMessage = str_replace('http://stuff.com/endpoints/endpoints/sls.php', $currentURL, $plainMessage);
        $plainMessage = str_replace('http://idp.example.com/', 'http://invalid.issuer.example.com', $plainMessage);
        $message = base64_encode(gzdeflate($plainMessage));

        $this->_settings->setStrict(false);
        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);
        $this->assertTrue($response->isValid());

        $this->_settings->setStrict(true);
        $response2 = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);

        $this->assertFalse($response2->isValid());
        $this->assertEquals('Invalid issuer in the Logout Response', $response2->getError());
    }

    /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutResponse
    * Case invalid xml
    *
    * @covers OneLogin_Saml2_LogoutResponse::isValid
    */
    public function testIsInValidWrongXML()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settingsInfo['security']['wantXMLValidation'] = false;

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $settings->setStrict(false);

        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/invalids/invalid_xml.xml.base64');

        $response = new OneLogin_Saml2_LogoutResponse($settings, $message);

        $this->assertTrue($response->isValid());

        $settings->setStrict(true);
        $response2 = new OneLogin_Saml2_LogoutResponse($settings, $message);
        $response2->isValid();
        $this->assertNotEquals('Invalid SAML Logout Response. Not match the saml-schema-protocol-2.0.xsd', $response2->getError());

        $settingsInfo['security']['wantXMLValidation'] = true;
        $settings2 = new OneLogin_Saml2_Settings($settingsInfo);
        $settings2->setStrict(false);
        $response3 = new OneLogin_Saml2_LogoutResponse($settings2, $message);
        $this->assertTrue($response3->isValid());

        $settings2->setStrict(true);
        $response4 = new OneLogin_Saml2_LogoutResponse($settings2, $message);
        $this->assertFalse($response4->isValid());
        $this->assertEquals('Invalid SAML Logout Response. Not match the saml-schema-protocol-2.0.xsd', $response4->getError());
    }

   /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutResponse
    * Case invalid Destination
    *
    * @covers OneLogin_Saml2_LogoutResponse::isValid
    */
    public function testIsInValidDestination()
    {
        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64');

        $this->_settings->setStrict(false);
        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);
        $this->assertTrue($response->isValid());

        $this->_settings->setStrict(true);
        $response2 = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);
        $this->assertFalse($response2->isValid());
        $this->assertContains('The LogoutResponse was received at', $response2->getError());
    }

   /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutResponse
    *
    * @covers OneLogin_Saml2_LogoutResponse::isValid
    */
    public function testIsInValidSign()
    {
        $currentURL = OneLogin_Saml2_Utils::getSelfURLNoQuery();

        $this->_settings->setStrict(false);
        $_GET = array (
            'SAMLResponse' => 'fZJva8IwEMa/Ssl7TZrW/gnqGHMMwSlM8cXeyLU9NaxNQi9lfvxVZczB5ptwSe733MPdjQma2qmFPdjOvyE5awiDU1MbUpevCetaoyyQJmWgQVK+VOvH14WSQ6Fca70tbc1ukPsEEGHrtTUsmM8mbDfKUhnFci8gliGINI/yXIAAiYnsw6JIRgWWAKlkwRZb6skJ64V6nKjDuSEPxvdPIowHIhpIsQkTFaYqSt9ZMEPy2oC/UEfvHSnOnfZFV38MjR1oN7TtgRv8tAZre9CGV9jYkGtT4Wnoju6Bauprme/ebOyErZbPi9XLfLnDoohwhHGc5WVSVhjCKM6rBMpYQpWJrIizfZ4IZNPxuTPqYrmd/m+EdONqPOfy8yG5rhxv0EMFHs52xvxWaHyd3tqD7+j37clWGGyh7vD+POiSrdZdWSIR49NrhR9R/teGTL8A',
            'RelayState' => 'https://pitbulk.no-ip.org/newonelogin/demo1/index.php',
            'SigAlg' => 'http://www.w3.org/2000/09/xmldsig#rsa-sha1',
            'Signature' => 'vfWbbc47PkP3ejx4bjKsRX7lo9Ml1WRoE5J5owF/0mnyKHfSY6XbhO1wwjBV5vWdrUVX+xp6slHyAf4YoAsXFS0qhan6txDiZY4Oec6yE+l10iZbzvie06I4GPak4QrQ4gAyXOSzwCrRmJu4gnpeUxZ6IqKtdrKfAYRAcVfNKGA='
        );

        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $_GET['SAMLResponse']);
        $this->assertTrue($response->isValid());

        $this->_settings->setStrict(true);
        $response2 = new OneLogin_Saml2_LogoutResponse($this->_settings, $_GET['SAMLResponse']);
        $this->assertFalse($response2->isValid());
        $this->assertContains('Invalid issuer in the Logout Response', $response2->getError());

        $this->_settings->setStrict(false);
        $oldSignature = $_GET['Signature'];
        $_GET['Signature'] = 'vfWbbc47PkP3ejx4bjKsRX7lo9Ml1WRoE5J5owF/0mnyKHfSY6XbhO1wwjBV5vWdrUVX+xp6slHyAf4YoAsXFS0qhan6txDiZY4Oec6yE+l10iZbzvie06I4GPak4QrQ4gAyXOSzwCrRmJu4gnpeUxZ6IqKtdrKfAYRAcVf3333=';
        $response3 = new OneLogin_Saml2_LogoutResponse($this->_settings, $_GET['SAMLResponse']);

        $this->assertFalse($response3->isValid());
        $this->assertEquals('Signature validation failed. Logout Response rejected', $response3->getError());

        $_GET['Signature'] = $oldSignature;
        $oldSigAlg = $_GET['SigAlg'];
        unset($_GET['SigAlg']);
        $response4 = new OneLogin_Saml2_LogoutResponse($this->_settings, $_GET['SAMLResponse']);
        $this->assertTrue($response4->isValid());

        $oldRelayState = $_GET['RelayState'];
        $_GET['RelayState'] = 'http://example.com/relaystate';
        $response5 = new OneLogin_Saml2_LogoutResponse($this->_settings, $_GET['SAMLResponse']);
        $this->assertFalse($response5->isValid());
        $this->assertEquals('Signature validation failed. Logout Response rejected', $response5->getError());

        $this->_settings->setStrict(true);

        $plainMessage6 = gzinflate(base64_decode($_GET['SAMLResponse']));
        $plainMessage6 = str_replace('https://pitbulk.no-ip.org/newonelogin/demo1/index.php?sls', $currentURL, $plainMessage6);
        $plainMessage6 = str_replace('https://pitbulk.no-ip.org/simplesaml/saml2/idp/metadata.php', 'http://idp.example.com/', $plainMessage6);
        $_GET['SAMLResponse'] = base64_encode(gzdeflate($plainMessage6));

        $response6 = new OneLogin_Saml2_LogoutResponse($this->_settings, $_GET['SAMLResponse']);
        $this->assertFalse($response6->isValid());
        $this->assertEquals('Signature validation failed. Logout Response rejected', $response6->getError());

        $this->_settings->setStrict(false);
        $response7 = new OneLogin_Saml2_LogoutResponse($this->_settings, $_GET['SAMLResponse']);
        $this->assertFalse($response7->isValid());
        $this->assertEquals('Signature validation failed. Logout Response rejected', $response7->getError());

        $_GET['SigAlg'] = 'http://www.w3.org/2000/09/xmldsig#dsa-sha1';
        $response8 = new OneLogin_Saml2_LogoutResponse($this->_settings, $_GET['SAMLResponse']);
        $this->assertFalse($response8->isValid());
        $this->assertEquals('Invalid signAlg in the recieved Logout Response', $response8->getError());

        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';
        $settingsInfo['strict'] = true;
        $settingsInfo['security']['wantMessagesSigned'] = true;

        $settings = new OneLogin_Saml2_Settings($settingsInfo);

        $_GET['SigAlg'] = $oldSigAlg;
        $oldSignature = $_GET['Signature'];
        unset($_GET['Signature']);
        $_GET['SAMLResponse'] = base64_encode(gzdeflate($plainMessage6));
        $response9 = new OneLogin_Saml2_LogoutResponse($settings, $_GET['SAMLResponse']);
        $this->assertFalse($response9->isValid());
        $this->assertEquals('The Message of the Logout Response is not signed and the SP requires it', $response9->getError());

        $_GET['Signature'] = $oldSignature;

        $settingsInfo['idp']['certFingerprint'] = 'afe71c28ef740bc87425be13a2263d37971da1f9';
        unset($settingsInfo['idp']['x509cert']);
        $settings2 = new OneLogin_Saml2_Settings($settingsInfo);

        $response10 = new OneLogin_Saml2_LogoutResponse($settings2, $_GET['SAMLResponse']);
        $this->assertFalse($response10->isValid());
        $this->assertEquals('In order to validate the sign on the Logout Response, the x509cert of the IdP is required', $response10->getError());
    }

    /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutResponse
    *
    * @covers OneLogin_Saml2_LogoutResponse::isValid
    */
    public function testIsValid()
    {
        $message = file_get_contents(TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64');
        $response = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);

        $this->assertTrue($response->isValid());

        $this->_settings->setStrict(true);
        $response2 = new OneLogin_Saml2_LogoutResponse($this->_settings, $message);
        $this->assertFalse($response2->isValid());
        $this->assertContains('The LogoutResponse was received at', $response2->getError());

        $plainMessage = gzinflate(base64_decode($message));
        $currentURL = OneLogin_Saml2_Utils::getSelfURLNoQuery();
        $plainMessage = str_replace('http://stuff.com/endpoints/endpoints/sls.php', $currentURL, $plainMessage);
        $message3 = base64_encode(gzdeflate($plainMessage));

        $response3 = new OneLogin_Saml2_LogoutResponse($this->_settings, $message3);
        $this->assertTrue($response3->isValid());
    }

    /**
    * Tests that a 'true' value for compress => responses gets honored when we
    * try to obtain the request payload from getResponse()
    *
    * @covers OneLogin_Saml2_LogoutResponse::getResponse()
    */
    public function testWeCanChooseToCompressAResponse()
    {
        //Test that we can compress.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $message = file_get_contents(
            TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64'
        );

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $logoutResponse = new OneLogin_Saml2_LogoutResponse($settings, $message);
        $payload = $logoutResponse->getResponse();
        $decoded = base64_decode($payload);
        $decompressed = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:LogoutResponse#', $decompressed);

    }

    /**
    * Tests that a 'false' value for compress => responses gets honored when we
    * try to obtain the request payload from getResponse()
    *
    * @covers OneLogin_Saml2_LogoutResponse::getResponse()
    */
    public function testWeCanChooseNotToCompressAResponse()
    {
        //Test that we can choose not to compress the request payload.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings2.php';

        $message = file_get_contents(
            TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64'
        );

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $logoutResponse = new OneLogin_Saml2_LogoutResponse($settings, $message);
        $payload = $logoutResponse->getResponse();
        $decoded = base64_decode($payload);
        $this->assertRegExp('#^<samlp:LogoutResponse#', $decoded);
    }

    public function testWeCanChooseToDeflateAResponseBody()
    {

        $message = file_get_contents(
            TEST_ROOT . '/data/logout_responses/logout_response_deflated.xml.base64'
        );

        //Test that we can choose not to compress the request payload.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';
        
        //Compression is currently turned on in settings.
        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $logoutResponse = new OneLogin_Saml2_LogoutResponse($settings, $message);
        $payload = $logoutResponse->getResponse(false);
        $decoded = base64_decode($payload);
        $this->assertRegExp('#^<samlp:LogoutResponse#', $decoded);

        //Test that we can choose not to compress the request payload.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings2.php';
        
        //Compression is currently turned on in settings.
        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $logoutResponse = new OneLogin_Saml2_LogoutResponse($settings, $message);
        $payload = $logoutResponse->getResponse(true);
        $decoded = base64_decode($payload);
        $decompressed = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:LogoutResponse#', $decompressed);
    }
}
