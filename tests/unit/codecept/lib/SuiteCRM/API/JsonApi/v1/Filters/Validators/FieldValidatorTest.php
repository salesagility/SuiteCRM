<?php


/**
 * Class FieldValidatorTest
 * Tests that the fields comply with the JSON Api Spec.
 * @see http://jsonapi.org/format/1.0/#document-member-names
 */
class FieldValidatorTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var \SuiteCRM\API\JsonApi\v1\Filters\Validators\FieldValidator $fieldValidator */
    private static $fieldValidator;

    /** @var  \SuiteCRM\API\JsonApi\v1\Filters\Operators\FieldOperator $fieldOperator */
    private static $fieldOperator;

    public function _before()
    {
        parent::_before();
        $containers = $this->tester->getContainerInterface();
        if(self::$fieldValidator === null) {
            self::$fieldValidator = new \SuiteCRM\API\JsonApi\v1\Filters\Validators\FieldValidator($containers);
        }

        if(self::$fieldOperator === null) {
            self::$fieldOperator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\FieldOperator($containers);
        }
    }



    public function testIsValidWithWrongDataType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\InvalidArgumentException(
                '[JsonApi][v1][Filters][Validators][FieldValidator][isValid][expected type to be string] $fieldKey'
            ),
            function() {
                self::$fieldValidator->isValid(array());
            }
        );
    }

    public function testIsValidWithSpace()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('Accounts name')));
    }

    public function testIsValidWithPlusSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('+name')));
    }

    public function testIsValidWithComma()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('id,name')));
    }

    public function testIsValidWithPeriod()
    {
        $this->tester->assertTrue(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('Accounts.name')));
    }

    public function testIsValidWithBrackets()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('[id]')));
    }

    public function testIsValidWithExclamationMark()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('!id')));
    }

    public function testIsValidWithQuotationMark()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('"id"')));
    }

    public function testIsValidWithNumberSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('#id')));
    }

    public function testIsValidWithDollarSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('$id')));
    }

    public function testIsValidWithPercentSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('%contains%')));
    }

    public function testIsValidWithAmpersandSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('&something')));
    }

    public function testIsValidWithApostropheSign()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag("'")));
    }

    public function testIsValidWithParenthesis()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('(name)')));
    }

    public function testIsValidWithAsterix()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('*.pdf')));
    }

    public function testIsValidWithSolidus()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('/path/to/somthing')));
    }

    public function testIsValidWithColon()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('ClassName::method')));
    }

    public function testIsValidWithSemiColon()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('foo;bar;baz')));
    }

    public function testIsValidWithLessThan()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('foo<baz')));
    }

    public function testIsValidWithEquals()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('foo=baz')));
    }

    public function testIsValidWithGreaterThan()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('foo>baz')));
    }

    public function testIsValidWithQuestionMark()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('foo?baz')));
    }

    public function testIsValidWithAt()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('foo@localhost')));
    }

    public function testIsValidWithReverseSolidus()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('\\ comment')));
    }

    public function testIsValidWithCircumflexAccent()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('^regex')));
    }

    public function testIsValidWithGraveAccent()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('```field```')));
    }

    public function testIsValidWithBraces()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('{templateField}')));
    }

    public function testIsValidWithTilde()
    {
        $this->tester->assertFalse(self::$fieldValidator->isValid(self::$fieldOperator->toFilterTag('~approx')));
    }
}