<?php


class OperatorsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testToFilterOperator()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Operator();
        $tag = $operator->toFilterTag('test');
        $this->assertEquals('[test]', $tag);
    }
}