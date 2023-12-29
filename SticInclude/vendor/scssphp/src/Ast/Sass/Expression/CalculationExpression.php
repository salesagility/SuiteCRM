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

use ScssPhp\ScssPhp\Ast\Sass\Expression;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Visitor\ExpressionVisitor;

/**
 * A calculation literal.
 *
 * @internal
 */
class CalculationExpression implements Expression
{
    /**
     * This calculation's name.
     *
     * @var string
     * @readonly
     */
    private $name;

    /**
     * The arguments for the calculation.
     *
     * @var list<Expression>
     * @readonly
     */
    private $arguments;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * Returns a `calc()` calculation expression.
     *
     * @param Expression $argument
     * @param FileSpan   $span
     *
     * @return CalculationExpression
     */
    public static function calc(Expression $argument, FileSpan $span): CalculationExpression
    {
        return new CalculationExpression('calc', [$argument], $span);
    }

    /**
     * Returns a `min()` calculation expression.
     *
     * @param list<Expression> $arguments
     * @param FileSpan         $span
     *
     * @return CalculationExpression
     */
    public static function min(array $arguments, FileSpan $span): CalculationExpression
    {
        if (!$arguments) {
            throw new \InvalidArgumentException('min() requires at least one argument.');
        }

        return new CalculationExpression('min', $arguments, $span);
    }

    /**
     * Returns a `max()` calculation expression.
     *
     * @param list<Expression> $arguments
     * @param FileSpan         $span
     *
     * @return CalculationExpression
     */
    public static function max(array $arguments, FileSpan $span): CalculationExpression
    {
        if (!$arguments) {
            throw new \InvalidArgumentException('max() requires at least one argument.');
        }

        return new CalculationExpression('max', $arguments, $span);
    }

    /**
     * Returns a `clamp()` calculation expression.
     *
     * @param Expression $min
     * @param Expression $value
     * @param Expression $max
     * @param FileSpan   $span
     *
     * @return CalculationExpression
     */
    public static function clamp(Expression $min, Expression $value, Expression $max, FileSpan $span): CalculationExpression
    {
        return new CalculationExpression('clamp', [$min, $value, $max], $span);
    }

    /**
     * Returns a calculation expression with the given name and arguments.
     *
     * Unlike the other constructors, this doesn't verify that the arguments are
     * valid for the name.
     *
     * @param string           $name
     * @param list<Expression> $arguments
     * @param FileSpan         $span
     */
    public function __construct(string $name, array $arguments, FileSpan $span)
    {
        self::verifyArguments($arguments);
        $this->name = $name;
        $this->arguments = $arguments;
        $this->span = $span;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return list<Expression>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accepts(ExpressionVisitor $visitor)
    {
        return $visitor->visitCalculationExpression($this);
    }

    /**
     * @param list<Expression> $arguments
     *
     * @throws \InvalidArgumentException if $arguments aren't valid calculation arguments.
     */
    private static function verifyArguments(array $arguments): void
    {
        foreach ($arguments as $argument) {
            self::verify($argument);
        }
    }

    /**
     * @throws \InvalidArgumentException if $expression isn't a valid calculation argument.
     */
    private static function verify(Expression $expression): void
    {
        if ($expression instanceof NumberExpression) {
            return;
        }

        if ($expression instanceof CalculationExpression) {
            return;
        }

        if ($expression instanceof VariableExpression) {
            return;
        }

        if ($expression instanceof FunctionExpression) {
            return;
        }

        if ($expression instanceof IfExpression) {
            return;
        }

        if ($expression instanceof StringExpression) {
            if ($expression->hasQuotes()) {
                throw new \InvalidArgumentException('Invalid calculation argument.');
            }

            return;
        }

        if ($expression instanceof ParenthesizedExpression) {
            self::verify($expression->getExpression());

            return;
        }

        if ($expression instanceof BinaryOperationExpression) {
            self::verify($expression->getLeft());
            self::verify($expression->getRight());

            if ($expression->getOperator() === BinaryOperator::PLUS) {
                return;
            }

            if ($expression->getOperator() === BinaryOperator::MINUS) {
                return;
            }

            if ($expression->getOperator() === BinaryOperator::TIMES) {
                return;
            }

            if ($expression->getOperator() === BinaryOperator::DIVIDED_BY) {
                return;
            }

            throw new \InvalidArgumentException('Invalid calculation argument.');
        }

        throw new \InvalidArgumentException('Invalid calculation argument.');
    }
}
