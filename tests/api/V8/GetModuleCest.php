<?php
namespace Test\Api\V8;

use Account;
use apiTester;
use Codeception\Example;

class GetModuleCest
{
    /**
     * @var string
     */
    private $accountId = '';

    /**
     * @param apiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function _before(ApiTester $I)
    {
        $I->getLogin();
        $this->accountId = $I->createAccount();
    }

    /**
     * @param apiTester $I
     */
    public function _after(ApiTester $I)
    {
        $I->deleteAccount($this->accountId);
    }

    /**
     * @param apiTester $I
     * @param Example $example
     *
     * @dataProvider shouldWorkDataProvider
     * @throws \Exception
     */
    public function shouldWork(ApiTester $I, Example $example)
    {
        /** @var \ArrayIterator $iterator */
        $iterator = $example->getIterator();
        $endpoint = str_replace('{id}', $this->accountId, $iterator->offsetGet('endPoint'));

        $I->sendGET($I->getInstanceURL() . $endpoint);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'type' => Account::class,
            'id' => $this->accountId
        ]);

        $I->seeResponseJsonMatchesJsonPath('$.data.attributes');
        $assert = $iterator->current() === 'withFields' ? 'assertEquals' : 'assertGreaterThan';
        $I->{$assert}(2, count($I->grabDataFromResponseByJsonPath('$.data.attributes')[0]));
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
        $endpoint = str_replace('{id}', $this->accountId, $iterator->offsetGet('endPoint'));

        $expectedResult = [
            'errors' => [
                'status' => 400,
                'title' => null,
                'detail' => $iterator->offsetGet('detail')
            ]
        ];

        $I->sendGET($I->getInstanceURL() . $endpoint);
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseEquals(json_encode($expectedResult, JSON_PRETTY_PRINT));
    }

    /**
     * @return array
     */
    protected function shouldWorkDataProvider()
    {
        return [
            [
                'shouldWork01' => 'withoutParams',
                'endPoint' => '/Api/V8/module/Accounts/{id}'
            ],
            [
                'shouldWork02' => 'withFields',
                'endPoint' => '/Api/V8/module/Accounts/{id}?fields[Accounts]=name,account_type'
            ],
        ];
    }

    /**
     * @return array
     */
    protected function shouldNotWorkDataProvider()
    {
        return [
            [
                'shouldNotWork01' => 'withInvalidModuleName',
                'endPoint' => '/Api/V8/module/InvalidModuleName/{id}',
                'detail' => 'Module with name InvalidModuleName is not found'
            ],
            [
                'shouldNotWork02' => 'withInvalidId',
                'endPoint' => '/Api/V8/module/Accounts/111',
                'detail' => 'The option "id" with value "111" is invalid.'
            ],
            [
                'shouldNotWork03' => 'withIdNotExist',
                'endPoint' => '/Api/V8/module/Accounts/97c3669b-607a-4b30-964f-2409b55a1551',
                'detail' => 'Accounts module with id 97c3669b-607a-4b30-964f-2409b55a1551 is not found'
            ],
            [
                'shouldNotWork04' => 'withInvalidParameter',
                'endPoint' => '/Api/V8/module/Accounts/{id}?invalidParam',
                'detail' => 'The option "invalidParam" does not exist. Defined options are: "bean", "fields", "id", "moduleName".'
            ],
            [
                'shouldNotWork05' => 'withInvalidFieldParameter',
                'endPoint' => '/Api/V8/module/Accounts/{id}?fields[Accounts]=name,not_exist_property1,not_exist_property2',
                'detail' => 'The following fields in Account module are not found: not_exist_property1, not_exist_property2'
            ],
            [
                'shouldNotWork06' => 'withInvalidFieldParameterKey',
                'endPoint' => '/Api/V8/module/Accounts/{id}?fields[NotExist]=name,account_type',
                'detail' => 'Module NotExist does not exist'
            ],
        ];
    }
}
