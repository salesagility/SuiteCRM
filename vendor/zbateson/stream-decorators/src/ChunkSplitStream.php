<?php
/**
 * This file is part of the ZBateson\StreamDecorators project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\StreamDecorators;

use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Psr7\StreamDecoratorTrait;

/**
 * Inserts line ending characters after the set number of characters have been
 * written to the underlying stream.
 *
 * @author Zaahid Bateson
 */
class ChunkSplitStream implements StreamInterface
{
    use StreamDecoratorTrait;

    /**
     * @var int Number of bytes written, and importantly, if non-zero, writes a
     *      final $lineEnding on close (and so maintained instead of using
     *      tell() directly)
     */
    private $position;

    /**
     * @var int The number of characters in a line before inserting $lineEnding.
     */
    private $lineLength;

    /**
     * @var string The line ending characters to insert.
     */
    private $lineEnding;

    /**
     * @var int The strlen() of $lineEnding
     */
    private $lineEndingLength;

    /**
     * @param StreamInterface $stream
     * @param int $lineLength
     * @param string $lineEnding
     */
    public function __construct(StreamInterface $stream, $lineLength = 76, $lineEnding = "\r\n")
    {
        $this->stream = $stream;
        $this->lineLength = $lineLength;
        $this->lineEnding = $lineEnding;
        $this->lineEndingLength = strlen($this->lineEnding);
    }

    /**
     * Inserts the line ending character after each line length characters in
     * the passed string, making sure previously written bytes are taken into
     * account.
     *
     * @param string $string
     * @return string
     */
    private function getChunkedString($string)
    {
        $firstLine = '';
        if ($this->tell() !== 0) {
            $next = $this->lineLength - ($this->position % ($this->lineLength + $this->lineEndingLength));
            if (strlen($string) > $next) {
                $firstLine = substr($string, 0, $next) . $this->lineEnding;
                $string = substr($string, $next);
            }
        }
        // chunk_split always ends with the passed line ending
        $chunked = $firstLine . chunk_split($string, $this->lineLength, $this->lineEnding);
        return substr($chunked, 0, strlen($chunked) - $this->lineEndingLength);
    }

    /**
     * Writes the passed string to the underlying stream, ensuring line endings
     * are inserted every "line length" characters in the string.
     *
     * @param string $string
     * @return int number of bytes written
     */
    public function write($string)
    {
        $chunked = $this->getChunkedString($string);
        $this->position += strlen($chunked);
        return $this->stream->write($chunked);
    }

    /**
     * Inserts a final line ending character.
     */
    private function beforeClose()
    {
        if ($this->position !== 0) {
            $this->stream->write($this->lineEnding);
        }
    }

    /**
     * Closes the stream after ensuring a final line ending character is
     * inserted.
     * @return void
     */
    public function close()
    {
        $this->beforeClose();
        $this->stream->close();
    }

    /**
     * Detaches the stream after ensuring a final line ending character is
     * inserted.
     * @return resource|null Underlying PHP stream, if any
     */
    public function detach()
    {
        $this->beforeClose();
        $this->stream->detach();
    }
}
