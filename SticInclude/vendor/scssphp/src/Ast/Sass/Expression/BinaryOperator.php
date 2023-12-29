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

namespace ScssPhp\ScssPhp\Ast\Sass\Expression;

/**
 * @internal
 */
final class BinaryOperator
{
    const SINGLE_EQUALS = '=';
    const OR = 'or';
    const AND = 'and';
    const EQUALS = '==';
    const NOT_EQUALS = '!=';
    const GREATER_THAN = '>';
    const GREATER_THAN_OR_EQUALS = '>=';
    const LESS_THAN = '<';
    const LESS_THAN_OR_EQUALS = '<=';
    const PLUS = '+';
    const MINUS = '-';
    const TIMES = '*';
    const DIVIDED_BY = '/';
    const MODULO = '%';

    /**
     * @param BinaryOperator::* $operator
     */
    public static function getPrecedence(string $operator): int
    {
        switch ($operator) {
            case self::SINGLE_EQUALS:
                return 0;

            case self::OR:
                return 1;

            case self::AND:
                return 2;

            case self::EQUALS:
            case self::NOT_EQUALS:
                return 3;

            case self::GREATER_THAN:
            case self::GREATER_THAN_OR_EQUALS:
            case self::LESS_THAN:
            case self::LESS_THAN_OR_EQUALS:
                return 4;

            case self::PLUS:
            case self::MINUS:
                return 5;

            case self::TIMES:
            case self::DIVIDED_BY:
            case self::MODULO:
                return 6;
        }

        throw new \InvalidArgumentException(sprintf('Unknown operator "%s".', $operator));
    }
}
