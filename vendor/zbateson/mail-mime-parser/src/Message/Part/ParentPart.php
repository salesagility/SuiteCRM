<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Part;

use Psr\Http\Message\StreamInterface;
use ZBateson\MailMimeParser\Message\PartFilterFactory;
use ZBateson\MailMimeParser\Message\PartFilter;
use ZBateson\MailMimeParser\Stream\StreamFactory;

/**
 * A MessagePart that contains children.
 *
 * @author Zaahid Bateson
 */
abstract class ParentPart extends MessagePart
{
    /**
     * @var PartFilterFactory factory object responsible for create PartFilters
     */
    protected $partFilterFactory;

    /**
     * @var MessagePart[] array of child parts
     */
    protected $children = [];

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
        parent::__construct($partStreamFilterManager, $streamFactory, $stream, $contentStream);
        $this->partFilterFactory = $partFilterFactory;

        $pbChildren = $partBuilder->getChildren();
        if (!empty($pbChildren)) {
            $this->children = array_map(function ($child) use ($stream) {
                $childPart = $child->createMessagePart($stream);
                $childPart->parent = $this;
                return $childPart;
            }, $pbChildren);
        }
    }

    /**
     * Returns all parts, including the current object, and all children below
     * it (including children of children, etc...)
     *
     * @return MessagePart[]
     */
    protected function getAllNonFilteredParts()
    {
        $parts = [ $this ];
        foreach ($this->children as $part) {
            if ($part instanceof MimePart) {
                $parts = array_merge(
                    $parts,
                    $part->getAllNonFilteredParts()
                );
            } else {
                array_push($parts, $part);
            }
        }
        return $parts;
    }

    /**
     * Returns the part at the given 0-based index, or null if none is set.
     *
     * Note that the first part returned is the current part itself.  This is
     * often desirable for queries with a PartFilter, e.g. looking for a
     * MessagePart with a specific Content-Type that may be satisfied by the
     * current part.
     *
     * @param int $index
     * @param PartFilter $filter
     * @return MessagePart
     */
    public function getPart($index, PartFilter $filter = null)
    {
        $parts = $this->getAllParts($filter);
        if (!isset($parts[$index])) {
            return null;
        }
        return $parts[$index];
    }

    /**
     * Returns the current part, all child parts, and child parts of all
     * children optionally filtering them with the provided PartFilter.
     *
     * The first part returned is always the current MimePart.  This is often
     * desirable as it may be a valid MimePart for the provided PartFilter.
     *
     * @param PartFilter $filter an optional filter
     * @return MessagePart[]
     */
    public function getAllParts(PartFilter $filter = null)
    {
        $parts = $this->getAllNonFilteredParts();
        if (!empty($filter)) {
            return array_values(array_filter(
                $parts,
                [ $filter, 'filter' ]
            ));
        }
        return $parts;
    }

    /**
     * Returns the total number of parts in this and all children.
     *
     * Note that the current part is considered, so the minimum getPartCount is
     * 1 without a filter.
     *
     * @param PartFilter $filter
     * @return int
     */
    public function getPartCount(PartFilter $filter = null)
    {
        return count($this->getAllParts($filter));
    }

    /**
     * Returns the direct child at the given 0-based index, or null if none is
     * set.
     *
     * @param int $index
     * @param PartFilter $filter
     * @return MessagePart
     */
    public function getChild($index, PartFilter $filter = null)
    {
        $parts = $this->getChildParts($filter);
        if (!isset($parts[$index])) {
            return null;
        }
        return $parts[$index];
    }

    /**
     * Returns all direct child parts.
     *
     * If a PartFilter is provided, the PartFilter is applied before returning.
     *
     * @param PartFilter $filter
     * @return MessagePart[]
     */
    public function getChildParts(PartFilter $filter = null)
    {
        if ($filter !== null) {
            return array_values(array_filter($this->children, [ $filter, 'filter' ]));
        }
        return $this->children;
    }

    /**
     * Returns the number of direct children under this part.
     *
     * @param PartFilter $filter
     * @return int
     */
    public function getChildCount(PartFilter $filter = null)
    {
        return count($this->getChildParts($filter));
    }

    /**
     * Returns the part associated with the passed mime type, at the passed
     * index, if it exists.
     *
     * @param string $mimeType
     * @param int $index
     * @return MessagePart|null
     */
    public function getPartByMimeType($mimeType, $index = 0)
    {
        $partFilter = $this->partFilterFactory->newFilterFromContentType($mimeType);
        return $this->getPart($index, $partFilter);
    }

    /**
     * Returns an array of all parts associated with the passed mime type if any
     * exist or null otherwise.
     *
     * @param string $mimeType
     * @return MessagePart[] or null
     */
    public function getAllPartsByMimeType($mimeType)
    {
        $partFilter = $this->partFilterFactory->newFilterFromContentType($mimeType);
        return $this->getAllParts($partFilter);
    }

    /**
     * Returns the number of parts matching the passed $mimeType
     *
     * @param string $mimeType
     * @return int
     */
    public function getCountOfPartsByMimeType($mimeType)
    {
        $partFilter = $this->partFilterFactory->newFilterFromContentType($mimeType);
        return $this->getPartCount($partFilter);
    }

    /**
     * Registers the passed part as a child of the current part.
     *
     * If the $position parameter is non-null, adds the part at the passed
     * position index.
     *
     * @param MessagePart $part
     * @param int $position
     */
    public function addChild(MessagePart $part, $position = null)
    {
        if ($part !== $this) {
            $part->parent = $this;
            array_splice(
                $this->children,
                ($position === null) ? count($this->children) : $position,
                0,
                [ $part ]
            );
            $this->onChange();
        }
    }

    /**
     * Removes the child part from this part and returns its position or
     * null if it wasn't found.
     *
     * Note that if the part is not a direct child of this part, the returned
     * position is its index within its parent (calls removePart on its direct
     * parent).
     *
     * @param MessagePart $part
     * @return int or null if not found
     */
    public function removePart(MessagePart $part)
    {
        $parent = $part->getParent();
        if ($this !== $parent && $parent !== null) {
            return $parent->removePart($part);
        } else {
            $position = array_search($part, $this->children, true);
            if ($position !== false && is_int($position)) {
                array_splice($this->children, $position, 1);
                $this->onChange();
                return $position;
            }
        }
        return null;
    }

    /**
     * Removes all parts that are matched by the passed PartFilter.
     *
     * Note: the current part will not be removed.  Although the function naming
     * matches getAllParts, which returns the current part, it also doesn't only
     * remove direct children like getChildParts.  Internally this function uses
     * getAllParts but the current part is filtered out if returned.
     *
     * @param \ZBateson\MailMimeParser\Message\PartFilter $filter
     */
    public function removeAllParts(PartFilter $filter = null)
    {
        foreach ($this->getAllParts($filter) as $part) {
            if ($part === $this) {
                continue;
            }
            $this->removePart($part);
        }
    }
}
