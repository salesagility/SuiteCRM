<?php


class NotLikeOperatorTest extends \Codeception\Test\Unit
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
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Strings\NotLikeOperator();
        $tag = $operator->toFilterTag('nli');
        $this->assertEquals($operator->toFilterOperator(), $tag);
    }

    public function testToSqlOperator()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Strings\NotLikeOperator();
        $sql = 'NOT LIKE';
        $this->assertEquals($operator->toSqlOperator(), $sql);
    }
}