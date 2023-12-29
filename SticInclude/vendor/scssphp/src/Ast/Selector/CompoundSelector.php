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
use ScssPhp\ScssPhp\Extend\ExtendUtil;
use ScssPhp\ScssPhp\Logger\LoggerInterface;
use ScssPhp\ScssPhp\Parser\SelectorParser;
use ScssPhp\ScssPhp\Util\EquatableUtil;
use ScssPhp\ScssPhp\Visitor\SelectorVisitor;

/**
 * A compound selector.
 *
 * A compound selector is composed of {@see SimpleSelector}s. It matches an element
 * that matches all of the component simple selectors.
 */
final class CompoundSelector extends Selector
{
    /**
     * The components of this selector.
     *
     * This is never empty.
     *
     * @var list<SimpleSelector>
     */
    private $components;

    /**
     * @var int|null
     */
    private $minSpecificity;

    /**
     * @var int|null
     */
    private $maxSpecificity;

    /**
     * Parses a compound selector from $contents.
     *
     * If passed, $url is the name of the file from which $contents comes.
     * $allowParent controls whether a {@see ParentSelector} is allowed in this
     * selector.
     *
     * @throws SassFormatException if parsing fails.
     */
    public static function parse(string $contents, ?LoggerInterface $logger = null, ?string $url = null, bool $allowParent = true): CompoundSelector
    {
        return (new SelectorParser($contents, $logger, $url, $allowParent))->parseCompoundSelector();
    }

    /**
     * @param list<SimpleSelector> $components
     */
    public function __construct(array $components)
    {
        if ($components === []) {
            throw new \InvalidArgumentException('components may not be empty.');
        }

        $this->components = $components;
    }

    /**
     * @return list<SimpleSelector>
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function getLastComponent(): SimpleSelector
    {
        return $this->components[\count($this->components) - 1];
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
        foreach ($this->components as $component) {
            if ($component->isInvisible()) {
                return true;
            }
        }

        return false;
    }

    public function accept(SelectorVisitor $visitor)
    {
        return $visitor->visitCompoundSelector($this);
    }

    /**
     * Whether this is a superselector of $other.
     *
     * That is, whether this matches every element that $other matches, as well
     * as possibly additional elements.
     */
    public function isSuperselector(CompoundSelector $other): bool
    {
        return ExtendUtil::compoundIsSuperselector($this, $other);
    }

    public function equals(object $other): bool
    {
        return $other instanceof CompoundSelector && EquatableUtil::listEquals($this->components, $other->components);
    }

    /**
     * Computes {@see minSpecificity} and {@see maxSpecificity}.
     */
    private function computeSpecificity(): void
    {
        $minSpecificity = 0;
        $maxSpecificity = 0;

        foreach ($this->components as $simple) {
            $minSpecificity += $simple->getMinSpecificity();
            $maxSpecificity += $simple->getMaxSpecificity();
        }

        $this->minSpecificity = $minSpecificity;
        $this->maxSpecificity = $maxSpecificity;
    }
}
