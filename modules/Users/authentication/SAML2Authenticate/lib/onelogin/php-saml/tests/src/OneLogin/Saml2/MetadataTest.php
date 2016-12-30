<?php

/**
 * Unit tests for Metadata class
 */
class OneLogin_Saml2_MetadataTest extends PHPUnit_Framework_TestCase
{

    /**
    * Tests the builder method of the OneLogin_Saml2_Metadata
    *
    * @covers OneLogin_Saml2_Metadata::builder
    */
    public function testBuilder()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $spData = $settings->getSPData();
        $security = $settings->getSecurityData();
        $organization = $settings->getOrganization();
        $contacts = $settings->getContacts();

        $metadata = OneLogin_Saml2_Metadata::builder($spData, $security['authnRequestsSigned'], $security['wantAssertionsSigned'], null, null, $contacts, $organization);

        $this->assertNotEmpty($metadata);

        $this->assertContains('<md:SPSSODescriptor', $metadata);
        $this->assertContains('entityID="http://stuff.com/endpoints/metadata.php"', $metadata);
        $this->assertContains('AuthnRequestsSigned="false"', $metadata);
        $this->assertContains('WantAssertionsSigned="false"', $metadata);

        $this->assertContains('<md:AssertionConsumerService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST"', $metadata);
        $this->assertContains('Location="http://stuff.com/endpoints/endpoints/acs.php"', $metadata);
        $this->assertContains('<md:SingleLogoutService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect"', $metadata);
        $this->assertContains('Location="http://stuff.com/endpoints/endpoints/sls.php"', $metadata);

        $this->assertContains('<md:NameIDFormat>urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified</md:NameIDFormat>', $metadata);

        $this->assertContains('<md:OrganizationName xml:lang="en-US">sp_test</md:OrganizationName>', $metadata);
        $this->assertContains('<md:ContactPerson contactType="technical">', $metadata);
        $this->assertContains('<md:GivenName>technical_name</md:GivenName>', $metadata);

        $security['authnRequestsSigned'] = true;
        $security['wantAssertionsSigned'] = true;
        unset($spData['singleLogoutService']);

        $metadata2 = OneLogin_Saml2_Metadata::builder($spData, $security['authnRequestsSigned'], $security['wantAssertionsSigned']);

        $this->assertNotEmpty($metadata2);

        $this->assertContains('AuthnRequestsSigned="true"', $metadata2);
        $this->assertContains('WantAssertionsSigned="true"', $metadata2);

        $this->assertNotContains('<md:SingleLogoutService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect"', $metadata2);
        $this->assertNotContains(' Location="http://stuff.com/endpoints/endpoints/sls.php"/>', $metadata2);
    }

    /**
    * Tests the builder method of the OneLogin_Saml2_Metadata
    *
    * @covers OneLogin_Saml2_Metadata::builder
    */
    public function testBuilderWithAttributeConsumingService()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings3.php';
        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $spData = $settings->getSPData();
        $security = $settings->getSecurityData();
        $organization = $settings->getOrganization();
        $contacts = $settings->getContacts();

        $metadata = OneLogin_Saml2_Metadata::builder($spData, $security['authnRequestsSigned'], $security['wantAssertionsSigned'], null, null, $contacts, $organization);

        $this->assertContains('<md:ServiceName xml:lang="en">Service Name</md:ServiceName>', $metadata);
        $this->assertContains('<md:ServiceDescription xml:lang="en">Service Description</md:ServiceDescription>', $metadata);
        $this->assertContains('<md:RequestedAttribute Name="FirstName" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:uri" isRequired="true" />', $metadata);
        $this->assertContains('<md:RequestedAttribute Name="LastName" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:uri" isRequired="true" />', $metadata);

        $result = \OneLogin_Saml2_Utils::validateXML($metadata, 'saml-schema-metadata-2.0.xsd');
        $this->assertInstanceOf('DOMDocument', $result);
    }

    /**
    * Tests the builder method of the OneLogin_Saml2_Metadata
    *
    * @covers OneLogin_Saml2_Metadata::builder
    */
    public function testBuilderWithAttributeConsumingServiceWithMultipleAttributeValue()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings4.php';
        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $spData = $settings->getSPData();
        $security = $settings->getSecurityData();
        $organization = $settings->getOrganization();
        $contacts = $settings->getContacts();

        $metadata = OneLogin_Saml2_Metadata::builder($spData, $security['authnRequestsSigned'], $security['wantAssertionsSigned'], null, null, $contacts, $organization);

        $this->assertContains('<md:ServiceName xml:lang="en">Service Name</md:ServiceName>', $metadata);
        $this->assertContains('<md:ServiceDescription xml:lang="en">Service Description</md:ServiceDescription>', $metadata);
        $this->assertContains('<md:RequestedAttribute Name="urn:oid:0.9.2342.19200300.100.1.1" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:uri" FriendlyName="uid" isRequired="true" />', $metadata);
        $this->assertContains('<saml:AttributeValue xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion">userType</saml:AttributeValue>', $metadata);
        $this->assertContains('<saml:AttributeValue xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion">admin</saml:AttributeValue>', $metadata);

        $result = \OneLogin_Saml2_Utils::validateXML($metadata, 'saml-schema-metadata-2.0.xsd');
        $this->assertInstanceOf('DOMDocument', $result);
    }

    /**
    * Tests the signMetadata method of the OneLogin_Saml2_Metadata
    *
    * @covers OneLogin_Saml2_Metadata::signMetadata
    */
    public function testSignMetadata()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $spData = $settings->getSPData();
        $security = $settings->getSecurityData();

        $metadata = OneLogin_Saml2_Metadata::builder($spData, $security['authnRequestsSigned'], $security['wantAssertionsSigned']);

        $this->assertNotEmpty($metadata);

        $certPath = $settings->getCertPath();
        $key = file_get_contents($certPath.'sp.key');
        $cert = file_get_contents($certPath.'sp.crt');

        $signedMetadata = OneLogin_Saml2_Metadata::signMetadata($metadata, $key, $cert);

        $this->assertContains('<md:SPSSODescriptor', $signedMetadata);
        $this->assertContains('entityID="http://stuff.com/endpoints/metadata.php"', $signedMetadata);
        $this->assertContains('AuthnRequestsSigned="false"', $signedMetadata);
        $this->assertContains('WantAssertionsSigned="false"', $signedMetadata);

        $this->assertContains('<md:AssertionConsumerService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST"', $signedMetadata);
        $this->assertContains('Location="http://stuff.com/endpoints/endpoints/acs.php"', $signedMetadata);
        $this->assertContains('<md:SingleLogoutService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect"', $signedMetadata);
        $this->assertContains(' Location="http://stuff.com/endpoints/endpoints/sls.php"/>', $signedMetadata);

        $this->assertContains('<md:NameIDFormat>urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified</md:NameIDFormat>', $signedMetadata);

        $this->assertContains('<ds:SignedInfo><ds:CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/>', $signedMetadata);
        $this->assertContains('<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>', $signedMetadata);
        $this->assertContains('<ds:Reference', $signedMetadata);
        $this->assertContains('<ds:KeyInfo><ds:X509Data><ds:X509Certificate>', $signedMetadata);

        try {
            $signedMetadata2 = OneLogin_Saml2_Metadata::signMetadata('', $key, $cert);
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('Empty string supplied as input', $e->getMessage());
        }
    }

    /**
    * Tests the addX509KeyDescriptors method of the OneLogin_Saml2_Metadata
    *
    * @covers OneLogin_Saml2_Metadata::addX509KeyDescriptors
    */
    public function testAddX509KeyDescriptors()
    {
        $settingsDir = TEST_ROOT .'/settings/';
        include $settingsDir . 'settings1.php';

        $settings = new OneLogin_Saml2_Settings($settingsInfo);
        $spData = $settings->getSPData();

        $metadata = OneLogin_Saml2_Metadata::builder($spData);

        $this->assertNotContains('<md:KeyDescriptor use="signing"', $metadata);
        $this->assertNotContains('<md:KeyDescriptor use="encryption"', $metadata);

        $certPath = $settings->getCertPath();
        $cert = file_get_contents($certPath.'sp.crt');

        $metadataWithDescriptors = OneLogin_Saml2_Metadata::addX509KeyDescriptors($metadata, $cert);

        $this->assertContains('<md:KeyDescriptor use="signing"', $metadataWithDescriptors);
        $this->assertContains('<md:KeyDescriptor use="encryption"', $metadataWithDescriptors);

        $metadataWithDescriptors = OneLogin_Saml2_Metadata::addX509KeyDescriptors($metadata, $cert, false);

        $this->assertContains('<md:KeyDescriptor use="signing"', $metadataWithDescriptors);
        $this->assertNotContains('<md:KeyDescriptor use="encryption"', $metadataWithDescriptors);

        $metadataWithDescriptors = OneLogin_Saml2_Metadata::addX509KeyDescriptors($metadata, $cert, 'foobar');

        $this->assertContains('<md:KeyDescriptor use="signing"', $metadataWithDescriptors);
        $this->assertNotContains('<md:KeyDescriptor use="encryption"', $metadataWithDescriptors);

        try {
            $signedMetadata2 = OneLogin_Saml2_Metadata::addX509KeyDescriptors('', $cert);
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('Error parsing metadata', $e->getMessage());
        }

        libxml_use_internal_errors(true);
        $unparsedMetadata = file_get_contents(TEST_ROOT . '/data/metadata/unparsed_metadata.xml');
        try {
            $metadataWithDescriptors = OneLogin_Saml2_Metadata::addX509KeyDescriptors($unparsedMetadata, $cert);
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertContains('Error parsing metadata', $e->getMessage());
        }
    }
}
