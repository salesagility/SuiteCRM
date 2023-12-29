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
use ScssPhp\ScssPhp\Value\Value;

/**
 * A plain CSS declaration (that is, a `name: value` pair).
 *
 * @internal
 */
interface CssDeclaration extends CssNode
{
    /**
     * The name of this declaration.
     *
     * @return CssValue<string>
     */
    public function getName(): CssValue;

    /**
     * The value of this declaration.
     *
     * @return CssValue<Value>
     */
    public function getValue(): CssValue;

    /**
     * The span for {@see getValue} that should be emitted to the source map.
     *
     * When the declaration's expression is just a variable, this is the span
     * where that variable was declared whereas `$this->getValue()->getSpan()` is the span where
     * the variable was used. Otherwise, this is identical to `$this->getValue()->getSpan()`.
     */
    public function getValueSpanForMap(): FileSpan;

    /**
     * Returns whether this is a CSS Custom Property declaration.
     */
    public function isCustomProperty(): bool;

    /**
     * Whether this was originally parsed as a custom property declaration, as
     * opposed to using something like `#{--foo}: ...` to cause it to be parsed
     * as a normal Sass declaration.
     *
     * If this is `true`, {@see isCustomProperty} will also be `true` and {@see getValue} will
     * contain a {@see SassString}.
     */
    public function isParsedAsCustomProperty(): bool;
}
