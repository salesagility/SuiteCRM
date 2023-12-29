<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Part;

use Psr\Http\Message\StreamInterface;
use ZBateson\MailMimeParser\Stream\StreamFactory;

/**
 * A specialized NonMimePart representing a uuencoded part.
 * 
 * This represents part of a message that is not a mime message.  A multi-part
 * mime message may have a part with a Content-Transfer-Encoding of x-uuencode
 * but that would be represented by a normal MimePart.
 * 
 * UUEncodedPart extends NonMimePart to return a Content-Transfer-Encoding of
 * x-uuencode, a Content-Type of application-octet-stream, and a
 * Content-Disposition of 'attachment'.  It also expects a mode and filename to
 * initialize it, and adds 'filename' parts to the Content-Disposition and
 * 'name' to Content-Type.
 * 
 * @author Zaahid Bateson
 */
class UUEncodedPart extends NonMimePart
{
    /**
     * @var int the unix file permission
     */
    protected $mode = null;
    
    /**
     * @var string the name of the file in the uuencoding 'header'.
     */
    protected $filename = null;
    
    /**
     * Constructor
     * 
     * @param PartStreamFilterManager $partStreamFilterManager
     * @param StreamFactory $streamFactory
     * @param PartBuilder $partBuilder
     * @param StreamInterface $stream
     * @param StreamInterface $contentStream
     */
    public function __construct(
        PartStreamFilterManager $partStreamFilterManager,
        StreamFactory $streamFactory,
        PartBuilder $partBuilder,
        StreamInterface $stream = null,
        StreamInterface $contentStream = null
    ) {
        parent::__construct($partStreamFilterManager, $streamFactory, $stream, $contentStream);
        $this->mode = intval($partBuilder->getProperty('mode'));
        $this->filename = $partBuilder->getProperty('filename');
    }
    
    /**
     * Returns the file mode included in the uuencoded header for this part.
     * 
     * @return int
     */
    public function getUnixFileMode()
    {
        return $this->mode;
    }
    
    /**
     * Returns the filename included in the uuencoded header for this part.
     * 
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Sets the unix file mode for the uuencoded header.
     *
     * @param int $mode
     */
    public function setUnixFileMode($mode)
    {
        $this->mode = $mode;
        $this->onChange();
    }

    /**
     * Sets the filename included in the uuencoded header.
     *
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        $this->onChange();
    }
    
    /**
     * Returns false.
     * 
     * @return bool
     */
    public function isTextPart()
    {
        return false;
    }
    
    /**
     * Returns text/plain
     * 
     * @return string
     */
    public function getContentType()
    {
        return 'application/octet-stream';
    }
    
    /**
     * Returns null
     * 
     * @return string
     */
    public function getCharset()
    {
        return null;
    }
    
    /**
     * Returns 'inline'.
     * 
     * @return string
     */
    public function getContentDisposition()
    {
        return 'attachment';
    }
    
    /**
     * Returns 'x-uuencode'.
     * 
     * @return string
     */
    public function getContentTransferEncoding()
    {
        return 'x-uuencode';
    }
}
