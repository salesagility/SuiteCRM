<?php


class NotInOperatorTest extends \Codeception\Test\Unit
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
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\NotInOperator();
        $tag = $operator->toFilterTag('nin');
        $this->assertEquals($operator->toFilterOperator(), $tag);
    }

    public function testToSqlOperator()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\NotInOperator();
        $sql = 'NOT IN';
        $this->assertEquals($operator->toSqlOperator(), $sql);
    }
}