<?php


class GreaterThanOperatorTest extends \Codeception\Test\Unit
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
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\GreaterThanOperator();
        $tag = $operator->toFilterTag('gt');
        $this->assertEquals($operator->toFilterOperator(), $tag);
    }

    public function testToSqlOperator()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\GreaterThanOperator();
        $sql = '>';
        $this->assertEquals($operator->toSqlOperator(), $sql);
    }
}