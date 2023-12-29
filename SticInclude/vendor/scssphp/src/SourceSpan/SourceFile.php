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
final class SourceFile
{
    /**
     * @var string
     * @readonly
     */
    private $string;

    /**
     * @var string|null
     * @readonly
     */
    private $sourceUrl;

    /**
     * @var int[]
     * @readonly
     */
    private $lineStarts;

    /**
     * The 0-based last line that was returned by {@see getLine}
     *
     * This optimizes computation for successive accesses to
     * the same line or to the next line.
     * It is stored as 0-based to correspond to the indices
     * in {@see $lineStarts}.
     *
     * @var int|null
     */
    private $cachedLine;

    public function __construct(string $content, ?string $sourceUrl)
    {
        $this->string = $content;
        $this->sourceUrl = $sourceUrl;

        // Extract line starts
        $this->lineStarts = [0];

        if ($content === '') {
            return;
        }

        $prev = 0;

        while (($pos = strpos($content, "\n", $prev)) !== false) {
            $this->lineStarts[] = $pos;
            $prev = $pos + 1;
        }

        $this->lineStarts[] = \strlen($content);

        if (substr($content, -1) !== "\n") {
            $this->lineStarts[] = \strlen($content) + 1;
        }
    }

    public function span(int $start, ?int $end = null): FileSpan
    {
        if ($end === null) {
            $end = \strlen($this->string);
        }

        return new FileSpan($this, $start, $end);
    }

    public function getSourceUrl(): ?string
    {
        return $this->sourceUrl;
    }

    /**
     * The 0-based line
     *
     * @param int $position
     *
     * @return int
     */
    public function getLine(int $position): int
    {
        if ($position < 0) {
            throw new \RangeException('Position cannot be negative');
        }

        if ($position > \strlen($this->string)) {
            throw new \RangeException('Position cannot be greater than the number of characters in the string.');
        }

        if ($this->isNearCacheLine($position)) {
            assert($this->cachedLine !== null);

            return $this->cachedLine;
        }

        $low = 0;
        $high = \count($this->lineStarts);

        while ($low < $high) {
            $mid = (int) (($high + $low) / 2);

            if ($position < $this->lineStarts[$mid]) {
                $high = $mid - 1;
                continue;
            }

            if ($position >= $this->lineStarts[$mid + 1]) {
                $low = $mid + 1;
                continue;
            }

            $this->cachedLine = $mid;

            return $this->cachedLine;
        }

        $this->cachedLine = $low;

        return $this->cachedLine;
    }

    /**
     * Returns `true` if $position is near {@see $cachedLine}.
     *
     * Checks on {@see $cachedLine} and the next line. If it's on the next line, it
     * updates {@see $cachedLine} to point to that.
     *
     * @param int $position
     *
     * @return bool
     */
    private function isNearCacheLine(int $position): bool
    {
        if ($this->cachedLine === null) {
            return false;
        }

        if ($position < $this->lineStarts[$this->cachedLine]) {
            return false;
        }

        if ($this->cachedLine >= \count($this->lineStarts) - 1 ||
            $position < $this->lineStarts[$this->cachedLine + 1]
        ) {
            return true;
        }

        if ($this->cachedLine >= \count($this->lineStarts) - 2 ||
            $position < $this->lineStarts[$this->cachedLine + 2]
        ) {
            ++$this->cachedLine;

            return true;
        }

        return false;
    }

    /**
     * The 0-based column of that position
     *
     * @param int $position
     *
     * @return int
     */
    public function getColumn(int $position): int
    {
        $line = $this->getLine($position);

        return $position - $this->lineStarts[$line];
    }

    /**
     * Returns the text of the file from $start to $end (exclusive).
     *
     * If $end isn't passed, it defaults to the end of the file.
     */
    public function getText(int $start, ?int $end = null): string
    {
        if ($end === null) {
            return substr($this->string, $start);
        }

        if ($end < $start) {
            $length = 0;
        } else {
            $length = $end - $start;
        }

        return substr($this->string, $start, $length);
    }
}
