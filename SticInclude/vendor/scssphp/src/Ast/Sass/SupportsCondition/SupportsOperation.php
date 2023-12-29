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

namespace ScssPhp\ScssPhp\Ast\Sass\SupportsCondition;

use ScssPhp\ScssPhp\Ast\Sass\SupportsCondition;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * An operation defining the relationship between two conditions.
 *
 * @internal
 */
final class SupportsOperation implements SupportsCondition
{
    /**
     * The left-hand operand.
     *
     * @var SupportsCondition
     * @readonly
     */
    private $left;

    /**
     * The right-hand operand.
     *
     * @var SupportsCondition
     * @readonly
     */
    private $right;

    /**
     * @var string
     * @readonly
     */
    private $operator;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    public function __construct(SupportsCondition $left, SupportsCondition $right, string $operator, FileSpan $span)
    {
        $this->left = $left;
        $this->right = $right;
        $this->operator = $operator;
        $this->span = $span;
    }

    public function getLeft(): SupportsCondition
    {
        return $this->left;
    }

    public function getRight(): SupportsCondition
    {
        return $this->right;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }
}
