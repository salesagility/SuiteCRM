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

use ScssPhp\ScssPhp\Ast\Sass\ArgumentInvocation;
use ScssPhp\ScssPhp\Ast\Sass\Statement;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Visitor\StatementVisitor;

/**
 * A `@content` rule.
 *
 * This is used in a mixin to include statement-level content passed by the
 * caller.
 *
 * @internal
 */
final class ContentRule implements Statement
{
    /**
     * The arguments pass to this `@content` rule.
     *
     * This will be an empty invocation if `@content` has no arguments.
     *
     * @var ArgumentInvocation
     * @readonly
     */
    private $arguments;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    public function __construct(ArgumentInvocation $arguments, FileSpan $span)
    {
        $this->arguments = $arguments;
        $this->span = $span;
    }

    public function getArguments(): ArgumentInvocation
    {
        return $this->arguments;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accepts(StatementVisitor $visitor)
    {
        return $visitor->visitContentRule($this);
    }
}
