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
 * A modifiable version of {@see CssKeyframeBlock} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssKeyframeBlock extends ModifiableCssParentNode implements CssKeyframeBlock
{
    /**
     * @var CssValue<list<string>>
     * @readonly
     */
    private $selector;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param CssValue<list<string>> $selector
     * @param FileSpan               $span
     */
    public function __construct(CssValue $selector, FileSpan $span)
    {
        parent::__construct();
        $this->selector = $selector;
        $this->span = $span;
    }

    public function getSelector(): CssValue
    {
        return $this->selector;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept($visitor)
    {
        return $visitor->visitCssKeyframeBlock($this);
    }

    /**
     * @phpstan-return ModifiableCssKeyframeBlock
     */
    public function copyWithoutChildren(): ModifiableCssParentNode
    {
        return new ModifiableCssKeyframeBlock($this->selector, $this->span);
    }
}
