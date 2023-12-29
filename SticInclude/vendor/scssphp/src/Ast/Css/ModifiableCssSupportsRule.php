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

namespace ScssPhp\ScssPhp\Ast\Css;

use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * A modifiable version of {@see CssSupportsRule} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssSupportsRule extends ModifiableCssParentNode implements CssSupportsRule
{
    /**
     * @var CssValue<string>
     * @readonly
     */
    private $condition;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param CssValue<string> $condition
     * @param FileSpan         $span
     */
    public function __construct(CssValue $condition, FileSpan $span)
    {
        parent::__construct();
        $this->condition = $condition;
        $this->span = $span;
    }

    public function getCondition(): CssValue
    {
        return $this->condition;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept($visitor)
    {
        return $visitor->visitCssSupportsRule($this);
    }

    /**
     * @phpstan-return ModifiableCssSupportsRule
     */
    public function copyWithoutChildren(): ModifiableCssParentNode
    {
        return new ModifiableCssSupportsRule($this->condition, $this->span);
    }
}
