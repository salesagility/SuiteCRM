<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once __DIR__ . '/../../../../../modules/Users/authentication/SAML2Authenticate/SAML2Authenticate.php';

/**
 * Class SAML2MetadataTest
 */
class SAML2MetadataTest extends SuitePHPUnitFrameworkTestCase
{
    public function testEntryPointNoAuth(): void
    {
        $result = (new SugarController())->checkEntryPointRequiresAuth('SAML2Metadata');
        self::assertFalse($result);
    }

    public function testIncompleteSettings(): void
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

        self::assertTrue($failed);
    }

    public function testMinimalValidExample(): void
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
                'x509cert' => 'test',
            ],
        ];

        // php-saml triggers deprecation warnings, so disable temporarily
        error_reporting(E_ALL & ~E_DEPRECATED);
        $xml = getSAML2Metadata($settings);
        self::assertNotEmpty($xml);
        self::assertRegexp('/someid/', $xml);
        self::assertRegexp('/someurl/', $xml);
        self::assertNotFalse(simplexml_load_string($xml));
    }
}
