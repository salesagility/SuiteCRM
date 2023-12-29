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
 * A number literal.
 *
 * @internal
 */
final class NumberExpression implements Expression
{
    /**
     * @var float|int
     * @readonly
     */
    private $value;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @var string|null
     * @readonly
     */
    private $unit;

    /**
     * @param int|float $value
     */
    public function __construct($value, FileSpan $span, ?string $unit = null)
    {
        $this->value = $value;
        $this->span = $span;
        $this->unit = $unit;
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function accepts(ExpressionVisitor $visitor)
    {
        return $visitor->visitNumberExpression($this);
    }
}
