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

namespace ScssPhp\ScssPhp\Ast\Selector;

/**
 * A combinator that defines the relationship between selectors in a
 * {@see ComplexSelector}.
 */
final class Combinator
{
    /**
     * Matches the right-hand selector if it's immediately adjacent to the
     * left-hand selector in the DOM tree.
     */
    public const NEXT_SIBLING = '+';

    /**
     * Matches the right-hand selector if it's a direct child of the left-hand
     * selector in the DOM tree.
     */
    public const CHILD = '>';

    /**
     * Matches the right-hand selector if it comes after the left-hand selector
     * in the DOM tree.
     */
    public const FOLLOWING_SIBLING = '~';
}
