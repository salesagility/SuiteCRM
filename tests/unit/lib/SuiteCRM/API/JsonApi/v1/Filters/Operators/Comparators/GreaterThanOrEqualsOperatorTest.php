<?php


class GreaterThanOrEqualsOperatorTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private static $operator;

    public function _before()
    {
        parent::_before();
        $containers = $this->tester->getContainerInterface();
        self::$operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Comparators\GreaterThanOrEqualsOperator($containers);
    }


    public function testIsValidTagWithInvalidType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\InvalidArgumentException('[JsonApi][v1][Filters][Operators][Comparators][GreaterThanOrEqualsOperator][isValid][expected type to be string] $operator'),
            function () {
                self::$operator->isValid(array());
            }
        );
    }

    public function testIsValidTagWithInvalidName()
    {
        $this->assertFalse(self::$operator->isValid(self::$operator->toFilterTag('eq2')));
    }

    public function testToFilterOperator()
    {
        $tag = self::$operator->toFilterTag('gte');
        $this->assertEquals(self::$operator->toFilterOperator(), $tag);
    }

    public function testToSqlOperator()
    {
        $sql = '>=';
        $this->assertEquals(self::$operator->toSqlOperator(), $sql);
    }
}
