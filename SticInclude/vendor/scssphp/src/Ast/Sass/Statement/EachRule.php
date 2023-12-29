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
 * An `@each` rule.
 *
 * This iterates over values in a list or map.
 *
 * @extends ParentStatement<Statement[]>
 *
 * @internal
 */
final class EachRule extends ParentStatement
{
    /**
     * @var string[]
     * @readonly
     */
    private $variables;

    /**
     * @var Expression
     * @readonly
     */
    private $list;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param string[]    $variables
     * @param Statement[] $children
     */
    public function __construct(array $variables, Expression $list, array $children, FileSpan $span)
    {
        $this->variables = $variables;
        $this->list = $list;
        $this->span = $span;
        parent::__construct($children);
    }

    /**
     * @return string[]
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    public function getList(): Expression
    {
        return $this->list;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accepts(StatementVisitor $visitor)
    {
        return $visitor->visitEachRule($this);
    }
}
