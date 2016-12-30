<?php

/**
 * Unit tests for Logout Request
 */
class OneLogin_Saml2_LogoutRequestTest extends PHPUnit_Framework_TestCase
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
    * Tests the OneLogin_Saml2_LogoutRequest Constructor.
    *
    * @covers OneLogin_Saml2_LogoutRequest
    */
    public function testConstructor()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settingsInfo['security']['nameIdEncrypted'] = true;

        $settings = new OneLogin_Saml2_Settings($settingsInfo);

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($settings);

        $parameters = array('SAMLRequest' => $logoutRequest->getRequest());
        $logoutUrl = OneLogin_Saml2_Utils::redirect('http://idp.example.com/SingleLogoutService.php', $parameters, true);
        $this->assertRegExp('#^http://idp\.example\.com\/SingleLogoutService\.php\?SAMLRequest=#', $logoutUrl);
        parse_str(parse_url($logoutUrl, PHP_URL_QUERY), $exploded);
        // parse_url already urldecode de params so is not required.
        $payload = $exploded['SAMLRequest'];
        $decoded = base64_decode($payload);
        $inflated = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:LogoutRequest#', $inflated);
    }

    /**
    * Tests the OneLogin_Saml2_LogoutRequest Constructor.
    *
    * @covers OneLogin_Saml2_LogoutRequest
    */
    public function testConstructorWithRequest()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);

        $encodedDeflatedRequest = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request_deflated.xml.base64');

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($settings, $encodedDeflatedRequest);

        $parameters = array('SAMLRequest' => $logoutRequest->getRequest());
        $logoutUrl = OneLogin_Saml2_Utils::redirect('http://idp.example.com/SingleLogoutService.php', $parameters, true);
        $this->assertRegExp('#^http://idp\.example\.com\/SingleLogoutService\.php\?SAMLRequest=#', $logoutUrl);
        parse_str(parse_url($logoutUrl, PHP_URL_QUERY), $exploded);
        // parse_url already urldecode de params so is not required.
        $payload = $exploded['SAMLRequest'];
        $decoded = base64_decode($payload);
        $inflated = gzinflate($decoded);
        $this->assertRegExp('#<samlp:LogoutRequest#', $inflated);
    }

    /**
    * Tests the OneLogin_Saml2_LogoutRequest Constructor.
    *
    * @covers OneLogin_Saml2_LogoutRequest
    */
    public function testConstructorWithSessionIndex()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $sessionIndex = '_51be37965feb5579d803141076936dc2e9d1d98ebf';
        $settings = new OneLogin_Saml2_Settings($settingsInfo);

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($settings, null, null, $sessionIndex);

        $parameters = array('SAMLRequest' => $logoutRequest->getRequest());
        $logoutUrl = OneLogin_Saml2_Utils::redirect('http://idp.example.com/SingleLogoutService.php', $parameters, true);
        $this->assertRegExp('#^http://idp\.example\.com\/SingleLogoutService\.php\?SAMLRequest=#', $logoutUrl);
        parse_str(parse_url($logoutUrl, PHP_URL_QUERY), $exploded);
        // parse_url already urldecode de params so is not required.
        $payload = $exploded['SAMLRequest'];
        $decoded = base64_decode($payload);
        $inflated = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:LogoutRequest#', $inflated);

        $sessionIndexes = OneLogin_Saml2_LogoutRequest::getSessionIndexes($inflated);
        $this->assertInternalType('array', $sessionIndexes);
        $this->assertEquals(array($sessionIndex), $sessionIndexes);
    }

    /**
    * Tests the OneLogin_Saml2_LogoutRequest Constructor.
    *
    * @covers OneLogin_Saml2_LogoutRequest
    */
    public function testConstructorWithNameIdFormat()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $nameId = 'test@example.com';
        $nameIdFormat = 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient';
        $settings = new OneLogin_Saml2_Settings($settingsInfo);

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($settings, null, $nameId, null, $nameIdFormat);

        $parameters = array('SAMLRequest' => $logoutRequest->getRequest());
        $logoutUrl = OneLogin_Saml2_Utils::redirect('http://idp.example.com/SingleLogoutService.php', $parameters, true);
        $this->assertRegExp('#^http://idp\.example\.com\/SingleLogoutService\.php\?SAMLRequest=#', $logoutUrl);
        parse_str(parse_url($logoutUrl, PHP_URL_QUERY), $exploded);
        // parse_url already urldecode de params so is not required.
        $payload = $exploded['SAMLRequest'];
        $decoded = base64_decode($payload);
        $inflated = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:LogoutRequest#', $inflated);

        $logoutNameId = OneLogin_Saml2_LogoutRequest::getNameId($inflated);
        $this->assertEquals($nameId, $logoutNameId);

        $logoutNameIdData = OneLogin_Saml2_LogoutRequest::getNameIdData($inflated);
        $this->assertEquals($nameIdFormat, $logoutNameIdData['Format']);
    }

    /**
    * Tests the OneLogin_Saml2_LogoutRequest Constructor.
    * The creation of a deflated SAML Logout Request
    *
    * @covers OneLogin_Saml2_LogoutRequest
    */
    public function testCreateDeflatedSAMLLogoutRequestURLParameter()
    {
        $logoutRequest = new OneLogin_Saml2_LogoutRequest($this->_settings);

        $parameters = array('SAMLRequest' => $logoutRequest->getRequest());
        $logoutUrl = OneLogin_Saml2_Utils::redirect('http://idp.example.com/SingleLogoutService.php', $parameters, true);
        $this->assertRegExp('#^http://idp\.example\.com\/SingleLogoutService\.php\?SAMLRequest=#', $logoutUrl);
        parse_str(parse_url($logoutUrl, PHP_URL_QUERY), $exploded);
        // parse_url already urldecode de params so is not required.
        $payload = $exploded['SAMLRequest'];
        $decoded = base64_decode($payload);
        $inflated = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:LogoutRequest#', $inflated);
    }

    /**
    * Tests the getID method of the OneLogin_Saml2_LogoutRequest
    *
    * @covers OneLogin_Saml2_LogoutRequest::getID
    */
    public function testGetIDFromSAMLLogoutRequest()
    {
        $logoutRequest = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request.xml');
        $id = OneLogin_Saml2_LogoutRequest::getID($logoutRequest);
        $this->assertEquals('ONELOGIN_21584ccdfaca36a145ae990442dcd96bfe60151e', $id);

        $dom = new DOMDocument;
        $dom->loadXML($logoutRequest);
        $id2 = OneLogin_Saml2_LogoutRequest::getID($dom);
        $this->assertEquals('ONELOGIN_21584ccdfaca36a145ae990442dcd96bfe60151e', $id2);
    }

    /**
    * Tests the getID method of the OneLogin_Saml2_LogoutRequest
    *
    * @covers OneLogin_Saml2_LogoutRequest::getID
    */
    public function testGetIDFromDeflatedSAMLLogoutRequest()
    {
        $deflatedLogoutRequest = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request_deflated.xml.base64');
        $decoded = base64_decode($deflatedLogoutRequest);
        $logoutRequest = gzinflate($decoded);
        $id = OneLogin_Saml2_LogoutRequest::getID($logoutRequest);
        $this->assertEquals('ONELOGIN_21584ccdfaca36a145ae990442dcd96bfe60151e', $id);
    }

    /**
    * Tests the getNameIdData method of the OneLogin_Saml2_LogoutRequest
    *
    * @covers OneLogin_Saml2_LogoutRequest::getNameIdData
    */
    public function testGetNameIdData()
    {
        $expectedNameIdData = array (
            'Value' => 'ONELOGIN_1e442c129e1f822c8096086a1103c5ee2c7cae1c',
            'Format' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
            'SPNameQualifier' => 'http://idp.example.com/'
        );

        $request = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request.xml');

        $nameIdData = OneLogin_Saml2_LogoutRequest::getNameIdData($request);

        $this->assertEquals($expectedNameIdData, $nameIdData);

        $dom = new DOMDocument();
        $dom->loadXML($request);
        $nameIdData2 = OneLogin_Saml2_LogoutRequest::getNameIdData($dom);
        $this->assertEquals($expectedNameIdData, $nameIdData2);

        $request2 = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request_encrypted_nameid.xml');

        try {
            $nameIdData3 = OneLogin_Saml2_LogoutRequest::getNameIdData($request2);
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('Key is required in order to decrypt the NameID', $e->getMessage());
        }

        $key = $this->_settings->getSPkey();
        $nameIdData4 = OneLogin_Saml2_LogoutRequest::getNameIdData($request2, $key);

        $expectedNameIdData = array (
            'Value' => 'ONELOGIN_9c86c4542ab9d6fce07f2f7fd335287b9b3cdf69',
            'Format' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:emailAddress',
            'SPNameQualifier' => 'https://pitbulk.no-ip.org/newonelogin/demo1/metadata.php'
        );

        $this->assertEquals($expectedNameIdData, $nameIdData4);

        $invRequest = file_get_contents(TEST_ROOT . '/data/logout_requests/invalids/no_nameId.xml');
        try {
            $nameIdData3 = OneLogin_Saml2_LogoutRequest::getNameIdData($invRequest);
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('Not NameID found in the Logout Request', $e->getMessage());
        }

    }

    /**
    * Tests the getNameIdmethod of the OneLogin_Saml2_LogoutRequest
    *
    * @covers OneLogin_Saml2_LogoutRequest::getNameId
    */
    public function testGetNameId()
    {
        $request = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request.xml');

        $nameId = OneLogin_Saml2_LogoutRequest::getNameId($request);
        $this->assertEquals('ONELOGIN_1e442c129e1f822c8096086a1103c5ee2c7cae1c', $nameId);

        $request2 = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request_encrypted_nameid.xml');
        try {
            $nameId2 = OneLogin_Saml2_LogoutRequest::getNameId($request2);
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('Key is required in order to decrypt the NameID', $e->getMessage());
        }
        $key = $this->_settings->getSPkey();
        $nameId3 = OneLogin_Saml2_LogoutRequest::getNameId($request2, $key);
        $this->assertEquals('ONELOGIN_9c86c4542ab9d6fce07f2f7fd335287b9b3cdf69', $nameId3);
    }

    /**
    * Tests the getIssuer of the OneLogin_Saml2_LogoutRequest
    *
    * @covers OneLogin_Saml2_LogoutRequest::getIssuer
    */
    public function testGetIssuer()
    {
        $request = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request.xml');

        $issuer = OneLogin_Saml2_LogoutRequest::getIssuer($request);
        $this->assertEquals('http://idp.example.com/', $issuer);

        $dom = new DOMDocument();
        $dom->loadXML($request);
        $issuer2 = OneLogin_Saml2_LogoutRequest::getIssuer($dom);
        $this->assertEquals('http://idp.example.com/', $issuer2);
    }

    /**
    * Tests the getSessionIndexes of the OneLogin_Saml2_LogoutRequest
    *
    * @covers OneLogin_Saml2_LogoutRequest::getSessionIndexes
    */
    public function testGetSessionIndexes()
    {
        $request = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request.xml');

        $sessionIndexes = OneLogin_Saml2_LogoutRequest::getSessionIndexes($request);
        $this->assertEmpty($sessionIndexes);

        $dom = new DOMDocument();
        $dom->loadXML($request);
        $sessionIndexes = OneLogin_Saml2_LogoutRequest::getSessionIndexes($dom);
        $this->assertEmpty($sessionIndexes);

        $request2 = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request_with_sessionindex.xml');
        $sessionIndexes2 = OneLogin_Saml2_LogoutRequest::getSessionIndexes($request2);
        $this->assertEquals(array('_ac72a76526cb6ca19f8438e73879a0e6c8ae5131'), $sessionIndexes2);
    }

    /**
    * Tests the getError method of the OneLogin_Saml2_LogoutRequest
    *
    * @covers OneLogin_Saml2_LogoutRequest::getError
    */
    public function testGetError()
    {
        $request = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request.xml');

        $deflatedRequest = gzdeflate($request);
        $encodedRequest = base64_encode($deflatedRequest);

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);

        $this->assertNull($logoutRequest->getError());

        $this->assertTrue($logoutRequest->isValid());
        $this->assertNull($logoutRequest->getError());

        $this->_settings->setStrict(true);
        $logoutRequest2 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);

        $this->assertFalse($logoutRequest2->isValid());
        $this->assertContains('The LogoutRequest was received at', $logoutRequest2->getError());
    }

    /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutRequest
    * Case Invalid Issuer
    *
    * @covers OneLogin_Saml2_LogoutRequest::isValid
    */
    public function testIsInvalidIssuer()
    {
        $request = file_get_contents(TEST_ROOT . '/data/logout_requests/invalids/invalid_issuer.xml');
        $currentURL = OneLogin_Saml2_Utils::getSelfURLNoQuery();
        $request = str_replace('http://stuff.com/endpoints/endpoints/sls.php', $currentURL, $request);

        $deflatedRequest = gzdeflate($request);
        $encodedRequest = base64_encode($deflatedRequest);

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);
        $this->assertTrue($logoutRequest->isValid());

        $this->_settings->setStrict(true);
        $logoutRequest2 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);

        $this->assertFalse($logoutRequest2->isValid());
        $this->assertContains('Invalid issuer in the Logout Request', $logoutRequest2->getError());
    }

    /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutRequest
    * Case invalid xml
    *
    * @covers OneLogin_Saml2_LogoutRequest::isValid
    */
    public function testIsInValidWrongXML()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settingsInfo['security']['wantXMLValidation'] = false;

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $settings->setStrict(false);

        $message = file_get_contents(TEST_ROOT . '/data/logout_requests/invalids/invalid_xml.xml.base64');
        $response = new OneLogin_Saml2_LogoutRequest($settings, $message);

        $this->assertTrue($response->isValid());

        $settings->setStrict(true);
        $response2 = new OneLogin_Saml2_LogoutRequest($settings, $message);
        $response2->isValid();
        $this->assertNotEquals('Invalid SAML Logout Request. Not match the saml-schema-protocol-2.0.xsd', $response2->getError());

        $settingsInfo['security']['wantXMLValidation'] = true;
        $settings2 = new OneLogin_Saml2_Settings($settingsInfo);
        $settings2->setStrict(false);
        $response3 = new OneLogin_Saml2_LogoutRequest($settings2, $message);
        $this->assertTrue($response3->isValid());

        $settings2->setStrict(true);
        $response4 = new OneLogin_Saml2_LogoutRequest($settings2, $message);
        $this->assertFalse($response4->isValid());
        $this->assertEquals('Invalid SAML Logout Request. Not match the saml-schema-protocol-2.0.xsd', $response4->getError());
    }

    /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutRequest
    * Case Invalid Destination
    *
    * @covers OneLogin_Saml2_LogoutRequest::isValid
    */
    public function testIsInvalidDestination()
    {
        $request = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request.xml');

        $deflatedRequest = gzdeflate($request);
        $encodedRequest = base64_encode($deflatedRequest);

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);
        $this->assertTrue($logoutRequest->isValid());

        $this->_settings->setStrict(true);
        $logoutRequest2 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);

        $this->assertFalse($logoutRequest2->isValid());
        $this->assertContains('The LogoutRequest was received at', $logoutRequest2->getError());
    }

    /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutRequest
    * Case Invalid NotOnOrAfter
    *
    * @covers OneLogin_Saml2_LogoutRequest::isValid
    */
    public function testIsInvalidNotOnOrAfter()
    {
        $request = file_get_contents(TEST_ROOT . '/data/logout_requests/invalids/not_after_failed.xml');
        $currentURL = OneLogin_Saml2_Utils::getSelfURLNoQuery();
        $request = str_replace('http://stuff.com/endpoints/endpoints/sls.php', $currentURL, $request);

        $deflatedRequest = gzdeflate($request);
        $encodedRequest = base64_encode($deflatedRequest);

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);
        $this->assertTrue($logoutRequest->isValid());

        $this->_settings->setStrict(true);
        $logoutRequest2 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);

        $this->assertFalse($logoutRequest2->isValid());
        $this->assertEquals('Timing issues (please check your clock settings)', $logoutRequest2->getError());
    }

    /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutRequest
    *
    * @covers OneLogin_Saml2_LogoutRequest::isValid
    */
    public function testIsValid()
    {
        $request = file_get_contents(TEST_ROOT . '/data/logout_requests/logout_request.xml');

        $deflatedRequest = gzdeflate($request);
        $encodedRequest = base64_encode($deflatedRequest);

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);
        $this->assertTrue($logoutRequest->isValid());

        $this->_settings->setStrict(true);
        $logoutRequest2 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);
        $this->assertFalse($logoutRequest2->isValid());

        $this->_settings->setStrict(false);
        $logoutRequest3 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);

        $currentURL = OneLogin_Saml2_Utils::getSelfURLNoQuery();
        $request2 = str_replace('http://stuff.com/endpoints/endpoints/sls.php', $currentURL, $request);

        $deflatedRequest2 = gzdeflate($request2);
        $encodedRequest2 = base64_encode($deflatedRequest2);
        $logoutRequest4 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest2);
        $this->assertTrue($logoutRequest4->isValid());
    }

    /**
    * Tests that a 'true' value for compress => requests gets honored when we
    * try to obtain the request payload from getRequest()
    *
    * @covers OneLogin_Saml2_LogoutRequest::getRequest()
    */
    public function testWeCanChooseToCompressARequest()
    {
        //Test that we can compress.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $logoutRequest = new OneLogin_Saml2_LogoutRequest($settings);
        $payload = $logoutRequest->getRequest();
        $decoded = base64_decode($payload);
        $decompressed = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:LogoutRequest#', $decompressed);

    }

    /**
    * Tests that a 'false' value for compress => requests gets honored when we
    * try to obtain the request payload from getRequest()
    *
    * @covers OneLogin_Saml2_LogoutRequest::getRequest()
    */
    public function testWeCanChooseNotToCompressARequest()
    {
        //Test that we can choose not to compress the request payload.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings2.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $logoutRequest = new OneLogin_Saml2_LogoutRequest($settings);
        $payload = $logoutRequest->getRequest();
        $decoded = base64_decode($payload);
        $this->assertRegExp('#^<samlp:LogoutRequest#', $decoded);
    }

    /**
     * Tests that we can pass a boolean value to the getRequest()
     * method to choose whether it should 'gzdeflate' the body
     * of the request.
     *
     * @covers OneLogin_Saml2_LogoutRequest::getRequest()
     */
    public function testWeCanChooseToDeflateARequestBody()
    {
        //Test that we can choose not to compress the request payload.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        //Compression is currently turned on in settings.
        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $logoutRequest = new OneLogin_Saml2_LogoutRequest($settings);
        $payload = $logoutRequest->getRequest(false);
        $decoded = base64_decode($payload);
        $this->assertRegExp('#^<samlp:LogoutRequest#', $decoded);

        //Test that we can choose not to compress the request payload.
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings2.php';

        //Compression is currently turned off in settings.
        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $logoutRequest = new OneLogin_Saml2_LogoutRequest($settings);
        $payload = $logoutRequest->getRequest(true);
        $decoded = base64_decode($payload);
        $decompressed = gzinflate($decoded);
        $this->assertRegExp('#^<samlp:LogoutRequest#', $decompressed);
    }

    /**
    * Tests the isValid method of the OneLogin_Saml2_LogoutRequest
    *
    * @covers OneLogin_Saml2_LogoutRequest::isValid
    */
    public function testIsInValidSign()
    {
        $currentURL = OneLogin_Saml2_Utils::getSelfURLNoQuery();

        $this->_settings->setStrict(false);
        $_GET = array (
            'SAMLRequest' => 'lVLBitswEP0Vo7tjeWzJtki8LIRCYLvbNksPewmyPc6K2pJqyXQ/v1LSQlroQi/DMJr33rwZbZ2cJysezNms/gt+X9H55G2etBOXlx1ZFy2MdMoJLWd0wvfieP/xQcCGCrsYb3ozkRvI+wjpHC5eGU2Sw35HTg3lA8hqZFwWFcMKsStpxbEsxoLXeQN9OdY1VAgk+YqLC8gdCUQB7tyKB+281D6UaF6mtEiBPudcABcMXkiyD26Ulv6CevXeOpFlVvlunb5ttEmV3ZjlnGn8YTRO5qx0NuBs8kzpAd829tXeucmR5NH4J/203I8el6gFRUqbFPJnyEV51Wq30by4TLW0/9ZyarYTxt4sBsjUYLMZvRykl1Fxm90SXVkfwx4P++T4KSafVzmpUcVJ/sfSrQZJPphllv79W8WKGtLx0ir8IrVTqD1pT2MH3QAMSs4KTvui71jeFFiwirOmprwPkYW063+5uRq4urHiiC4e8hCX3J5wqAEGaPpw9XB5JmkBdeDqSlkz6CmUXdl0Qae5kv2F/1384wu3PwE=',
            'RelayState' => '_1037fbc88ec82ce8e770b2bed1119747bb812a07e6',
            'SigAlg' => 'http://www.w3.org/2000/09/xmldsig#rsa-sha1',
            'Signature' => 'XCwCyI5cs7WhiJlB5ktSlWxSBxv+6q2xT3c8L7dLV6NQG9LHWhN7gf8qNsahSXfCzA0Ey9dp5BQ0EdRvAk2DIzKmJY6e3hvAIEp1zglHNjzkgcQmZCcrkK9Czi2Y1WkjOwR/WgUTUWsGJAVqVvlRZuS3zk3nxMrLH6f7toyvuJc='
        );

        $request = gzinflate(base64_decode($_GET['SAMLRequest']));
        $encodedRequest = $_GET['SAMLRequest'];

        $logoutRequest = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);
        $this->assertTrue($logoutRequest->isValid());

        $this->_settings->setStrict(true);
        $logoutRequest2 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);

        $this->assertFalse($logoutRequest2->isValid());
        $this->assertContains('The LogoutRequest was received at', $logoutRequest2->getError());

        $this->_settings->setStrict(false);
        $oldSignature = $_GET['Signature'];
        $_GET['Signature'] = 'vfWbbc47PkP3ejx4bjKsRX7lo9Ml1WRoE5J5owF/0mnyKHfSY6XbhO1wwjBV5vWdrUVX+xp6slHyAf4YoAsXFS0qhan6txDiZY4Oec6yE+l10iZbzvie06I4GPak4QrQ4gAyXOSzwCrRmJu4gnpeUxZ6IqKtdrKfAYRAcVf3333=';

        $logoutRequest3 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest);

        $this->assertFalse($logoutRequest3->isValid());
        $this->assertContains('Signature validation failed. Logout Request rejected', $logoutRequest3->getError());

        $_GET['Signature'] = $oldSignature;
        $oldSigAlg = $_GET['SigAlg'];
        unset($_GET['SigAlg']);

        $this->assertTrue($logoutRequest3->isValid());

        $oldRelayState = $_GET['RelayState'];
        $_GET['RelayState'] = 'http://example.com/relaystate';

        $this->assertFalse($logoutRequest3->isValid());
        $this->assertContains('Signature validation failed. Logout Request rejected', $logoutRequest3->getError());

        $this->_settings->setStrict(true);

        $request2 = str_replace('https://pitbulk.no-ip.org/newonelogin/demo1/index.php?sls', $currentURL, $request);
        $request2 = str_replace('https://pitbulk.no-ip.org/simplesaml/saml2/idp/metadata.php', 'http://idp.example.com/', $request2);

        $deflatedRequest2 = gzdeflate($request2);
        $encodedRequest2 = base64_encode($deflatedRequest2);

        $_GET['SAMLRequest'] = $encodedRequest2;
        $logoutRequest4 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest2);

        $this->assertFalse($logoutRequest4->isValid());
        $this->assertEquals('Signature validation failed. Logout Request rejected', $logoutRequest4->getError());

        $this->_settings->setStrict(false);
        $logoutRequest5 = new OneLogin_Saml2_LogoutRequest($this->_settings, $encodedRequest2);

        $this->assertFalse($logoutRequest5->isValid());
        $this->assertEquals('Signature validation failed. Logout Request rejected', $logoutRequest5->getError());


        $_GET['SigAlg'] = 'http://www.w3.org/2000/09/xmldsig#dsa-sha1';

        $this->assertFalse($logoutRequest5->isValid());
        $this->assertEquals('Invalid signAlg in the recieved Logout Request', $logoutRequest5->getError());

        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';
        $settingsInfo['strict'] = true;
        $settingsInfo['security']['wantMessagesSigned'] = true;

        $settings = new OneLogin_Saml2_Settings($settingsInfo);

        $_GET['SigAlg'] = $oldSigAlg;
        $oldSignature = $_GET['Signature'];
        unset($_GET['Signature']);
        $logoutRequest6 = new OneLogin_Saml2_LogoutRequest($settings, $encodedRequest2);

        $this->assertFalse($logoutRequest6->isValid());
        $this->assertEquals('The Message of the Logout Request is not signed and the SP require it', $logoutRequest6->getError());

        $_GET['Signature'] = $oldSignature;

        $settingsInfo['idp']['certFingerprint'] = 'afe71c28ef740bc87425be13a2263d37971da1f9';
        unset($settingsInfo['idp']['x509cert']);
        $settings2 = new OneLogin_Saml2_Settings($settingsInfo);
        $logoutRequest7 = new OneLogin_Saml2_LogoutRequest($settings2, $encodedRequest2);

        $this->assertFalse($logoutRequest7->isValid());
        $this->assertContains('In order to validate the sign on the Logout Request, the x509cert of the IdP is required', $logoutRequest7->getError());
    }
}
