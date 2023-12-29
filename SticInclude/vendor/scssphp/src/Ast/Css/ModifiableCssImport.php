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
 * A modifiable version of {@see CssImport} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssImport extends ModifiableCssNode implements CssImport
{
    /**
     * The URL being imported.
     *
     * This includes quotes.
     *
     * @var CssValue<string>
     * @readonly
     */
    private $url;

    /**
     * @var CssValue<string>|null
     * @readonly
     */
    private $supports;

    /**
     * @var list<CssMediaQuery>|null
     * @readonly
     */
    private $media;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param CssValue<string>         $url
     * @param FileSpan                 $span
     * @param CssValue<string>|null    $supports
     * @param list<CssMediaQuery>|null $media
     */
    public function __construct(CssValue $url, FileSpan $span, ?CssValue $supports = null, ?array $media = null)
    {
        $this->url = $url;
        $this->supports = $supports;
        $this->media = $media;
        $this->span = $span;
    }

    public function getUrl(): CssValue
    {
        return $this->url;
    }

    public function getSupports(): ?CssValue
    {
        return $this->supports;
    }

    public function getMedia(): ?array
    {
        return $this->media;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept($visitor)
    {
        return $visitor->visitCssImport($this);
    }
}
