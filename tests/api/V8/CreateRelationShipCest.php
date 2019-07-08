<?php
namespace Test\Api\V8;

use ApiTester;

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
     * @throws \Exception
     */
    public function shouldWork(ApiTester $I)
    {
        $accountId = $I->createAccount();
        $contactId = $I->createContact();

        $linkName = 'contacts';

        $endpoint = $I->getInstanceURL() . '/Api/V8/module/Accounts/{id}/relationships/' . $linkName;
        $endpoint = str_replace('{id}', $accountId, $endpoint);

        $payload = [
            'data' => [
                'type' => 'Contacts',
                'id' => '{id}',
            ]
        ];
        $payload['data']['id'] = str_replace('{id}', $contactId, $payload['data']['id']);

        $I->sendPOST($endpoint, $payload);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.meta.message');
        $I->seeResponseContainsJson(
            [
                'message' => sprintf(
                    'Contact with id %s has been added to Account with id %s using link %s',
                    $contactId,
                    $accountId,
                    $linkName
                )
            ]
        );

        $I->deleteBean('accounts', $accountId);
        $I->deleteBean('contacts', $contactId);
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
    }
}
