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
 * Doesn't close the underlying stream when 'close' is called on it.  Instead,
 * calling close simply removes any reference to the underlying stream.  Note
 * that GuzzleHttp\Psr7\Stream calls close in __destruct, so a reference to the
 * Stream needs to be kept.  For example:
 *
 * ```
 * $f = fopen('php://temp', 'r+');
 * $test = new NonClosingStream(Psr7\Utils::streamFor('test'));
 * // work
 * $test->close();
 * rewind($f);      // error, $f is a closed resource
 * ```
 *
 * Instead, this would work:
 *
 * ```
 * $stream = Psr7\Utils::streamFor(fopen('php://temp', 'r+'));
 * $test = new NonClosingStream($stream);
 * // work
 * $test->close();
 * $stream->rewind();  // works
 * ```
 *
 * @author Zaahid Bateson
 */
class NonClosingStream implements StreamInterface
{
    use StreamDecoratorTrait;

    /**
     * Overridden to detach the underlying stream without closing it.
     * @return void
     */
    public function close()
    {
        $this->stream = null;
    }

    /**
     * Overridden to detach the underlying stream without closing it.
     * @return resource|null Underlying PHP stream, if any
     */
    public function detach()
    {
        $this->stream = null;
    }
}
