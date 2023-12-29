<?php

/**
 * SCSSPHP
 *
 * @copyright 2018-2020 Anthon Pang
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace ScssPhp\ScssPhp\Serializer;

use ScssPhp\ScssPhp\Ast\AstNode;
use ScssPhp\ScssPhp\Ast\Css\CssAtRule;
use ScssPhp\ScssPhp\Ast\Css\CssComment;
use ScssPhp\ScssPhp\Ast\Css\CssDeclaration;
use ScssPhp\ScssPhp\Ast\Css\CssMediaQuery;
use ScssPhp\ScssPhp\Ast\Css\CssNode;
use ScssPhp\ScssPhp\Ast\Css\CssParentNode;
use ScssPhp\ScssPhp\Ast\Css\CssStyleRule;
use ScssPhp\ScssPhp\Ast\Css\CssValue;
use ScssPhp\ScssPhp\Ast\Selector\AttributeSelector;
use ScssPhp\ScssPhp\Ast\Selector\ClassSelector;
use ScssPhp\ScssPhp\Ast\Selector\ComplexSelector;
use ScssPhp\ScssPhp\Ast\Selector\CompoundSelector;
use ScssPhp\ScssPhp\Ast\Selector\IDSelector;
use ScssPhp\ScssPhp\Ast\Selector\ParentSelector;
use ScssPhp\ScssPhp\Ast\Selector\PlaceholderSelector;
use ScssPhp\ScssPhp\Ast\Selector\PseudoSelector;
use ScssPhp\ScssPhp\Ast\Selector\SelectorList;
use ScssPhp\ScssPhp\Ast\Selector\TypeSelector;
use ScssPhp\ScssPhp\Ast\Selector\UniversalSelector;
use ScssPhp\ScssPhp\Colors;
use ScssPhp\ScssPhp\Exception\SassRuntimeException;
use ScssPhp\ScssPhp\Exception\SassScriptException;
use ScssPhp\ScssPhp\OutputStyle;
use ScssPhp\ScssPhp\Parser\LineScanner;
use ScssPhp\ScssPhp\Parser\Parser;
use ScssPhp\ScssPhp\Parser\StringScanner;
use ScssPhp\ScssPhp\Util;
use ScssPhp\ScssPhp\Util\Character;
use ScssPhp\ScssPhp\Util\NumberUtil;
use ScssPhp\ScssPhp\Value\CalculationInterpolation;
use ScssPhp\ScssPhp\Value\CalculationOperation;
use ScssPhp\ScssPhp\Value\CalculationOperator;
use ScssPhp\ScssPhp\Value\ListSeparator;
use ScssPhp\ScssPhp\Value\SassBoolean;
use ScssPhp\ScssPhp\Value\SassCalculation;
use ScssPhp\ScssPhp\Value\SassColor;
use ScssPhp\ScssPhp\Value\SassFunction;
use ScssPhp\ScssPhp\Value\SassList;
use ScssPhp\ScssPhp\Value\SassMap;
use ScssPhp\ScssPhp\Value\SassNumber;
use ScssPhp\ScssPhp\Value\SassString;
use ScssPhp\ScssPhp\Value\Value;
use ScssPhp\ScssPhp\Visitor\CssVisitor;
use ScssPhp\ScssPhp\Visitor\SelectorVisitor;
use ScssPhp\ScssPhp\Visitor\ValueVisitor;

/**
 * @internal
 *
 * @template-implements CssVisitor<void>
 * @template-implements ValueVisitor<void>
 * @template-implements SelectorVisitor<void>
 */
class SerializeVisitor implements CssVisitor, ValueVisitor, SelectorVisitor
{
    /**
     * @var StringBuffer
     */
    private $buffer;

    /**
     * The current indentation of the CSS output.
     *
     * @var int
     */
    private $indentation = 0;

    /**
     * Whether we're emitting an unambiguous representation of the source
     * structure, as opposed to valid CSS.
     *
     * @var bool
     */
    private $inspect;

    /**
     * Whether quoted strings should be emitted with quotes.
     *
     * @var bool
     */
    private $quote;

    /**
     * @var bool
     */
    private $compressed;

    /**
     * @phpstan-param OutputStyle::* $style
     */
    public function __construct(bool $inspect = false, bool $quote = true, string $style = OutputStyle::EXPANDED)
    {
        $this->buffer = new SimpleStringBuffer();
        $this->inspect = $inspect;
        $this->quote = $quote;
        $this->compressed = $style === OutputStyle::COMPRESSED;
    }

    /**
     * @return StringBuffer
     */
    public function getBuffer(): StringBuffer
    {
        return $this->buffer;
    }

    public function visitCssStylesheet($node): void
    {
        $previous = null;

        foreach ($node->getChildren() as $child) {
            if ($this->isInvisible($child)) {
                continue;
            }

            if ($previous !== null) {
                if ($this->requiresSemicolon($previous)) {
                    $this->buffer->writeChar(';');
                }
                $this->writeLineFeed();

                if ($previous->isGroupEnd()) {
                    $this->writeLineFeed();
                }
            }

            $previous = $child;
            $child->accept($this);
        }

        if ($previous !== null && $this->requiresSemicolon($previous) && !$this->compressed) {
            $this->buffer->writeChar(';');
        }
    }

    public function visitCssComment($node): void
    {
        $this->for($node, function () use ($node) {
            // Preserve comments that start with `/*!`.
            if ($this->compressed && !$node->isPreserved()) {
                return;
            }

            $minimumIndentation = $this->minimumIndentation($node->getText());
            assert($minimumIndentation !== -1);

            if ($minimumIndentation === null) {
                $this->writeIndentation();
                $this->buffer->write($node->getText());
                return;
            }

            $minimumIndentation = min($minimumIndentation, $node->getSpan()->getStart()->getColumn());
            $this->writeIndentation();
            $this->writeWithIndent($node->getText(), $minimumIndentation);
        });
    }

    public function visitCssAtRule($node): void
    {
        $this->writeIndentation();

        $this->for($node, function () use ($node) {
            $this->buffer->writeChar('@');
            $this->write($node->getName());

            $value = $node->getValue();

            if ($value !== null) {
                $this->buffer->writeChar(' ');
                $this->write($value);
            }

            if (!$node->isChildless()) {
                $this->writeOptionalSpace();
                $this->visitChildren($node->getChildren());
            }
        });
    }

    public function visitCssMediaRule($node): void
    {
        $this->writeIndentation();

        $this->for($node, function () use ($node) {
            $this->buffer->write('@media');

            if (!$this->compressed || !$node->getQueries()[0]->isCondition()) {
                $this->buffer->writeChar(' ');
            }

            $this->writeBetween($node->getQueries(), $this->getCommaSeparator(), [$this, 'visitMediaQuery']);
        });

        $this->writeOptionalSpace();
        $this->visitChildren($node->getChildren());
    }

    public function visitCssImport($node): void
    {
        $this->writeIndentation();

        $this->for($node, function () use ($node) {
            $this->buffer->write('@import');
            $this->writeOptionalSpace();
            $this->for($node->getUrl(), function () use ($node) {
                $this->writeImportUrl($node->getUrl()->getValue());
            });

            if ($node->getSupports() !== null) {
                $this->writeOptionalSpace();
                $this->write($node->getSupports());
            }

            if ($node->getMedia() !== null) {
                $this->writeOptionalSpace();
                $this->writeBetween($node->getMedia(), $this->getCommaSeparator(), [$this, 'visitMediaQuery']);
            }
        });
    }

    /**
     * Writes $url, which is an import's URL, to the buffer.
     */
    private function writeImportUrl(string $url): void
    {
        if (!$this->compressed || $url[0] !== 'u') {
            $this->buffer->write($url);
            return;
        }

        // If this is url(...), remove the surrounding function. This is terser and
        // it allows us to remove whitespace between `@import` and the URL.
        $urlContents = substr($url, 4, \strlen($url) - 5);

        $maybeQuote = $urlContents[0];
        if ($maybeQuote === "'" || $maybeQuote === '"') {
            $this->buffer->write($urlContents);
        } else {
            // If the URL didn't contain quotes, write them manually.
            $this->visitQuotedString($urlContents);
        }
    }

    public function visitCssKeyframeBlock($node): void
    {
        $this->writeIndentation();

        $this->for($node->getSelector(), function () use ($node) {
            $this->writeBetween($node->getSelector()->getValue(), $this->getCommaSeparator(), [$this->buffer, 'write']);
        });
        $this->writeOptionalSpace();
        $this->visitChildren($node->getChildren());
    }

    private function visitMediaQuery(CssMediaQuery $query): void
    {
        if ($query->getModifier() !== null) {
            $this->buffer->write($query->getModifier());
            $this->buffer->writeChar(' ');
        }

        if ($query->getType() !== null) {
            $this->buffer->write($query->getType());

            if (\count($query->getFeatures())) {
                $this->buffer->write(' and ');
            }
        }

        $this->writeBetween($query->getFeatures(), $this->compressed ? 'and ' : ' and ', [$this->buffer, 'write']);
    }

    public function visitCssStyleRule($node): void
    {
        $this->writeIndentation();

        $this->for($node->getSelector(), function () use ($node) {
            $node->getSelector()->getValue()->accept($this);
        });
        $this->writeOptionalSpace();
        $this->visitChildren($node->getChildren());
    }

    public function visitCssSupportsRule($node): void
    {
        $this->writeIndentation();

        $this->for($node, function () use ($node) {
            $this->buffer->write('@supports');

            if (!($this->compressed && $node->getCondition()->getValue()[0] === '(')) {
                $this->buffer->writeChar(' ');
            }

            $this->write($node->getCondition());
        });
        $this->writeOptionalSpace();
        $this->visitChildren($node->getChildren());
    }

    public function visitCssDeclaration($node): void
    {
        $this->writeIndentation();
        $this->write($node->getName());
        $this->buffer->writeChar(':');

        // If `node` is a custom property that was parsed as a normal Sass-syntax
        // property (such as `#{--foo}: ...`), we serialize its value using the
        // normal Sass property logic as well.
        if ($node->isCustomProperty() && $node->isParsedAsCustomProperty()) {
            $this->for($node->getValue(), function () use ($node) {
                if ($this->compressed) {
                    $this->writeFoldedValue($node);
                } else {
                    $this->writeReindentedValue($node);
                }
            });
        } else {
            $this->writeOptionalSpace();

            try {
                // TODO implement source map tracking
                $node->getValue()->getValue()->accept($this);
            } catch (SassScriptException $error) {
                throw new SassRuntimeException($error->getMessage(), $node->getValue()->getSpan(), $error);
            }
        }
    }

    /**
     * Emits the value of $node, with all newlines followed by whitespace
     */
    private function writeFoldedValue(CssDeclaration $node): void
    {
        $value = $node->getValue()->getValue();
        assert($value instanceof SassString);
        $scannner = new StringScanner($value->getText());

        while (!$scannner->isDone()) {
            $next = $scannner->readUtf8Char();
            if ($next !== "\n") {
                $this->buffer->writeChar($next);
                continue;
            }

            $this->buffer->writeChar(' ');
            while (Character::isWhitespace($scannner->peekChar())) {
                $scannner->readChar();
            }
        }
    }

    /**
     * Emits the value of $node, re-indented relative to the current indentation.
     */
    private function writeReindentedValue(CssDeclaration $node): void
    {
        $nodeValue = $node->getValue()->getValue();
        assert($nodeValue instanceof SassString);
        $value = $nodeValue->getText();

        $minimumIndentation = $this->minimumIndentation($value);
        if ($minimumIndentation === null) {
            $this->buffer->write($value);
            return;
        }

        if ($minimumIndentation === -1) {
            $this->buffer->write(Util\StringUtil::trimAsciiRight($value, true));
            $this->buffer->writeChar(' ');
            return;
        }

        $minimumIndentation = min($minimumIndentation, $node->getName()->getSpan()->getStart()->getColumn());
        $this->writeWithIndent($value, $minimumIndentation);
    }

    /**
     * Returns the indentation level of the least-indented non-empty line in
     * $text after the first.
     *
     * Returns `null` if $text contains no newlines, and -1 if it contains
     * newlines but no lines are indented.
     */
    private function minimumIndentation(string $text): ?int
    {
        $scanner = new LineScanner($text);
        while (!$scanner->isDone() && $scanner->readChar() !== "\n") {
        }

        if ($scanner->isDone()) {
            return $scanner->peekChar(-1) === "\n" ? -1 : null;
        }

        $min = null;
        while (!$scanner->isDone()) {
            while (!$scanner->isDone()) {
                $next = $scanner->peekChar();
                if ($next !== ' ' && $next !== "\t") {
                    break;
                }
                $scanner->readChar();
            }

            if ($scanner->isDone() || $scanner->scanChar("\n")) {
                continue;
            }

            $min = $min === null ? $scanner->getColumn() : min($min, $scanner->getColumn());

            while (!$scanner->isDone() && $scanner->readChar() !== "\n") {
            }
        }

        return $min ?? -1;
    }

    /**
     * Writes $text to {@see buffer}, replacing $minimumIndentation with
     * {@see indentation} for each non-empty line after the first.
     *
     * Compresses trailing empty lines of $text into a single trailing space.
     */
    private function writeWithIndent(string $text, int $minimumIndentation): void
    {
        $scanner = new LineScanner($text);

        while (!$scanner->isDone()) {
            $next = $scanner->readChar();

            if ($next === "\n") {
                break;
            }
            $this->buffer->writeChar($next);
        }

        while (true) {
            assert(Character::isWhitespace($scanner->peekChar(-1)));
            // Scan forward until we hit non-whitespace or the end of [text].
            $lineStart = $scanner->getPosition();
            $newlines = 1;

            while (true) {
                // If we hit the end of $text, we still need to preserve the fact that
                // whitespace exists because it could matter for custom properties.
                if ($scanner->isDone()) {
                    $this->buffer->writeChar(' ');
                    return;
                }

                $next = $scanner->readChar();

                if ($next === ' ' || $next === "\t") {
                    continue;
                }

                if ($next !== "\n") {
                    break;
                }

                $lineStart = $scanner->getPosition();
                $newlines++;
            }

            $this->writeTimes("\n", $newlines);
            $this->writeIndentation();
            $this->buffer->write($scanner->substring($lineStart + $minimumIndentation));

            // Scan and write until we hit a newline or the end of $text.
            while (true) {
                if ($scanner->isDone()) {
                    return;
                }
                $next = $scanner->readChar();
                if ($next === "\n") {
                    break;
                }
                $this->buffer->writeChar($next);
            }
        }
    }

    // ## Values

    public function visitBoolean(SassBoolean $value)
    {
        $this->buffer->write($value->getValue() ? 'true': 'false');
    }

    public function visitCalculation(SassCalculation $value)
    {
        $this->buffer->write($value->getName());
        $this->buffer->writeChar('(');

        $isFirst = true;

        foreach ($value->getArguments() as $argument) {
            if ($isFirst) {
                $isFirst = false;
            } else {
                $this->buffer->write($this->getCommaSeparator());
            }

            $this->writeCalculationValue($argument);
        }
        $this->buffer->writeChar(')');
    }

    private function writeCalculationValue(object $value): void
    {
        if ($value instanceof Value) {
            $value->accept($this);
        } elseif ($value instanceof CalculationInterpolation) {
            $this->buffer->write($value->getValue());
        } elseif ($value instanceof CalculationOperation) {
            $left = $value->getLeft();
            $parenthesizeLeft = $left instanceof CalculationInterpolation || ($left instanceof CalculationOperation && CalculationOperator::getPrecedence($left->getOperator()) < CalculationOperator::getPrecedence($value->getOperator()));

            if ($parenthesizeLeft) {
                $this->buffer->writeChar('(');
            }
            $this->writeCalculationValue($left);
            if ($parenthesizeLeft) {
                $this->buffer->writeChar(')');
            }

            $operatorWhitespace = !$this->compressed || CalculationOperator::getPrecedence($value->getOperator()) === 1;
            if ($operatorWhitespace) {
                $this->buffer->writeChar(' ');
            }
            $this->buffer->write($value->getOperator());
            if ($operatorWhitespace) {
                $this->buffer->writeChar(' ');
            }

            $right = $value->getRight();
            $parenthesizeRight = $right instanceof CalculationInterpolation || ($right instanceof CalculationOperation && $this->parenthesizeCalculationRhs($value->getOperator(), $right->getOperator()));

            if ($parenthesizeRight) {
                $this->buffer->writeChar('(');
            }
            $this->writeCalculationValue($right);
            if ($parenthesizeRight) {
                $this->buffer->writeChar(')');
            }
        }
    }

    /**
     * Returns whether the right-hand operation of a calculation should be
     * parenthesized.
     *
     * In `a ? (b # c)`, `outer` is `?` and `right` is `#`.
     *
     * @phpstan-param CalculationOperator::* $outer
     * @phpstan-param CalculationOperator::* $right
     */
    private function parenthesizeCalculationRhs(string $outer, string $right): bool
    {
        if ($outer === CalculationOperator::DIVIDED_BY) {
            return true;
        }

        if ($outer === CalculationOperator::PLUS) {
            return false;
        }

        return $right === CalculationOperator::PLUS || $right === CalculationOperator::MINUS;
    }

    public function visitColor(SassColor $value)
    {
        $name = Colors::RGBaToColorName($value->getRed(), $value->getGreen(), $value->getBlue(), $value->getAlpha());

        // In compressed mode, emit colors in the shortest representation possible.
        if ($this->compressed && NumberUtil::fuzzyEquals($value->getAlpha(), 1)) {
            $canUseShortHex = $this->canUseShortHex($value);
            $hexLength = $canUseShortHex ? 4 : 7;

            if ($name !== null && \strlen($name) <= $hexLength) {
                $this->buffer->write($name);
            } elseif ($canUseShortHex) {
                $this->buffer->writeChar('#');
                $this->buffer->writeChar(dechex($value->getRed() & 0xF));
                $this->buffer->writeChar(dechex($value->getGreen() & 0xF));
                $this->buffer->writeChar(dechex($value->getBlue() & 0xF));
            } else {
                $this->buffer->writeChar('#');
                $this->writeHexComponent($value->getRed());
                $this->writeHexComponent($value->getGreen());
                $this->writeHexComponent($value->getBlue());
            }

            return;
        }

        if ($name !== null && !NumberUtil::fuzzyEquals($value->getAlpha(), 0)) {
            $this->buffer->write($name);
        } elseif (NumberUtil::fuzzyEquals($value->getAlpha(), 1)) {
            $this->buffer->writeChar('#');
            $this->writeHexComponent($value->getRed());
            $this->writeHexComponent($value->getGreen());
            $this->writeHexComponent($value->getBlue());
        } else {
            $this->buffer->write('rgba(');
            $this->buffer->write((string) $value->getRed());
            $this->buffer->write($this->getCommaSeparator());
            $this->buffer->write((string) $value->getGreen());
            $this->buffer->write($this->getCommaSeparator());
            $this->buffer->write((string) $value->getBlue());
            $this->buffer->write($this->getCommaSeparator());
            $this->writeNumber($value->getAlpha());
            $this->buffer->writeChar(')');
        }
    }

    /**
     * Returns whether $color's hex pair representation is symmetrical (e.g. `FF`)
     */
    private function isSymmetricalHex(int $color): bool
    {
        return ($color & 0xF) === $color >> 4;
    }

    /**
     * Returns whether $color can be represented as a short hexadecimal color
     * (e.g. `#fff`).
     */
    private function canUseShortHex(SassColor $color): bool
    {
        return $this->isSymmetricalHex($color->getRed()) && $this->isSymmetricalHex($color->getGreen()) && $this->isSymmetricalHex($color->getBlue());
    }

    /**
     * Emits $color as a hex character pair.
     */
    private function writeHexComponent(int $color): void
    {
        $this->buffer->write(str_pad(dechex($color), 2, '0', STR_PAD_LEFT));
    }

    public function visitFunction(SassFunction $value)
    {
        if (!$this->inspect) {
            throw new SassScriptException("$value is not a valid CSS value.");
        }

        $this->buffer->write('get-function(');
        $this->visitQuotedString($value->getName());
        $this->buffer->writeChar(')');
    }

    public function visitList(SassList $value)
    {
        if ($value->hasBrackets()) {
            $this->buffer->writeChar('[');
        } elseif (\count($value->asList()) === 0) {
            if (!$this->inspect) {
                throw new SassScriptException("() is not a valid CSS value.");
            }

            $this->buffer->write('()');
            return;
        }

        $singleton = $this->inspect && \count($value->asList()) === 1 && ($value->getSeparator() === ListSeparator::COMMA || $value->getSeparator() === ListSeparator::SLASH);

        if ($singleton && !$value->hasBrackets()) {
            $this->buffer->writeChar('(');
        }

        $separator = $this->separatorString($value->getSeparator());

        $isFirst = true;

        foreach ($value->asList() as $element) {
            if (!$this->inspect && $element->isBlank()) {
                continue;
            }

            if ($isFirst) {
                $isFirst = false;
            } else {
                $this->buffer->write($separator);
            }

            $needsParens = $this->inspect && self::elementNeedsParens($value->getSeparator(), $element);

            if ($needsParens) {
                $this->buffer->writeChar('(');
            }

            $element->accept($this);

            if ($needsParens) {
                $this->buffer->writeChar(')');
            }
        }

        if ($singleton) {
            $this->buffer->write($value->getSeparator());

            if (!$value->hasBrackets()) {
                $this->buffer->writeChar(')');
            }
        }

        if ($value->hasBrackets()) {
            $this->buffer->writeChar(']');
        }
    }

    /**
     * @phpstan-param ListSeparator::* $separator
     */
    private function separatorString(string $separator): string
    {
        switch ($separator) {
            case ListSeparator::COMMA:
                return $this->getCommaSeparator();

            case ListSeparator::SLASH:
                return $this->compressed ? '/' : ' / ';

            case ListSeparator::SPACE:
                return ' ';

            default:
                /**
                 * This should never be used, but it may still be returned since
                 * {@see separatorString} is invoked eagerly by {@see writeList} even for lists
                 * with only one element.
                 */
                return '';
        }
    }

    /**
     * Returns whether the value needs parentheses as an element in a list with the given separator.
     *
     * @param string $separator
     * @param Value $value
     *
     * @return bool
     *
     * @phpstan-param ListSeparator::* $separator
     */
    private static function elementNeedsParens(string $separator, Value $value): bool
    {
        if (!$value instanceof SassList) {
            return false;
        }

        if (count($value->asList()) < 2) {
            return false;
        }

        if ($value->hasBrackets()) {
            return false;
        }

        switch ($separator) {
            case ListSeparator::COMMA:
                return $value->getSeparator() === ListSeparator::COMMA;

            case ListSeparator::SLASH:
                return $value->getSeparator() === ListSeparator::COMMA || $value->getSeparator() === ListSeparator::SLASH;

            default:
                return $value->getSeparator() !== ListSeparator::UNDECIDED;
        }
    }

    public function visitMap(SassMap $value)
    {
        if (!$this->inspect) {
            throw new SassScriptException("$value is not a valid CSS value.");
        }

        $this->buffer->writeChar('(');

        $isFirst = true;

        foreach ($value->getContents() as $key => $element) {
            if ($isFirst) {
                $isFirst = false;
            } else {
                $this->buffer->write(', ');
            }

            $this->writeMapElement($key);
            $this->buffer->write(': ');
            $this->writeMapElement($element);
        }
        $this->buffer->writeChar(')');
    }

    private function writeMapElement(Value $value): void
    {
        $needsParens = $value instanceof SassList
            && ListSeparator::COMMA === $value->getSeparator()
            && !$value->hasBrackets();

        if ($needsParens) {
            $this->buffer->writeChar('(');
        }

        $value->accept($this);

        if ($needsParens) {
            $this->buffer->writeChar(')');
        }
    }

    public function visitNull()
    {
        if ($this->inspect) {
            $this->buffer->write('null');
        }
    }

    public function visitNumber(SassNumber $value)
    {
        $asSlash = $value->getAsSlash();

        if ($asSlash !== null) {
            $this->visitNumber($asSlash[0]);
            $this->buffer->writeChar('/');
            $this->visitNumber($asSlash[1]);

            return;
        }

        $this->writeNumber($value->getValue());

        if (!$this->inspect) {
            if (\count($value->getNumeratorUnits()) > 1 || \count($value->getDenominatorUnits()) > 0) {
                throw new SassScriptException("$value is not a valid CSS value.");
            }

            if (\count($value->getNumeratorUnits()) > 0) {
                $this->buffer->write($value->getNumeratorUnits()[0]);
            }
        } else {
            $this->buffer->write($value->getUnitString());
        }
    }

    /**
     * Writes $number without exponent notation and with at most
     * {@see SassNumber::PRECISION} digits after the decimal point.
     *
     * @param int|float $number
     */
    private function writeNumber($number): void
    {
        if (is_nan($number)) {
            $this->buffer->write('NaN');
            return;
        }

        if ($number === INF) {
            $this->buffer->write('Infinity');
            return;
        }

        if ($number === -INF) {
            $this->buffer->write('-Infinity');
            return;
        }

        $int = NumberUtil::fuzzyAsInt($number);

        if ($int !== null) {
            $this->buffer->write((string) $int);
            return;
        }

        $output = number_format($number, SassNumber::PRECISION, '.', '');

        $this->buffer->write(rtrim(rtrim($output, '0'), '.'));
    }

    public function visitString(SassString $value)
    {
        if ($this->quote && $value->hasQuotes()) {
            $this->visitQuotedString($value->getText());
        } else {
            $this->visitUnquotedString($value->getText());
        }
    }

    private function visitQuotedString(string $string): void
    {
        $includesDoubleQuote = false !== strpos($string, '"');
        $includesSingleQuote = false !== strpos($string, '\'');
        $forceDoubleQuotes = $includesSingleQuote && $includesDoubleQuote;
        $quote = $forceDoubleQuotes || !$includesDoubleQuote ? '"' : "'";

        $this->buffer->writeChar($quote);

        $length = \strlen($string);

        for ($i = 0; $i < $length; $i++) {
            $char = $string[$i];

            switch ($char) {
                case "'":
                    $this->buffer->writeChar("'"); // such string is always rendered double-quoted
                    break;

                case '"':
                    if ($forceDoubleQuotes) {
                        $this->buffer->writeChar('\\');
                    }
                    $this->buffer->writeChar('"');
                    break;

                case "\0":
                case "\x1":
                case "\x2":
                case "\x3":
                case "\x4":
                case "\x5":
                case "\x6":
                case "\x7":
                case "\x8":
                case "\xA":
                case "\xB":
                case "\xC":
                case "\xD":
                case "\xE":
                case "\xF":
                case "\x11":
                case "\x12":
                case "\x13":
                case "\x14":
                case "\x15":
                case "\x16":
                case "\x17":
                case "\x18":
                case "\x19":
                case "\x1A":
                case "\x1B":
                case "\x1C":
                case "\x1D":
                case "\x1E":
                case "\x1F":
                    $this->writeEscape($this->buffer, $char, $string, $i);
                    break;

                case '\\':
                    $this->buffer->writeChar('\\');
                    $this->buffer->writeChar('\\');
                    break;

                default:
                    $newIndex = $this->tryPrivateUseCharacter($this->buffer, $char, $string, $i);

                    if ($newIndex !== null) {
                        $i = $newIndex;
                        break;
                    }

                    $this->buffer->writeChar($char);
                    break;
            }
        }

        $this->buffer->writeChar($quote);
    }

    private function visitUnquotedString(string $string): void
    {
        $afterNewline = false;
        $length = \strlen($string);

        for ($i = 0; $i < $length; ++$i) {
            $char = $string[$i];

            switch ($char) {
                case "\n":
                    $this->buffer->writeChar(' ');
                    $afterNewline = true;
                    break;

                case ' ':
                    if (!$afterNewline) {
                        $this->buffer->writeChar(' ');
                    }
                    break;

                default:
                    $afterNewline = false;
                    $newIndex = $this->tryPrivateUseCharacter($this->buffer, $char, $string, $i);

                    if ($newIndex !== null) {
                        $i = $newIndex;
                        break;
                    }

                    $this->buffer->writeChar($char);
                    break;
            }
        }
    }

    /**
     * If $char is the beginning of a private-use character and Sass isn't
     * emitting compressed CSS, writes that character as an escape to $buffer.
     *
     * The $string is the string from which $char was read, and $i is the
     * index it was read from. If this successfully writes the character, returns
     * the index of the *last* byte that was consumed for it. Otherwise,
     * returns `null`.
     *
     * In expanded mode, we print all characters in Private Use Areas as escape
     * codes since there's no useful way to render them directly. These
     * characters are often used for glyph fonts, where it's useful for readers
     * to be able to distinguish between them in the rendered stylesheet.
     */
    private function tryPrivateUseCharacter(StringBuffer $buffer, string $char, string $string, int $i): ?int
    {
        if ($this->compressed) {
            return null;
        }

        $firstByteCode = \ord($char);
        if ($firstByteCode >= 0xF0) {
            $extraBytes = 3; // 4-bytes chars
        } elseif ($firstByteCode >= 0xE0) {
            $extraBytes = 2; // 3-bytes chars
        } elseif ($firstByteCode >= 0xC2) {
            $extraBytes = 1; // 2-bytes chars
        } elseif ($firstByteCode >= 0x80 && $firstByteCode <= 0x8F) {
            return null; // Continuation of a UTF-8 char started in a previous byte
        } else {
            $extraBytes = 0;
        }

        if (\strlen($string) <= $i + $extraBytes) {
            return null; // Invalid UTF-8 chars
        }

        if ($extraBytes) {
            $fullChar = substr($string, $i, $extraBytes + 1);
            $charCode = Util::mbOrd($fullChar);
        } else {
            $fullChar = $char;
            $charCode = $firstByteCode;
        }

        if ($charCode >= 0xE000 && $charCode <= 0xF8FF || // PUA of the BMP
            $charCode >= 0xF0000 && $charCode <= 0x10FFFF // Supplementary PUAs of the planes 15 and 16
        ) {
            $this->writeEscape($buffer, $fullChar, $string, $i + $extraBytes);

            return $i + $extraBytes;
        }

        return null;
    }

    /**
     * Writes $character as a hexadecimal escape sequence to $buffer.
     *
     * The $string is the string from which the escape is being written, and $i
     * is the index of the last byte of $character in that string. These
     * are used to write a trailing space after the escape if necessary to
     * disambiguate it from the next character.
     */
    private function writeEscape(StringBuffer $buffer, string $character, string $string, int $i): void
    {
        $buffer->writeChar('\\');
        $buffer->write(dechex(Util::mbOrd($character)));

        if (\strlen($string) === $i + 1) {
            return;
        }

        $next = $string[$i + 1];

        if ($next === ' ' || $next === "\t" || Character::isHex($next)) {
            $buffer->writeChar(' ');
        }
    }

    // ## Selectors

    public function visitAttributeSelector(AttributeSelector $attribute)
    {
        $this->buffer->writeChar('[');
        $this->buffer->write($attribute->getName());

        $value = $attribute->getValue();

        if ($value !== null) {
            assert($attribute->getOp() !== null);
            $this->buffer->write($attribute->getOp());

            // Emit identifiers that start with `--` with quotes, because IE11
            // doesn't consider them to be valid identifiers.
            if (Parser::isIdentifier($value) && 0 !== strpos($value, '--')) {
                $this->buffer->write($value);

                if ($attribute->getModifier() !== null) {
                    $this->buffer->writeChar(' ');
                }
            } else {
                $this->visitQuotedString($value);

                if ($attribute->getModifier() !== null) {
                    $this->writeOptionalSpace();
                }
            }

            if ($attribute->getModifier() !== null) {
                $this->buffer->write($attribute->getModifier());
            }
        }

        $this->buffer->writeChar(']');
    }

    public function visitClassSelector(ClassSelector $klass)
    {
        $this->buffer->writeChar('.');
        $this->buffer->write($klass->getName());
    }

    public function visitComplexSelector(ComplexSelector $complex)
    {
        $lastComponent = null;

        foreach ($complex->getComponents() as $component) {
            if ($lastComponent !== null && !$this->omitSpacesAround($lastComponent) && !$this->omitSpacesAround($component)) {
                $this->buffer->writeChar(' ');
            }

            if ($component instanceof CompoundSelector) {
                $this->visitCompoundSelector($component);
            } else {
                $this->buffer->write($component);
            }

            $lastComponent = $component;
        }
    }

    /**
     * @param CompoundSelector|string $component
     *
     * @return bool
     */
    private function omitSpacesAround($component): bool
    {
        // Combinator values
        return $this->compressed && \is_string($component);
    }

    public function visitCompoundSelector(CompoundSelector $compound)
    {
        $start = $this->buffer->getLength();

        foreach ($compound->getComponents() as $simple) {
            $simple->accept($this);
        }

        // If we emit an empty compound, it's because all of the components got
        // optimized out because they match all selectors, so we just emit the
        // universal selector.
        if ($this->buffer->getLength() === $start) {
            $this->buffer->writeChar('*');
        }
    }

    public function visitIDSelector(IDSelector $id)
    {
        $this->buffer->writeChar('#');
        $this->buffer->write($id->getName());
    }

    public function visitSelectorList(SelectorList $list)
    {
        $first = true;

        foreach ($list->getComponents() as $complex) {
            if (!$this->inspect && $complex->isInvisible()) {
                continue;
            }

            if ($first) {
                $first = false;
            } else {
                $this->buffer->writeChar(',');

                if ($complex->getLineBreak()) {
                    $this->writeLineFeed();
                } else {
                    $this->writeOptionalSpace();
                }
            }

            $this->visitComplexSelector($complex);
        }
    }

    public function visitParentSelector(ParentSelector $parent)
    {
        $this->buffer->writeChar('&');

        if ($parent->getSuffix() !== null) {
            $this->buffer->write($parent->getSuffix());
        }
    }

    public function visitPlaceholderSelector(PlaceholderSelector $placeholder)
    {
        $this->buffer->writeChar('%');
        $this->buffer->write($placeholder->getName());
    }

    public function visitPseudoSelector(PseudoSelector $pseudo)
    {
        $innerSelector = $pseudo->getSelector();

        // `:not(%a)` is semantically identical to `*`.
        if ($innerSelector !== null && $pseudo->getName() === 'not' && $innerSelector->isInvisible()) {
            return;
        }

        $this->buffer->writeChar(':');
        if ($pseudo->isSyntacticElement()) {
            $this->buffer->writeChar(':');
        }
        $this->buffer->write($pseudo->getName());

        if ($pseudo->getArgument() === null && $pseudo->getSelector() === null) {
            return;
        }

        $this->buffer->writeChar('(');

        if ($pseudo->getArgument() !== null) {
            $this->buffer->write($pseudo->getArgument());

            if ($pseudo->getSelector() !== null) {
                $this->buffer->writeChar(' ');
            }
        }

        if ($innerSelector !== null) {
            $this->visitSelectorList($innerSelector);
        }

        $this->buffer->writeChar(')');
    }

    public function visitTypeSelector(TypeSelector $type)
    {
        $this->buffer->write($type->getName());
    }

    public function visitUniversalSelector(UniversalSelector $universal)
    {
        if ($universal->getNamespace() !== null) {
            $this->buffer->write($universal->getNamespace());
            $this->buffer->writeChar('|');
        }
        $this->buffer->writeChar('*');
    }

    // ## Utilities

    /**
     * Runs $callback and associates all text written within it with the span of $node
     *
     * @template T
     *
     * @param AstNode  $node
     * @param callable(): T $callback
     *
     * @return T
     */
    private function for(AstNode $node, callable $callback)
    {
        // TODO implement sourcemap tracking
        return $callback();
    }

    /**
     * @param CssValue<string> $value
     */
    private function write(CssValue $value): void
    {
        $this->for($value, function () use ($value) {
            $this->buffer->write($value->getValue());
        });
    }

    /**
     * Emits $children in a block
     *
     * @param CssNode[] $children
     */
    private function visitChildren(array $children): void
    {
        $this->buffer->writeChar('{');

        $allInvisible = true;
        foreach ($children as $child) {
            if (!$this->isInvisible($child)) {
                $allInvisible = false;
                break;
            }
        }

        if ($allInvisible) {
            $this->buffer->writeChar('}');
            return;
        }

        $this->writeLineFeed();
        $previous = null;

        $this->indent(function () use ($children, &$previous) {
            foreach ($children as $child) {
                if ($this->isInvisible($child)) {
                    continue;
                }

                if ($previous !== null) {
                    if ($this->requiresSemicolon($previous)) {
                        $this->buffer->writeChar(';');
                    }
                    $this->writeLineFeed();

                    if ($previous->isGroupEnd()) {
                        $this->writeLineFeed();
                    }
                }

                $previous = $child;
                $child->accept($this);
            }
        });

        if ($this->requiresSemicolon($previous) && !$this->compressed) {
            $this->buffer->writeChar(';');
        }
        $this->writeLineFeed();
        $this->writeIndentation();
        $this->buffer->writeChar('}');
    }

    /**
     * Whether $node requires a semicolon to be written after it.
     */
    private function requiresSemicolon(?CssNode $node): bool
    {
        if ($node instanceof CssParentNode) {
            return $node->isChildless();
        }

        return !$node instanceof CssComment;
    }

    /**
     * Writes a line feed, unless this emitting compressed CSS.
     */
    private function writeLineFeed(): void
    {
        if (!$this->compressed) {
            $this->buffer->writeChar("\n");
        }
    }

    private function writeOptionalSpace(): void
    {
        if (!$this->compressed) {
            $this->buffer->writeChar(' ');
        }
    }

    private function writeIndentation(): void
    {
        if (!$this->compressed) {
            $this->writeTimes(' ', $this->indentation * 2);
        }
    }

    /**
     * Writes $char to {@see buffer} with $times repetitions.
     */
    private function writeTimes(string $char, int $times): void
    {
        for ($i = 0; $i < $times; $i++) {
            $this->buffer->writeChar($char);
        }
    }

    /**
     * Calls $callback to write each value in $iterable, and writes $text
     * between each one.
     *
     * @template T
     *
     * @param iterable<T>       $iterable
     * @param string            $text
     * @param callable(T): void $callback
     */
    private function writeBetween(iterable $iterable, string $text, callable $callback): void
    {
        $first = true;

        foreach ($iterable as $value) {
            if ($first) {
                $first = false;
            } else {
                $this->buffer->write($text);
            }

            $callback($value);
        }
    }

    /**
     * Returns a comma used to separate values in lists.
     */
    private function getCommaSeparator(): string
    {
        return $this->compressed ? ',': ', ';
    }

    /**
     * Runs $callback with indentation increased one level.
     *
     * @param callable(): void $callback
     */
    private function indent(callable $callback): void
    {
        $this->indentation++;
        $callback();
        $this->indentation--;
    }

    /**
     * Returns whether $node is invisible.
     */
    private function isInvisible(CssNode $node): bool
    {
        if ($this->inspect) {
            return false;
        }

        if ($this->compressed && $node instanceof CssComment && !$node->isPreserved()) {
            return true;
        }

        if ($node instanceof CssParentNode) {
            // An unknown at-rule is never invisible. Because we don't know the
            // semantics of unknown rules, we can't guarantee that (for example)
            // `@foo {}` isn't meaningful.
            if ($node instanceof CssAtRule) {
                return false;
            }

            if ($node instanceof CssStyleRule && $node->getSelector()->getValue()->isInvisible()) {
                return true;
            }

            foreach ($node->getChildren() as $child) {
                if (!$this->isInvisible($child)) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }
}
