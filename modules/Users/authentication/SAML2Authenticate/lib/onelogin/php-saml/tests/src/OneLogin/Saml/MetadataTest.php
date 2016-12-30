<?php

/**
 * Unit tests for Metadata class
 */
class OneLogin_Saml_MetadataTest extends PHPUnit_Framework_TestCase
{
    /**
    * Tests the OneLogin_Saml_Metadata Constructor and the getXml method. 
    * Prepare the object to generate SAML Metadata (initialize settings)
    * and then generate the Metadata with the getXML method.
    *
    * @covers OneLogin_Saml_Metadata
    * @covers OneLogin_Saml_Metadata::getXml
    */
    public function testMetadata()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $metadata = new OneLogin_Saml_Metadata($settingsInfo);
        $xmlMetadata = $metadata->getXML();

        $this->assertNotEmpty($xmlMetadata);

        $dom = new DOMDocument();
        $dom->loadXML($xmlMetadata);

        $entityDescriptor = $dom->firstChild;
        $this->assertEquals('md:EntityDescriptor', $entityDescriptor->tagName);
        $this->assertTrue($entityDescriptor->hasAttribute('entityID'));
        $this->assertEquals('http://stuff.com/endpoints/metadata.php', $entityDescriptor->getAttribute('entityID'));
        $this->assertTrue($entityDescriptor->hasAttribute('validUntil'));
        $this->assertTrue($entityDescriptor->hasAttribute('cacheDuration'));

        $this->assertTrue(time() < strtotime($entityDescriptor->getAttribute('validUntil')));

        $sspSSONodes = $entityDescriptor->getElementsByTagName('SPSSODescriptor');
        $this->assertEquals(1, $sspSSONodes->length);
        $spSSODescriptor = $sspSSONodes->item(0);

        $this->assertTrue($spSSODescriptor->hasAttribute('AuthnRequestsSigned'));
        $this->assertEquals("false", $spSSODescriptor->getAttribute('AuthnRequestsSigned'));
        $this->assertTrue($spSSODescriptor->hasAttribute('WantAssertionsSigned'));
        $this->assertEquals("false", $spSSODescriptor->getAttribute('WantAssertionsSigned'));
        $this->assertTrue($spSSODescriptor->hasAttribute('protocolSupportEnumeration'));
        $this->assertEquals("urn:oasis:names:tc:SAML:2.0:protocol", $spSSODescriptor->getAttribute('protocolSupportEnumeration'));

        $nameIdNodes = $entityDescriptor->getElementsByTagName('NameIDFormat');
        $this->assertEquals(1, $nameIdNodes->length);
        $nameID = $nameIdNodes->item(0);
        
        $nameIdNodes = $entityDescriptor->getElementsByTagName('NameIDFormat');
        $this->assertEquals(1, $nameIdNodes->length);
        $nameID = $nameIdNodes->item(0);
        $this->assertEquals("urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified", $nameID->nodeValue);

        $assertionConsumerServiceNodes = $entityDescriptor->getElementsByTagName('AssertionConsumerService');
        $this->assertEquals(1, $assertionConsumerServiceNodes->length);
        $acs = $assertionConsumerServiceNodes->item(0);
        $this->assertTrue($acs->hasAttribute('Binding'));
        $this->assertEquals('urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST', $acs->getAttribute('Binding'));
        $this->assertTrue($acs->hasAttribute('Location'));
        $this->assertEquals('http://stuff.com/endpoints/endpoints/acs.php', $acs->getAttribute('Location'));
        $this->assertTrue($acs->hasAttribute('index'));
        $this->assertEquals('1', $acs->getAttribute('index'));

        $singleLogoutServiceNodes = $entityDescriptor->getElementsByTagName('SingleLogoutService');
        $this->assertEquals(1, $singleLogoutServiceNodes->length);
        $sls = $singleLogoutServiceNodes->item(0);
        $this->assertTrue($sls->hasAttribute('Binding'));
        $this->assertEquals('urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect', $sls->getAttribute('Binding'));
        $this->assertTrue($sls->hasAttribute('Location'));
        $this->assertEquals('http://stuff.com/endpoints/endpoints/sls.php', $sls->getAttribute('Location'));
    }

    /**
    * Tests the protected method _getMetadataValidTimestamp of the OneLogin_Saml_Metadata
    *
    * @covers OneLogin_Saml_Metadata::_getMetadataValidTimestamp
    */
    public function testGetMetadataValidTimestamp()
    {
        if (class_exists('ReflectionClass')) {
            $reflectionClass = new ReflectionClass("OneLogin_Saml_Metadata");
            $method = $reflectionClass->getMethod('_getMetadataValidTimestamp');

            if (method_exists($method, 'setAccessible')) {
                $method->setAccessible(true);

                $settingsDir = TEST_ROOT .'/settings/';
                include $settingsDir . 'settings1.php';

                $metadata = new OneLogin_Saml_Metadata($settingsInfo);

                $time = time()+ OneLogin_Saml_Metadata::VALIDITY_SECONDS;
                $validTimestamp = $method->invoke($metadata);
                $this->assertEquals(strtotime($validTimestamp), $time);
            }
        }
    }
}
