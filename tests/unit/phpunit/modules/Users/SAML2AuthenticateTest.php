<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once __DIR__ . '/../../../../../modules/Users/authentication/SAML2Authenticate/SAML2Authenticate.php';

class SAML2MetadataTest extends SuitePHPUnitFrameworkTestCase
{
    public function testEntryPointNoAuth()
    {
        $result = (new SugarController())->checkEntryPointRequiresAuth('SAML2Metadata');
        $this->assertFalse($result);
    }

    public function testIncompleteSettings()
    {
        // php-saml triggers deprecation warnings, so disable temporarily
        error_reporting(E_ALL & ~E_DEPRECATED);

        $failed = false;
        $settings = ['sp' => [], 'idp' => []];
        try {
            getSAML2Metadata($settings);
        } catch (Exception $e) {
            $failed = true;
        }

        $this->assertTrue($failed);
    }

    public function testMinimalValidExample()
    {
        $settings = [
            'sp' => [
                'entityId' => 'someid',
                'assertionConsumerService' => [
                    'url' => 'https://someurl',
                ],
            ],
            'idp' => [
                'entityId' => 'someotherid',
                'singleSignOnService' => [
                    'url' => 'https://localhost/foo',
                ],
            ],
        ];

        // php-saml triggers deprecation warnings, so disable temporarily
        error_reporting(E_ALL & ~E_DEPRECATED);
        $xml = getSAML2Metadata($settings);
        $this->assertNotEmpty($xml);
        $this->assertRegexp('/someid/', $xml);
        $this->assertRegexp('/someurl/', $xml);
        $this->assertNotFalse(simplexml_load_string($xml));
    }
}
