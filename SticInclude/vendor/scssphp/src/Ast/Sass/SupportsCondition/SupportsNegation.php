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
 * A negated condition.
 *
 * @internal
 */
final class SupportsNegation implements SupportsCondition
{
    /**
     * The condition that's been negated.
     *
     * @var SupportsCondition
     * @readonly
     */
    private $condition;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    public function __construct(SupportsCondition $condition, FileSpan $span)
    {
        $this->condition = $condition;
        $this->span = $span;
    }

    public function getCondition(): SupportsCondition
    {
        return $this->condition;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }
}
