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

/**
 * A plain CSS `@import`.
 *
 * @internal
 */
interface CssImport extends CssNode
{
    /**
     * The URL being imported.
     *
     * This includes quotes.
     *
     * @return CssValue<string>
     */
    public function getUrl(): CssValue;

    /**
     * The supports condition attached to this import.
     *
     * @return CssValue<string>|null
     */
    public function getSupports(): ?CssValue;

    /**
     * The media query attached to this import.
     *
     * @return list<CssMediaQuery>|null
     */
    public function getMedia(): ?array;
}
