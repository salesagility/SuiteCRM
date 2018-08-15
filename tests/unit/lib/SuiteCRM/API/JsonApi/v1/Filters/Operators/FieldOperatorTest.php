<?php


class FieldOperatorTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\API\JsonApi\v1\Filters\Operators\FieldOperator $fieldOperator
     */
    private static $fieldOperator;

    public function _before()
    {
        parent::_before();
        $containers = $this->tester->getContainerInterface();
        if (self::$fieldOperator === null) {
            self::$fieldOperator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\FieldOperator($containers);
        }
    }



    public function testToFilterOperator()
    {
        $tag = self::$fieldOperator->toFilterTag('test');
        $this->assertEquals('[test]', $tag);
    }

    public function testIsValidTagWithInvalidType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\InvalidArgumentException('[JsonApi][v1][Filters][Operators][FieldOperator][isValid][expected type to be string] $operator'),
            function () {
                self::$fieldOperator->isValid(array());
            }
        );
    }

    public function testIsValidTagWithInvalidName()
    {
        $this->assertFalse(self::$fieldOperator->isValid('Accounts$1'));
    }

    public function testIsValidTagWithInvalidSymbol()
    {
        $this->assertFalse(self::$fieldOperator->isValid(self::$fieldOperator->toFilterTag('+')));
    }

    public function testIsValidTagWithValidNames()
    {
        $this->assertTrue(self::$fieldOperator->isValid(self::$fieldOperator->toFilterTag('eq')));
        $this->assertTrue(self::$fieldOperator->isValid(self::$fieldOperator->toFilterTag('equalsUser')));
        $this->assertTrue(self::$fieldOperator->isValid(self::$fieldOperator->toFilterTag('eq_user')));
        $this->assertTrue(self::$fieldOperator->isValid(self::$fieldOperator->toFilterTag('eq-user')));
    }

    public function testIsOperatorWithInvalidType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\InvalidArgumentException('[JsonApi][v1][Filters][Operators][FieldOperator][isValid][expected type to be string] $operator'),
            function () {
                self::$fieldOperator->isValid(array());
            }
        );
    }

    public function testTotalOperands()
    {
        $this->assertEquals(0, self::$fieldOperator->totalOperands());
    }
}
