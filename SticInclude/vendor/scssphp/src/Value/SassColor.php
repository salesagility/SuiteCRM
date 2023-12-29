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
use ScssPhp\ScssPhp\Util\ErrorUtil;
use ScssPhp\ScssPhp\Util\NumberUtil;
use ScssPhp\ScssPhp\Visitor\ValueVisitor;

final class SassColor extends Value
{
    /**
     * This color's red channel, between `0` and `255`.
     *
     * @var int|null
     */
    private $red;

    /**
     * This color's blue channel, between `0` and `255`.
     *
     * @var int|null
     */
    private $blue;

    /**
     * This color's green channel, between `0` and `255`.
     *
     * @var int|null
     */
    private $green;

    /**
     * This color's hue, between `0` and `360`.
     *
     * @var int|float|null
     */
    private $hue;

    /**
     * This color's saturation, a percentage between `0` and `100`.
     *
     * @var int|float|null
     */
    private $saturation;

    /**
     * This color's lightness, a percentage between `0` and `100`.
     *
     * @var int|float|null
     */
    private $lightness;

    /**
     * TThis color's alpha channel, between `0` and `1`.
     *
     * @var int|float
     */
    private $alpha;

    /**
     * Creates a RGB color
     *
     * @param int $red
     * @param int $blue
     * @param int $green
     * @param int|float|null $alpha
     *
     * @return SassColor
     *
     * @throws \OutOfRangeException if values are outside the expected range.
     */
    public static function rgb(int $red, int $green, int $blue, $alpha = null): SassColor
    {
        if ($alpha === null) {
            $alpha = 1;
        } else {
            $alpha = NumberUtil::fuzzyAssertRange($alpha, 0, 1, 'alpha');
        }

        ErrorUtil::checkIntInInterval($red, 0, 255, 'red');
        ErrorUtil::checkIntInInterval($green, 0, 255, 'green');
        ErrorUtil::checkIntInInterval($blue, 0, 255, 'blue');

        return new self($red, $green, $blue, null, null, null, $alpha);
    }

    /**
     * @param int|float $hue
     * @param int|float $saturation
     * @param int|float $lightness
     * @param int|float|null $alpha
     *
     * @return SassColor
     */
    public static function hsl($hue, $saturation, $lightness, $alpha = null): SassColor
    {
        if ($alpha === null) {
            $alpha = 1;
        } else {
            $alpha = NumberUtil::fuzzyAssertRange($alpha, 0, 1, 'alpha');
        }

        $hue = fmod($hue , 360);
        $saturation = NumberUtil::fuzzyAssertRange($saturation, 0, 100, 'saturation');
        $lightness = NumberUtil::fuzzyAssertRange($lightness, 0, 100, 'lightness');

        return new self(null, null, null, $hue, $saturation, $lightness, $alpha);
    }

    /**
     * @param int|float      $hue
     * @param int|float      $whiteness
     * @param int|float      $blackness
     * @param int|float|null $alpha
     *
     * @return SassColor
     */
    public static function hwb($hue, $whiteness, $blackness, $alpha = null): SassColor
    {
        $scaledHue = fmod($hue , 360) / 360;
        $scaledWhiteness = NumberUtil::fuzzyAssertRange($whiteness, 0, 100, 'whiteness') / 100;
        $scaledBlackness = NumberUtil::fuzzyAssertRange($blackness, 0, 100, 'blackness') / 100;

        $sum = $scaledWhiteness + $scaledBlackness;

        if ($sum > 1) {
            $scaledWhiteness /= $sum;
            $scaledBlackness /= $sum;
        }

        $factor = 1 - $scaledWhiteness - $scaledBlackness;

        $toRgb = function (float $hue) use ($factor, $scaledWhiteness) {
            $channel = self::hueToRgb(0, 1, $hue) * $factor + $scaledWhiteness;

            return NumberUtil::fuzzyRound($channel * 255);
        };

        return self::rgb($toRgb($scaledHue + 1/3), $toRgb($scaledHue), $toRgb($scaledHue - 1/3), $alpha);
    }

    /**
     * This must always provide non-null values for either RGB or HSL values.
     * If they are all provided, they are expected to be in sync and this not
     * revalidated. This constructor does not revalidate ranges either.
     * Use named factories when this cannot be guaranteed.
     *
     * @param int|null       $red
     * @param int|null       $green
     * @param int|null       $blue
     * @param int|float|null $hue
     * @param int|float|null $saturation
     * @param int|float|null $lightness
     * @param int|float      $alpha
     */
    private function __construct(?int $red, ?int $green, ?int $blue, $hue, $saturation, $lightness, $alpha)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->lightness = $lightness;
        $this->alpha = $alpha;
    }

    public function getRed(): int
    {
        if (\is_null($this->red)) {
            $this->hslToRgb();
            assert(!\is_null($this->red));
        }

        return $this->red;
    }

    public function getGreen(): int
    {
        if (\is_null($this->green)) {
            $this->hslToRgb();
            assert(!\is_null($this->green));
        }

        return $this->green;
    }

    public function getBlue(): int
    {
        if (\is_null($this->blue)) {
            $this->hslToRgb();
            assert(!\is_null($this->blue));
        }

        return $this->blue;
    }

    /**
     * @return int|float
     */
    public function getHue()
    {
        if (\is_null($this->hue)) {
            $this->rgbToHsl();
            assert(!\is_null($this->hue));
        }

        return $this->hue;
    }

    /**
     * @return int|float
     */
    public function getSaturation()
    {
        if (\is_null($this->saturation)) {
            $this->rgbToHsl();
            assert(!\is_null($this->saturation));
        }

        return $this->saturation;
    }

    /**
     * @return int|float
     */
    public function getLightness()
    {
        if (\is_null($this->lightness)) {
            $this->rgbToHsl();
            assert(!\is_null($this->lightness));
        }

        return $this->lightness;
    }

    /**
     * @return float|int
     */
    public function getWhiteness()
    {
        return min($this->getRed(), $this->getGreen(), $this->getBlue()) / 255 * 100;
    }

    /**
     * @return float|int
     */
    public function getBlackness()
    {
        return 100 - max($this->getRed(), $this->getGreen(), $this->getBlue()) / 255 * 100;
    }

    /**
     * @return int|float
     */
    public function getAlpha()
    {
        return $this->alpha;
    }

    public function accept(ValueVisitor $visitor)
    {
        return $visitor->visitColor($this);
    }

    public function assertColor(?string $name = null): SassColor
    {
        return $this;
    }

    /**
     * @param int|null $red
     * @param int|null $green
     * @param int|null $blue
     * @param int|float|null $alpha
     *
     * @return SassColor
     */
    public function changeRgb(?int $red = null, ?int $green = null, ?int $blue = null, $alpha = null): SassColor
    {
        return self::rgb($red ?? $this->getRed(), $green ?? $this->getGreen(), $blue ?? $this->getBlue(), $alpha ?? $this->alpha);
    }

    /**
     * @param int|float|null $hue
     * @param int|float|null $saturation
     * @param int|float|null $lightness
     * @param int|float|null $alpha
     *
     * @return SassColor
     */
    public function changeHsl($hue = null, $saturation = null, $lightness = null, $alpha = null): SassColor
    {
        return self::hsl($hue ?? $this->getHue(), $saturation ?? $this->getSaturation(), $lightness ?? $this->getLightness(), $alpha ?? $this->alpha);
    }

    /**
     * @param int|float|null $hue
     * @param int|float|null $whiteness
     * @param int|float|null $blackness
     * @param int|float|null $alpha
     *
     * @return SassColor
     */
    public function changeHwb($hue = null, $whiteness = null, $blackness = null, $alpha = null): SassColor
    {
        return self::hwb($hue ?? $this->getHue(), $whiteness ?? $this->getWhiteness(), $blackness ?? $this->getBlackness(), $alpha ?? $this->alpha);
    }

    /**
     * @param int|float $alpha
     *
     * @return SassColor
     */
    public function changeAlpha($alpha): SassColor
    {
        return new self(
            $this->red,
            $this->green,
            $this->blue,
            $this->hue,
            $this->saturation,
            $this->lightness,
            NumberUtil::fuzzyAssertRange($alpha, 0, 1, 'alpha')
        );
    }

    public function plus(Value $other): Value
    {
        if (!$other instanceof SassColor && !$other instanceof SassNumber) {
            return parent::plus($other);
        }

        throw new SassScriptException("Undefined operation \"$this + $other\".");
    }

    public function minus(Value $other): Value
    {
        if (!$other instanceof SassColor && !$other instanceof SassNumber) {
            return parent::minus($other);
        }

        throw new SassScriptException("Undefined operation \"$this - $other\".");
    }

    public function dividedBy(Value $other): Value
    {
        if (!$other instanceof SassColor && !$other instanceof SassNumber) {
            return parent::dividedBy($other);
        }

        throw new SassScriptException("Undefined operation \"$this / $other\".");
    }

    public function modulo(Value $other): Value
    {
        if (!$other instanceof SassColor && !$other instanceof SassNumber) {
            return parent::modulo($other);
        }

        throw new SassScriptException("Undefined operation \"$this % $other\".");
    }

    public function equals(object $other): bool
    {
        return $other instanceof SassColor && $this->getRed() === $other->getRed() && $this->getGreen() === $other->getGreen() && $this->getBlue() === $other->getBlue() && $this->alpha === $other->alpha;
    }

    /**
     * @return void
     */
    private function rgbToHsl(): void
    {
        $scaledRed = $this->getRed() / 255;
        $scaledGreen = $this->getGreen() / 255;
        $scaledBlue = $this->getBlue() / 255;

        $min = min($scaledRed, $scaledGreen, $scaledBlue);
        $max = max($scaledRed, $scaledGreen, $scaledBlue);
        $delta = $max - $min;

        if ($delta == 0) {
            $this->hue = 0;
        } elseif ($max == $scaledRed) {
            $this->hue = fmod(60 * ($scaledGreen - $scaledBlue) / $delta, 360);
        } elseif ($max == $scaledGreen) {
            $this->hue = fmod(120 + 60 * ($scaledBlue - $scaledRed) / $delta, 360);
        } else {
            $this->hue = fmod(240 + 60 * ($scaledRed - $scaledGreen) / $delta, 360);
        }

        $this->lightness = 50 * ($max + $min);

        if ($max == $min) {
            $this->saturation = 50;
        } elseif ($this->lightness < 50) {
            $this->saturation = 100 * $delta / ($max + $min);
        } else {
            $this->saturation = 100 * $delta / (2 - $max - $min);
        }
    }

    /**
     * @return void
     */
    private function hslToRgb(): void
    {
        $scaledHue = $this->getHue() / 360;
        $scaledSaturation = $this->getSaturation() / 100;
        $scaledLightness = $this->getLightness() / 100;

        if ($scaledLightness <= 0.5) {
            $m2 = $scaledLightness * ($scaledSaturation + 1);
        } else {
            $m2 = $scaledLightness + $scaledSaturation - $scaledLightness * $scaledSaturation;
        }

        $m1 = $scaledLightness * 2 - $m2;

        $this->red = NumberUtil::fuzzyRound(self::hueToRgb($m1, $m2, $scaledHue + 1 / 3) * 255);
        $this->green = NumberUtil::fuzzyRound(self::hueToRgb($m1, $m2, $scaledHue) * 255);
        $this->blue = NumberUtil::fuzzyRound(self::hueToRgb($m1, $m2, $scaledHue - 1 / 3) * 255);
    }

    /**
     * @param int|float $m1
     * @param int|float $m2
     * @param int|float $hue
     *
     * @return int|float
     */
    private static function hueToRgb($m1, $m2, $hue)
    {
        if ($hue < 0) {
            $hue += 1;
        } elseif ($hue > 1) {
            $hue -= 1;
        }

        if ($hue < 1 / 6) {
            return $m1 + ($m2 - $m1) * $hue * 6;
        }

        if ($hue < 1 / 2) {
            return $m2;
        }

        if ($hue < 2 / 3) {
            return $m1 + ($m2 - $m1) * (2 / 3 - $hue) * 6;
        }

        return $m1;
    }
}
