<?php


class SpecialOperatorTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private static $specialOperator;

    protected function _before()
    {
        if(self::$specialOperator === null) {
            self::$specialOperator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\SpecialOperator();
        }
    }

    protected function _after()
    {
    }

    public function testToFilterOperator()
    {
        $tag = self::$specialOperator->toFilterTag('test');
        $this->assertEquals('[[[test]]]', $tag);
    }

    public function testIsValidTagWithInvalidType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\Exception(
                '[JsonApi][v1][Filters][Operators][SpecialOperator][isValid][expected type to be string] $operator'
            ),
            function() {
                self::$specialOperator->isValid(array());
            }
        );
    }

    public function testIsValidTagWithInvalidName()
    {
        $this->assertFalse(self::$specialOperator->isValid(self::$specialOperator->toFilterTag('eq2')));
    }

    public function testIsValidTagWithInvalidSymbol()
    {
        $this->assertFalse(self::$specialOperator->isValid(self::$specialOperator->toFilterTag('+')));
    }

    public function testIsValidTagWithValidNames()
    {
        $this->assertTrue(self::$specialOperator->isValid(self::$specialOperator->toFilterTag('eq')));
        $this->assertTrue(self::$specialOperator->isValid(self::$specialOperator->toFilterTag('equalsUser')));
        $this->assertTrue(self::$specialOperator->isValid(self::$specialOperator->toFilterTag('eq_user')));
        $this->assertTrue(self::$specialOperator->isValid(self::$specialOperator->toFilterTag('eq-user')));
    }

    public function testIsOperatorWithInvalidType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\Exception('[JsonApi][v1][Filters][Operators][SpecialOperator][isValid][expected type to be string] $operator'),
            function() {
                self::$specialOperator->isValid(array());
            }
        );
    }
}