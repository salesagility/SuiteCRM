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
use ScssPhp\ScssPhp\Util\Character;

/**
 * A parser for `@keyframes` block selectors.
 */
class KeyframeSelectorParser extends Parser
{
    /**
     * @return string[]
     *
     * @throws SassFormatException
     */
    public function parse(): array
    {
        try {
            $selectors = [];

            do {
                $this->whitespace();
                if ($this->lookingAtIdentifier()) {
                    if ($this->scanIdentifier('from')) {
                        $selectors[] = 'from';
                    } else {
                        $this->expectIdentifier('to', '"to" or "from"');
                        $selectors[] = 'to';
                    }
                } else {
                    $selectors[] = $this->percentage();
                }
                $this->whitespace();
            } while ($this->scanner->scanChar(','));
            $this->scanner->expectDone();

            return $selectors;
        } catch (FormatException $e) {
            throw $this->wrapException($e);
        }
    }

    private function percentage(): string
    {
        $buffer = '';

        if ($this->scanner->scanChar('+')) {
            $buffer .= '+';
        }

        $second = $this->scanner->peekChar();

        if (!Character::isDigit($second) && $second !== '.') {
            $this->scanner->error('Expected number.');
        }

        while (Character::isDigit($this->scanner->peekChar())) {
            $buffer .= $this->scanner->readChar();
        }

        if ($this->scanner->peekChar() === '.') {
            $buffer .= $this->scanner->readChar();

            while (Character::isDigit($this->scanner->peekChar())) {
                $buffer .= $this->scanner->readChar();
            }
        }

        if ($this->scanIdentChar('e')) {
            $buffer .= 'e';
            $next = $this->scanner->peekChar();

            if ($next === '+' || $next === '-') {
                $buffer .= $this->scanner->readChar();
            }

            if (!Character::isDigit($this->scanner->peekChar())) {
                $this->scanner->error('Expected digit.');
            }

            while (Character::isDigit($this->scanner->peekChar())) {
                $buffer .= $this->scanner->readChar();
            }
        }

        $this->scanner->expectChar('%');
        $buffer .= '%';

        return $buffer;
    }
}
