<?php

namespace Flow\JSONPath;

class JSONPathLexer
{

    /*
     * Match within bracket groups
     * Matches are whitespace insensitive
     */
    const MATCH_INDEX        = '-?\w+ | \*'; // Eg. foo
    const MATCH_INDEXES      = '\s* -?\d+ [-?\d,\s]+'; // Eg. 0,1,2
    const MATCH_SLICE        = '[-\d:]+ | :'; // Eg. [0:2:1]
    const MATCH_QUERY_RESULT = '\s* \( .+? \) \s*'; // Eg. ?(@.length - 1)
    const MATCH_QUERY_MATCH  = '\s* \?\(.+?\) \s*'; // Eg. ?(@.foo = "bar")
    const MATCH_INDEX_IN_SINGLE_QUOTES = '\s* \' (.+?) \' \s*'; // Eg. 'bar'
    const MATCH_INDEX_IN_DOUBLE_QUOTES = '\s* " (.+?) " \s*'; // Eg. 'bar'

    /**
     * The expression being lexed.
     *
     * @var string
     */
    protected $expression = '';

    /**
     * The length of the expression.
     *
     * @var int
     */
    protected $expressionLength = 0;

    public function __construct($expression)
    {
        $expression = trim($expression);

        if (!strlen($expression)) {
            return;
        }

        if ($expression[0] === '$') {
            $expression = substr($expression, 1);
        }

        if ($expression[0] !== '.' && $expression[0] !== '[') {
            $expression = '.' . $expression;
        }

        $this->expression = $expression;
        $this->expressionLength = strlen($expression);
    }

    public function parseExpressionTokens()
    {
        $dotIndexDepth = 0;
        $squareBracketDepth = 0;
        $capturing = false;
        $tokenValue = '';
        $tokens = [];

        for ($i = 0; $i < $this->expressionLength; $i++) {
            $char = $this->expression[$i];

            if ($squareBracketDepth === 0) {
                if ($char === '.') {

                    if ($this->lookAhead($i, 1) === ".") {
                        $tokens[] = new JSONPathToken(JSONPathToken::T_RECURSIVE, null);
                    }

                    continue;
                }
            }

            if ($char === '[') {
                $squareBracketDepth += 1;

                if ($squareBracketDepth === 1) {
                    continue;
                }
            }

            if ($char === ']') {
                $squareBracketDepth -= 1;

                if ($squareBracketDepth === 0) {
                    continue;
                }
            }

            /*
             * Within square brackets
             */
            if ($squareBracketDepth > 0) {
                $tokenValue .= $char;
                if ($this->lookAhead($i, 1) === ']' && $squareBracketDepth === 1) {
                    $tokens[] = $this->createToken($tokenValue);
                    $tokenValue = '';
                }
            }

            /*
             * Outside square brackets
             */
            if ($squareBracketDepth === 0) {
                $tokenValue .= $char;

                // Double dot ".."
                if ($char === "." && $dotIndexDepth > 1) {
                    $tokens[] = $this->createToken($tokenValue);
                    $tokenValue = '';
                    continue;
                }

                if ($this->lookAhead($i, 1) === '.' || $this->lookAhead($i, 1) === '[' || $this->atEnd($i)) {
                    $tokens[] = $this->createToken($tokenValue);
                    $tokenValue = '';
                    $dotIndexDepth -= 1;
                }
            }

        }

        if ($tokenValue !== '') {
            $tokens[] = $this->createToken($tokenValue);
            $tokenValue = '';
        }

        return $tokens;
    }

    protected function lookAhead($pos, $forward = 1)
    {
        return isset($this->expression[$pos + $forward]) ? $this->expression[$pos + $forward] : null;
    }

    protected function atEnd($pos)
    {
        return $pos === $this->expressionLength;
    }



    public function parseExpression()
    {
        $tokens = $this->parseExpressionTokens();

        return $tokens;
    }

    /**
     * @param $value
     * @return string
     */
    protected function createToken($value)
    {
        if (preg_match('/^(' . static::MATCH_INDEX . ')$/x', $value, $matches)) {
            if (preg_match('/^-?\d+$/', $value)) {
                $value = (int)$value;
            }
            return new JSONPathToken(JSONPathToken::T_INDEX, $value);
        }

        if (preg_match('/^' . static::MATCH_INDEXES . '$/x', $value, $matches)) {
            $value = explode(',', trim($value, ','));

            foreach ($value as $i => $v) {
                $value[$i] = (int) trim($v);
            }

            return new JSONPathToken(JSONPathToken::T_INDEXES, $value);
        }

        if (preg_match('/^' . static::MATCH_SLICE . '$/x', $value, $matches)) {
            $parts = explode(':', $value);

            $value = [
                'start' => isset($parts[0]) && $parts[0] !== "" ? (int) $parts[0] : null,
                'end'   => isset($parts[1]) && $parts[1] !== "" ? (int) $parts[1] : null,
                'step'  => isset($parts[2]) && $parts[2] !== "" ? (int) $parts[2] : null,
            ];

            return new JSONPathToken(JSONPathToken::T_SLICE, $value);
        }

        if (preg_match('/^' . static::MATCH_QUERY_RESULT . '$/x', $value)) {
            $value = substr($value, 1, -1);

            return new JSONPathToken(JSONPathToken::T_QUERY_RESULT, $value);
        }

        if (preg_match('/^' . static::MATCH_QUERY_MATCH . '$/x', $value)) {
            $value = substr($value, 2, -1);

            return new JSONPathToken(JSONPathToken::T_QUERY_MATCH, $value);
        }

        if (preg_match('/^' . static::MATCH_INDEX_IN_SINGLE_QUOTES . '$/x', $value, $matches)) {
            $value = $matches[1];
            $value = trim($value);

            return new JSONPathToken(JSONPathToken::T_INDEX, $value);
        }

        if (preg_match('/^' . static::MATCH_INDEX_IN_DOUBLE_QUOTES . '$/x', $value, $matches)) {
            $value = $matches[1];
            $value = trim($value);

            return new JSONPathToken(JSONPathToken::T_INDEX, $value);
        }

        throw new JSONPathException("Unable to parse token {$value} in expression: $this->expression");
    }

}
