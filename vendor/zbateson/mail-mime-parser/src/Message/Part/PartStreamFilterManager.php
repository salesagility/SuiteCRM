<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Part;

use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Psr7\CachingStream;
use ZBateson\MailMimeParser\Stream\StreamFactory;

/**
 * Manages attached stream filters for a MessagePart's content resource handle.
 * 
 * The attached stream filters are:
 *  o Content-Transfer-Encoding filter to manage decoding from a supported
 *    encoding: quoted-printable, base64 and x-uuencode.
 *  o Charset conversion filter to convert to UTF-8
 *
 * @author Zaahid Bateson
 */
class PartStreamFilterManager
{
    /**
     * @var StreamInterface the underlying content stream without filters
     *      applied
     */
    protected $stream;

    /**
     * @var StreamInterface the content stream after attaching transfer encoding
     *      streams to $stream.
     */
    protected $decodedStream;

    /**
     * @var StreamInterface the content stream after attaching charset streams
     *      to $binaryStream
     */
    protected $charsetStream;

    /**
     * @var array map of the active encoding filter on the current handle.
     */
    private $encoding = [
        'type' => null,
        'filter' => null
    ];
    
    /**
     * @var array map of the active charset filter on the current handle.
     */
    private $charset = [
        'from' => null,
        'to' => null,
        'filter' => null
    ];

    /**
     * @var StreamFactory used to apply psr7 stream decorators to the
     *      attached StreamInterface based on encoding.
     */
    private $streamFactory;
    
    /**
     * Sets up filter names used for stream_filter_append
     * 
     * @param StreamFactory $streamFactory
     */
    public function __construct(StreamFactory $streamFactory)
    {
        $this->streamFactory = $streamFactory;
    }

    /**
     * Sets the URL used to open the content resource handle.
     * 
     * The function also closes the currently attached handle if any.
     * 
     * @param StreamInterface $stream
     */
    public function setStream(StreamInterface $stream = null)
    {
        $this->stream = $stream;
        $this->decodedStream = null;
        $this->charsetStream = null;
    }
    
    /**
     * Returns true if the attached stream filter used for decoding the content
     * on the current handle is different from the one passed as an argument.
     * 
     * @param string $transferEncoding
     * @return boolean
     */
    private function isTransferEncodingFilterChanged($transferEncoding)
    {
        return ($transferEncoding !== $this->encoding['type']);
    }
    
    /**
     * Returns true if the attached stream filter used for charset conversion on
     * the current handle is different from the one needed based on the passed 
     * arguments.
     * 
     * @param string $fromCharset
     * @param string $toCharset
     * @return boolean
     */
    private function isCharsetFilterChanged($fromCharset, $toCharset)
    {
        return ($fromCharset !== $this->charset['from']
            || $toCharset !== $this->charset['to']);
    }
    
    /**
     * Attaches a decoding filter to the attached content handle, for the passed
     * $transferEncoding.
     * 
     * @param string $transferEncoding
     */
    protected function attachTransferEncodingFilter($transferEncoding)
    {
        if ($this->decodedStream !== null) {
            $this->encoding['type'] = $transferEncoding;
            $assign = null;
            switch ($transferEncoding) {
                case 'base64':
                    $assign = $this->streamFactory->newBase64Stream($this->decodedStream);
                    break;
                case 'x-uuencode':
                    $assign = $this->streamFactory->newUUStream($this->decodedStream);
                    break;
                case 'quoted-printable':
                    $assign = $this->streamFactory->newQuotedPrintableStream($this->decodedStream);
                    break;
            }
            if ($assign !== null) {
                $this->decodedStream = new CachingStream($assign);
            }
        }
    }
    
    /**
     * Attaches a charset conversion filter to the attached content handle, for
     * the passed arguments.
     * 
     * @param string $fromCharset the character set the content is encoded in
     * @param string $toCharset the target encoding to return
     */
    protected function attachCharsetFilter($fromCharset, $toCharset)
    {
        if ($this->charsetStream !== null) {
            $this->charsetStream = new CachingStream($this->streamFactory->newCharsetStream(
                $this->charsetStream,
                $fromCharset,
                $toCharset
            ));
            $this->charset['from'] = $fromCharset;
            $this->charset['to'] = $toCharset;
        }
    }
    
    /**
     * Resets just the charset stream, and rewinds the decodedStream.
     */
    private function resetCharsetStream()
    {
        $this->charset = [
            'from' => null,
            'to' => null,
            'filter' => null
        ];
        $this->decodedStream->rewind();
        $this->charsetStream = $this->decodedStream;
    }

    /**
     * Resets cached encoding and charset streams, and rewinds the stream.
     */
    public function reset()
    {
        $this->encoding = [
            'type' => null,
            'filter' => null
        ];
        $this->charset = [
            'from' => null,
            'to' => null,
            'filter' => null
        ];
        $this->stream->rewind();
        $this->decodedStream = $this->stream;
        $this->charsetStream = $this->stream;
    }
    
    /**
     * Checks what transfer-encoding decoder stream and charset conversion
     * stream are currently attached on the underlying stream, and resets them
     * if the requested arguments differ from the currently assigned ones.
     * 
     * @param string $transferEncoding
     * @param string $fromCharset the character set the content is encoded in
     * @param string $toCharset the target encoding to return
     * @return StreamInterface
     */
    public function getContentStream($transferEncoding, $fromCharset, $toCharset)
    {
        if ($this->stream === null) {
            return null;
        }
        if (empty($fromCharset) || empty($toCharset)) {
            return $this->getBinaryStream($transferEncoding);
        }
        if ($this->charsetStream === null
            || $this->isTransferEncodingFilterChanged($transferEncoding)
            || $this->isCharsetFilterChanged($fromCharset, $toCharset)) {
            if ($this->charsetStream === null
                || $this->isTransferEncodingFilterChanged($transferEncoding)) {
                $this->reset();
                $this->attachTransferEncodingFilter($transferEncoding);
            }
            $this->resetCharsetStream();
            $this->attachCharsetFilter($fromCharset, $toCharset);
        }
        $this->charsetStream->rewind();
        return $this->charsetStream;
    }

    /**
     * Checks what transfer-encoding decoder stream is attached on the
     * underlying stream, and resets it if the requested arguments differ.
     *
     * @param string $transferEncoding
     * @return StreamInterface
     */
    public function getBinaryStream($transferEncoding)
    {
        if ($this->stream === null) {
            return null;
        }
        if ($this->decodedStream === null
            || $this->isTransferEncodingFilterChanged($transferEncoding)) {
            $this->reset();
            $this->attachTransferEncodingFilter($transferEncoding);
        }
        $this->decodedStream->rewind();
        return $this->decodedStream;
    }
}
