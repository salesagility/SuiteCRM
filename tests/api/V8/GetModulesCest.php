<?php
namespace Test\Api\V8;

use apiTester;
use Codeception\Example;

class GetModulesCest
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
     * @param Example $example
     *
     * @dataProvider shouldNotWorkDataProvider
     * @throws \Exception
     */
    public function shouldNotWork(ApiTester $I, Example $example)
    {
        /** @var \ArrayIterator $iterator */
        $iterator = $example->getIterator();

        $expectedResult = [
            'errors' => [
                'status' => 400,
                'title' => null,
                'detail' => $iterator->offsetGet('detail')
            ]
        ];

        $I->sendGET($I->getInstanceURL() . $iterator->offsetGet('endPoint'));
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
                'endPoint' => '/Api/index.php/V8/module/InvalidModuleName',
                'detail' => 'Module InvalidModuleName does not exist'
            ],
            [
                'shouldNotWork02' => 'withInvalidParameter',
                'endPoint' => '/Api/index.php/V8/module/Accounts?invalidParam',
                'detail' => 'The option "invalidParam" does not exist. Defined options are: "fields", "filter", "moduleName", "page", "sort".'
            ],
            [
                'shouldNotWork03' => 'withInvalidField',
                'endPoint' => '/Api/index.php/V8/module/Accounts?fields[Accounts]=name,not_exist_property1,not_exist_property2',
                'detail' => 'The following fields in Account module are not found: not_exist_property1, not_exist_property2'
            ],
            [
                'shouldNotWork04' => 'withInvalidFieldKey',
                'endPoint' => '/Api/index.php/V8/module/Accounts?fields[NotExist]=name,account_type',
                'detail' => 'Module NotExist does not exist'
            ],
            [
                'shouldNotWork05' => 'withInvalidPage',
                'endPoint' => '/Api/index.php/V8/module/Accounts?page[size]=-1',
                'detail' => 'The option "page" with value array is invalid.'
            ],
            [
                'shouldNotWork06' => 'withInvalidPageKey',
                'endPoint' => '/Api/index.php/V8/module/Accounts?page[invalidParameter]=1',
                'detail' => 'The option "invalidParameter" does not exist. Defined options are: "number", "size".'
            ],
            [
                'shouldNotWork07' => 'withInvalidSort',
                'endPoint' => '/Api/index.php/V8/module/Accounts?sort=invalidField',
                'detail' => 'Sort field invalidField in Account module is not found'
            ],
            [
                'shouldNotWork08' => 'withInvalidFilter',
                'endPoint' => '/Api/index.php/V8/module/Accounts?filter[operator]=and&filter[invalidProperty][eq]=Customer',
                'detail' => 'Filter field invalidProperty in Account module is not found'
            ],
            [
                'shouldNotWork09' => 'withInvalidFilterOperator',
                'endPoint' => '/Api/index.php/V8/module/Accounts?filter[operator]=and&filter[account_type][eq111]=Customer',
                'detail' => 'Filter operator eq111 is invalid'
            ],
        ];
    }
}
