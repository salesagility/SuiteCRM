<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Part;

use Psr\Http\Message\StreamInterface;
use ZBateson\MailMimeParser\Header\ParameterHeader;
use ZBateson\MailMimeParser\Stream\StreamFactory;
use ZBateson\MailMimeParser\Message\PartFilterFactory;
use ZBateson\MailMimeParser\Header\HeaderContainer;

/**
 * A parent part containing headers.
 *
 * @author Zaahid Bateson
 */
abstract class ParentHeaderPart extends ParentPart
{
    /**
     * @var HeaderContainer Contains headers for this part.
     */
    protected $headerContainer;

    /**
     * Constructor
     *
     * @param PartStreamFilterManager $partStreamFilterManager
     * @param StreamFactory $streamFactory
     * @param PartFilterFactory $partFilterFactory
     * @param PartBuilder $partBuilder
     * @param StreamInterface $stream
     * @param StreamInterface $contentStream
     */
    public function __construct(
        PartStreamFilterManager $partStreamFilterManager,
        StreamFactory $streamFactory,
        PartFilterFactory $partFilterFactory,
        PartBuilder $partBuilder,
        StreamInterface $stream = null,
        StreamInterface $contentStream = null
    ) {
        parent::__construct(
            $partStreamFilterManager,
            $streamFactory,
            $partFilterFactory,
            $partBuilder,
            $stream,
            $contentStream
        );
        $this->headerContainer = $partBuilder->getHeaderContainer();
    }

    /**
     * Returns the AbstractHeader object for the header with the given $name.
     * If the optional $offset is passed, and multiple headers exist with the
     * same name, the one at the passed offset is returned.
     *
     * Note that mime headers aren't case sensitive.
     *
     * @param string $name
     * @param int $offset
     * @return \ZBateson\MailMimeParser\Header\AbstractHeader
     *         |\ZBateson\MailMimeParser\Header\AddressHeader
     *         |\ZBateson\MailMimeParser\Header\DateHeader
     *         |\ZBateson\MailMimeParser\Header\GenericHeader
     *         |\ZBateson\MailMimeParser\Header\IdHeader
     *         |\ZBateson\MailMimeParser\Header\ParameterHeader
     *         |\ZBateson\MailMimeParser\Header\ReceivedHeader
     *         |\ZBateson\MailMimeParser\Header\SubjectHeader
     *         |null
     */
    public function getHeader($name, $offset = 0)
    {
        return $this->headerContainer->get($name, $offset);
    }

    /**
     * Returns an array of headers in this part.
     *
     * @return \ZBateson\MailMimeParser\Header\AbstractHeader[]
     */
    public function getAllHeaders()
    {
        return $this->headerContainer->getHeaderObjects();
    }

    /**
     * Returns an array of headers that match the passed name.
     *
     * @param string $name
     * @return \ZBateson\MailMimeParser\Header\AbstractHeader[]
     */
    public function getAllHeadersByName($name)
    {
        return $this->headerContainer->getAll($name);
    }

    /**
     * Returns an array of all headers for the mime part with the first element
     * holding the name, and the second its value.
     *
     * @return string[][]
     */
    public function getRawHeaders()
    {
        return $this->headerContainer->getHeaders();
    }

    /**
     * Returns an iterator to the headers in this collection.  Each returned
     * element is an array with its first element set to the header's name, and
     * the second to its raw value:
     *
     * [ 'Header-Name', 'Header Value' ]
     *
     * @return \Iterator
     */
    public function getRawHeaderIterator()
    {
        return $this->headerContainer->getIterator();
    }

    /**
     * Returns the string value for the header with the given $name.
     *
     * Note that mime headers aren't case sensitive.
     *
     * @param string $name
     * @param string $defaultValue
     * @return string
     */
    public function getHeaderValue($name, $defaultValue = null)
    {
        $header = $this->getHeader($name);
        if ($header !== null) {
            return $header->getValue();
        }
        return $defaultValue;
    }

    /**
     * Returns a parameter of the header $header, given the parameter named
     * $param.
     *
     * Only headers of type
     * \ZBateson\MailMimeParser\Header\ParameterHeader have parameters.
     * Content-Type and Content-Disposition are examples of headers with
     * parameters. "Charset" is a common parameter of Content-Type.
     *
     * @param string $header
     * @param string $param
     * @param string $defaultValue
     * @return string
     */
    public function getHeaderParameter($header, $param, $defaultValue = null)
    {
        $obj = $this->getHeader($header);
        if ($obj && $obj instanceof ParameterHeader) {
            return $obj->getValueFor($param, $defaultValue);
        }
        return $defaultValue;
    }

    /**
     * Adds a header with the given $name and $value.  An optional $offset may
     * be passed, which will overwrite a header if one exists with the given
     * name and offset. Otherwise a new header is added.  The passed $offset may
     * be ignored in that case if it doesn't represent the next insert position
     * for the header with the passed name... instead it would be 'pushed' on at
     * the next position.
     *
     * ```php
     * $part = $myParentHeaderPart;
     * $part->setRawHeader('New-Header', 'value');
     * echo $part->getHeaderValue('New-Header');        // 'value'
     *
     * $part->setRawHeader('New-Header', 'second', 4);
     * echo is_null($part->getHeader('New-Header', 4)); // '1' (true)
     * echo $part->getHeader('New-Header', 1)
     *      ->getValue();                               // 'second'
     * ```
     *
     * A new \ZBateson\MailMimeParser\Header\AbstractHeader object is created
     * from the passed value.  No processing on the passed string is performed,
     * and so the passed name and value must be formatted correctly according to
     * related RFCs.  In particular, be careful to encode non-ascii data, to
     * keep lines under 998 characters in length, and to follow any special
     * formatting required for the type of header.
     *
     * @param string $name
     * @param string $value
     * @param int $offset
     */
    public function setRawHeader($name, $value, $offset = 0)
    {
        $this->headerContainer->set($name, $value, $offset);
        $this->onChange();
    }

    /**
     * Adds a header with the given $name and $value.
     *
     * Note: If a header with the passed name already exists, a new header is
     * created with the same name.  This should only be used when that is
     * intentional - in most cases setRawHeader should be called.
     *
     * Creates a new \ZBateson\MailMimeParser\Header\AbstractHeader object and
     * registers it as a header.
     *
     * @param string $name
     * @param string $value
     */
    public function addRawHeader($name, $value)
    {
        $this->headerContainer->add($name, $value);
        $this->onChange();
    }

    /**
     * Removes all headers from this part with the passed name.
     *
     * @param string $name
     */
    public function removeHeader($name)
    {
        $this->headerContainer->removeAll($name);
        $this->onChange();
    }

    /**
     * Removes a single header with the passed name (in cases where more than
     * one may exist, and others should be preserved).
     *
     * @param string $name
     */
    public function removeSingleHeader($name, $offset = 0)
    {
        $this->headerContainer->remove($name, $offset);
        $this->onChange();
    }
}
