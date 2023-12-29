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
 * A modifiable version of {@see CssValue} for use in the evaluation step.
 *
 * @template T
 * @template-extends CssValue<T>
 *
 * @internal
 */
class ModifiableCssValue extends CssValue
{
    /**
     * @param T $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
}
