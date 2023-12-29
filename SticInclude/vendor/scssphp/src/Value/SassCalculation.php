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

use ScssPhp\ScssPhp\Exception\SassScriptException;
use ScssPhp\ScssPhp\Util\Equatable;
use ScssPhp\ScssPhp\Util\NumberUtil;
use ScssPhp\ScssPhp\Visitor\ValueVisitor;

/**
 * A SassScript calculation.
 *
 * Although calculations can in principle have any name or any number of
 * arguments, this class only exposes the specific calculations that are
 * supported by the Sass spec. This ensures that all calculations that the user
 * works with are always fully simplified.
 */
final class SassCalculation extends Value
{
    /**
     * The calculation's name, such as `"calc"`.
     *
     * @var string
     */
    private $name;

    /**
     * The calculation's arguments.
     *
     * Each argument is either a {@see SassNumber}, a {@see SassCalculation}, an unquoted
     * {@see SassString}, a {@see CalculationOperation}, or a {@see CalculationInterpolation}.
     *
     * @var list<object>
     */
    private $arguments;

    /**
     * Creates a `calc()` calculation with the given $argument.
     *
     * The $argument must be either a {@see SassNumber}, a {@see SassCalculation}, an
     * unquoted {@see SassString}, a {@see CalculationOperation}, or a
     * {@see CalculationInterpolation}.
     *
     * This automatically simplifies the calculation, so it may return a
     * {@see SassNumber} rather than a {@see SassCalculation}. It throws an exception if it
     * can determine that the calculation will definitely produce invalid CSS.
     *
     * @param list<object> $argument
     *
     * @return Value
     *
     * @throws SassScriptException
     */
    public static function calc($argument): Value
    {
        $argument = self::simplify($argument);

        if ($argument instanceof SassNumber) {
            return $argument;
        }

        if ($argument instanceof SassCalculation) {
            return $argument;
        }

        return new SassCalculation('calc', [$argument]);
    }

    /**
     * Creates a `min()` calculation with the given $arguments.
     *
     * Each argument must be either a {@see SassNumber}, a {@see SassCalculation}, an
     * unquoted {@see SassString}, a {@see CalculationOperation}, or a
     * {@see CalculationInterpolation}. It must be passed at least one argument.
     *
     * This automatically simplifies the calculation, so it may return a
     * {@see SassNumber} rather than a {@see SassCalculation}. It throws an exception if it
     * can determine that the calculation will definitely produce invalid CSS.
     *
     * @param list<object> $arguments
     *
     * @return Value
     *
     * @throws SassScriptException
     */
    public static function min(array $arguments): Value
    {
        $args = self::simplifyArguments($arguments);

        if (!$args) {
            throw new \InvalidArgumentException('min() must have at least one argument.');
        }

        /** @var SassNumber|null $minimum */
        $minimum = null;

        foreach ($args as $arg) {
            if (!$arg instanceof SassNumber || $minimum !== null && !$minimum->isComparableTo($arg)) {
                $minimum = null;
                break;
            }

            if ($minimum === null || $minimum->greaterThan($arg)->isTruthy()) {
                $minimum = $arg;
            }
        }

        if ($minimum !== null) {
            return $minimum;
        }

        self::verifyCompatibleNumbers($args);

        return new SassCalculation('min', $args);
    }

    /**
     * Creates a `max()` calculation with the given $arguments.
     *
     * Each argument must be either a {@see SassNumber}, a {@see SassCalculation}, an
     * unquoted {@see SassString}, a {@see CalculationOperation}, or a
     * {@see CalculationInterpolation}. It must be passed at least one argument.
     *
     * This automatically simplifies the calculation, so it may return a
     * {@see SassNumber} rather than a {@see SassCalculation}. It throws an exception if it
     * can determine that the calculation will definitely produce invalid CSS.
     *
     * @param list<object> $arguments
     *
     * @return Value
     *
     * @throws SassScriptException
     */
    public static function max(array $arguments): Value
    {
        $args = self::simplifyArguments($arguments);

        if (!$args) {
            throw new \InvalidArgumentException('max() must have at least one argument.');
        }

        /** @var SassNumber|null $maximum */
        $maximum = null;

        foreach ($args as $arg) {
            if (!$arg instanceof SassNumber || $maximum !== null && !$maximum->isComparableTo($arg)) {
                $maximum = null;
                break;
            }

            if ($maximum === null || $maximum->lessThan($arg)->isTruthy()) {
                $maximum = $arg;
            }
        }

        if ($maximum !== null) {
            return $maximum;
        }

        self::verifyCompatibleNumbers($args);

        return new SassCalculation('max', $args);
    }

    /**
     * Creates a `clamp()` calculation with the given $min, $value, and $max.
     *
     * Each argument must be either a {@see SassNumber}, a {@see SassCalculation}, an
     * unquoted {@see SassString}, a {@see CalculationOperation}, or a
     * {@see CalculationInterpolation}.
     *
     * This automatically simplifies the calculation, so it may return a
     * {@see SassNumber} rather than a {@see SassCalculation}. It throws an exception if it
     * can determine that the calculation will definitely produce invalid CSS.
     *
     * This may be passed fewer than three arguments, but only if one of the
     * arguments is an unquoted `var()` string.
     *
     * @param object      $min
     * @param object|null $value
     * @param object|null $max
     *
     * @return Value
     *
     * @throws SassScriptException
     */
    public static function clamp(object $min, object $value = null, object $max = null): Value
    {
        if ($value === null && $max !== null) {
            throw new \InvalidArgumentException('If value is null, max must also be null.');
        }

        $min = self::simplify($min);

        if ($value !== null) {
            $value = self::simplify($value);
        }

        if ($max !== null) {
            $max = self::simplify($max);
        }

        if ($min instanceof SassNumber && $value instanceof SassNumber && $max instanceof SassNumber && $min->hasCompatibleUnits($value) && $min->hasCompatibleUnits($max)) {
            if ($value->lessThanOrEquals($min)->isTruthy()) {
                return $min;
            }

            if ($value->greaterThanOrEquals($max)->isTruthy()) {
                return $max;
            }

            return $value;
        }

        $args = array_filter([$min, $value, $max]);
        self::verifyCompatibleNumbers($args);
        self::verifyLength($args, 3);

        return new SassCalculation('clamp', $args);
    }

    /**
     * Creates and simplifies a {@see CalculationOperation} with the given $operator,
     * $left, and $right.
     *
     * This automatically simplifies the operation, so it may return a
     * {@see SassNumber} rather than a {@see CalculationOperation}.
     *
     * Each of $left and $right must be either a {@see SassNumber}, a
     * {@see SassCalculation}, an unquoted {@see SassString}, a {@see CalculationOperation}, or
     * a {@see CalculationInterpolation}.
     *
     * @param string $operator
     * @param object $left
     * @param object $right
     *
     * @return object
     *
     * @phpstan-param CalculationOperator::* $operator
     *
     * @throws SassScriptException
     */
    public static function operate(string $operator, object $left, object $right): object
    {
        return self::operateInternal($operator, $left, $right, false);
    }

    /**
     * Like {@see operate}, but with the internal-only $inMinMax parameter.
     *
     * If $inMinMax is `true`, this allows unitless numbers to be added and
     * subtracted with numbers with units, for backwards-compatibility with the
     * old global `min()` and `max()` functions.
     *
     * @param string $operator
     * @param object $left
     * @param object $right
     * @param bool   $inMinMax
     *
     * @return object
     *
     * @throws SassScriptException
     *
     * @phpstan-param CalculationOperator::* $operator
     *
     * @internal
     */
    public static function operateInternal(string $operator, object $left, object $right, bool $inMinMax): object
    {
        $left = self::simplify($left);
        $right = self::simplify($right);

        if ($operator === CalculationOperator::PLUS || $operator === CalculationOperator::MINUS) {
            if ($left instanceof SassNumber && $right instanceof SassNumber && ($inMinMax ? $left->isComparableTo($right) : $left->hasCompatibleUnits($right))) {
                return $operator === CalculationOperator::PLUS ? $left->plus($right) : $left->minus($right);
            }

            self::verifyCompatibleNumbers([$left, $right]);

            if ($right instanceof SassNumber && NumberUtil::fuzzyLessThan($right->getValue(), 0)) {
                $right = $right->times(SassNumber::create(-1));
                $operator = $operator === CalculationOperator::PLUS ? CalculationOperator::MINUS : CalculationOperator::PLUS;
            }

            return new CalculationOperation($operator, $left, $right);
        }

        if ($left instanceof SassNumber && $right instanceof SassNumber) {
            return $operator === CalculationOperator::TIMES ? $left->times($right) : $left->dividedBy($right);
        }

        return new CalculationOperation($operator, $left, $right);
    }

    /**
     * An internal constructor that doesn't perform any validation or
     * simplification.
     *
     * @param string       $name
     * @param list<object> $arguments
     */
    private function __construct(string $name, array $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isSpecialNumber(): bool
    {
        return true;
    }

    /**
     * @return list<object>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function accept(ValueVisitor $visitor)
    {
        return $visitor->visitCalculation($this);
    }

    public function assertCalculation(?string $name = null): SassCalculation
    {
        return $this;
    }

    public function plus(Value $other): Value
    {
        if ($other instanceof SassString) {
            return parent::plus($other);
        }

        throw new SassScriptException("Undefined operation \"$this + $other\".");
    }

    public function minus(Value $other): Value
    {
        throw new SassScriptException("Undefined operation \"$this - $other\".");
    }

    public function unaryPlus(): Value
    {
        throw new SassScriptException("Undefined operation \"+$this\".");
    }

    public function unaryMinus(): Value
    {
        throw new SassScriptException("Undefined operation \"-$this\".");
    }

    public function equals(object $other): bool
    {
        if (!$other instanceof SassCalculation || $this->name !== $other->name) {
            return false;
        }

        if (\count($this->arguments) !== \count($other->arguments)) {
            return false;
        }

        foreach ($this->arguments as $i => $argument) {
            assert($argument instanceof Equatable);
            $otherArgument = $other->arguments[$i];

            if (!$argument->equals($otherArgument)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param list<mixed> $args
     *
     * @return list<object>
     *
     * @throws SassScriptException
     */
    private static function simplifyArguments(array $args): array
    {
        return array_map([self::class, 'simplify'], $args);
    }

    /**
     * @param mixed $arg
     *
     * @return object
     *
     * @throws SassScriptException
     */
    private static function simplify($arg): object
    {
        if ($arg instanceof SassNumber || $arg instanceof CalculationInterpolation || $arg instanceof CalculationOperation) {
            return $arg;
        }

        if ($arg instanceof SassString) {
            if (!$arg->hasQuotes()) {
                return $arg;
            }

            throw new SassScriptException("Quoted string $arg can't be used in a calculation.");
        }

        if ($arg instanceof SassCalculation) {
            return $arg->getName() === 'calc' ? $arg->getArguments()[0] : $arg;
        }

        if ($arg instanceof Value) {
            throw new SassScriptException("Value $arg can't be used in a calculation.");
        }

        throw new \InvalidArgumentException(sprintf('Unexpected calculation argument %s.', \is_object($arg) ? get_class($arg) : gettype($arg)));
    }

    /**
     * Verifies that all the numbers in $args aren't known to be incompatible
     * with one another, and that they don't have units that are too complex for
     * calculations.
     *
     * @param list<object> $args
     *
     * @throws SassScriptException
     */
    private static function verifyCompatibleNumbers(array $args): void
    {
        foreach ($args as $arg) {
            if (!$arg instanceof SassNumber) {
                continue;
            }

            if (\count($arg->getNumeratorUnits()) > 1 || \count($arg->getDenominatorUnits())) {
                throw new SassScriptException("Number $arg isn't compatible with CSS calculations.");
            }
        }

        for ($i = 0; $i < \count($args); $i++) {
            $number1 = $args[$i];

            if (!$number1 instanceof SassNumber) {
                continue;
            }

            for ($j = $i + 1; $j < \count($args); $j++) {
                $number2 = $args[$j];

                if (!$number2 instanceof SassNumber) {
                    continue;
                }

                if ($number1->hasPossiblyCompatibleUnits($number2)) {
                    continue;
                }

                throw new SassScriptException("$number1 and $number2 are incompatible.");
            }
        }
    }

    /**
     * Throws a {@see SassScriptException} if $args isn't $expectedLength *and*
     * doesn't contain either a {@see SassString} or a {@see CalculationInterpolation}.
     *
     * @param list<object> $args
     * @param int          $expectedLength
     *
     * @throws SassScriptException
     */
    private static function verifyLength(array $args, int $expectedLength): void
    {
        if (\count($args) === $expectedLength) {
            return;
        }

        foreach ($args as $arg) {
            if ($arg instanceof SassString || $arg instanceof CalculationInterpolation) {
                return;
            }
        }

        $length = \count($args);
        $verb = $length === 1 ? 'was' : 'were';

        throw new SassScriptException("$expectedLength arguments required, but only $length $verb passed.");
    }
}
