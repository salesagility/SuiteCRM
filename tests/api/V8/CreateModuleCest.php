<?php
namespace Test\Api\V8;

use apiTester;
use Codeception\Example;

class CreateModuleCest
{
    /**
     * @param apiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function _before(ApiTester $I)
    {
        $I->login();
    }

    /**
     * @param apiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     * @throws \Exception
     */
    public function shouldWork(ApiTester $I)
    {
        $id = create_guid();
        $endpoint = $I->getInstanceURL() . '/Api/V8/module';
        $payload = [
            'data' => [
                'type' => 'Accounts',
                'id' => $id,
                'attributes' => [
                    'name' => 'testName',
                    'account_type' => 'testAccountType'
                ]
            ]
        ];

        $I->sendPOST($endpoint, $payload);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'type' => \Account::class,
            'id' => $id
        ]);
        $I->assertGreaterThanOrEqual(2, count($I->grabDataFromResponseByJsonPath('$.data.attributes')[0]));

        $I->deleteAccount($id);
    }

    /**
     * @param apiTester $I
     * @param Example $example
     *
     * @dataProvider shouldNotWorkDataProvider
     * @throws \Exception
     */
    public function shouldNotWork(ApiTester $I, Example $example)
    {
        /** @var \ArrayIterator $iterator */
        $iterator = $example->getIterator();
        $endpoint = $I->getInstanceURL() . '/Api/V8/module';
        $payload = $iterator->offsetGet('payload');
        $expectedResult = [
            'errors' => [
                'status' => 400,
                'title' => null,
                'detail' => $iterator->offsetGet('detail')
            ]
        ];

        $I->sendPOST($endpoint, $payload);
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseEquals(json_encode($expectedResult, JSON_PRETTY_PRINT));
    }

    /**
     * @return array
     */
    protected function shouldNotWorkDataProvider()
    {
        return [
            [
                'shouldNotWork01' => 'withInvalidParameter',
                'payload' => [
                    'data' => [
                        'invalidParam' => 'what-eva'
                    ]
                ],
                'detail' => 'The option "invalidParam" does not exist. Defined options are: "attributes", "bean", "id", "type".'
            ],
            [
                'shouldNotWork02' => 'withInvalidType',
                'payload' => [
                    'data' => [
                        'type' => 'InvalidModule',
                        'id' => '86ee02b3-96d2-47b3-bd6d-9e1035daff3a'
                    ]
                ],
                'detail' => 'Module InvalidModule does not exist'
            ],
            [
                'shouldNotWork03' => 'withInvalidId',
                'payload' => [
                    'data' => [
                        'type' => 'Accounts',
                        'id' => '111'
                    ]
                ],
                'detail' => 'The option "id" with value "111" is invalid.'
            ],
            [
                'shouldNotWork04' => 'withInvalidAttribute',
                'payload' => [
                    'data' => [
                        'type' => 'Accounts',
                        'id' => '86ee02b3-96d2-47b3-bd6d-9e1035daff3a',
                        'attributes' => [
                            'invalidAttribute' => 'what-eva'
                        ]
                    ]
                ],
                'detail' => 'Property invalidAttribute in Account module is invalid'
            ],
        ];
    }
}
