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
use ScssPhp\ScssPhp\Serializer\Serializer;
use ScssPhp\ScssPhp\Util\Equatable;
use ScssPhp\ScssPhp\Visitor\ValueVisitor;

abstract class Value implements Equatable
{
    /**
     * Whether the value counts as `true` in an `@if` statement and other contexts
     *
     * @return bool
     */
    public function isTruthy(): bool
    {
        return true;
    }

    /**
     * The separator for this value as a list.
     *
     * All SassScript values can be used as lists. Maps count as lists of pairs,
     * and all other values count as single-value lists.
     *
     * @return string
     *
     * @phpstan-return ListSeparator::*
     */
    public function getSeparator(): string
    {
        return ListSeparator::UNDECIDED;
    }

    /**
     * Whether this value as a list has brackets.
     *
     * All SassScript values can be used as lists. Maps count as lists of pairs,
     * and all other values count as single-value lists.
     *
     * @return bool
     */
    public function hasBrackets(): bool
    {
        return false;
    }

    /**
     * This value as a list.
     *
     * All SassScript values can be used as lists. Maps count as lists of pairs,
     * and all other values count as single-value lists.
     *
     * @return list<Value>
     */
    public function asList(): array
    {
        return [$this];
    }

    /**
     * The length of {@see asList}.
     *
     * This is used to compute {@see sassIndexToListIndex} without allocating a new
     * list.
     */
    protected function getLengthAsList(): int
    {
        return 1;
    }

    /**
     * Calls the appropriate visit method on $visitor.
     *
     * @template T
     *
     * @param ValueVisitor<T> $visitor
     *
     * @return T
     *
     * @internal
     */
    abstract public function accept(ValueVisitor $visitor);

    /**
     * Converts $sassIndex into a PHP-style index into the list returned by
     * {@see asList}.
     *
     * Sass indexes are one-based, while PHP indexes are zero-based. Sass
     * indexes may also be negative in order to index from the end of the list.
     *
     * @throws SassScriptException if $sassIndex isn't a number, if that
     * number isn't an integer, or if that integer isn't a valid index for
     * {@see asList}. If $sassIndex came from a function argument, $name is the
     * argument name (without the `$`). It's used for error reporting.
     */
    public function sassIndexToListIndex(Value $sassIndex, ?string $name = null): int
    {
        $index = $sassIndex->assertNumber($name)->assertInt($name);

        if ($index === 0) {
            throw SassScriptException::forArgument('List index may not be 0.', $name);
        }

        $lengthAsList = $this->getLengthAsList();

        if (abs($index) > $lengthAsList) {
            throw SassScriptException::forArgument("Invalid index $sassIndex for a list with $lengthAsList elements.", $name);
        }

        return $index < 0 ? $lengthAsList + $index : $index - 1;
    }

    /**
     * Throws a {@see SassScriptException} if $this isn't a boolean.
     *
     * Note that generally, functions should use {@see isTruthy} rather than requiring
     * a literal boolean.
     *
     * If this came from a function argument, $name is the argument name
     * (without the `$`). It's used for error reporting.
     *
     * @param string|null $name
     *
     * @return SassBoolean
     *
     * @throws SassScriptException
     */
    public function assertBoolean(?string $name = null): SassBoolean
    {
        throw SassScriptException::forArgument("$this is not a boolean.", $name);
    }

    /**
     * Throws a {@see SassScriptException} if $this isn't a calculation.
     *
     * If this came from a function argument, $name is the argument name
     * (without the `$`). It's used for error reporting.
     *
     * @param string|null $name
     *
     * @return SassCalculation
     *
     * @throws SassScriptException
     */
    public function assertCalculation(?string $name = null): SassCalculation
    {
        throw SassScriptException::forArgument("$this is not a calculation.", $name);
    }

    /**
     * Throws a {@see SassScriptException} if $this isn't a color.
     *
     * If this came from a function argument, $name is the argument name
     * (without the `$`). It's used for error reporting.
     *
     * @param string|null $name
     *
     * @return SassColor
     *
     * @throws SassScriptException
     */
    public function assertColor(?string $name = null): SassColor
    {
        throw SassScriptException::forArgument("$this is not a color.", $name);
    }

    /**
     * Throws a {@see SassScriptException} if $this isn't a string.
     *
     * If this came from a function argument, $name is the argument name
     * (without the `$`). It's used for error reporting.
     *
     * @param string|null $name
     *
     * @return SassFunction
     *
     * @throws SassScriptException
     */
    public function assertFunction(?string $name = null): SassFunction
    {
        throw SassScriptException::forArgument("$this is not a function.", $name);
    }

    /**
     * Throws a {@see SassScriptException} if $this isn't a map.
     *
     * If this came from a function argument, $name is the argument name
     * (without the `$`). It's used for error reporting.
     *
     * @param string|null $name
     *
     * @return SassMap
     *
     * @throws SassScriptException
     */
    public function assertMap(?string $name = null): SassMap
    {
        throw SassScriptException::forArgument("$this is not a map.", $name);
    }

    /**
     * Return $this as a SassMap if it is one (including empty lists) or null otherwise.
     *
     * @return SassMap|null
     */
    public function tryMap(): ?SassMap
    {
        return null;
    }

    /**
     * Throws a {@see SassScriptException} if $this isn't a number.
     *
     * If this came from a function argument, $name is the argument name
     * (without the `$`). It's used for error reporting.
     *
     * @param string|null $name
     *
     * @return SassNumber
     *
     * @throws SassScriptException
     */
    public function assertNumber(?string $name = null): SassNumber
    {
        throw SassScriptException::forArgument("$this is not a number.", $name);
    }

    /**
     * Throws a {@see SassScriptException} if $this isn't a string.
     *
     * If this came from a function argument, $name is the argument name
     * (without the `$`). It's used for error reporting.
     *
     * @param string|null $name
     *
     * @return SassString
     *
     * @throws SassScriptException
     */
    public function assertString(?string $name = null): SassString
    {
        throw SassScriptException::forArgument("$this is not a string.", $name);
    }

    /**
     * Whether the value will be represented in CSS as the empty string.
     *
     * @return bool
     *
     * @internal
     */
    public function isBlank(): bool
    {
        return false;
    }

    /**
     * Whether this is a value that CSS may treat as a number, such as `calc()` or `var()`.
     *
     * Functions that shadow plain CSS functions need to gracefully handle when
     * these arguments are passed in.
     *
     * @return bool
     *
     * @internal
     */
    public function isSpecialNumber(): bool
    {
        return false;
    }

    /**
     * Whether this is a call to `var()`, which may be substituted in CSS for a custom property value.
     *
     * Functions that shadow plain CSS functions need to gracefully handle when
     * these arguments are passed in.
     *
     * @return bool
     *
     * @internal
     */
    public function isVar(): bool
    {
        return false;
    }

    /**
     * Returns a new list containing $contents that defaults to this value's
     * separator and brackets.
     *
     * @param list<Value> $contents
     * @param string|null $separator
     * @param bool|null   $brackets
     *
     * @return SassList
     *
     * @phpstan-param ListSeparator::*|null $separator
     */
    public function withListContents(array $contents, ?string $separator = null, ?bool $brackets = null): SassList
    {
        return new SassList($contents, $separator ?? $this->getSeparator(), $brackets ?? $this->hasBrackets());
    }

    /**
     * The SassScript = operation
     *
     * @param Value $other
     *
     * @return Value
     *
     * @internal
     */
    public function singleEquals(Value $other): Value
    {
        return new SassString(sprintf('%s=%s', $this->toCssString(), $other->toCssString()), false);
    }

    /**
     * The SassScript `>` operation.
     *
     * @param Value $other
     *
     * @return SassBoolean
     *
     * @internal
     */
    public function greaterThan(Value $other): SassBoolean
    {
        throw new SassScriptException("Undefined operation \"$this > $other\".");
    }

    /**
     * The SassScript `>=` operation.
     *
     * @param Value $other
     *
     * @return SassBoolean
     *
     * @internal
     */
    public function greaterThanOrEquals(Value $other): SassBoolean
    {
        throw new SassScriptException("Undefined operation \"$this >= $other\".");
    }

    /**
     * The SassScript `<` operation.
     *
     * @param Value $other
     *
     * @return SassBoolean
     *
     * @internal
     */
    public function lessThan(Value $other): SassBoolean
    {
        throw new SassScriptException("Undefined operation \"$this < $other\".");
    }

    /**
     * The SassScript `<=` operation.
     *
     * @param Value $other
     *
     * @return SassBoolean
     *
     * @internal
     */
    public function lessThanOrEquals(Value $other): SassBoolean
    {
        throw new SassScriptException("Undefined operation \"$this <= $other\".");
    }

    /**
     * The SassScript `*` operation.
     *
     * @param Value $other
     *
     * @return Value
     *
     * @internal
     */
    public function times(Value $other): Value
    {
        throw new SassScriptException("Undefined operation \"$this * $other\".");
    }

    /**
     * The SassScript `%` operation.
     *
     * @param Value $other
     *
     * @return Value
     *
     * @internal
     */
    public function modulo(Value $other): Value
    {
        throw new SassScriptException("Undefined operation \"$this % $other\".");
    }

    /**
     * The SassScript `+` operation.
     *
     * @param Value $other
     *
     * @return Value
     *
     * @internal
     */
    public function plus(Value $other): Value
    {
        if ($other instanceof SassString) {
            return new SassString($this->toCssString() . $other->getText(), $other->hasQuotes());
        }

        if ($other instanceof SassCalculation) {
            throw new SassScriptException("Undefined operation \"$this + $other\".");
        }

        return new SassString($this->toCssString() . $other->toCssString(), false);
    }

    /**
     * The SassScript `-` operation.
     *
     * @param Value $other
     *
     * @return Value
     *
     * @internal
     */
    public function minus(Value $other): Value
    {
        if ($other instanceof SassCalculation) {
            throw new SassScriptException("Undefined operation \"$this - $other\".");
        }

        return new SassString(sprintf('%s-%s', $this->toCssString(), $other->toCssString()), false);
    }

    /**
     * The SassScript `/` operation.
     *
     * @param Value $other
     *
     * @return Value
     *
     * @internal
     */
    public function dividedBy(Value $other): Value
    {
        return new SassString(sprintf('%s/%s', $this->toCssString(), $other->toCssString()), false);
    }

    /**
     * The SassScript unary `+` operation.
     *
     * @return Value
     *
     * @internal
     */
    public function unaryPlus(): Value
    {
        return new SassString(sprintf('+%s', $this->toCssString()), false);
    }

    /**
     * The SassScript unary `-` operation.
     *
     * @return Value
     *
     * @internal
     */
    public function unaryMinus(): Value
    {
        return new SassString(sprintf('-%s', $this->toCssString()), false);
    }

    /**
     * The SassScript unary `/` operation.
     *
     * @return Value
     *
     * @internal
     */
    public function unaryDivide(): Value
    {
        return new SassString(sprintf('/%s', $this->toCssString()), false);
    }

    /**
     * The SassScript unary `not` operation.
     *
     * @return Value
     *
     * @internal
     */
    public function unaryNot(): Value
    {
        return SassBoolean::create(false);
    }

    /**
     * Returns a copy of $this without {@see SassNumber::$asSlash} set.
     *
     * If this isn't a SassNumber, return it as-is.
     *
     * @return Value
     *
     * @internal
     */
    public function withoutSlash(): Value
    {
        return $this;
    }

    /**
     * Returns a valid CSS representation of $this.
     *
     * Use {@see toString} instead to get a string representation even if this
     * isn't valid CSS.
     *
     * Internal-only: If $quote is `false`, quoted strings are emitted without
     * quotes.
     *
     * @throws SassScriptException if $this cannot be represented in plain CSS.
     */
    final public function toCssString(bool $quote = true): string
    {
        return Serializer::serializeValue($this, false, $quote);
    }

    /**
     * Returns a Sass representation of $this.
     *
     * Note that this is equivalent to calling `inspect()` on the value, and thus
     * won't reflect the user's output settings. {@see toCssString} should be used
     * instead to convert $this to CSS.
     *
     * @return string
     */
    final public function __toString(): string
    {
        return Serializer::serializeValue($this, true);
    }
}
