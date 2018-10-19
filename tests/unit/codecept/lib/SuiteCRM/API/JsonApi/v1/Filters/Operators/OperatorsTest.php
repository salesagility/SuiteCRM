<?php


class OperatorsTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \SuiteCRM\API\JsonApi\v1\Filters\Operators\Operator $operator
     */
    private static $operator;

    public function _before()
    {
        parent::_before();
        if (self::$operator === null) {
            $containers = $this->tester->getContainerInterface();
            self::$operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Operator($containers);
        }
    }



    public function testToFilterOperator()
    {
        $tag = self::$operator->toFilterTag('test');
        $this->assertEquals('[[test]]', $tag);
    }

    public function testStripFilterTag()
    {
        $tag = self::$operator->stripFilterTag('[[test]]');
        $this->assertEquals('test', $tag);
    }

    public function testIsValidTagWithInvalidType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\InvalidArgumentException(
                '[JsonApi][v1][Filters][Operators][Operator][isValid][expected type to be string] $operator'
            ),
            function () {
                self::$operator->isValid(array());
            }
        );
    }

    public function testIsValidTagWithInvalidName()
    {
        $this->assertFalse(self::$operator->isValid(self::$operator->toFilterTag('eq2')));
    }

    public function testIsValidTagWithInvalidSymbol()
    {
        $this->assertFalse(self::$operator->isValid(self::$operator->toFilterTag('+')));
    }

    public function testIsValidTagWithValidNames()
    {
        $this->assertTrue(self::$operator->isValid(self::$operator->toFilterTag('eq')));
        $this->assertTrue(self::$operator->isValid(self::$operator->toFilterTag('equalsUser')));
        $this->assertTrue(self::$operator->isValid(self::$operator->toFilterTag('eq_user')));
        $this->assertTrue(self::$operator->isValid(self::$operator->toFilterTag('eq-user')));
    }

    public function testIsOperatorWithInvalidType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\InvalidArgumentException(
                '[JsonApi][v1][Filters][Operators][Operator][isValid][expected type to be string] $operator'
            ),
            function () {
                self::$operator->isValid(array());
            }
        );
    }

    public function testToSqlOperandsWithValidData()
    {
        $data = array('bannana');
        $expected = '"bannana"';
        $actual = self::$operator->toSqlOperands($data);

        $this->assertEquals($expected, $actual);
    }

    public function testTotalOperands()
    {
        $this->assertEquals(1, self::$operator->totalOperands());
    }
}
