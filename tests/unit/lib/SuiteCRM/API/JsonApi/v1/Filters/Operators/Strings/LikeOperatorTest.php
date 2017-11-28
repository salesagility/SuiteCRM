<?php


class LikeOperatorTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private static $operator;

    protected function _before()
    {
        self::$operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Strings\LikeOperator();
    }


    public function testIsValidTagWithInvalidType()
    {
        $operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Strings\LikeOperator();
        $this->tester->expectException(
            new \SuiteCRM\Exception\Exception('[JsonApi][v1][Filters][Operators][Strings][LikeOperator][isValid][expected type to be string] $operator'),
            function() use($operator) {
                $operator->isValid(array());
            }
        );
    }

    protected function _after()
    {
    }

    public function testIsValidTagWithInvalidName()
    {
        $this->assertFalse(self::$operator->isValid(self::$operator->toFilterTag('eq2')));
    }

    public function testToFilterOperator()
    {
        $tag = self::$operator->toFilterTag('li');
        $this->assertEquals(self::$operator->toFilterOperator(), $tag);
    }

    public function testToSqlOperator()
    {
        $sql = 'LIKE';
        $this->assertEquals(self::$operator->toSqlOperator(), $sql);
    }
}