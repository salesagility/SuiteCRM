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

namespace ScssPhp\ScssPhp\Parser;

use ScssPhp\ScssPhp\Exception\SassFormatException;
use ScssPhp\ScssPhp\Logger\LoggerInterface;
use ScssPhp\ScssPhp\Logger\QuietLogger;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;
use ScssPhp\ScssPhp\Util;
use ScssPhp\ScssPhp\Util\Character;
use ScssPhp\ScssPhp\Util\ParserUtil;

/**
 * @internal
 */
class Parser
{
    /**
     * @var StringScanner
     * @readonly
     */
    protected $scanner;

    /**
     * @var LoggerInterface
     * @readonly
     */
    protected $logger;

    /**
     * @var string|null
     * @readonly
     */
    protected $sourceUrl;

    /**
     * Parses $text as a CSS identifier and returns the result.
     *
     * @throws SassFormatException if parsing fails.
     */
    public static function parseIdentifier(string $text, ?LoggerInterface $logger = null): string
    {
        return (new Parser($text, $logger))->doParseIdentifier();
    }

    /**
     * Returns whether $text is a valid CSS identifier.
     */
    public static function isIdentifier(string $text, ?LoggerInterface $logger = null): bool
    {
        try {
            self::parseIdentifier($text, $logger);

            return true;
        } catch (SassFormatException $e) {
            return false;
        }
    }

    public function __construct(string $contents, ?LoggerInterface $logger = null, ?string $sourceUrl = null)
    {
        $this->scanner = new StringScanner($contents);
        $this->logger = $logger ?: new QuietLogger();
        $this->sourceUrl = $sourceUrl;
    }

    /**
     * @throws SassFormatException
     */
    private function doParseIdentifier(): string
    {
        try {
            $result = $this->identifier();
            $this->scanner->expectDone();

            return $result;
        } catch (FormatException $e) {
            throw $this->wrapException($e);
        }
    }

    /**
     * Consumes whitespace, including any comments.
     */
    protected function whitespace(): void
    {
        do {
            $this->whitespaceWithoutComments();
        } while ($this->scanComment());
    }

    /**
     * Consumes whitespace, but not comments.
     */
    protected function whitespaceWithoutComments(): void
    {
        while (!$this->scanner->isDone() && Character::isWhitespace($this->scanner->peekChar())) {
            $this->scanner->readChar();
        }
    }

    /**
     * Consumes spaces and tabs.
     */
    protected function spaces(): void
    {
        while (!$this->scanner->isDone() && Character::isSpaceOrTab($this->scanner->peekChar())) {
            $this->scanner->readChar();
        }
    }

    /**
     * Consumes and ignores a comment if possible.
     *
     * Returns whether the comment was consumed.
     */
    protected function scanComment(): bool
    {
        if ($this->scanner->peekChar() !== '/') {
            return false;
        }

        $next = $this->scanner->peekChar(1);

        if ($next === '/') {
            $this->silentComment();

            return true;
        }

        if ($next === '*') {
            $this->loudComment();
            return true;
        }

        return false;
    }

    /**
     * Consumes and ignores a silent (Sass-style) comment.
     */
    protected function silentComment(): void
    {
        $this->scanner->expect('//');

        while (!$this->scanner->isDone() && !Character::isNewline($this->scanner->peekChar())) {
            $this->scanner->readChar();
        }
    }

    /**
     * Consumes and ignores a loud (CSS-style) comment.
     */
    protected function loudComment(): void
    {
        $this->scanner->expect('/*');

        while (true) {
            $next = $this->scanner->readChar();

            if ($next !== '*') {
                continue;
            }

            do {
                $next = $this->scanner->readChar();
            } while ($next === '*');

            if ($next === '/') {
                break;
            }
        }
    }

    /**
     * Consumes a plain CSS identifier.
     *
     * If $normalize is `true`, this converts underscores into hyphens.
     *
     * If $unit is `true`, this doesn't parse a `-` followed by a digit. This
     * ensures that `1px-2px` parses as subtraction rather than the unit
     * `px-2px`.
     */
    protected function identifier(bool $normalize = false, bool $unit = false): string
    {
        $text = '';

        if ($this->scanner->scanChar('-')) {
            $text .= '-';


            if ($this->scanner->scanChar('-')) {
                $text .= '-';
                $text .= $this->consumeIdentifierBody($normalize, $unit);

                return $text;
            }
        }

        $first = $this->scanner->peekChar();

        if ($first === null) {
            $this->scanner->error('Expected identifier.');
        }

        if ($normalize && $first === '_') {
            $this->scanner->readChar();
            $text .= '-';
        } elseif (Character::isNameStart($first)) {
            $text .= $this->scanner->readUtf8Char();
        } elseif ($first === '\\') {
            $text .= $this->escape(true);
        } else {
            $this->scanner->error('Expected identifier.');
        }

        $text .= $this->consumeIdentifierBody($normalize, $unit);

        return $text;
    }

    /**
     * Consumes a chunk of a plain CSS identifier after the name start.
     */
    public function identifierBody(): string
    {
        $text = $this->consumeIdentifierBody();

        if ($text === '') {
            $this->scanner->error('Expected identifier body.');
        }

        return $text;
    }

    private function consumeIdentifierBody(bool $normalize = false, bool $unit = false): string
    {
        $text = '';

        while (true) {
            $next = $this->scanner->peekChar();

            if ($next === null) {
                break;
            }

            if ($unit && $next === '-') {
                $second = $this->scanner->peekChar(1);

                if ($second !== null && ($second === '.' || Character::isDigit($second))) {
                    break;
                }

                $text .= $this->scanner->readChar();
            } elseif ($normalize && $next === '_') {
                $this->scanner->readChar();
                $text .= '-';
            } elseif (Character::isName($next)) {
                $text .= $this->scanner->readUtf8Char();
            } elseif ($next === '\\') {
                $text .= $this->escape();
            } else {
                break;
            }
        }

        return $text;
    }

    /**
     * Consumes a plain CSS string.
     *
     * This returns the parsed contents of the string—that is, it doesn't include
     * quotes and its escapes are resolved.
     */
    protected function string(): string
    {
        $quote = $this->scanner->readChar();

        if ($quote !== '"' && $quote !== "'") {
            $this->scanner->error('Expected string.');
        }

        $buffer = '';

        while (true) {
            $next = $this->scanner->peekChar();

            if ($next === $quote) {
                $this->scanner->readChar();
                break;
            }

            if ($next === null || Character::isNewline($next)) {
                $this->scanner->error("Expected $quote.");
            }

            if ($next === '\\') {
                $second = $this->scanner->peekChar(1);

                if ($second !== null && Character::isNewline($second)) {
                    $this->scanner->readChar();
                    $this->scanner->readChar();
                } else {
                    $buffer .= $this->escapeCharacter();
                }
            } else {
                $buffer .= $this->scanner->readUtf8Char();
            }
        }

        return $buffer;
    }

    /**
     * Consumes and returns a natural number (that is, a non-negative integer).
     *
     * Doesn't support scientific notation.
     */
    protected function naturalNumber(): int
    {
        $first = $this->scanner->readChar();

        if (!Character::isDigit($first)) {
            $this->scanner->error('Expected digit.', $this->scanner->getPosition() - 1);
        }

        $number = $first;

        $next = $this->scanner->peekChar();

        while ($next !== null && Character::isDigit($next)) {
            $number .= $this->scanner->readChar();
            $next = $this->scanner->peekChar();
        }

        return intval($number);
    }

    /**
     * Consumes tokens until it reaches a top-level `";"`, `")"`, `"]"`,
     * or `"}"` and returns their contents as a string.
     *
     * If $allowEmpty is `false` (the default), this requires at least one token.
     */
    protected function declarationValue(bool $allowEmpty = false): string
    {
        $buffer = '';
        $brackets = [];
        $wroteNewline = false;

        while (true) {
            $next = $this->scanner->peekChar();

            if ($next === null) {
                break;
            }

            switch ($next) {
                case '\\':
                    $buffer .= $this->escape(true);
                    $wroteNewline = false;
                    break;

                case '"':
                case "'":
                    $buffer .= $this->rawText([$this, 'string']);
                    $wroteNewline = false;
                    break;

                case '/':
                    if ($this->scanner->peekChar(1) === '*') {
                        $buffer .= $this->rawText([$this, 'loudComment']);
                    } else {
                        $buffer .= $this->scanner->readChar();
                    }
                    $wroteNewline = false;
                    break;

                case ' ':
                case "\t":
                    $second = $this->scanner->peekChar(1);
                    if ($wroteNewline || $second === null || !Character::isWhitespace($second)) {
                        $buffer .= ' ';
                    }
                    $this->scanner->readChar();
                    break;

                case "\n":
                case "\r":
                case "\f":
                    $prev = $this->scanner->peekChar(-1);
                    if ($prev === null || !Character::isNewline($prev)) {
                        $buffer .= "\n";
                    }
                    $this->scanner->readChar();
                    $wroteNewline = true;
                    break;

                case '(':
                case '{':
                case '[':
                    $buffer .= $next;
                    $brackets[] = Character::opposite($this->scanner->readChar());
                    $wroteNewline = false;
                    break;

                case ')':
                case '}':
                case ']':
                    if (empty($brackets)) {
                        break 2;
                    }

                    $buffer .= $next;
                    $this->scanner->expectChar(array_pop($brackets));
                    $wroteNewline = false;
                    break;

                case ';':
                    if (empty($brackets)) {
                        break 2;
                    }

                    $buffer .= $this->scanner->readChar();
                    break;

                case 'u':
                case 'U':
                    $url = $this->tryUrl();

                    if ($url !== null) {
                        $buffer .= $url;
                    } else {
                        $buffer .= $this->scanner->readChar();
                    }

                    $wroteNewline = false;
                    break;

                default:
                    if ($this->lookingAtIdentifier()) {
                        $buffer .= $this->identifier();
                    } else {
                        $buffer .= $this->scanner->readUtf8Char();
                    }
                    $wroteNewline = false;
                    break;
            }
        }

        if (!empty($brackets)) {
            $this->scanner->expectChar(array_pop($brackets));
        }

        if (!$allowEmpty && $buffer === '') {
            $this->scanner->error('Expected token.');
        }

        return $buffer;
    }

    /**
     * Consumes a `url()` token if possible, and returns `null` otherwise.
     */
    protected function tryUrl(): ?string
    {
        $start = $this->scanner->getPosition();

        if (!$this->scanIdentifier('url')) {
            return null;
        }

        if (!$this->scanner->scanChar('(')) {
            $this->scanner->setPosition($start);

            return null;
        }

        $this->whitespace();

        $buffer = 'url(';

        while (true) {
            $next = $this->scanner->peekChar();

            if ($next === null) {
                break;
            }

            $nextCharCode = \ord($next);

            if ($next === '\\') {
                $buffer .= $this->escape();
            } elseif ($next === '%' || $next === '&' || $next === '#' || ($nextCharCode >= \ord('*') && $nextCharCode <= \ord('~')) || $nextCharCode >= 0x80) {
                $buffer .= $this->scanner->readUtf8Char();
            } elseif (Character::isWhitespace($next)) {
                $this->whitespace();

                if ($this->scanner->peekChar() !== ')') {
                    break;
                }
            } elseif ($next === ')') {
                $buffer .= $this->scanner->readChar();

                return $buffer;
            } else {
                break;
            }
        }

        $this->scanner->setPosition($start);

        return null;
    }

    /**
     * Consumes a Sass variable name, and returns its name without the dollar sign.
     */
    protected function variableName(): string
    {
        $this->scanner->expectChar('$');

        return $this->identifier(true);
    }

    /**
     * Consumes an escape sequence and returns the text that defines it.
     *
     * If $identifierStart is true, this normalizes the escape sequence as
     * though it were at the beginning of an identifier.
     */
    protected function escape(bool $identifierStart = false): string
    {
        $start = $this->scanner->getPosition();

        $this->scanner->expectChar('\\');

        $first = $this->scanner->peekChar();

        if ($first === null) {
            $this->scanner->error('Expected escape sequence.');
        }

        if (Character::isNewline($first)) {
            $this->scanner->error('Expected escape sequence.');
        }

        if (Character::isHex($first)) {
            $value = 0;
            for ($i = 0; $i < 6; $i++) {
                $next = $this->scanner->peekChar();

                if ($next === null || !Character::isHex($next)) {
                    break;
                }

                $value *= 16;
                $value += hexdec($this->scanner->readChar());
                assert(\is_int($value));
            }

            $this->scanCharIf([Character::class, 'isWhitespace']);
            $valueText = Util::mbChr($value);
        } else {
            $valueText = $this->scanner->readUtf8Char();
            $value = Util::mbOrd($valueText);
        }

        if ($identifierStart ? Character::isNameStart($valueText) : Character::isName($valueText)) {
            if ($value > 0x10ffff) {
                $this->scanner->error('Invalid Unicode code point.', $start);
            }

            return $valueText;
        }

        if ($value < 0x1f || $valueText === "\x7f" || ($identifierStart && Character::isDigit($valueText))) {
            return '\\' . bin2hex($valueText) . ' ';
        }

        return '\\' . $valueText;
    }

    /**
     * Consumes an escape sequence and returns the character it represents.
     */
    protected function escapeCharacter(): string
    {
        return ParserUtil::consumeEscapedCharacter($this->scanner);
    }

    /**
     * @param callable(string): bool $condition
     *
     * @phpstan-impure
     */
    protected function scanCharIf(callable $condition): bool
    {
        $next = $this->scanner->peekChar();

        if ($next === null || !$condition($next)) {
            return false;
        }

        $this->scanner->readChar();

        return true;
    }

    /**
     * Consumes the next character or escape sequence if it matches $character.
     *
     * Matching will be case-insensitive unless $caseSensitive is true.
     * When matching case-insensitively, $character must be passed in lowercase.
     *
     * This only supports ASCII identifier characters.
     */
    protected function scanIdentChar(string $character, bool $caseSensitive = false): bool
    {
        $matches = function (string $actual) use ($character, $caseSensitive): bool {
            if ($caseSensitive) {
                return $actual === $character;
            }

            return \strtolower($actual) === $character;
        };

        $next = $this->scanner->peekChar();

        if ($next !== null && $matches($next)) {
            $this->scanner->readChar();

            return true;
        }

        if ($next === '\\') {
            $start = $this->scanner->getPosition();

            if ($matches($this->escapeCharacter())) {
                return true;
            }

            $this->scanner->setPosition($start);
        }

        return false;
    }

    /**
     * Consumes the next character or escape sequence and asserts it matches $char.
     *
     * Matching will be case-insensitive unless $caseSensitive is true.
     * When matching case-insensitively, $char must be passed in lowercase.
     *
     * This only supports ASCII identifier characters.
     */
    protected function expectIdentChar(string $char, bool $caseSensitive = false): void
    {
        if ($this->scanIdentChar($char, $caseSensitive)) {
            return;
        }

        $this->scanner->error("Expected \"$char\"");
    }

    /**
     * Returns whether the scanner is immediately before a number.
     *
     * This follows [the CSS algorithm][].
     *
     * [the CSS algorithm]: https://drafts.csswg.org/css-syntax-3/#starts-with-a-number
     */
    protected function lookingAtNumber(): bool
    {
        $first = $this->scanner->peekChar();

        if ($first === null) {
            return false;
        }

        if (Character::isDigit($first)) {
            return true;
        }

        if ($first === '.') {
            $second = $this->scanner->peekChar(1);

            return $second !== null && Character::isDigit($second);
        }

        if ($first === '+' || $first === '-') {
            $second = $this->scanner->peekChar(1);

            if ($second === null) {
                return false;
            }

            if (Character::isDigit($second)) {
                return true;
            }

            if ($second !== '.') {
                return false;
            }

            $third = $this->scanner->peekChar(2);

            return $third !== null && Character::isDigit($third);
        }

        return false;
    }

    /**
     * Returns whether the scanner is immediately before a plain CSS identifier.
     *
     * If $forward is passed, this looks that many characters forward instead.
     *
     * This is based on [the CSS algorithm][], but it assumes all backslashes
     * start escapes.
     *
     * [the CSS algorithm]: https://drafts.csswg.org/css-syntax-3/#would-start-an-identifier
     */
    protected function lookingAtIdentifier(int $forward = 0): bool
    {
        $first = $this->scanner->peekChar($forward);

        if ($first === null) {
            return false;
        }

        if ($first === '\\' || Character::isNameStart($first)) {
            return true;
        }

        if ($first !== '-') {
            return false;
        }

        $second = $this->scanner->peekChar($forward + 1);

        if ($second === null) {
            return false;
        }

        return $second === '\\' || $second === '-' || Character::isNameStart($second);
    }

    /**
     * Returns whether the scanner is immediately before a sequence of characters
     * that could be part of a plain CSS identifier body.
     */
    protected function lookingAtIdentifierBody(): bool
    {
        $next = $this->scanner->peekChar();

        return $next !== null && ($next === '\\' || Character::isName($next));
    }

    /**
     * Consumes an identifier if its name exactly matches $text.
     *
     * When matching case-insensitively, $text must be passed in lowercase.
     *
     * This only supports ASCII identifiers.
     */
    protected function scanIdentifier(string $text, bool $caseSensitive = false): bool
    {
        if (!$this->lookingAtIdentifier()) {
            return false;
        }

        $start = $this->scanner->getPosition();

        for ($i = 0; $i < \strlen($text); $i++) {
            if ($this->scanIdentChar($text[$i], $caseSensitive)) {
                continue;
            }

            $this->scanner->setPosition($start);

            return false;
        }

        if (!$this->lookingAtIdentifierBody()) {
            return true;
        }

        $this->scanner->setPosition($start);

        return false;
    }

    /**
     * Consumes an identifier asserts that its name exactly matches $text.
     *
     * When matching case-insensitively, $text must be passed in lowercase.
     *
     * This only supports ASCII identifiers.
     */
    protected function expectIdentifier(string $text, ?string $name = null, bool $caseSensitive = false): void
    {
        $name = $name ?? "\"$text\"";

        $start = $this->scanner->getPosition();

        for ($i = 0; $i < \strlen($text); $i++) {
            if ($this->scanIdentChar($text[$i], $caseSensitive)) {
                continue;
            }

            $this->scanner->error("Expected $name.", $start);
        }

        if (!$this->lookingAtIdentifierBody()) {
            return;
        }

        $this->scanner->error("Expected $name.", $start);
    }

    /**
     * Runs $consumer and returns the source text that it consumes.
     *
     * @param callable(): void $consumer
     */
    protected function rawText(callable $consumer): string
    {
        $start = $this->scanner->getPosition();
        $consumer();

        return $this->scanner->substring($start);
    }

    /**
     * Prints a warning to standard error, associated with $span.
     */
    protected function warn(string $message, FileSpan $span): void
    {
        $this->logger->warn($span->message($message));
    }

    /**
     * Throws an error associated with $position.
     *
     * @throws FormatException
     *
     * @return never-returns
     */
    protected function error(string $message, FileSpan $span): void
    {
        throw new FormatException($message, $span);
    }

    protected function wrapException(FormatException $error): SassFormatException
    {
        $span = $error->getSpan();

        if ($span->getLength() === 0 && 0 === stripos($error->getMessage(), 'expected')) {
            $startPosition = $this->firstNewlineBefore($span->getStart()->getOffset());

            if ($startPosition !== $span->getStart()->getOffset()) {
                $span = $span->getFile()->span($startPosition, $startPosition);
            }
        }

        return new SassFormatException($error->getMessage(), $span, $error);
    }

    /**
     * If [position] is separated from the previous non-whitespace character in
     * `$scanner->getString()` by one or more newlines, returns the offset of the last
     * separating newline.
     *
     * Otherwise returns $position.
     *
     * This helps avoid missing token errors pointing at the next closing bracket
     * rather than the line where the problem actually occurred.
     *
     * @param int $position
     *
     * @return int
     */
    private function firstNewlineBefore(int $position): int
    {
        $index = $position - 1;
        $lastNewline = null;
        $string = $this->scanner->getString();

        while ($index >= 0) {
            $char = $string[$index];

            if (!Character::isWhitespace($char)) {
                return $lastNewline ?? $position;
            }

            if (Character::isNewline($char)) {
                $lastNewline = $index;
            }
            $index--;
        }

        // If the document *only* contains whitespace before $position, always
        // return $position.

        return $position;
    }
}
