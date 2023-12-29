<?php
namespace Flow\JSONPath\Test;

use Flow\JSONPath\JSONPathLexer;
use Flow\JSONPath\JSONPathToken;

require_once __DIR__ . "/../vendor/autoload.php";

class JSONPathLexerTest extends \PHPUnit_Framework_TestCase
{
    public function test_Index_Wildcard()
    {
        $tokens = (new JSONPathLexer('.*'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[0]->type);
        $this->assertEquals("*", $tokens[0]->value);
    }

    public function test_Index_Simple()
    {
        $tokens = (new JSONPathLexer('.foo'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[0]->type);
        $this->assertEquals("foo", $tokens[0]->value);
    }

    public function test_Index_Recursive()
    {
        $tokens = (new JSONPathLexer('..teams.*'))->parseExpression();

        $this->assertEquals(3, count($tokens));

        $this->assertEquals(JSONPathToken::T_RECURSIVE, $tokens[0]->type);
        $this->assertEquals(null, $tokens[0]->value);
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[1]->type);
        $this->assertEquals('teams', $tokens[1]->value);
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[2]->type);
        $this->assertEquals('*', $tokens[2]->value);
    }

    public function test_Index_Complex()
    {
        $tokens = (new JSONPathLexer('["\'b.^*_"]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[0]->type);
        $this->assertEquals("'b.^*_", $tokens[0]->value);
    }

    /**
     * @expectedException           Flow\JSONPath\JSONPathException
     * @expectedExceptionMessage    Unable to parse token hello* in expression: .hello*
     */
    public function test_Index_BadlyFormed()
    {
        $tokens = (new JSONPathLexer('.hello*'))->parseExpression();
    }

    public function test_Index_Integer()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('[0]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[0]->type);
        $this->assertEquals("0", $tokens[0]->value);
    }

    public function test_Index_IntegerAfterDotNotation()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('.books[0]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[0]->type);
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[1]->type);
        $this->assertEquals("books", $tokens[0]->value);
        $this->assertEquals("0", $tokens[1]->value);
    }

    public function test_Index_Word()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('["foo$-/\'"]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[0]->type);
        $this->assertEquals("foo$-/'", $tokens[0]->value);
    }

    public function test_Index_WordWithWhitespace()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('[   "foo$-/\'"     ]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[0]->type);
        $this->assertEquals("foo$-/'", $tokens[0]->value);
    }

    public function test_Slice_Simple()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('[0:1:2]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_SLICE, $tokens[0]->type);
        $this->assertEquals(['start' => 0, 'end' => 1, 'step' => 2], $tokens[0]->value);
    }

    public function test_Slice_NegativeIndex()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('[-1]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_SLICE, $tokens[0]->type);
        $this->assertEquals(['start' => -1, 'end' => null, 'step' => null], $tokens[0]->value);
    }

    public function test_Slice_AllNull()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('[:]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_SLICE, $tokens[0]->type);
        $this->assertEquals(['start' => null, 'end' => null, 'step' => null], $tokens[0]->value);
    }

    public function test_QueryResult_Simple()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('[(@.foo + 2)]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_QUERY_RESULT, $tokens[0]->type);
        $this->assertEquals('@.foo + 2', $tokens[0]->value);
    }

    public function test_QueryMatch_Simple()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('[?(@.foo < \'bar\')]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_QUERY_MATCH, $tokens[0]->type);
        $this->assertEquals('@.foo < \'bar\'', $tokens[0]->value);
    }

    public function test_QueryMatch_NotEqualTO()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('[?(@.foo != \'bar\')]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_QUERY_MATCH, $tokens[0]->type);
        $this->assertEquals('@.foo != \'bar\'', $tokens[0]->value);
    }

    public function test_QueryMatch_Brackets()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer("[?(@['@language']='en')]"))->parseExpression();

        $this->assertEquals(JSONPathToken::T_QUERY_MATCH, $tokens[0]->type);
        $this->assertEquals("@['@language']='en'", $tokens[0]->value);

    }


    public function test_Recursive_Simple()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('..foo'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_RECURSIVE, $tokens[0]->type);
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[1]->type);
        $this->assertEquals(null, $tokens[0]->value);
        $this->assertEquals('foo', $tokens[1]->value);
    }


    public function test_Recursive_Wildcard()
    {
        $tokens = (new \Flow\JSONPath\JSONPathLexer('..*'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_RECURSIVE, $tokens[0]->type);
        $this->assertEquals(JSONPathToken::T_INDEX, $tokens[1]->type);
        $this->assertEquals(null, $tokens[0]->value);
        $this->assertEquals('*', $tokens[1]->value);
    }


    /**
     * @expectedException           Flow\JSONPath\JSONPathException
     * @expectedExceptionMessage    Unable to parse token ba^r in expression: ..ba^r
     */
    public function test_Recursive_BadlyFormed()
    {
        $tokens = (new JSONPathLexer('..ba^r'))->parseExpression();
    }


    /**
     */
    public function test_Indexes_Simple()
    {
        $tokens = (new JSONPathLexer('[1,2,3]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_INDEXES, $tokens[0]->type);
        $this->assertEquals([1,2,3], $tokens[0]->value);
    }
    /**
     */
    public function test_Indexes_Whitespace()
    {
        $tokens = (new JSONPathLexer('[ 1,2 , 3]'))->parseExpression();
        $this->assertEquals(JSONPathToken::T_INDEXES, $tokens[0]->type);
        $this->assertEquals([1,2,3], $tokens[0]->value);
    }





}
 