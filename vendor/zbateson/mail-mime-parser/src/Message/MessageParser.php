<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message;

use Psr\Http\Message\StreamInterface;
use ZBateson\MailMimeParser\Message\Part\PartBuilder;
use ZBateson\MailMimeParser\Message\Part\Factory\PartBuilderFactory;
use ZBateson\MailMimeParser\Message\Part\Factory\PartFactoryService;
use GuzzleHttp\Psr7\StreamWrapper;

/**
 * Parses a mail mime message into its component parts.  To invoke, call
 * MailMimeParser::parse.
 *
 * @author Zaahid Bateson
 */
class MessageParser
{
    /**
     * @var PartFactoryService service instance used to create MimePartFactory
     *      objects.
     */
    protected $partFactoryService;
    
    /**
     * @var PartBuilderFactory used to create PartBuilders
     */
    protected $partBuilderFactory;
    
    /**
     * @var int maintains the character length of the last line separator,
     *      typically 2 for CRLF, to keep track of the correct 'end' position
     *      for a part because the CRLF before a boundary is considered part of
     *      the boundary.
     */
    private $lastLineSeparatorLength = 0;
    
    /**
     * Sets up the parser with its dependencies.
     * 
     * @param PartFactoryService $pfs
     * @param PartBuilderFactory $pbf
     */
    public function __construct(
        PartFactoryService $pfs,
        PartBuilderFactory $pbf
    ) {
        $this->partFactoryService = $pfs;
        $this->partBuilderFactory = $pbf;
    }
    
    /**
     * Parses the passed stream into a ZBateson\MailMimeParser\Message object
     * and returns it.
     * 
     * @param StreamInterface $stream the stream to parse the message from
     * @return \ZBateson\MailMimeParser\Message
     */
    public function parse(StreamInterface $stream)
    {
        $partBuilder = $this->read($stream);
        return $partBuilder->createMessagePart($stream);
    }
    
    /**
     * Ensures the header isn't empty and contains a colon separator character,
     * then splits it and calls $partBuilder->addHeader.
     * 
     * @param string $header
     * @param PartBuilder $partBuilder
     */
    private function addRawHeaderToPart($header, PartBuilder $partBuilder)
    {
        if ($header !== '' && strpos($header, ':') !== false) {
            $a = explode(':', $header, 2);
            $partBuilder->addHeader($a[0], trim($a[1]));
        }
    }

    /**
     * Reads a line of up to 4096 characters.  If the line is larger than that,
     * the remaining characters in the line are read and discarded, and only the
     * first 4096 characters are returned.
     *
     * @param resource $handle
     * @return string
     */
    private function readLine($handle)
    {
        $size = 4096;
        $ret = $line = fgets($handle, $size);
        while (strlen($line) === $size - 1 && substr($line, -1) !== "\n") {
            $line = fgets($handle, $size);
        }
        return $ret;
    }

    /**
     * Reads a line of 2048 characters.  If the line is larger than that, the
     * remaining characters in the line are read and
     * discarded, and only the first part is returned.
     *
     * This method is identical to readLine, except it calculates the number of
     * characters that make up the line's new line characters (e.g. 2 for "\r\n"
     * or 1 for "\n").
     *
     * @param resource $handle
     * @param int $lineSeparatorLength
     * @return string
     */
    private function readBoundaryLine($handle, &$lineSeparatorLength = 0)
    {
        $size = 2048;
        $isCut = false;
        $line = fgets($handle, $size);
        while (strlen($line) === $size - 1 && substr($line, -1) !== "\n") {
            $line = fgets($handle, $size);
            $isCut = true;
        }
        $ret = rtrim($line, "\r\n");
        $lineSeparatorLength = strlen($line) - strlen($ret);
        return ($isCut) ? '' : $ret;
    }

    /**
     * Reads header lines up to an empty line, adding them to the passed
     * $partBuilder.
     * 
     * @param resource $handle the resource handle to read from
     * @param PartBuilder $partBuilder the current part to add headers to
     */
    protected function readHeaders($handle, PartBuilder $partBuilder)
    {
        $header = '';
        do {
            $line = $this->readLine($handle);
            if (empty($line) || $line[0] !== "\t" && $line[0] !== ' ') {
                $this->addRawHeaderToPart($header, $partBuilder);
                $header = '';
            } else {
                $line = "\r\n" . $line;
            }
            $header .= rtrim($line, "\r\n");
        } while ($header !== '');
    }

    /**
     * Reads lines from the passed $handle, calling
     * $partBuilder->setEndBoundaryFound with the passed line until it returns
     * true or the stream is at EOF.
     * 
     * setEndBoundaryFound returns true if the passed line matches a boundary
     * for the $partBuilder itself or any of its parents.
     * 
     * Once a boundary is found, setStreamPartAndContentEndPos is called with
     * the passed $handle's read pos before the boundary and its line separator
     * were read.
     * 
     * @param resource $handle
     * @param PartBuilder $partBuilder
     */
    private function findContentBoundary($handle, PartBuilder $partBuilder)
    {
        // last separator before a boundary belongs to the boundary, and is not
        // part of the current part
        while (!feof($handle)) {
            $endPos = ftell($handle) - $this->lastLineSeparatorLength;
            $line = $this->readBoundaryLine($handle, $this->lastLineSeparatorLength);
            if ($line !== '' && $partBuilder->setEndBoundaryFound($line)) {
                $partBuilder->setStreamPartAndContentEndPos($endPos);
                return;
            }
        }
        $partBuilder->setStreamPartAndContentEndPos(ftell($handle));
        $partBuilder->setEof();
    }
    
    /**
     * Reads content for a non-mime message.  If there are uuencoded attachment
     * parts in the message (denoted by 'begin' lines), those parts are read and
     * added to the passed $partBuilder as children.
     * 
     * @param resource $handle
     * @param PartBuilder $partBuilder
     * @return string
     */
    protected function readUUEncodedOrPlainTextMessage($handle, PartBuilder $partBuilder)
    {
        $partBuilder->setStreamContentStartPos(ftell($handle));
        $part = $partBuilder;
        while (!feof($handle)) {
            $start = ftell($handle);
            $line = trim($this->readLine($handle));
            if (preg_match('/^begin ([0-7]{3}) (.*)$/', $line, $matches)) {
                $part = $this->partBuilderFactory->newPartBuilder(
                    $this->partFactoryService->getUUEncodedPartFactory()
                );
                $part->setStreamPartStartPos($start);
                // 'begin' line is part of the content
                $part->setStreamContentStartPos($start);
                $part->setProperty('mode', $matches[1]);
                $part->setProperty('filename', $matches[2]);
                $partBuilder->addChild($part);
            }
            $part->setStreamPartAndContentEndPos(ftell($handle));
        }
        $partBuilder->setStreamPartEndPos(ftell($handle));
    }
    
    /**
     * Reads content for a single part of a MIME message.
     * 
     * If the part being read is in turn a multipart part, readPart is called on
     * it recursively to read its headers and content.
     * 
     * The start/end positions of the part's content are set on the passed
     * $partBuilder, which in turn sets the end position of the part and its
     * parents.
     * 
     * @param resource $handle
     * @param PartBuilder $partBuilder
     */
    private function readPartContent($handle, PartBuilder $partBuilder)
    {
        $partBuilder->setStreamContentStartPos(ftell($handle));
        $this->findContentBoundary($handle, $partBuilder);
        if ($partBuilder->isMultiPart()) {
            while (!$partBuilder->isParentBoundaryFound()) {
                $child = $this->partBuilderFactory->newPartBuilder(
                    $this->partFactoryService->getMimePartFactory()
                );
                $partBuilder->addChild($child);
                $this->readPart($handle, $child);
            }
        }
    }
    
    /**
     * Reads a part and any of its children, into the passed $partBuilder,
     * either by calling readUUEncodedOrPlainTextMessage or readPartContent
     * after reading headers.
     * 
     * @param resource $handle
     * @param PartBuilder $partBuilder
     */
    protected function readPart($handle, PartBuilder $partBuilder)
    {
        $partBuilder->setStreamPartStartPos(ftell($handle));
        
        if ($partBuilder->canHaveHeaders()) {
            $this->readHeaders($handle, $partBuilder);
            $this->lastLineSeparatorLength = 0;
        }
        if ($partBuilder->getParent() === null && !$partBuilder->isMime()) {
            $this->readUUEncodedOrPlainTextMessage($handle, $partBuilder);
        } else {
            $this->readPartContent($handle, $partBuilder);
        }
    }
    
    /**
     * Reads the message from the passed stream and returns a PartBuilder
     * representing it.
     * 
     * @param StreamInterface $stream
     * @return PartBuilder
     */
    protected function read(StreamInterface $stream)
    {
        $partBuilder = $this->partBuilderFactory->newPartBuilder(
            $this->partFactoryService->getMessageFactory()
        );
        // the remaining parts use a resource handle for better performance...
        // it seems fgets does much better than Psr7\readline (not specifically
        // measured, but difference in running tests is big)
        $this->readPart(StreamWrapper::getResource($stream), $partBuilder);
        return $partBuilder;
    }
}
