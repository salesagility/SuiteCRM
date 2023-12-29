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

use ScssPhp\ScssPhp\Util\Equatable;

/**
 * A string injected into a {@see SassCalculation} using interpolation.
 *
 * This is tracked separately from string arguments because it requires
 * additional parentheses when used as an operand of a {@see CalculationOperation}.
 */
final class CalculationInterpolation implements Equatable
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(object $other): bool
    {
        return $other instanceof CalculationInterpolation && $this->value === $other->value;
    }
}
