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

use ScssPhp\ScssPhp\Ast\Selector\SelectorList;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * A modifiable version of {@see CssStyleRule} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssStyleRule extends ModifiableCssParentNode implements CssStyleRule
{
    /**
     * @var ModifiableCssValue<SelectorList>
     * @readonly
     */
    private $selector;

    /**
     * @var SelectorList
     * @readonly
     */
    private $originalSelector;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param ModifiableCssValue<SelectorList> $selector
     * @param FileSpan                         $span
     * @param SelectorList|null                $originalSelector
     */
    public function __construct(ModifiableCssValue $selector, FileSpan $span, ?SelectorList $originalSelector = null)
    {
        parent::__construct();
        $this->selector = $selector;
        $this->originalSelector = $originalSelector ?? $selector->getValue();
        $this->span = $span;
    }

    /**
     * @phpstan-return ModifiableCssValue<SelectorList>
     */
    public function getSelector(): CssValue
    {
        return $this->selector;
    }

    public function getOriginalSelector(): SelectorList
    {
        return $this->originalSelector;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept($visitor)
    {
        return $visitor->visitCssStyleRule($this);
    }

    /**
     * @phpstan-return ModifiableCssStyleRule
     */
    public function copyWithoutChildren(): ModifiableCssParentNode
    {
        return new ModifiableCssStyleRule($this->selector, $this->span, $this->originalSelector);
    }
}
