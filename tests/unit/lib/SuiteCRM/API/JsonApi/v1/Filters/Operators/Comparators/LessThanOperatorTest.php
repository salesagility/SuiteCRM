<?php


class LessThanOperatorTest extends \Codeception\Test\Unit
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

    public function testIsValidTagWithInvalidType()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\LessThanOperator();
        $this->tester->expectException(
            new \SuiteCRM\Exception\Exception('[JsonApi][v1][Filters][Operators][Comparators][LessThanOperator][isValid][expected type to be string] $operator'),
            function() use($operator) {
                $operator->isValid(array());
            }
        );
    }

    public function testIsValidTagWithInvalidName()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\LessThanOperator();
        $this->assertFalse($operator->isValid($operator->toFilterTag('eq2')));
    }

    public function testToFilterOperator()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\LessThanOperator();
        $tag = $operator->toFilterTag('lt');
        $this->assertEquals($operator->toFilterOperator(), $tag);
    }

    public function testToSqlOperator()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\LessThanOperator();
        $sql = '<';
        $this->assertEquals($operator->toSqlOperator(), $sql);
    }
}