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
use ScssPhp\ScssPhp\Value\ListSeparator;
use ScssPhp\ScssPhp\Visitor\ExpressionVisitor;

/**
 * A list literal.
 *
 * @internal
 */
final class ListExpression implements Expression
{
    /**
     * @var Expression[]
     * @readonly
     */
    private $contents;

    /**
     * @var ListSeparator::*
     * @readonly
     */
    private $separator;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @var bool
     * @readonly
     */
    private $brackets;

    /**
     * ListExpression constructor.
     *
     * @param Expression[] $contents
     * @param ListSeparator::* $separator
     */
    public function __construct(array $contents, string $separator, FileSpan $span, bool $brackets = false)
    {
        $this->contents = $contents;
        $this->separator = $separator;
        $this->span = $span;
        $this->brackets = $brackets;
    }

    /**
     * @return Expression[]
     */
    public function getContents(): array
    {
        return $this->contents;
    }

    /**
     * @return ListSeparator::*
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    public function hasBrackets(): bool
    {
        return $this->brackets;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accepts(ExpressionVisitor $visitor)
    {
        return $visitor->visitListExpression($this);
    }
}
