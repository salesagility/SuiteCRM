<?php

/**
 * SCSSPHP
 *
 * @copyright 2012-2020 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace ScssPhp\ScssPhp\Ast\Sass\Expression;

use ScssPhp\ScssPhp\Ast\Sass\Expression;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Visitor\ExpressionVisitor;

/**
 * A unary operator, as in `+$var` or `not fn()`.
 *
 * @internal
 */
class UnaryOperationExpression implements Expression
{
    /**
     * @var UnaryOperator::*
     * @readonly
     */
    private $operator;

    /**
     * @var Expression
     * @readonly
     */
    private $operand;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param UnaryOperator::* $operator
     */
    public function __construct(string $operator, Expression $operand, FileSpan $span)
    {
        $this->operator = $operator;
        $this->operand = $operand;
        $this->span = $span;
    }

    /**
     * @return UnaryOperator::*
     */
    public function getOperator()
    {
        return $this->operator;
    }

    public function getOperand(): Expression
    {
        return $this->operand;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accepts(ExpressionVisitor $visitor)
    {
        return $visitor->visitUnaryOperationExpression($this);
    }
}
