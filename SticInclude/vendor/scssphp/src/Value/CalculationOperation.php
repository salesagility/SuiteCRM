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
 * A binary operation that can appear in a {@see SassCalculation}.
 */
final class CalculationOperation implements Equatable
{
    /**
     * @phpstan-var CalculationOperator::*
     */
    private $operator;

    /**
     * The left-hand operand.
     *
     * This is either a {@see SassNumber}, a {@see SassCalculation}, an unquoted
     * {@see SassString}, a {@see CalculationOperation}, or a {@see CalculationInterpolation}.
     *
     * @var object
     */
    private $left;

    /**
     * The right-hand operand.
     *
     * This is either a {@see SassNumber}, a {@see SassCalculation}, an unquoted
     * {@see SassString}, a {@see CalculationOperation}, or a {@see CalculationInterpolation}.
     *
     * @var object
     */
    private $right;

    /**
     * @param string $operator
     * @param object $left
     * @param object $right
     *
     * @phpstan-param CalculationOperator::* $operator
     */
    public function __construct(string $operator, object $left, object $right)
    {
        $this->operator = $operator;
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * @phpstan-return CalculationOperator::*
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getLeft(): object
    {
        return $this->left;
    }

    public function getRight(): object
    {
        return $this->right;
    }

    public function equals(object $other): bool
    {
        assert($this->left instanceof Equatable);
        assert($this->right instanceof Equatable);

        return $other instanceof CalculationOperation && $this->operator === $other->operator && $this->left->equals($other->left) && $this->right->equals($other->right);
    }
}
