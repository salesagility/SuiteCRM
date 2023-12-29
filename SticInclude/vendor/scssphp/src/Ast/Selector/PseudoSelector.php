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

use ScssPhp\ScssPhp\Util;
use ScssPhp\ScssPhp\Util\EquatableUtil;
use ScssPhp\ScssPhp\Visitor\SelectorVisitor;

/**
 * A pseudo-class or pseudo-element selector.
 *
 * The semantics of a specific pseudo selector depends on its name. Some
 * selectors take arguments, including other selectors. Sass manually encodes
 * logic for each pseudo selector that takes a selector as an argument, to
 * ensure that extension and other selector operations work properly.
 */
final class PseudoSelector extends SimpleSelector
{
    /**
     * The name of this selector.
     *
     * @var string
     * @readonly
     */
    private $name;

    /**
     * Like {@see name}, but without any vendor prefixes.
     *
     * @var string
     * @readonly
     */
    private $normalizedName;

    /**
     * @var bool
     * @readonly
     */
    private $isClass;

    /**
     * @var bool
     * @readonly
     */
    private $isSyntacticClass;

    /**
     * The non-selector argument passed to this selector.
     *
     * This is `null` if there's no argument. If {@see argument} and {@see selector} are
     * both non-`null`, the selector follows the argument.
     *
     * @var string|null
     * @readonly
     */
    private $argument;

    /**
     * The selector argument passed to this selector.
     *
     * This is `null` if there's no selector. If {@see argument} and {@see selector} are
     * both non-`null`, the selector follows the argument.
     *
     * @var SelectorList|null
     * @readonly
     */
    private $selector;

    /**
     * @var int|null
     */
    private $minSpecificity;

    /**
     * @var int|null
     */
    private $maxSpecificity;

    public function __construct(string $name, bool $element = false, ?string $argument = null, ?SelectorList $selector = null)
    {
        $this->name = $name;
        $this->isClass = !$element && !self::isFakePseudoElement($name);
        $this->isSyntacticClass = !$element;
        $this->argument = $argument;
        $this->selector = $selector;
        $this->normalizedName = Util::unvendor($name);
    }

    /**
     * Returns whether $name is the name of a pseudo-element that can be written
     * with pseudo-class syntax (`:before`, `:after`, `:first-line`, or
     * `:first-letter`)
     */
    private static function isFakePseudoElement(string $name): bool
    {
        if ($name === '') {
            return false;
        }

        switch ($name[0]) {
            case 'a':
            case 'A':
                return strtolower($name) === 'after';

            case 'b':
            case 'B':
                return strtolower($name) === 'before';

            case 'f':
            case 'F':
                $lowerCasedName = strtolower($name);

                return $lowerCasedName === 'first-line' || $lowerCasedName === 'first-letter';

            default:
                return false;
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNormalizedName(): string
    {
        return $this->normalizedName;
    }

    /**
     * Whether this is a pseudo-class selector.
     *
     * This is `true` if and only if {@see isElement} is `false`.
     */
    public function isClass(): bool
    {
        return $this->isClass;
    }

    /**
     * Whether this is a pseudo-element selector.
     *
     * This is `true` if and only if {@see isClass} is `false`.
     */
    public function isElement(): bool
    {
        return !$this->isClass;
    }

    /**
     * Whether this is syntactically a pseudo-class selector.
     *
     * This is the same as {@see isClass} unless this selector is a pseudo-element
     * that was written syntactically as a pseudo-class (`:before`, `:after`,
     * `:first-line`, or `:first-letter`).
     *
     * This is `true` if and only if {@see isSyntacticElement} is `false`.
     */
    public function isSyntacticClass(): bool
    {
        return $this->isSyntacticClass;
    }

    /**
     * Whether this is syntactically a pseudo-element selector.
     *
     * This is `true` if and only if {@see isSyntacticClass} is `false`.
     */
    public function isSyntacticElement(): bool
    {
        return !$this->isSyntacticClass;
    }

    /**
     * Whether this is a valid `:host` selector.
     *
     * @internal
     */
    public function isHost(): bool
    {
        return $this->isClass && $this->name === 'host';
    }

    /**
     * Whether this is a valid `:host-context` selector.
     *
     * @internal
     */
    public function isHostContext(): bool
    {
        return $this->isClass && $this->name === 'host-context' && $this->selector !== null;
    }

    public function getArgument(): ?string
    {
        return $this->argument;
    }

    public function getSelector(): ?SelectorList
    {
        return $this->selector;
    }

    public function getMinSpecificity(): int
    {
        if ($this->minSpecificity === null) {
            $this->computeSpecificity();
            assert($this->minSpecificity !== null);
        }

        return $this->minSpecificity;
    }

    public function getMaxSpecificity(): int
    {
        if ($this->maxSpecificity === null) {
            $this->computeSpecificity();
            assert($this->maxSpecificity !== null);
        }

        return $this->maxSpecificity;
    }

    public function isInvisible(): bool
    {
        if ($this->selector === null) {
            return false;
        }

        // We don't consider `:not(%foo)` to be invisible because, semantically, it
        // means "doesn't match this selector that matches nothing", so it's
        // equivalent to *. If the entire compound selector is composed of `:not`s
        // with invisible lists, the serializer emits it as `*`.
        return 'not' !== $this->name && $this->selector->isInvisible();
    }

    public function withSelector(SelectorList $selector): PseudoSelector
    {
        return new PseudoSelector($this->name, $this->isElement(), $this->argument, $selector);
    }

    public function addSuffix(string $suffix): SimpleSelector
    {
        if ($this->argument !== null || $this->selector !== null) {
            parent::addSuffix($suffix);
        }

        return new PseudoSelector($this->name . $suffix, $this->isElement());
    }

    public function unify(array $compound): ?array
    {
        if ($this->name === 'host' || $this->name === 'host-context') {
            foreach ($compound as $simple) {
                if (!$simple instanceof PseudoSelector || (!$simple->isHost() && $simple->selector === null)) {
                    return null;
                }
            }
        } elseif (\count($compound) === 1) {
            $other = $compound[0];

            if ($other instanceof UniversalSelector || $other instanceof PseudoSelector && ($other->isHost() || $other->isHostContext())) {
                return $other->unify([$this]);
            }
        }

        if (EquatableUtil::listContains($compound, $this)) {
            return $compound;
        }

        $result = [];
        $addedThis = false;

        foreach ($compound as $simple) {
            if ($simple instanceof PseudoSelector && $simple->isElement()) {
                // A given compound selector may only contain one pseudo element. If
                // $compound has a different one than $this, unification fails.
                if ($this->isElement()) {
                    return null;
                }

                // Otherwise, this is a pseudo selector and should come before pseudo
                // elements.
                $result[] = $this;
                $addedThis = true;
            }

            $result[] = $simple;
        }

        if (!$addedThis) {
            $result[] = $this;
        }

        return $result;
    }

    public function accept(SelectorVisitor $visitor)
    {
        return $visitor->visitPseudoSelector($this);
    }

    public function equals(object $other): bool
    {
        return $other instanceof PseudoSelector &&
            $other->name === $this->name &&
            $other->isClass === $this->isClass &&
            $other->argument === $this->argument &&
            ($this->selector === $other->selector || ($this->selector !== null && $other->selector !== null && $this->selector->equals($other->selector)));
    }

    /**
     * Computes {@see minSpecificity} and {@see maxSpecificity}.
     */
    private function computeSpecificity(): void
    {
        if ($this->isElement()) {
            $this->minSpecificity = 1;
            $this->maxSpecificity = 1;

            return;
        }

        $selector = $this->selector;

        if ($selector === null) {
            $this->minSpecificity = parent::getMinSpecificity();
            $this->maxSpecificity = parent::getMaxSpecificity();

            return;
        }

        if ($this->name === 'not') {
            $minSpecificity = 0;
            $maxSpecificity = 0;

            foreach ($selector->getComponents() as $complex) {
                $minSpecificity = max($minSpecificity, $complex->getMinSpecificity());
                $maxSpecificity = max($maxSpecificity, $complex->getMaxSpecificity());
            }

            $this->minSpecificity = $minSpecificity;
            $this->maxSpecificity = $maxSpecificity;
        } else {
            // This is higher than any selector's specificity can actually be.
            $minSpecificity = parent::getMinSpecificity() ** 3;
            $maxSpecificity = 0;

            foreach ($selector->getComponents() as $complex) {
                $minSpecificity = min($minSpecificity, $complex->getMinSpecificity());
                $maxSpecificity = max($maxSpecificity, $complex->getMaxSpecificity());
            }

            $this->minSpecificity = $minSpecificity;
            $this->maxSpecificity = $maxSpecificity;
        }
    }
}
