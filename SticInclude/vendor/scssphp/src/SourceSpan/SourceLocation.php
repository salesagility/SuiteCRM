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

namespace ScssPhp\ScssPhp\SourceSpan;

/**
 * @internal
 */
final class SourceLocation
{
    /**
     * @var SourceFile
     * @readonly
     */
    private $file;

    /**
     * @var int
     * @readonly
     */
    private $offset;

    public function __construct(SourceFile $file, int $offset)
    {
        $this->file = $file;
        $this->offset = $offset;
    }

    public function getFile(): SourceFile
    {
        return $this->file;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLine(): int
    {
        return $this->file->getLine($this->offset);
    }

    public function getColumn(): int
    {
        return $this->file->getColumn($this->offset);
    }
}
