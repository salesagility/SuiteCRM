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

namespace ScssPhp\ScssPhp\Ast\Sass\Statement;

use ScssPhp\ScssPhp\Ast\Sass\Expression;
use ScssPhp\ScssPhp\Ast\Sass\Statement;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Visitor\StatementVisitor;

/**
 * A `@for` rule.
 *
 * This iterates a set number of times.
 *
 * @extends ParentStatement<Statement[]>
 *
 * @internal
 */
final class ForRule extends ParentStatement
{
    /**
     * @var string
     * @readonly
     */
    private $variable;

    /**
     * @var Expression
     * @readonly
     */
    private $from;

    /**
     * @var Expression
     * @readonly
     */
    private $to;

    /**
     * @var bool
     * @readonly
     */
    private $exclusive;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param Statement[] $children
     */
    public function __construct(string $variable, Expression $from, Expression $to, array $children, FileSpan $span, bool $exclusive = false)
    {
        $this->variable = $variable;
        $this->from = $from;
        $this->to = $to;
        $this->exclusive = $exclusive;
        $this->span = $span;
        parent::__construct($children);
    }

    public function getVariable(): string
    {
        return $this->variable;
    }

    public function getFrom(): Expression
    {
        return $this->from;
    }

    public function getTo(): Expression
    {
        return $this->to;
    }

    /**
     * Whether {@see getTo} is exclusive.
     */
    public function isExclusive(): bool
    {
        return $this->exclusive;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accepts(StatementVisitor $visitor)
    {
        return $visitor->visitForRule($this);
    }
}
