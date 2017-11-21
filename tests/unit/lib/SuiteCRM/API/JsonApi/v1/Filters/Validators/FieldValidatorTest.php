<?php


class FieldValidatorTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var \SuiteCRM\API\JsonApi\v1\Filters\Validators\FieldValidator $fieldValidator */
    private static $fieldValidator;

    protected function _before()
    {
        if(self::$fieldValidator === null) {
            self::$fieldValidator = new \SuiteCRM\API\JsonApi\v1\Filters\Validators\FieldValidator();
        }
    }

    protected function _after()
    {
    }

    public function testIsValidWithWrongDataType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\Exception('[JsonApi][v1][FieldValidator][expected type to be string] $fieldKey'),
            function() {
                self::$fieldValidator->isValid(array());
            }
        );
    }

    public function testIsValidWithSpace()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('Accounts name'));
    }

    public function testIsValidWithPlusSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('+name'));
    }

    public function testIsValidWithComma()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('id,name'));
    }

    public function testIsValidWithPeriod()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('Accounts.name'));
    }

    public function testIsValidWithBrackets()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('[id]'));
    }

    public function testIsValidWithExclamationMark()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('!id'));
    }

    public function testIsValidWithQuotationMark()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('"id"'));
    }

    public function testIsValidWithNumberSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('#id'));
    }

    public function testIsValidWithDollarSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('$id'));
    }

    public function testIsValidWithPercentSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('%contains%'));
    }

    public function testIsValidWithAmpersandSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('&something'));
    }

    public function testIsValidWithApostropheSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid("'"));
    }

    public function testIsValidWithParenthesis()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('(name)'));
    }

    public function testIsValidWithAsterix()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('*.pdf'));
    }

    public function testIsValidWithSolidus()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('/path/to/somthing'));
    }

    public function testIsValidWithColon()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('ClassName::method'));
    }

    public function testIsValidWithSemiColon()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('foo;bar;baz'));
    }

    public function testIsValidWithLessThan()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('foo<baz'));
    }

    public function testIsValidWithEquals()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('foo=baz'));
    }

    public function testIsValidWithGreaterThan()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('foo>baz'));
    }

    public function testIsValidWithQuestionMark()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('foo?baz'));
    }

    public function testIsValidWithAt()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('foo@localhost'));
    }

    public function testIsValidWithReverseSolidus()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('\\ comment'));
    }

    public function testIsValidWithCircumflexAccent()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('^regex'));
    }

    public function testIsValidWithGraveAccent()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('```field```'));
    }

    public function testIsValidWithBraces()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('{templateField}'));
    }

    public function testIsValidWithTilde()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid('~approx'));
    }
}