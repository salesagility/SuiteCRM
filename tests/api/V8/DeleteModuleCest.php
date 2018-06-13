<?php
namespace Test\Api\V8;

use apiTester;
use Codeception\Example;

class DeleteModuleCest
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
        $id = $I->createAccount();
        $endpoint = $I->getInstanceURL() . '/Api/V8/module/Accounts/' . $id;
        $expectedResult = [
            'meta' => [
                'message' => sprintf('Record with id %s is deleted', $id)
            ],
            'data' => []
        ];

        $I->sendDELETE($endpoint);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseEquals(json_encode($expectedResult, JSON_PRETTY_PRINT));

        // perm delete
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
        $endpoint = $I->getInstanceURL() . $iterator->offsetGet('endPoint');
        $detail = $iterator->offsetGet('detail');

        if ($iterator->current() === 'withDeletedRecord') {
            $id = $I->createAccount();
            $I->deleteAccount($id);
            $endpoint = str_replace('{id}', $id, $endpoint);
            $detail = str_replace('{id}', $id, $detail);
        }

        $expectedResult = [
            'errors' => [
                'status' => 400,
                'title' => null,
                'detail' => $detail
            ]
        ];

        $I->sendGET($endpoint);
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
                'shouldNotWork01' => 'withInvalidModuleName',
                'endPoint' => '/Api/V8/module/InvalidModuleName/11a71596-83e7-624d-c792-5ab9006dd493',
                'detail' => 'Module with name InvalidModuleName is not found'
            ],
            [
                'shouldNotWork02' => 'withInvalidId',
                'endPoint' => '/Api/V8/module/Accounts/111',
                'detail' => 'The option "id" with value "111" is invalid.'
            ],
            [
                'shouldNotWork03' => 'withDeletedRecord',
                'endPoint' => '/Api/V8/module/Accounts/{id}',
                'detail' => 'Accounts module with id {id} is not found'
            ],
        ];
    }
}
