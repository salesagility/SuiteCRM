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

class SimpleStringBuffer implements StringBuffer
{
    /**
     * @var string
     */
    private $text = '';

    public function getLength(): int
    {
        return \strlen($this->text);
    }

    public function write(string $string): void
    {
        $this->text .= $string;
    }

    public function writeChar(string $char): void
    {
        $this->text .= $char;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
