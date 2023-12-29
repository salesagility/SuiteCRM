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

use ScssPhp\ScssPhp\Visitor\SelectorVisitor;

/**
 * An ID selector.
 *
 * This selects elements whose `id` attribute exactly matches the given name.
 */
final class IDSelector extends SimpleSelector
{
    /**
     * The ID name this selects for.
     *
     * @var string
     * @readonly
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMinSpecificity(): int
    {
        return parent::getMinSpecificity() ** 2;
    }

    public function accept(SelectorVisitor $visitor)
    {
        return $visitor->visitIDSelector($this);
    }

    public function addSuffix(string $suffix): SimpleSelector
    {
        return new IDSelector($this->name . $suffix);
    }

    public function unify(array $compound): ?array
    {
        // A given compound selector may only contain one ID.
        foreach ($compound as $simple) {
            if ($simple instanceof IDSelector && !$simple->equals($this)) {
                return null;
            }
        }

        return parent::unify($compound);
    }

    public function equals(object $other): bool
    {
        return $other instanceof IDSelector && $other->name === $this->name;
    }
}
