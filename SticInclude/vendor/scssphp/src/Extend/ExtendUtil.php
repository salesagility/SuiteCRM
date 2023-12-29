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

namespace ScssPhp\ScssPhp\Extend;

use ScssPhp\ScssPhp\Ast\Selector\Combinator;
use ScssPhp\ScssPhp\Ast\Selector\ComplexSelector;
use ScssPhp\ScssPhp\Ast\Selector\CompoundSelector;
use ScssPhp\ScssPhp\Ast\Selector\IDSelector;
use ScssPhp\ScssPhp\Ast\Selector\PlaceholderSelector;
use ScssPhp\ScssPhp\Ast\Selector\PseudoSelector;
use ScssPhp\ScssPhp\Ast\Selector\QualifiedName;
use ScssPhp\ScssPhp\Ast\Selector\SelectorList;
use ScssPhp\ScssPhp\Ast\Selector\SimpleSelector;
use ScssPhp\ScssPhp\Ast\Selector\TypeSelector;
use ScssPhp\ScssPhp\Ast\Selector\UniversalSelector;
use ScssPhp\ScssPhp\Util\EquatableUtil;
use ScssPhp\ScssPhp\Util\ListUtil;

/**
 * @internal
 */
final class ExtendUtil
{
    /**
     * Names of pseudo selectors that take selectors as arguments, and that are
     * subselectors of their arguments.
     *
     * For example, `.foo` is a superselector of `:matches(.foo)`.
     */
    private const SUBSELECTOR_PSEUDOS = [
        'is',
        'matches',
        'any',
        'nth-child',
        'nth-last-child',
    ];

    /**
     * @param list<list<CompoundSelector|string>> $complexes
     *
     * @return list<list<CompoundSelector|string>>|null
     *
     * @phpstan-param list<list<CompoundSelector|Combinator::*>> $complexes
     * @phpstan-return list<list<CompoundSelector|Combinator::*>>|null
     */
    public static function unifyComplex(array $complexes): ?array
    {
        assert(!empty($complexes));

        if (\count($complexes) === 1) {
            return $complexes;
        }

        $unifiedBase = null;

        foreach ($complexes as $complex) {
            $base = $complex[\count($complex) - 1];

            if (!$base instanceof CompoundSelector) {
                return null;
            }

            if ($unifiedBase === null) {
                $unifiedBase = $base->getComponents();
            } else {
                foreach ($base->getComponents() as $simple) {
                    $unifiedBase = $simple->unify($unifiedBase);

                    if ($unifiedBase === null) {
                        return null;
                    }
                }
            }
        }

        $complexesWithoutBases = array_map(static function (array $complex) {
            return array_slice($complex, 0, \count($complex) - 1);
        }, $complexes);

        $complexesWithoutBases[\count($complexesWithoutBases) - 1][] = new CompoundSelector($unifiedBase);

        return self::weave($complexesWithoutBases);
    }

    /**
     * Returns a {@see CompoundSelector} that matches only elements that are matched by
     * both $compound1 and $compound2.
     *
     * If no such selector can be produced, returns `null`.
     *
     * @param list<SimpleSelector> $compound1
     * @param list<SimpleSelector> $compound2
     *
     * @return CompoundSelector|null
     */
    public static function unifyCompound(array $compound1, array $compound2): ?CompoundSelector
    {
        $result = $compound2;

        foreach ($compound1 as $simple) {
            $unified = $simple->unify($result);

            if ($unified === null) {
                return null;
            }

            $result = $unified;
        }

        return new CompoundSelector($result);
    }

    /**
     * Returns a {@see SimpleSelector} that matches only elements that are matched by
     * both $selector1 and $selector2, which must both be either
     * {@see UniversalSelector}s or {@see TypeSelector}s.
     *
     * If no such selector can be produced, returns `null`.
     */
    public static function unifyUniversalAndElement(SimpleSelector $selector1, SimpleSelector $selector2): ?SimpleSelector
    {
        $name1 = null;
        if ($selector1 instanceof UniversalSelector) {
            $namespace1 = $selector1->getNamespace();
        } elseif ($selector1 instanceof TypeSelector) {
            $namespace1 = $selector1->getName()->getNamespace();
            $name1 = $selector1->getName()->getName();
        } else {
            throw new \InvalidArgumentException('selector1 must be a UniversalSelector or a TypeSelector');
        }

        $name2 = null;
        if ($selector2 instanceof UniversalSelector) {
            $namespace2 = $selector2->getNamespace();
        } elseif ($selector2 instanceof TypeSelector) {
            $namespace2 = $selector2->getName()->getNamespace();
            $name2 = $selector2->getName()->getName();
        } else {
            throw new \InvalidArgumentException('selector2 must be a UniversalSelector or a TypeSelector');
        }

        if ($namespace1 === $namespace2 || $namespace2 === '*') {
            $namespace = $namespace1;
        } elseif ($namespace1 === '*') {
            $namespace = $namespace2;
        } else {
            return null;
        }

        if ($name1 === $name2 || $name2 === null) {
            $name = $name1;
        } elseif ($name1 === null) {
            $name = $name2;
        } else {
            return null;
        }

        if ($name === null) {
            return new UniversalSelector($namespace);
        }

        return new TypeSelector(new QualifiedName($name, $namespace));
    }

    /**
     * Expands "parenthesized selectors" in $complexes.
     *
     * That is, if we have `.A .B {@extend .C}` and `.D .C {...}`, this
     * conceptually expands into `.D .C, .D (.A .B)`, and this function translates
     * `.D (.A .B)` into `.D .A .B, .A .D .B`. For thoroughness, `.A.D .B` would
     * also be required, but including merged selectors results in exponential
     * output for very little gain.
     *
     * The selector `.D (.A .B)` is represented as the list `[[.D], [.A, .B]]`.
     *
     * @param list<list<CompoundSelector|string>> $complexes
     *
     * @return list<list<CompoundSelector|string>>
     *
     * @phpstan-param list<list<CompoundSelector|Combinator::*>> $complexes
     * @phpstan-return list<list<CompoundSelector|Combinator::*>>
     */
    public static function weave(array $complexes): array
    {
        $prefixes = [$complexes[0]];

        foreach (array_slice($complexes, 1) as $complex) {
            if ($complex === []) {
                continue;
            }

            $target = $complex[\count($complex) - 1];

            if (\count($complex) === 1) {
                foreach ($prefixes as $i => $prefix) {
                    $prefixes[$i][] = $target;
                }

                continue;
            }

            $parents = array_slice($complex, 0, \count($complex) - 1);
            $newPrefixes = [];

            foreach ($prefixes as $prefix) {
                $parentPrefixes = self::weaveParents($prefix, $parents);

                if ($parentPrefixes === null) {
                    continue;
                }

                foreach ($parentPrefixes as $parentPrefix) {
                    $parentPrefix[] = $target;
                    $newPrefixes[] = $parentPrefix;
                }
            }

            $prefixes = $newPrefixes;
        }

        return $prefixes;
    }

    /**
     * Interweaves $parents1 and $parents2 as parents of the same target selector.
     *
     * Returns all possible orderings of the selectors in the inputs (including
     * using unification) that maintain the relative ordering of the input. For
     * example, given `.foo .bar` and `.baz .bang`, this would return `.foo .bar
     * .baz .bang`, `.foo .bar.baz .bang`, `.foo .baz .bar .bang`, `.foo .baz
     * .bar.bang`, `.foo .baz .bang .bar`, and so on until `.baz .bang .foo .bar`.
     *
     * Semantically, for selectors A and B, this returns all selectors `AB_i`
     * such that the union over all i of elements matched by `AB_i X` is
     * identical to the intersection of all elements matched by `A X` and all
     * elements matched by `B X`. Some `AB_i` are elided to reduce the size of
     * the output.
     *
     * @param list<CompoundSelector|string> $parents1
     * @param list<CompoundSelector|string> $parents2
     *
     * @return list<list<CompoundSelector|string>>|null
     *
     * @phpstan-param list<CompoundSelector|Combinator::*> $parents1
     * @phpstan-param list<CompoundSelector|Combinator::*> $parents2
     * @phpstan-return list<list<CompoundSelector|Combinator::*>>|null
     */
    private static function weaveParents(array $parents1, array $parents2): ?array
    {
        $queue1 = $parents1;
        $queue2 = $parents2;

        $initialCombinators = self::mergeInitialCombinators($queue1, $queue2);
        if ($initialCombinators === null) {
            return null;
        }
        $finalCombinators = self::mergeFinalCombinators($queue1, $queue2);
        if ($finalCombinators === null) {
            return null;
        }

        // Make sure there's at most one `:root` in the output.
        $root1 = self::firstIfRoot($queue1);
        $root2 = self::firstIfRoot($queue2);

        if ($root1 !== null && $root2 !== null) {
            $root = self::unifyCompound($root1->getComponents(), $root2->getComponents());

            if ($root === null) {
                return null;
            }

            array_unshift($queue1, $root);
            array_unshift($queue2, $root);
        } elseif ($root1 !== null) {
            array_unshift($queue2, $root1);
        } elseif ($root2 !== null) {
            array_unshift($queue1, $root2);
        }

        $groups1 = self::groupSelectors($queue1);
        $groups2 = self::groupSelectors($queue2);

        /** @phpstan-var list<list<CompoundSelector|Combinator::*>> $lcs */
        $lcs = ListUtil::longestCommonSubsequence($groups2, $groups1, function ($group1, $group2) {
            if (EquatableUtil::listEquals($group1, $group2)) {
                return $group1;
            }

            if (!$group1[0] instanceof CompoundSelector || !$group2[0] instanceof CompoundSelector) {
                return null;
            }

            if (self::complexIsParentSuperselector($group1, $group2)) {
                return $group2;
            }

            if (self::complexIsParentSuperselector($group2, $group1)) {
                return $group1;
            }

            if (!self::mustUnify($group1, $group2)) {
                return null;
            }

            $unified = self::unifyComplex([$group1, $group2]);

            if ($unified === null) {
                return null;
            }
            if (\count($unified) > 1) {
                return null;
            }

            return $unified[0];
        });

        $choices = [[$initialCombinators]];

        foreach ($lcs as $group) {
            $newChoice = [];
            /** @phpstan-var list<list<list<CompoundSelector|Combinator::*>>> $chunks */
            $chunks = self::chunks($groups1, $groups2, function ($sequence) use ($group) {
                /** @phpstan-var list<list<CompoundSelector|Combinator::*>> $sequence */
                return self::complexIsParentSuperselector($sequence[0], $group);
            });
            foreach ($chunks as $chunk) {
                $flattened = [];
                foreach ($chunk as $chunkGroup) {
                    $flattened = array_merge($flattened, $chunkGroup);
                }
                $newChoice[] = $flattened;
            }

            /** @phpstan-var list<list<CompoundSelector|Combinator::*>> $groups1 */
            /** @phpstan-var list<list<CompoundSelector|Combinator::*>> $groups2 */
            $choices[] = $newChoice;
            $choices[] = [$group];
            array_shift($groups1);
            array_shift($groups2);
        }

        $newChoice = [];
        /** @phpstan-var list<list<list<CompoundSelector|Combinator::*>>> $chunks */
        $chunks = self::chunks($groups1, $groups2, function ($sequence) {
            return count($sequence) === 0;
        });
        foreach ($chunks as $chunk) {
            $flattened = [];
            foreach ($chunk as $chunkGroup) {
                $flattened = array_merge($flattened, $chunkGroup);
            }
            $newChoice[] = $flattened;
        }

        $choices[] = $newChoice;

        foreach ($finalCombinators as $finalCombinator) {
            $choices[] = $finalCombinator;
        }

        $choices = array_filter($choices, function ($choice) {
            return $choice !== [];
        });

        /** @phpstan-var list<list<list<CompoundSelector|Combinator::*>>> $paths */
        $paths = self::paths($choices);

        return array_map(function (array $path) {
            $result = [];

            foreach ($path as $group) {
                $result = array_merge($result, $group);
            }

            return $result;
        }, $paths);
    }

    /**
     * If the first element of $queue has a `::root` selector, removes and returns
     * that element.
     *
     * @param list<CompoundSelector|string> $queue
     *
     * @return CompoundSelector|null
     *
     * @phpstan-param list<CompoundSelector|Combinator::*> $queue
     */
    private static function firstIfRoot(array &$queue): ?CompoundSelector
    {
        if (empty($queue)) {
            return null;
        }

        $first = $queue[0];

        if ($first instanceof CompoundSelector) {
            if (!self::hasRoot($first)) {
                return null;
            }

            array_shift($queue);

            return $first;
        }

        return null;
    }

    /**
     * Extracts leading  {@see Combinator}s from $components1 and $components2 and
     * merges them together into a single list of combinators.
     *
     * If there are no combinators to be merged, returns an empty list. If the
     * combinators can't be merged, returns `null`.
     *
     * @param list<CompoundSelector|string> $components1
     * @param list<CompoundSelector|string> $components2
     *
     * @return list<string>|null
     *
     * @phpstan-param list<CompoundSelector|Combinator::*> $components1
     * @phpstan-param list<CompoundSelector|Combinator::*> $components2
     * @phpstan-return list<Combinator::*>|null
     */
    private static function mergeInitialCombinators(array &$components1, array &$components2): ?array
    {
        $combinators1 = [];

        while ($components1 && \is_string($components1[0])) {
            $combinators1[] = $components1[0];
            array_shift($components1);
        }

        $combinators2 = [];

        while ($components2 && \is_string($components2[0])) {
            $combinators2[] = $components2[0];
            array_shift($components2);
        }

        // If neither sequence of combinators is a subsequence of the other, they
        // cannot be merged successfully.
        $lcs = ListUtil::longestCommonSubsequence($combinators1, $combinators2);

        if ($lcs === $combinators1) {
            return $combinators2;
        }

        if ($lcs === $combinators2) {
            return $combinators1;
        }

        return null;
    }

    /**
     * Extracts trailing {@see Combinator}s, and the selectors to which they apply, from
     * $components1 and $components2 and merges them together into a single list.
     *
     * If there are no combinators to be merged, returns an empty list. If the
     * sequences can't be merged, returns `null`.
     *
     * @param list<CompoundSelector|string>             $components1
     * @param list<CompoundSelector|string>             $components2
     * @param list<list<list<CompoundSelector|string>>> $result
     *
     * @return list<list<list<CompoundSelector|string>>>|null
     *
     * @phpstan-param list<CompoundSelector|Combinator::*> $components1
     * @phpstan-param list<CompoundSelector|Combinator::*> $components2
     * @phpstan-param list<list<list<CompoundSelector|Combinator::*>>> $result
     * @phpstan-return list<list<list<CompoundSelector|Combinator::*>>>|null
     */
    private static function mergeFinalCombinators(array &$components1, array &$components2, array $result = []): ?array
    {
        if ((\count($components1) === 0 || !\is_string($components1[\count($components1) - 1]))
            && (\count($components2) === 0 || !\is_string($components2[\count($components2) - 1]))
        ) {
            return $result;
        }

        /**
         * @var list<string> $combinators1
         * @phpstan-var list<Combinator::*> $combinators1
         */
        $combinators1 = [];

        while ($components1 && \is_string($components1[\count($components1) - 1])) {
            $combinators1[] = $components1[\count($components1) - 1];
            array_pop($components1);
        }

        /**
         * @var list<string> $combinators2
         * @phpstan-var list<Combinator::*> $combinators2
         */
        $combinators2 = [];

        while ($components2 && \is_string($components2[\count($components2) - 1])) {
            $combinators2[] = $components2[\count($components2) - 1];
            array_pop($components2);
        }

        if (\count($combinators1) > 1 || \count($combinators2) > 1) {
            $lcs = ListUtil::longestCommonSubsequence($combinators1, $combinators2);

            if ($lcs === $combinators1) {
                array_unshift($result, [array_reverse($combinators2)]);
            } elseif ($lcs === $combinators2) {
                array_unshift($result, [array_reverse($combinators1)]);
            } else {
                return null;
            }

            return $result;
        }

        // This code looks complicated, but it's actually just a bunch of special
        // cases for interactions between different combinators.
        $combinator1 = $combinators1[0] ?? null;
        $combinator2 = $combinators2[0] ?? null;

        if ($combinator1 !== null && $combinator2 !== null) {
            $compound1 = array_pop($components1);
            assert($compound1 instanceof CompoundSelector);
            $compound2 = array_pop($components2);
            assert($compound2 instanceof CompoundSelector);

            if ($combinator1 === Combinator::FOLLOWING_SIBLING && $combinator2 === Combinator::FOLLOWING_SIBLING) {
                if ($compound1->isSuperselector($compound2)) {
                    array_unshift($result, [[$compound2, Combinator::FOLLOWING_SIBLING]]);
                } elseif ($compound2->isSuperselector($compound1)) {
                    array_unshift($result, [[$compound1, Combinator::FOLLOWING_SIBLING]]);
                } else {
                    $choices = [
                        [$compound1, Combinator::FOLLOWING_SIBLING, $compound2, Combinator::FOLLOWING_SIBLING],
                        [$compound2, Combinator::FOLLOWING_SIBLING, $compound1, Combinator::FOLLOWING_SIBLING],
                    ];

                    $unified = self::unifyCompound($compound1->getComponents(), $compound2->getComponents());

                    if ($unified !== null) {
                        $choices[] = [$unified, Combinator::FOLLOWING_SIBLING];
                    }

                    array_unshift($result, $choices);
                }
            } elseif (($combinator1 === Combinator::FOLLOWING_SIBLING && $combinator2 === Combinator::NEXT_SIBLING) || ($combinator1 === Combinator::NEXT_SIBLING && $combinator2 === Combinator::FOLLOWING_SIBLING)) {
                $followingSiblingSelector = $combinator1 === Combinator::FOLLOWING_SIBLING ? $compound1 : $compound2;
                $nextSiblingSelector = $combinator1 === Combinator::FOLLOWING_SIBLING ? $compound2 : $compound1;

                if ($followingSiblingSelector->isSuperselector($nextSiblingSelector)) {
                    array_unshift($result, [[$nextSiblingSelector, Combinator::NEXT_SIBLING]]);
                } else {
                    $unified = self::unifyCompound($compound1->getComponents(), $compound2->getComponents());

                    $choices = [
                        [$followingSiblingSelector, Combinator::FOLLOWING_SIBLING, $nextSiblingSelector, Combinator::NEXT_SIBLING],
                    ];

                    if ($unified !== null) {
                        $choices[] = [$unified, Combinator::NEXT_SIBLING];
                    }

                    array_unshift($result, $choices);
                }
            } elseif ($combinator1 === Combinator::CHILD && ($combinator2 === Combinator::NEXT_SIBLING || $combinator2 === Combinator::FOLLOWING_SIBLING)) {
                array_unshift($result, [[$compound2, $combinator2]]);
                $components1[] = $compound1;
                $components1[] = Combinator::CHILD;
            } elseif ($combinator2 === Combinator::CHILD && ($combinator1 === Combinator::NEXT_SIBLING || $combinator1 === Combinator::FOLLOWING_SIBLING)) {
                array_unshift($result, [[$compound1, $combinator1]]);
                $components2[] = $compound2;
                $components2[] = Combinator::CHILD;
            } elseif ($combinator1 === $combinator2) {
                $unified = self::unifyCompound($compound1->getComponents(), $compound2->getComponents());

                if ($unified === null) {
                    return null;
                }

                array_unshift($result, [[$unified, $combinator1]]);
            } else {
                return null;
            }

            return self::mergeFinalCombinators($components1, $components2, $result);
        }

        if ($combinator1 !== null) {
            $compound1 = array_pop($components1);
            assert($compound1 instanceof CompoundSelector);

            if ($combinator1 === Combinator::CHILD && \count($components2) > 0) {
                $compound2 = $components2[\count($components2) - 1];
                assert($compound2 instanceof CompoundSelector);

                if ($compound2->isSuperselector($compound1)) {
                    array_pop($components2);
                }
            }

            array_unshift($result, [[$compound1, $combinator1]]);

            return self::mergeFinalCombinators($components1, $components2, $result);
        }

        $compound2 = array_pop($components2);
        assert($compound2 instanceof CompoundSelector);
        assert($combinator2 !== null);

        if ($combinator2 === Combinator::CHILD && \count($components1) > 0) {
            $compound1 = $components1[\count($components1) - 1];
            assert($compound1 instanceof CompoundSelector);

            if ($compound1->isSuperselector($compound2)) {
                array_pop($components1);
            }
        }

        array_unshift($result, [[$compound2, $combinator2]]);

        return self::mergeFinalCombinators($components2, $components1, $result);
    }

    /**
     * Returns whether $complex1 and $complex2 need to be unified to produce a
     * valid combined selector.
     *
     * This is necessary when both selectors contain the same unique simple
     * selector, such as an ID.
     *
     * @param list<CompoundSelector|string> $complex1
     * @param list<CompoundSelector|string> $complex2
     *
     * @return bool
     *
     * @phpstan-param list<CompoundSelector|Combinator::*> $complex1
     * @phpstan-param list<CompoundSelector|Combinator::*> $complex2
     */
    private static function mustUnify(array $complex1, array $complex2): bool
    {
        $uniqueSelectors = [];
        foreach ($complex1 as $component) {
            if ($component instanceof CompoundSelector) {
                foreach ($component->getComponents() as $simple) {
                    if (self::isUnique($simple)) {
                        $uniqueSelectors[] = $simple;
                    }
                }
            }
        }

        if (\count($uniqueSelectors) === 0) {
            return false;
        }

        foreach ($complex2 as $component) {
            if ($component instanceof CompoundSelector) {
                foreach ($component->getComponents() as $simple) {
                    if (self::isUnique($simple) && EquatableUtil::listContains($uniqueSelectors, $simple)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Returns whether a {@see CompoundSelector} may contain only one simple selector of
     * the same type as $simple.
     */
    private static function isUnique(SimpleSelector $simple): bool
    {
        return $simple instanceof IDSelector || ($simple instanceof PseudoSelector && $simple->isElement());
    }

    /**
     * Returns all orderings of initial subsequences of $queue1 and $queue2.
     *
     * The $done callback is used to determine the extent of the initial
     * subsequences. It's called with each queue until it returns `true`.
     *
     * This destructively removes the initial subsequences of $queue1 and
     * $queue2.
     *
     * For example, given `(A B C | D E)` and `(1 2 | 3 4 5)` (with `|` denoting
     * the boundary of the initial subsequence), this would return `[(A B C 1 2),
     * (1 2 A B C)]`. The queues would then contain `(D E)` and `(3 4 5)`.
     *
     * @template T
     *
     * @param list<T>                 $queue1
     * @param list<T>                 $queue2
     * @param callable(list<T>): bool $done
     *
     * @return list<list<T>>
     */
    private static function chunks(array &$queue1, array &$queue2, callable $done): array
    {
        $chunk1 = [];
        while (!$done($queue1)) {
            $element = array_shift($queue1);
            if ($element === null) {
                throw new \LogicException('Cannot remove an element from an empty queue');
            }

            $chunk1[] = $element;
        }

        $chunk2 = [];
        while (!$done($queue2)) {
            $element = array_shift($queue2);
            if ($element === null) {
                throw new \LogicException('Cannot remove an element from an empty queue');
            }

            $chunk2[] = $element;
        }

        if (empty($chunk1) && empty($chunk2)) {
            return [];
        }

        if (empty($chunk1)) {
            return [$chunk2];
        }

        if (empty($chunk2)) {
            return [$chunk1];
        }

        return [
            array_merge($chunk1, $chunk2),
            array_merge($chunk2, $chunk1),
        ];
    }

    /**
     * Returns a list of all possible paths through the given lists.
     *
     * For example, given `[[1, 2], [3, 4], [5]]`, this returns:
     *
     * ```
     * [[1, 3, 5],
     *  [2, 3, 5],
     *  [1, 4, 5],
     *  [2, 4, 5]]
     * ```
     *
     * @template T
     *
     * @param array<list<T>> $choices
     *
     * @return list<list<T>>
     */
    public static function paths(array $choices): array
    {
        return array_reduce($choices, function (array $paths, array $choice) {
            $newPaths = [];

            foreach ($choice as $option) {
                foreach ($paths as $path) {
                    $path[] = $option;
                    $newPaths[] = $path;
                }
            }

            return $newPaths;
        }, [[]]);
    }

    /**
     * @param iterable<CompoundSelector|string> $complex
     *
     * @return list<list<CompoundSelector|string>>
     *
     * @phpstan-param iterable<CompoundSelector|Combinator::*> $complex
     * @phpstan-return list<list<CompoundSelector|Combinator::*>>
     */
    private static function groupSelectors(iterable $complex): array
    {
        $groups = [];
        $group = null;

        foreach ($complex as $current) {
            if ($group === null) {
                $group = [$current];
                continue;
            }

            if (\is_string($current) || \is_string($group[\count($group) - 1])) {
                $group[] = $current;
            } else {
                $groups[] = $group;
                $group = [$current];
            }
        }

        if ($group !== null) {
            $groups[] = $group;
        }

        return $groups;
    }

    /**
     * Returns whether or not $compound contains a `:root` selector.
     */
    private static function hasRoot(CompoundSelector $compound): bool
    {
        foreach ($compound->getComponents() as $simple) {
            if ($simple instanceof PseudoSelector && $simple->isClass() && $simple->getNormalizedName() === 'root') {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns whether $list1 is a superselector of $list2.
     *
     * That is, whether $list1 matches every element that $list2 matches, as well
     * as possibly additional elements.
     *
     * @param list<ComplexSelector> $list1
     * @param list<ComplexSelector> $list2
     *
     * @return bool
     */
    public static function listIsSuperselector(array $list1, array $list2): bool
    {
        foreach ($list2 as $complex1) {
            foreach ($list1 as $complex2) {
                if ($complex2->isSuperselector($complex1)) {
                    continue 2;
                }
            }

            return false;
        }

        return true;
    }

    /**
     * Like {@see complexIsSuperselector}, but compares $complex1 and $complex2 as
     * though they shared an implicit base {@see SimpleSelector}.
     *
     * For example, `B` is not normally a superselector of `B A`, since it doesn't
     * match elements that match `A`. However, it *is* a parent superselector,
     * since `B X` is a superselector of `B A X`.
     *
     * @param list<CompoundSelector|string> $complex1
     * @param list<CompoundSelector|string> $complex2
     *
     * @return bool
     *
     * @phpstan-param list<CompoundSelector|Combinator::*> $complex1
     * @phpstan-param list<CompoundSelector|Combinator::*> $complex2
     */
    public static function complexIsParentSuperselector(array $complex1, array $complex2): bool
    {
        if (\is_string($complex1[0])) {
            return false;
        }
        if (\is_string($complex2[0])) {
            return false;
        }

        if (\count($complex1) > \count($complex2)) {
            return false;
        }

        $base = new CompoundSelector([new PlaceholderSelector('<temp>')]);
        $complex1[] = $base;
        $complex2[] = $base;

        return self::complexIsSuperselector($complex1, $complex2);
    }

    /**
     * Returns whether $complex1 is a superselector of $complex2.
     *
     * That is, whether $complex1 matches every element that $complex2 matches, as well
     * as possibly additional elements.
     *
     * @param list<CompoundSelector|string> $complex1
     * @param list<CompoundSelector|string> $complex2
     *
     * @return bool
     *
     * @phpstan-param list<CompoundSelector|Combinator::*> $complex1
     * @phpstan-param list<CompoundSelector|Combinator::*> $complex2
     */
    public static function complexIsSuperselector(array $complex1, array $complex2): bool
    {
        // Selectors with trailing operators are neither superselectors nor
        // subselectors.
        if (\is_string($complex1[\count($complex1) - 1])) {
            return false;
        }
        if (\is_string($complex2[\count($complex2) - 1])) {
            return false;
        }

        $i1 = 0;
        $i2 = 0;

        while (true) {
            $remaining1 = \count($complex1) - $i1;
            $remaining2 = \count($complex2) - $i2;

            if ($remaining1 === 0 || $remaining2 === 0) {
                return false;
            }

            // More complex selectors are never superselectors of less complex ones.
            if ($remaining1 > $remaining2) {
                return false;
            }

            // Selectors with leading operators are neither superselectors nor
            // subselectors.
            if (\is_string($complex1[$i1])) {
                return false;
            }
            if (\is_string($complex2[$i2])) {
                return false;
            }

            $compound1 = $complex1[$i1];

            if ($remaining1 === 1) {
                return self::compoundIsSuperselector($compound1, $complex2[\count($complex2) - 1], array_slice($complex2, $i2, -1));
            }

            // Find the first index where `complex2.sublist(i2, afterSuperselector)` is
            // a subselector of $compound1. We stop before the superselector would
            // encompass all of $complex2 because we know $complex1 has more than one
            // element, and consuming all of $complex2 wouldn't leave anything for the
            // rest of $complex1 to match.
            $afterSuperselector = $i2 + 1;
            for (; $afterSuperselector < \count($complex2); $afterSuperselector++) {
                $compound2 = $complex2[$afterSuperselector - 1];

                if ($compound2 instanceof CompoundSelector) {
                    if (self::compoundIsSuperselector($compound1, $compound2, array_slice($complex2, $i2 + 1, max(0, ($afterSuperselector - 1) - ($i2 + 1))))) {
                        break;
                    }
                }
            }

            if ($afterSuperselector === \count($complex2)) {
                return false;
            }

            $combinator1 = $complex1[$i1 + 1];
            $combinator2 = $complex2[$afterSuperselector];

            if (\is_string($combinator1)) { // Combinator
                if (!\is_string($combinator2)) {
                    return false;
                }

                // `.foo ~ .bar` is a superselector of `.foo + .bar`, but otherwise the
                // combinators must match.
                if ($combinator1 === Combinator::FOLLOWING_SIBLING) {
                    if ($combinator2 === Combinator::CHILD) {
                        return false;
                    }
                } elseif ($combinator1 !== $combinator2) {
                    return false;
                }

                // `.foo > .baz` is not a superselector of `.foo > .bar > .baz` or
                // `.foo > .bar .baz`, despite the fact that `.baz` is a superselector of
                // `.bar > .baz` and `.bar .baz`. Same goes for `+` and `~`.
                if ($remaining1 === 3 && $remaining2 > 3) {
                    return false;
                }

                $i1 += 2;
                $i2 = $afterSuperselector + 1;
            } elseif (\is_string($combinator2)) {
                if ($combinator2 !== Combinator::CHILD) {
                    return false;
                }

                $i1++;
                $i2 = $afterSuperselector + 1;
            } else {
                $i1++;
                $i2 = $afterSuperselector;
            }
        }
    }

    /**
     * Returns whether $compound1 is a superselector of $compound2.
     *
     * That is, whether $compound1 matches every element that $compound2 matches, as well
     * as possibly additional elements.
     *
     * If $parents is passed, it represents the parents of $compound2. This is
     * relevant for pseudo selectors with selector arguments, where we may need to
     * know if the parent selectors in the selector argument match $parents.
     *
     * @param CompoundSelector                   $compound1
     * @param CompoundSelector                   $compound2
     * @param list<CompoundSelector|string>|null $parents
     *
     * @return bool
     *
     * @phpstan-param list<CompoundSelector|Combinator::*>|null $parents
     */
    public static function compoundIsSuperselector(CompoundSelector $compound1, CompoundSelector $compound2, ?array $parents = null): bool
    {
        // Every selector in `$compound1->getComponents()` must have a matching selector in
        // `$compound2->getComponents()`.
        foreach ($compound1->getComponents() as $simple1) {
            if ($simple1 instanceof PseudoSelector && $simple1->getSelector() !== null) {
                if (!self::selectorPseudoIsSuperselector($simple1, $compound2, $parents)) {
                    return false;
                }
            } elseif (!self::simpleIsSuperselectorOfCompound($simple1, $compound2)) {
                return false;
            }
        }

        // $compound1 can't be a superselector of a selector with non-selector
        // pseudo-elements that $compound2 doesn't share.
        foreach ($compound2->getComponents() as $simple2) {
            if ($simple2 instanceof PseudoSelector && $simple2->isElement() && $simple2->getSelector() === null && !self::simpleIsSuperselectorOfCompound($simple2, $compound1)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns whether $simple is a superselector of $compound.
     *
     * That is, whether $simple matches every element that $compound matches, as
     * well as possibly additional elements.
     */
    private static function simpleIsSuperselectorOfCompound(SimpleSelector $simple, CompoundSelector $compound): bool
    {
        foreach ($compound->getComponents() as $theirSimple) {
            if ($simple->equals($theirSimple)) {
                return true;
            }

            // Some selector pseudoclasses can match normal selectors.
            if (!$theirSimple instanceof PseudoSelector) {
                continue;
            }
            $selector = $theirSimple->getSelector();
            if ($selector === null) {
                continue;
            }
            if (!\in_array($theirSimple->getNormalizedName(), self::SUBSELECTOR_PSEUDOS, true)) {
                return false;
            }

            foreach ($selector->getComponents() as $complex) {
                if (\count($complex->getComponents()) !== 1) {
                    continue 2;
                }

                $innerCompound = $complex->getComponents()[0];
                assert($innerCompound instanceof CompoundSelector);

                if (!EquatableUtil::listContains($innerCompound->getComponents(), $simple)) {
                    continue 2;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Returns whether $pseudo1 is a superselector of $compound2.
     *
     * That is, whether $pseudo1 matches every element that $compound2 matches, as well
     * as possibly additional elements.
     *
     * This assumes that $pseudo1's `selector` argument is not `null`.
     *
     * If $parents is passed, it represents the parents of $compound2. This is
     * relevant for pseudo selectors with selector arguments, where we may need to
     * know if the parent selectors in the selector argument match $parents.
     *
     * @phpstan-param list<CompoundSelector|Combinator::*>|null $parents
     */
    private static function selectorPseudoIsSuperselector(PseudoSelector $pseudo1, CompoundSelector $compound2, ?array $parents): bool
    {
        $selector1 = $pseudo1->getSelector();

        if ($selector1 === null) {
            throw new \InvalidArgumentException("Selector $pseudo1 must have a selector argument.");
        }

        switch ($pseudo1->getNormalizedName()) {
            case 'is':
            case 'matches':
            case 'any':
                $selectors = self::selectorPseudoArgs($compound2, $pseudo1->getName());

                foreach ($selectors as $selector2) {
                    if ($selector1->isSuperselector($selector2)) {
                        return true;
                    }
                }

                $compoundWithParents = $parents;
                $compoundWithParents[] = $compound2;

                foreach ($selector1->getComponents() as $complex1) {
                    if (self::complexIsSuperselector($complex1->getComponents(), $compoundWithParents)) {
                        return true;
                    }
                }

                return false;

            case 'has':
            case 'host':
            case 'host-context':
                $selectors = self::selectorPseudoArgs($compound2, $pseudo1->getName());

                foreach ($selectors as $selector2) {
                    if ($selector1->isSuperselector($selector2)) {
                        return true;
                    }
                }

                return false;

            case 'slotted':
                $selectors = self::selectorPseudoArgs($compound2, $pseudo1->getName(), false);

                foreach ($selectors as $selector2) {
                    if ($selector1->isSuperselector($selector2)) {
                        return true;
                    }
                }

                return false;

            case 'not':
                foreach ($selector1->getComponents() as $complex) {
                    foreach ($compound2->getComponents() as $simple2) {
                        if ($simple2 instanceof TypeSelector) {
                            $compound1 = $complex->getLastComponent();

                            if (!$compound1 instanceof CompoundSelector) {
                                continue;
                            }

                            foreach ($compound1->getComponents() as $simple1) {
                                if ($simple1 instanceof TypeSelector && !$simple1->equals($simple2)) {
                                    continue 3;
                                }
                            }
                        } elseif ($simple2 instanceof IDSelector) {
                            $compound1 = $complex->getLastComponent();

                            if (!$compound1 instanceof CompoundSelector) {
                                continue;
                            }

                            foreach ($compound1->getComponents() as $simple1) {
                                if ($simple1 instanceof IDSelector && !$simple1->equals($simple2)) {
                                    continue 3;
                                }
                            }
                        } elseif ($simple2 instanceof PseudoSelector && $simple2->getName() === $pseudo1->getName()) {
                            $selector2 = $simple2->getSelector();
                            if ($selector2 === null) {
                                continue;
                            }

                            if (self::listIsSuperselector($selector2->getComponents(), [$complex])) {
                                continue 2;
                            }
                        }
                    }

                    return false;
                }

                return true;

            case 'current':
                $selectors = self::selectorPseudoArgs($compound2, $pseudo1->getName());

                foreach ($selectors as $selector2) {
                    if ($selector1->equals($selector2)) {
                        return true;
                    }
                }

                return false;

            case 'nth-child':
            case 'nth-last-child':
                foreach ($compound2->getComponents() as $pseudo2) {
                    if (!$pseudo2 instanceof PseudoSelector) {
                        continue;
                    }

                    if ($pseudo2->getName() !== $pseudo1->getName()) {
                        continue;
                    }

                    if ($pseudo2->getArgument() !== $pseudo1->getArgument()) {
                        continue;
                    }

                    $selector2 = $pseudo2->getSelector();

                    if ($selector2 === null) {
                        continue;
                    }

                    if ($selector1->isSuperselector($selector2)) {
                        return true;
                    }
                }

                return false;

            default:
                throw new \LogicException('unreachache');
        }
    }

    /**
     * Returns all the selector arguments of pseudo selectors in $compound with
     * the given $name.
     *
     * @return SelectorList[]
     */
    private static function selectorPseudoArgs(CompoundSelector $compound, string $name, bool $isClass = true): array
    {
        $selectors = [];

        foreach ($compound->getComponents() as $simple) {
            if (!$simple instanceof PseudoSelector) {
                continue;
            }

            if ($simple->isClass() !== $isClass || $simple->getName() !== $name) {
                continue;
            }

            if ($simple->getSelector() === null) {
                continue;
            }

            $selectors[] = $simple->getSelector();
        }

        return $selectors;
    }
}
