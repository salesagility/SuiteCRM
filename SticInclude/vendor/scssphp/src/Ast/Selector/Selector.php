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

use ScssPhp\ScssPhp\Serializer\Serializer;
use ScssPhp\ScssPhp\Util\Equatable;
use ScssPhp\ScssPhp\Visitor\SelectorVisitor;

/**
 * A node in the abstract syntax tree for a selector.
 *
 * This selector tree is mostly plain CSS, but also may contain a
 * {@see ParentSelector} or a {@see PlaceholderSelector}.
 *
 * Selectors have structural equality semantics
 */
abstract class Selector implements Equatable
{
    /**
     * Whether this selector, and complex selectors containing it, should not be
     * emitted.
     */
    public function isInvisible(): bool
    {
        return false;
    }

    /**
     * Calls the appropriate visit method on $visitor.
     *
     * @template T
     *
     * @param SelectorVisitor<T> $visitor
     *
     * @return T
     *
     * @internal
     */
    abstract public function accept(SelectorVisitor $visitor);

    final public function __toString(): string
    {
        return Serializer::serializeSelector($this, true);
    }
}
