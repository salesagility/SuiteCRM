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

use ScssPhp\ScssPhp\Util\NumberUtil;

/**
 * A specialized subclass of {@see SassNumber} for numbers that have exactly one numerator unit.
 *
 * @internal
 */
final class SingleUnitSassNumber extends SassNumber
{
    private const KNOWN_COMPATIBILITIES_BY_UNIT = [
        // length
        'em' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'ex' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'ch' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'rem' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'vw' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'vh' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'vmin' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'vmax' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'cm' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'mm' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'q' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'in' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'pc' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'pt' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        'px' => ['em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', 'cm', 'mm', 'q', 'in', 'pc', 'pt', 'px'],
        // angle
        'deg' => ['deg', 'grad', 'rad', 'turn'],
        'grad' => ['deg', 'grad', 'rad', 'turn'],
        'rad' => ['deg', 'grad', 'rad', 'turn'],
        'turn' => ['deg', 'grad', 'rad', 'turn'],
        // time
        's' => ['s', 'ms'],
        'ms' => ['s', 'ms'],
        // frequency
        'hz' => ['hz', 'khz'],
        'khz' => ['hz', 'khz'],
        // pixel density
        'dpi' => ['dpi', 'dpcm', 'dppx'],
        'dpcm' => ['dpi', 'dpcm', 'dppx'],
        'dppx' => ['dpi', 'dpcm', 'dppx'],
    ];

    /**
     * @var string
     */
    private $unit;

    /**
     * @param int|float                          $value
     * @param string                             $unit
     * @param array{SassNumber, SassNumber}|null $asSlash
     */
    public function __construct($value, string $unit, array $asSlash = null)
    {
        parent::__construct($value, $asSlash);
        $this->unit = $unit;
    }

    public function getNumeratorUnits(): array
    {
        return [$this->unit];
    }

    public function getDenominatorUnits(): array
    {
        return [];
    }

    public function hasUnits(): bool
    {
        return true;
    }

    protected function withValue($value): SassNumber
    {
        return new self($value, $this->unit);
    }

    public function withSlash(SassNumber $numerator, SassNumber $denominator): SassNumber
    {
        return new self($this->getValue(), $this->unit, array($numerator, $denominator));
    }

    public function hasUnit(string $unit): bool
    {
        return $unit === $this->unit;
    }

    public function hasCompatibleUnits(SassNumber $other): bool
    {
        return $other instanceof SingleUnitSassNumber && $this->compatibleWithUnit($other->unit);
    }

    public function hasPossiblyCompatibleUnits(SassNumber $other): bool
    {
        if (!$other instanceof SingleUnitSassNumber) {
            return false;
        }

        $knownCompatibilities = self::KNOWN_COMPATIBILITIES_BY_UNIT[strtolower($this->unit)] ?? null;

        if ($knownCompatibilities === null) {
            return true;
        }

        $otherUnit = strtolower($other->unit);

        return !isset(self::KNOWN_COMPATIBILITIES_BY_UNIT[$otherUnit]) || \in_array($otherUnit, $knownCompatibilities, true);
    }

    public function compatibleWithUnit(string $unit): bool
    {
        return self::getConversionFactor($this->unit, $unit) !== null;
    }

    public function coerceToMatch(SassNumber $other, ?string $name = null, ?string $otherName = null): SassNumber
    {
        return $this->convertToMatch($other, $name, $otherName);
    }

    public function coerceValueToMatch(SassNumber $other, ?string $name = null, ?string $otherName = null)
    {
        return $this->convertValueToMatch($other, $name, $otherName);
    }

    public function convertToMatch(SassNumber $other, ?string $name = null, ?string $otherName = null): SassNumber
    {
        if ($other instanceof SingleUnitSassNumber) {
            $coerced = $this->tryCoerceToUnit($other->unit);

            if ($coerced !== null) {
                return $coerced;
            }
        }

        // Call the parent to generate a consistent error message.
        return parent::convertToMatch($other, $name, $otherName);
    }

    public function convertValueToMatch(SassNumber $other, ?string $name = null, ?string $otherName = null)
    {
        if ($other instanceof SingleUnitSassNumber) {
            $coerced = $this->tryCoerceValueToUnit($other->unit);

            if ($coerced !== null) {
                return $coerced;
            }
        }

        // Call the parent to generate a consistent error message.
        return parent::convertValueToMatch($other, $name, $otherName);
    }

    public function coerce(array $newNumeratorUnits, array $newDenominatorUnits, ?string $name = null): SassNumber
    {
        if (\count($newNumeratorUnits) === 1 && \count($newDenominatorUnits) === 0) {
            $coerced = $this->tryCoerceToUnit($newNumeratorUnits[0]);

            if ($coerced !== null) {
                return $coerced;
            }
        }

        // Call the parent to generate a consistent error message.
        return parent::coerce($newNumeratorUnits, $newDenominatorUnits, $name);
    }

    public function coerceValue(array $newNumeratorUnits, array $newDenominatorUnits, ?string $name = null)
    {
        if (\count($newNumeratorUnits) === 1 && \count($newDenominatorUnits) === 0) {
            $coerced = $this->tryCoerceValueToUnit($newNumeratorUnits[0]);

            if ($coerced !== null) {
                return $coerced;
            }
        }

        // Call the parent to generate a consistent error message.
        return parent::coerceValue($newNumeratorUnits, $newDenominatorUnits, $name);
    }

    public function coerceValueToUnit(string $unit, ?string $name = null)
    {
        $coerced = $this->tryCoerceValueToUnit($unit);

        if ($coerced !== null) {
            return $coerced;
        }

        // Call the parent to generate a consistent error message.
        return parent::coerceValueToUnit($unit, $name);
    }

    public function unaryMinus(): Value
    {
        return new self(-$this->getValue(), $this->unit);
    }

    public function equals(object $other): bool
    {
        if ($other instanceof SingleUnitSassNumber) {
            $factor = self::getConversionFactor($other->unit, $this->unit);

            return $factor !== null && NumberUtil::fuzzyEquals($this->getValue() * $factor, $other->getValue());
        }

        return false;
    }

    /**
     * @param int|float    $value
     * @param list<string> $otherNumerators
     * @param list<string> $otherDenominators
     *
     * @return SassNumber
     */
    protected function multiplyUnits($value, array $otherNumerators, array $otherDenominators): SassNumber
    {
        $newNumerators = $otherDenominators;
        $removed = false;

        foreach ($otherDenominators as $key => $denominator) {
            $conversionFactor = self::getConversionFactor($denominator, $this->unit);

            if (\is_null($conversionFactor)) {
                continue;
            }

            $value *= $conversionFactor;
            unset($otherDenominators[$key]);
            $removed = true;
            break;
        }

        if ($removed) {
            $otherDenominators = array_values($otherDenominators);
        } else {
            array_unshift($newNumerators, $this->unit);
        }

        return SassNumber::withUnits($value, $newNumerators, $otherDenominators);
    }

    /**
     * @param string $unit
     *
     * @return SassNumber|null
     */
    private function tryCoerceToUnit(string $unit): ?SassNumber
    {
        if ($unit === $this->unit) {
            return $this;
        }

        $factor = self::getConversionFactor($unit, $this->unit);

        if ($factor === null) {
            return null;
        }

        return new SingleUnitSassNumber($this->getValue() * $factor, $unit);
    }

    /**
     * @param string $unit
     *
     * @return float|int|null
     */
    private function tryCoerceValueToUnit(string $unit)
    {
        $factor = self::getConversionFactor($unit, $this->unit);

        if ($factor === null) {
            return null;
        }

        return $this->getValue() * $factor;
    }
}
