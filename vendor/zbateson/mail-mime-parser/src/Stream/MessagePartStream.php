<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Stream;

use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\AppendStream;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use Psr\Http\Message\StreamInterface;
use ZBateson\MailMimeParser\MailMimeParser;
use ZBateson\MailMimeParser\Message\Part\MessagePart;
use ZBateson\MailMimeParser\Message\Part\ParentHeaderPart;
use ZBateson\MailMimeParser\Stream\StreamFactory;

/**
 * Provides a readable stream for a MessagePart.
 *
 * @author Zaahid Bateson
 */
class MessagePartStream implements StreamInterface
{
    use StreamDecoratorTrait;

    /**
     * @var StreamFactory For creating needed stream decorators.
     */
    protected $streamFactory;

    /**
     * @var MessagePart The part to read from.
     */
    protected $part;

    /**
     * Constructor
     * 
     * @param StreamFactory $sdf
     * @param MessagePart $part
     */
    public function __construct(StreamFactory $sdf, MessagePart $part)
    {
        $this->streamFactory = $sdf;
        $this->part = $part;
    }

    /**
     * Attaches and returns a CharsetStream decorator to the passed $stream.
     *
     * If the current attached MessagePart doesn't specify a charset, $stream is
     * returned as-is.
     *
     * @param StreamInterface $stream
     * @return StreamInterface
     */
    private function getCharsetDecoratorForStream(StreamInterface $stream)
    {
        $charset = $this->part->getCharset();
        if (!empty($charset)) {
            $stream = $this->streamFactory->newCharsetStream(
                $stream,
                $charset,
                MailMimeParser::DEFAULT_CHARSET
            );
        }
        return $stream;
    }
    
    /**
     * Attaches and returns a transfer encoding stream decorator to the passed
     * $stream.
     *
     * The attached stream decorator is based on the attached part's returned
     * value from MessagePart::getContentTransferEncoding, using one of the
     * following stream decorators as appropriate:
     *
     * o QuotedPrintableStream
     * o Base64Stream
     * o UUStream
     *
     * @param StreamInterface $stream
     * @return StreamInterface
     */
    private function getTransferEncodingDecoratorForStream(StreamInterface $stream)
    {
        $encoding = $this->part->getContentTransferEncoding();
        $decorator = null;
        switch ($encoding) {
            case 'quoted-printable':
                $decorator = $this->streamFactory->newQuotedPrintableStream($stream);
                break;
            case 'base64':
                $decorator = $this->streamFactory->newBase64Stream(
                    $this->streamFactory->newChunkSplitStream($stream));
                break;
            case 'x-uuencode':
                $decorator = $this->streamFactory->newUUStream($stream);
                $decorator->setFilename($this->part->getFilename());
                break;
            default:
                return $stream;
        }
        return $decorator;
    }

    /**
     * Writes out the content portion of the attached mime part to the passed
     * $stream.
     *
     * @param StreamInterface $stream
     */
    private function writePartContentTo(StreamInterface $stream)
    {
        $contentStream = $this->part->getContentStream();
        if ($contentStream !== null) {
            $copyStream = $this->streamFactory->newNonClosingStream($stream);
            $es = $this->getTransferEncodingDecoratorForStream($copyStream);
            $cs = $this->getCharsetDecoratorForStream($es);
            Psr7\Utils::copyToStream($contentStream, $cs);
            $cs->close();
        }
    }

    /**
     * Creates an array of streams based on the attached part's mime boundary
     * and child streams.
     *
     * @param ParentHeaderPart $part passed in because $this->part is declared
     *        as MessagePart
     * @return StreamInterface[]
     */
    protected function getBoundaryAndChildStreams(ParentHeaderPart $part)
    {
        $boundary = $part->getHeaderParameter('Content-Type', 'boundary');
        if ($boundary === null) {
            return array_map(
                function ($child) {
                    return $child->getStream();
                },
                $part->getChildParts()
            );
        }
        $streams = [];
        foreach ($part->getChildParts() as $i => $child) {
            if ($i !== 0 || $part->hasContent()) {
                $streams[] = Psr7\Utils::streamFor("\r\n");
            }
            $streams[] = Psr7\Utils::streamFor("--$boundary\r\n");
            $streams[] = $child->getStream();
        }
        $streams[] = Psr7\Utils::streamFor("\r\n--$boundary--\r\n");
        
        return $streams;
    }

    /**
     * Returns an array of Psr7 Streams representing the attached part and it's
     * direct children.
     *
     * @return StreamInterface[]
     */
    protected function getStreamsArray()
    {
        $content = Psr7\Utils::streamFor();
        $this->writePartContentTo($content);
        $content->rewind();
        $streams = [ $this->streamFactory->newHeaderStream($this->part), $content ];

        /**
         * @var ParentHeaderPart
         */
        $part = $this->part;
        if ($part instanceof ParentHeaderPart && $part->getChildCount()) {
            $streams = array_merge($streams, $this->getBoundaryAndChildStreams($part));
        }

        return $streams;
    }

    /**
     * Creates the underlying stream lazily when required.
     *
     * @return StreamInterface
     */
    protected function createStream()
    {
        return new AppendStream($this->getStreamsArray());
    }
}
