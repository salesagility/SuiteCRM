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

namespace ScssPhp\ScssPhp\Value;

use ScssPhp\ScssPhp\Visitor\ValueVisitor;

final class SassFunction extends Value
{
    // TODO find a better representation of functions, as names won't be unique anymore once modules enter in the equation.
    private $name;

    /**
     * @internal
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @internal
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function accept(ValueVisitor $visitor)
    {
        return $visitor->visitFunction($this);
    }

    public function assertFunction(?string $name = null): SassFunction
    {
        return $this;
    }

    public function equals(object $other): bool
    {
        return $other instanceof SassFunction && $this->name === $other->name;
    }
}
