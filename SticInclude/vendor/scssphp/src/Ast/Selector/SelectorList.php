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

use ScssPhp\ScssPhp\Exception\SassFormatException;
use ScssPhp\ScssPhp\Exception\SassScriptException;
use ScssPhp\ScssPhp\Extend\ExtendUtil;
use ScssPhp\ScssPhp\Logger\LoggerInterface;
use ScssPhp\ScssPhp\Parser\SelectorParser;
use ScssPhp\ScssPhp\Util\EquatableUtil;
use ScssPhp\ScssPhp\Util\ListUtil;
use ScssPhp\ScssPhp\Value\ListSeparator;
use ScssPhp\ScssPhp\Value\SassList;
use ScssPhp\ScssPhp\Value\SassString;
use ScssPhp\ScssPhp\Visitor\SelectorVisitor;

/**
 * A selector list.
 *
 * A selector list is composed of {@see ComplexSelector}s. It matches an element
 * that matches any of the component selectors.
 */
final class SelectorList extends Selector
{
    /**
     * The components of this selector.
     *
     * This is never empty.
     *
     * @var list<ComplexSelector>
     * @readonly
     */
    private $components;

    /**
     * Parses a selector list from $contents.
     *
     * If passed, $url is the name of the file from which $contents comes.
     * $allowParent and $allowPlaceholder control whether {@see ParentSelector}s or
     * {@see PlaceholderSelector}s are allowed in this selector, respectively.
     *
     * @throws SassFormatException if parsing fails.
     */
    public static function parse(string $contents, ?LoggerInterface $logger = null, ?string $url = null, bool $allowParent = true, bool $allowPlaceholder = true): SelectorList
    {
        return (new SelectorParser($contents, $logger, $url, $allowParent, $allowPlaceholder))->parse();
    }

    /**
     * @param list<ComplexSelector> $components
     */
    public function __construct(array $components)
    {
        if ($components === []) {
            throw new \InvalidArgumentException('components may not be empty.');
        }

        $this->components = $components;
    }

    /**
     * @return list<ComplexSelector>
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function isInvisible(): bool
    {
        foreach ($this->components as $component) {
            if (!$component->isInvisible()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns a SassScript list that represents this selector.
     *
     * This has the same format as a list returned by `selector-parse()`.
     */
    public function asSassList(): SassList
    {
        return new SassList(array_map(static function (ComplexSelector $complex) {
            return new SassList(array_map(static function($component) {
                return new SassString((string) $component, false);
            }, $complex->getComponents()), ListSeparator::SPACE);
        }, $this->components), ListSeparator::COMMA);
    }

    public function accept(SelectorVisitor $visitor)
    {
        return $visitor->visitSelectorList($this);
    }

    /**
     * Returns a {@see SelectorList} that matches only elements that are matched by
     * both this and $other.
     *
     * If no such list can be produced, returns `null`.
     */
    public function unify(SelectorList $other): ?SelectorList
    {
        $contents = [];

        foreach ($this->components as $complex1) {
            foreach ($other->components as $complex2) {
                $unified = ExtendUtil::unifyComplex([$complex1->getComponents(), $complex2->getComponents()]);

                if ($unified === null) {
                    continue;
                }

                foreach ($unified as $complex) {
                    $contents[] = new ComplexSelector($complex);
                }
            }
        }

        return \count($contents) === 0 ? null : new SelectorList($contents);
    }

    /**
     * Returns a new list with all {@see ParentSelector}s replaced with $parent.
     *
     * If $implicitParent is true, this treats [ComplexSelector]s that don't
     * contain an explicit {@see ParentSelector} as though they began with one.
     *
     * The given $parent may be `null`, indicating that this has no parents. If
     * so, this list is returned as-is if it doesn't contain any explicit
     * {@see ParentSelector}s. If it does, this throws a {@see SassScriptException}.
     */
    public function resolveParentSelectors(?SelectorList $parent, bool $implicitParent = true): SelectorList
    {
        if ($parent === null) {
            if (!$this->containsParentSelector()) {
                return $this;
            }

            throw new SassScriptException('Top-level selectors may not contain the parent selector "&".');
        }

        return new SelectorList(ListUtil::flattenVertically(array_map(function (ComplexSelector $complex) use ($parent, $implicitParent) {
            if (!self::complexContainsParentSelector($complex)) {
                if (!$implicitParent) {
                    return [$complex];
                }

                return array_map(function (ComplexSelector $parentComplex) use ($complex) {
                    return new ComplexSelector(
                        array_merge($parentComplex->getComponents(), $complex->getComponents()),
                        $complex->getLineBreak() || $parentComplex->getLineBreak()
                    );
                }, $parent->getComponents());
            }

            $newComplexes = [[]];
            $lineBreaks = [false];

            foreach ($complex->getComponents() as $component) {
                if ($component instanceof CompoundSelector) {
                    $resolved = self::resolveParentSelectorsCompound($component, $parent);
                    if ($resolved === null) {
                        foreach ($newComplexes as &$newComplex) {
                            $newComplex[] = $component;
                        }
                        unset($newComplex);
                        continue;
                    }

                    $previousComplexes = $newComplexes;
                    $previousLineBreaks = $lineBreaks;

                    $newComplexes = [];
                    $lineBreaks = [];
                    $i = 0;

                    foreach ($previousComplexes as $newComplex) {
                        $lineBreak = $previousLineBreaks[$i++];

                        foreach ($resolved as $resolvedComplex) {
                            $newComplexes[] = array_merge($newComplex, $resolvedComplex->getComponents());
                            $lineBreaks[] = $lineBreak || $resolvedComplex->getLineBreak();
                        }
                    }
                } else {
                    foreach ($newComplexes as &$newComplex) {
                        $newComplex[] = $component;
                    }
                    unset($newComplex);
                }
            }

            $i = 0;

            return array_map(function ($newComplex) use ($lineBreaks, &$i) {
                return new ComplexSelector($newComplex, $lineBreaks[$i++]);
            }, $newComplexes);
        }, $this->components)));
    }

    /**
     * Whether this is a superselector of $other.
     *
     * That is, whether this matches every element that $other matches, as well
     * as possibly additional elements.
     */
    public function isSuperselector(SelectorList $other): bool
    {
        return ExtendUtil::listIsSuperselector($this->components, $other->components);
    }

    public function equals(object $other): bool
    {
        return $other instanceof SelectorList && EquatableUtil::listEquals($this->components, $other->components);
    }

    /**
     * Whether this contains a {@see ParentSelector}.
     */
    private function containsParentSelector(): bool
    {
        foreach ($this->components as $component) {
            if (self::complexContainsParentSelector($component)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns whether $complex contains a {@see ParentSelector}.
     */
    private static function complexContainsParentSelector(ComplexSelector $complex): bool
    {
        foreach ($complex->getComponents() as $component) {
            if (!$component instanceof CompoundSelector) {
                continue;
            }

            foreach ($component->getComponents() as $simple) {
                if ($simple instanceof ParentSelector) {
                    return true;
                }

                if (!$simple instanceof PseudoSelector) {
                    continue;
                }

                $selector = $simple->getSelector();
                if ($selector !== null && $selector->containsParentSelector()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Returns a new {@see CompoundSelector} based on $compound with all
     * {@see ParentSelector}s replaced with $parent.
     *
     * Returns `null` if $compound doesn't contain any {@see ParentSelector}s.
     *
     * @return list<ComplexSelector>|null
     */
    private static function resolveParentSelectorsCompound(CompoundSelector $compound, SelectorList $parent): ?array
    {
        $containsSelectorPseudo = false;
        foreach ($compound->getComponents() as $simple) {
            if (!$simple instanceof PseudoSelector) {
                continue;
            }
            $selector = $simple->getSelector();

            if ($selector !== null && $selector->containsParentSelector()) {
                $containsSelectorPseudo = true;
                break;
            }
        }

        if (!$containsSelectorPseudo && !$compound->getComponents()[0] instanceof ParentSelector) {
            return null;
        }

        if ($containsSelectorPseudo) {
            $resolvedMembers = array_map(function (SimpleSelector $simple) use ($parent): SimpleSelector {
                if (!$simple instanceof PseudoSelector) {
                    return $simple;
                }

                $selector = $simple->getSelector();
                if ($selector === null) {
                    return $simple;
                }
                if (!$selector->containsParentSelector()) {
                    return $simple;
                }

                return $simple->withSelector($selector->resolveParentSelectors($parent, false));
            }, $compound->getComponents());
        } else {
            $resolvedMembers = $compound->getComponents();
        }

        $parentSelector = $compound->getComponents()[0];

        if ($parentSelector instanceof ParentSelector) {
            if (\count($compound->getComponents()) === 1 && $parentSelector->getSuffix() === null) {
                return $parent->getComponents();
            }
        } else {
            return [
                new ComplexSelector([new CompoundSelector($resolvedMembers)]),
            ];
        }

        return array_map(function (ComplexSelector $complex) use ($parentSelector, $resolvedMembers) {
            $lastComponent = $complex->getLastComponent();

            if (!$lastComponent instanceof CompoundSelector) {
                throw new SassScriptException("Parent \"$complex\" is incompatible with this selector.");
            }

            $last = $lastComponent;
            $suffix = $parentSelector->getSuffix();

            if ($suffix !== null) {
                $last = new CompoundSelector(array_merge(
                    array_slice($last->getComponents(), 0, -1),
                    [$last->getLastComponent()->addSuffix($suffix)],
                    array_slice($resolvedMembers, 1)
                ));
            } else {
                $last = new CompoundSelector(array_merge($last->getComponents(), array_slice($resolvedMembers, 1)));
            }

            $components = array_slice($complex->getComponents(), 0, -1);
            $components[] = $last;

            return new ComplexSelector($components, $complex->getLineBreak());
        }, $parent->getComponents());
    }
}
