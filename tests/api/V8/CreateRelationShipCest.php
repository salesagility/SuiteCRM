<?php
namespace Test\Api\V8;

use ApiTester;
use \Exception;

class CreateRelationShipCest
{
    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function _before(ApiTester $I)
    {
        $I->login();
    }

    /**
     * @param ApiTester $I
     *
     * @throws Exception
     */
    public function shouldWork(ApiTester $I)
    {
        $accountId = $I->createAccount();

        $contactId = $I->createContact();

        $linkName = 'contacts';

        $expectedMessage = sprintf(
            'Contact with id %s has been related to Account with id %s using link %s',
            $contactId,
            $accountId,
            $linkName
        );

        $endpoint = $I->getInstanceURL() . '/Api/V8/module/Accounts/{id}/relationships/{linkFieldName}';

        $endpoint = str_replace(
            [
                '{id}',
                '{linkFieldName}'
            ],
            [
                $accountId,
                $linkName
            ],
            $endpoint
        );

        $payload = [
            'data' => [
                'type' => 'Contacts',
                'id' => $contactId,
            ]
        ];

        $I->sendPOST($endpoint, $payload);

        $I->seeResponseCodeIs(201);

        $I->seeResponseIsJson();

        $responseJson = $I->grabResponse();

        $responseArray = json_decode($responseJson, true);

        $I->assertNotEmpty($responseArray);

        $I->assertArrayHasKey('meta', $responseArray);

        $I->assertNotEmpty($responseArray['meta']);

        $I->assertArrayHasKey('message', $responseArray['meta']);

        $I->assertNotEmpty($responseArray['meta']['message']);

        $I->assertEquals(
            $expectedMessage,
            $responseArray['meta']['message']
        );

        $I->deleteRelationship(
            [
                'tableName' => 'accounts_contacts',
                'sourceIdName' => 'account_id',
                'relatedIdName' => 'contact_id',
            ],
            [
                'sourceId' => $accountId,
                'relatedId' => $contactId,
            ]
        );

        $I->deleteBean('accounts', $accountId);

        $I->deleteBean('contacts', $contactId);
    }
}
