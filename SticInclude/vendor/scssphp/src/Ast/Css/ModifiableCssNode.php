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

use ScssPhp\ScssPhp\Visitor\ModifiableCssVisitor;

/**
 * A modifiable version of {@see CssNode}.
 *
 * Almost all CSS nodes are the modifiable classes under the covers. However,
 * modification should only be done within the evaluation step, so the
 * unmodifiable types are used elsewhere to enforce that constraint.
 *
 * @internal
 */
abstract class ModifiableCssNode implements CssNode
{
    /**
     * @var ModifiableCssParentNode|null
     */
    private $parent;

    /**
     * The index of `$this` in parent's children.
     *
     * This makes {@see remove} more efficient.
     *
     * @var int|null
     */
    private $indexInParent;

    /**
     * @var bool
     */
    private $groupEnd = false;

    public function getParent(): ?ModifiableCssParentNode
    {
        return $this->parent;
    }

    protected function setParent(ModifiableCssParentNode $parent, int $indexInParent): void
    {
        $this->parent = $parent;
        $this->indexInParent = $indexInParent;
    }

    public function isGroupEnd(): bool
    {
        return $this->groupEnd;
    }

    public function setGroupEnd(bool $groupEnd): void
    {
        $this->groupEnd = $groupEnd;
    }

    /**
     * Whether this node has a visible sibling after it.
     */
    public function hasFollowingSibling(): bool
    {
        $parent = $this->parent;

        if ($parent === null) {
            return false;
        }

        assert($this->indexInParent !== null);
        $siblings = $parent->getChildren();

        for ($i = $this->indexInParent + 1; $i < \count($siblings); $i++) {
            $sibling = $siblings[$i];

            if (!$this->isInvisible($sibling)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns whether $node is invisible for the purposes of
     * {@see hasFollowingSibling}.
     *
     * This can return a false negative for a comment node in compressed mode,
     * since the AST doesn't know the output style, but that's an extremely
     * narrow edge case so we don't worry about it.
     */
    private function isInvisible(CssNode $node): bool
    {
        if ($node instanceof CssParentNode) {
            // An unknown at-rule is never invisible. Because we don't know the
            // semantics of unknown rules, we can't guarantee that (for example)
            // `@foo {}` isn't meaningful.
            if ($node instanceof CssAtRule) {
                return false;
            }

            if ($node instanceof CssStyleRule && $node->getSelector()->getValue()->isInvisible()) {
                return true;
            }

            foreach ($node->getChildren() as $child) {
                if (!$this->isInvisible($child)) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Calls the appropriate visit method on $visitor.
     *
     * @template T
     *
     * @param ModifiableCssVisitor<T> $visitor
     *
     * @return T
     */
    abstract public function accept($visitor);

    /**
     * Removes $this from {@see parent}'s child list.
     *
     * @throws \LogicException if {@see parent} is `null`.
     */
    public function remove(): void
    {
        $parent = $this->parent;

        if ($parent === null) {
            throw new \LogicException("Can't remove a node without a parent.");
        }

        assert($this->indexInParent !== null);

        $parent->removeChildAt($this->indexInParent);
        $children = $parent->getChildren();

        for ($i = $this->indexInParent; $i < \count($children); $i++) {
            $child = $children[$i];
            assert($child->indexInParent !== null);
            $child->indexInParent = $child->indexInParent - 1;
        }
        $this->parent = null;
        $this->indexInParent = null;
    }
}
