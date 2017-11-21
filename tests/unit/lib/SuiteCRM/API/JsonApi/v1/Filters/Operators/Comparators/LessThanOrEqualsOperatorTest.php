<?php


class LessThanOrEqualsOperatorTest extends \Codeception\Test\Unit
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
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\LessThanOrEqualsOperator();
        $tag = $operator->toFilterTag('lte');
        $this->assertEquals($operator->toFilterOperator(), $tag);
    }

    public function testToSqlOperator()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\LessThanOrEqualsOperator();
        $sql = '<=';
        $this->assertEquals($operator->toSqlOperator(), $sql);
    }
}