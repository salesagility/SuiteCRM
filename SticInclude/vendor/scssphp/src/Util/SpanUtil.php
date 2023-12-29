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

namespace ScssPhp\ScssPhp\Util;

use ScssPhp\ScssPhp\Parser\StringScanner;
use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * @internal
 */
class SpanUtil
{
    /**
     * Returns this span with all leading whitespace trimmed.
     */
    public static function trimLeft(FileSpan $span): FileSpan
    {
        $start = 0;
        $text = $span->getText();
        $textLength = \strlen($text);

        while ($start < $textLength && Character::isWhitespace($text[$start])) {
            $start++;
        }

        return $span->subspan($start);
    }
    /**
     * Returns the span of the identifier at the start of this span.
     *
     * If $includeLeading is greater than 0, that many additional characters
     * will be included from the start of this span before looking for an
     * identifier.
     */
    public static function initialIdentifier(FileSpan $span, int $includeLeading = 0): FileSpan
    {
        $scanner = new StringScanner($span->getText());

        for ($i = 0; $i < $includeLeading; $i++) {
            $scanner->readUtf8Char();
        }

        self::scanIdentifier($scanner);

        return $span->subspan(0, $scanner->getPosition());
    }

    /**
     * Returns a subspan excluding the identifier at the start of this span.
     */
    public static function withoutInitialIdentifier(FileSpan $span): FileSpan
    {
        $scanner = new StringScanner($span->getText());
        self::scanIdentifier($scanner);

        return $span->subspan($scanner->getPosition());
    }

    /**
     * Returns a subspan excluding a namespace and `.` at the start of this span.
     */
    public static function withoutNamespace(FileSpan $span): FileSpan
    {
        return self::withoutInitialIdentifier($span)->subspan(1);
    }

    /**
     * Returns a subspan excluding an initial at-rule and any whitespace after
     * it.
     */
    public static function withoutInitialAtRule(FileSpan $span): FileSpan
    {
        $scanner = new StringScanner($span->getText());
        $scanner->expectChar('@');
        self::scanIdentifier($scanner);

        return self::trimLeft($span->subspan($scanner->getPosition()));
    }

    /**
     * Consumes an identifier from $scanner.
     */
    private static function scanIdentifier(StringScanner $scanner): void
    {
        while (!$scanner->isDone()) {
            $char = $scanner->peekChar();

            if ($char === '\\') {
                ParserUtil::consumeEscapedCharacter($scanner);
            } elseif ($char !== null && Character::isName($char)) {
                $scanner->readUtf8Char();
            } else {
                break;
            }
        }
    }
}
