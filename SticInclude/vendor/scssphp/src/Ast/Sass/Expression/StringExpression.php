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
use ScssPhp\ScssPhp\Ast\Sass\Interpolation;
use ScssPhp\ScssPhp\Parser\InterpolationBuffer;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Util\Character;
use ScssPhp\ScssPhp\Visitor\ExpressionVisitor;

/**
 * A string literal.
 *
 * @internal
 */
final class StringExpression implements Expression
{
    /**
     * @var Interpolation
     * @readonly
     */
    private $text;

    /**
     * @var bool
     * @readonly
     */
    private $quotes;

    public function __construct(Interpolation $text, bool $quotes = false)
    {
        $this->text = $text;
        $this->quotes = $quotes;
    }

    /**
     * Returns a string expression with no interpolation.
     */
    public static function plain(string $text, FileSpan $span, bool $quotes = false): self
    {
        return new self(new Interpolation([$text], $span), $quotes);
    }

    public function getText(): Interpolation
    {
        return $this->text;
    }

    public function hasQuotes(): bool
    {
        return $this->quotes;
    }

    public function getSpan(): FileSpan
    {
        return $this->text->getSpan();
    }

    public function accepts(ExpressionVisitor $visitor)
    {
        return $visitor->visitStringExpression($this);
    }

    public function asInterpolation(bool $static = false, string $quote = null): Interpolation
    {
        if (!$this->quotes) {
            return $this->text;
        }

        $quote = $quote ?? self::bestQuote($this->text->getContents());
        $buffer = new InterpolationBuffer();

        $buffer->write($quote);

        foreach ($this->text->getContents() as $value) {
            if ($value instanceof Expression) {
                $buffer->add($value);
            } else {
                self::quoteInnerText($value, $quote, $buffer, $static);
            }
        }

        $buffer->write($quote);

        return $buffer->buildInterpolation($this->text->getSpan());
    }

    private static function quoteInnerText(string $value, string $quote, InterpolationBuffer $buffer, bool $static = false): void
    {
        $length = \strlen($value);

        for ($i = 0; $i < $length; $i++) {
            $char = $value[$i];

            if (Character::isNewline($char)) {
                $buffer->write('\\a');

                if ($i !== $length - 1) {
                    $next = $value[$i + 1];

                    if (Character::isWhitespace($next) || Character::isHex($next)) {
                        $buffer->write(' ');
                    }
                }
            } else {
                if ($char === $quote || $char === '\\' || ($static && $char === '#' && $i < $length - 1 && $value[$i + 1] === '{')) {
                    $buffer->write('\\');
                }

                if (\ord($char) < 0x80) {
                    $buffer->write($char);
                } else {
                    if (!preg_match('/./usA', $value, $m, 0, $i)) {
                        throw new \UnexpectedValueException('Invalid UTF-8 char');
                    }

                    $buffer->write($m[0]);
                    $i += \strlen($m[0]) - 1; // skip over the extra bytes that have been processed.
                }
            }
        }

    }

    /**
     * @param array<string|Expression> $parts
     *
     * @return string
     */
    private static function bestQuote(array $parts): string
    {
        $containsDoubleQuote = false;

        foreach ($parts as $part) {
            if (!\is_string($part)) {
                continue;
            }

            if (false !== strpos($part, "'")) {
                return '"';
            }

            if (false !== strpos($part, '"')) {
                $containsDoubleQuote = true;
            }
        }

        return $containsDoubleQuote ? "'": '"';
    }
}
