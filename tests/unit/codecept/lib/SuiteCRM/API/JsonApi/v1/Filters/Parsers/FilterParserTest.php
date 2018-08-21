<?php

namespace SuiteCRM\API\JsonApi\v1\Filters\Parsers;

use SuiteCRM\API\JsonApi\v1\Filters\Operators\FieldOperator;
use SuiteCRM\API\JsonApi\v1\Filters\Operators\Operator;
use SuiteCRM\API\v8\Exception\BadRequestException;
use SuiteCRM\Exception\Exception;
use SuiteCRM\Exception\InvalidArgumentException;
use SuiteCRM\Utility\Paths;

include_once __DIR__ . '/FilterParserMock.php';

class FilterParserTest extends \SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var FilterParserMock $filterParser
     */
    private static $filterParser;

    /**
     * @var FieldOperator
     */
    private static $fieldOperator;

    /**
     * @var Operator
     */
    private static $operator;

    public function _before()
    {
        parent::_before();
        $container = $this->tester->getContainerInterface();
        if (self::$filterParser === null) {
            // load PSR 11 interface
            // Load mock class
            self::$filterParser = new FilterParserMock($container);
        }

        if (self::$operator === null) {
            self::$operator = new Operator($container);
        }

        if (self::$fieldOperator === null) {
            self::$fieldOperator = new FieldOperator($container);
        }
    }



    public function testSplitKeysWithEmptyArray()
    {
        $this->tester->expectException(
            new InvalidArgumentException(
                '[JsonApi][v1][Filters][Parsers][FilterParser]'.
                '[splitFieldKeys][expected type to be string] $fieldKey'
            ),
            function () {
                $emptyArray = array();
                self::$filterParser->splitFieldKeysAdapter($emptyArray);
            }
        );
    }

    public function testSplitKeysWithEmptyString()
    {
        $this->tester->expectException(
            new Exception(
                '[JsonApi][v1][Filters][Parsers][FilterParser][splitFieldKeys][InvalidValue] expected period ""'
            ),
            function () {
                self::$filterParser->splitFieldKeysAdapter('');
            }
        );
    }

    public function testSplitKeysWithInvalidString()
    {
        $badKey = self::$fieldOperator->toFilterTag('Accounts');
        $this->tester->expectException(
            new Exception(
                '[JsonApi][v1][Filters][Parsers][FilterParser][splitFieldKeys][InvalidValue] expected period "Accounts"'
            ),
            function () {
                self::$filterParser->splitFieldKeysAdapter('Accounts');
            }
        );
    }

    public function testSplitKeysWithInvalidKey()
    {
        $badKey = self::$fieldOperator->toFilterTag('bad+key');
        $this->tester->expectException(
            new Exception(
                '[JsonApi][v1][Filters][FilterParser][splitFieldKeys][InvalidValue] "'.$badKey.'"'
            ),
            function () {
                self::$filterParser->splitFieldKeysAdapter('Accounts.bad+key');
            }
        );
    }

    public function testSplitKeysWithArray()
    {
        $goodKey = 'Accounts.contacts.name';
        $expectGoodArray = array(
            self::$fieldOperator->toFilterTag('Accounts') => array(
                self::$fieldOperator->toFilterTag('contacts') => array(
                    // Empty marks the that this is the leaf of the field
                    // This is where the operators and values go
                    self::$fieldOperator->toFilterTag('name') => array()
                )
            )
        );

        $actualArray = self::$filterParser->splitFieldKeysAdapter($goodKey);
        $this->assertSame(
          $expectGoodArray,
          $actualArray
        );
    }

    public function testParsedFieldKeyWithInvalidType()
    {
        $this->tester->expectException(
            new Exception(
                '[JsonApi][v1][FilterParser][parseFieldKey][expected type to be string] $fieldKey'
            ),
            function () {
                self::$filterParser->parseFieldKeyAdapter(array());
            }
        );
    }

    public function testParsedFieldKeyWithSimpleValue()
    {
        $goodKey = 'Accounts';
        $expectGoodArray = array(
            self::$fieldOperator->toFilterTag('Accounts') => array()
        );

        $actualArray = self::$filterParser->parseFieldKeyAdapter($goodKey);
        $this->assertSame(
            $expectGoodArray,
            $actualArray
        );
    }

    public function testParsedFieldKeyWithRelatedValues()
    {
        $goodKey = 'Accounts.contacts.name';
        $expectGoodArray = array(
            self::$fieldOperator->toFilterTag('Accounts') => array(
                self::$fieldOperator->toFilterTag('contacts') => array(
                    // Empty marks the that this is the leaf of the field
                    // This is where the operators and values go
                    self::$fieldOperator->toFilterTag('name') => array()
                )
            )
        );

        $actualArray = self::$filterParser->parseFieldKeyAdapter($goodKey);
        $this->assertSame(
            $expectGoodArray,
            $actualArray
        );
    }

    public function testSplitValuesWithInvalidDataType()
    {
        $this->tester->expectException(
            new InvalidArgumentException(
                '[JsonApi][v1][Filters][Parsers][FilterParser]' .
                '[splitValues][expected type to be string] $fieldKey'
            ),
            function () {
                self::$filterParser->splitValuesAdapter(array());
            }
        );
    }

    public function testSplitValuesWithInvalidDataValue()
    {
        $this->tester->expectException(
            new Exception(
                '[JsonApi][v1][Filters][Parsers][FilterParser]' .
                '[splitValues][InvalidValue] expected delimiter "bad value"'
            ),
            function () {
                self::$filterParser->splitValuesAdapter('bad value');
            }
        );
    }

    public function testSplitValuesWithExpectedValue()
    {
        $expect = array(
            '[[eq]]foo',
            '[[eq]]bar'
        );
        $actual = self::$filterParser->splitValuesAdapter('[[eq]]foo,[[eq]]bar');
        $this->assertSame($expect, $actual);
    }

    public function testParseFieldFilterWithSingleValue()
    {
        $expect = array(
            'foo'
        );
        $actual = self::$filterParser->parseFieldFilterAdapter('foo');
        $this->assertSame($expect, $actual);
    }

    public function testParseFieldFilterWithOperator()
    {
        $expect = array(
            '[[eq]]'
        );
        $actual = self::$filterParser->parseFieldFilterAdapter('[[eq]]');
        $this->assertSame($expect, $actual);
    }

    public function testParseFieldFilterWithOperatorWithValue()
    {
        $expect = array(
            '[[eq]]',
            'foo'
        );

        $actual = self::$filterParser->parseFieldFilterAdapter('[[eq]]foo');
        $this->assertSame($expect, $actual);
    }

    public function testParseFieldFilterWithOperatorWithFieldOperator()
    {
        $expect = array(
            '[[eq]]',
            '[name]'
        );

        $actual = self::$filterParser->parseFieldFilterAdapter('[[eq]][name]');
        $this->assertSame($expect, $actual);
    }

    public function testParseFieldFilterWithOperatorWithSpecialOperator()
    {
        $expect = array(
            '[[eq]]',
            '[[[current_user]]]]'
        );

        $actual = self::$filterParser->parseFieldFilterAdapter('[[eq]][[[current_user]]]]');
        $this->assertSame($expect, $actual);
    }

    public function testParseFieldFilterWithSpecialOperator()
    {
        $expect = array(
            '[[[current_user]]]]'
        );

        $actual = self::$filterParser->parseFieldFilterAdapter('[[[current_user]]]]');
        $this->assertSame($expect, $actual);
    }

    public function testParseFieldFilterWithFieldOperator()
    {
        $expect = array(
            '[user.name]'
        );

        $actual = self::$filterParser->parseFieldFilterAdapter('[user.name]');
        $this->assertSame($expect, $actual);
    }

    public function testParseFieldFilterWithMissingOperator()
    {
        $this->tester->expectException(
            new Exception(
                '[JsonApi][v1][Filters][Parsers][FilterParser]' .
                '[parserFieldFilters][operator not found] please ensure that an operator has been added to '.
                'containers '
            ),
            function () {
                self::$filterParser->parseFieldFilterAdapter('[[missingTestOperator]]');
            }
        );
    }

    public function testParseFilter()
    {
        $expectedResult = array(
            self::$fieldOperator->toFilterTag('Accounts') => array(
                self::$fieldOperator->toFilterTag('name') => array(
                    self::$operator->toFilterTag('eq'),
                    'foo'
                )
            )
        );

        $actualResult = self::$filterParser->parseFilter('Accounts.name', '[[eq]]foo');
        $this->assertSame($expectedResult, $actualResult);
    }
}
