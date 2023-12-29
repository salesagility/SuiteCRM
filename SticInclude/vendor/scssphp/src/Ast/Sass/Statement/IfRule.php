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

use ScssPhp\ScssPhp\Ast\Sass\Statement;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Visitor\StatementVisitor;

/**
 * An `@if` rule.
 *
 * This conditionally executes a block of code.
 *
 * @internal
 */
final class IfRule implements Statement
{
    /**
     * @var IfClause[]
     * @readonly
     */
    private $clauses;

    /**
     * @var ElseClause|null
     * @readonly
     */
    private $lastClause;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param IfClause[] $clauses
     */
    public function __construct(array $clauses, FileSpan $span, ?ElseClause $lastClause = null)
    {
        $this->clauses = $clauses;
        $this->span = $span;
        $this->lastClause = $lastClause;
    }

    /**
     * The `@if` and `@else if` clauses.
     *
     * The first clause whose expression evaluates to `true` will have its
     * statements executed. If no expression evaluates to `true`, `lastClause`
     * will be executed if it's not `null`.
     *
     * @return IfClause[]
     */
    public function getClauses(): array
    {
        return $this->clauses;
    }

    /**
     * The final, unconditional `@else` clause.
     *
     * This is `null` if there is no unconditional `@else`.
     *
     * @return ElseClause|null
     */
    public function getLastClause(): ?ElseClause
    {
        return $this->lastClause;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accepts(StatementVisitor $visitor)
    {
        return $visitor->visitIfRule($this);
    }
}
