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
 * A modifiable version of {@see CssMediaRule} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssMediaRule extends ModifiableCssParentNode implements CssMediaRule
{
    /**
     * @var list<CssMediaQuery>
     */
    private $queries;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param CssMediaQuery[] $queries
     * @param FileSpan        $span
     */
    public function __construct(array $queries, FileSpan $span)
    {
        parent::__construct();
        $this->queries = $queries;
        $this->span = $span;
    }

    public function getQueries(): array
    {
        return $this->queries;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept($visitor)
    {
        return $visitor->visitCssMediaRule($this);
    }

    public function copyWithoutChildren(): ModifiableCssParentNode
    {
        return new ModifiableCssMediaRule($this->queries, $this->span);
    }
}
