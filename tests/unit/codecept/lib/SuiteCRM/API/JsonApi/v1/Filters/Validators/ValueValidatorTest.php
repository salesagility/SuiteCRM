<?php


class ValueValidatorTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var \SuiteCRM\API\JsonApi\v1\Filters\Validators\FieldValidator $valueValidator */
    private static $valueValidator;

    public function _before()
    {
        parent::_before();
        if(self::$valueValidator === null) {
            self::$valueValidator = new \SuiteCRM\API\JsonApi\v1\Filters\Validators\ValueValidator();
        }
    }


    public function testIsValidWithWrongDataType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\InvalidArgumentException(
                '[JsonApi][v1][Filters][Validators][ValueValidator][isValid][expected type to be string] $value'
            ),
            function() {
                self::$valueValidator->isValid(array());
            }
        );
    }

    public function testIsValidWithSpace()
    {
        $this->tester->assertTrue(self::$valueValidator->isValid('Accounts name'));
    }

    public function testIsValidWithPlusSign()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('+name'));
    }

    public function testIsValidWithComma()
    {
        $this->tester->assertTrue(self::$valueValidator->isValid('id,name'));
    }

    public function testIsValidWithPeriod()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('Accounts.name'));
    }

    public function testIsValidWithBrackets()
    {
        $this->tester->assertTrue(self::$valueValidator->isValid('[id]'));
    }

    public function testIsValidWithExclamationMark()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('!id'));
    }

    public function testIsValidWithQuotationMark()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('"id"'));
    }

    public function testIsValidWithNumberSign()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('#id'));
    }

    public function testIsValidWithDollarSign()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('$id'));
    }

    public function testIsValidWithPercentSign()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('%contains%'));
    }

    public function testIsValidWithAmpersandSign()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('&something'));
    }

    public function testIsValidWithApostropheSign()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid("'"));
    }

    public function testIsValidWithParenthesis()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('(name)'));
    }

    public function testIsValidWithAsterix()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('*.pdf'));
    }

    public function testIsValidWithSolidus()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('/path/to/somthing'));
    }

    public function testIsValidWithColon()
    {
        $this->tester->assertTrue(self::$valueValidator->isValid('ClassName::method'));
    }

    public function testIsValidWithSemiColon()
    {
        $this->tester->assertTrue(self::$valueValidator->isValid('foo;bar;baz'));
    }

    public function testIsValidWithLessThan()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('foo<baz'));
    }

    public function testIsValidWithEquals()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('foo=baz'));
    }

    public function testIsValidWithGreaterThan()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('foo>baz'));
    }

    public function testIsValidWithQuestionMark()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('foo?baz'));
    }

    public function testIsValidWithAt()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('foo@localhost'));
    }

    public function testIsValidWithReverseSolidus()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('\\ comment'));
    }

    public function testIsValidWithCircumflexAccent()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('^regex'));
    }

    public function testIsValidWithGraveAccent()
    {
        $this->tester->assertTrue(self::$valueValidator->isValid('```field```'));
    }

    public function testIsValidWithBraces()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('{templateField}'));
    }

    public function testIsValidWithTilde()
    {
        $this->tester->assertFalse(self::$valueValidator->isValid('~approx'));
    }
}