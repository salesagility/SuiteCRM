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

/**
 * An enumeration of possible operators for {@see CalculationOperation}.
 */
final class CalculationOperator
{
    public const PLUS = '+';
    public const MINUS = '-';
    public const TIMES = '*';
    public const DIVIDED_BY = '/';

    /**
     * The precedence of the operator
     *
     * An operator with higher precedence binds tighter.
     *
     * @phpstan-param CalculationOperator::* $operator
     *
     * @internal
     */
    public static function getPrecedence(string $operator): int
    {
        switch ($operator) {
            case self::PLUS:
            case self::MINUS:
                return 1;

            case self::TIMES:
            case self::DIVIDED_BY:
                return 2;
        }

        throw new \InvalidArgumentException(sprintf('Unknown operator "%s".', $operator));
    }
}
