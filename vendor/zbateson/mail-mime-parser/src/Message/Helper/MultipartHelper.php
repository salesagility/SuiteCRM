<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Helper;

use ZBateson\MailMimeParser\Message;
use ZBateson\MailMimeParser\Message\Part\Factory\MimePartFactory;
use ZBateson\MailMimeParser\Message\Part\Factory\PartBuilderFactory;
use ZBateson\MailMimeParser\Message\Part\Factory\UUEncodedPartFactory;
use ZBateson\MailMimeParser\Message\Part\MessagePart;
use ZBateson\MailMimeParser\Message\Part\MimePart;
use ZBateson\MailMimeParser\Message\Part\ParentHeaderPart;
use ZBateson\MailMimeParser\Message\PartFilter;

/**
 * Provides various routines to manipulate and create multipart messages from an
 * existing message (e.g. to make space for attachments in a message, or to
 * change a simple message to a multipart/alternative one, etc...)
 *
 * @author Zaahid Bateson
 */
class MultipartHelper extends AbstractHelper
{
    /**
     * @var GenericHelper a GenericHelper instance
     */
    private $genericHelper;

    /**
     * Constructor
     * 
     * @param MimePartFactory $mimePartFactory
     * @param UUEncodedPartFactory $uuEncodedPartFactory
     * @param PartBuilderFactory $partBuilderFactory
     * @param GenericHelper $genericHelper
     */
    public function __construct(
        MimePartFactory $mimePartFactory,
        UUEncodedPartFactory $uuEncodedPartFactory,
        PartBuilderFactory $partBuilderFactory,
        GenericHelper $genericHelper
    ) {
        parent::__construct($mimePartFactory, $uuEncodedPartFactory, $partBuilderFactory);
        $this->genericHelper = $genericHelper;
    }

    /**
     * Creates and returns a unique boundary.
     *
     * @param string $mimeType first 3 characters of a multipart type are used,
     *      e.g. REL for relative or ALT for alternative
     * @return string
     */
    public function getUniqueBoundary($mimeType)
    {
        $type = ltrim(strtoupper(preg_replace('/^(multipart\/(.{3}).*|.*)$/i', '$2-', $mimeType)), '-');
        return uniqid('----=MMP-' . $type . '.', true);
    }

    /**
     * Creates a unique mime boundary and assigns it to the passed part's
     * Content-Type header with the passed mime type.
     *
     * @param ParentHeaderPart $part
     * @param string $mimeType
     */
    public function setMimeHeaderBoundaryOnPart(ParentHeaderPart $part, $mimeType)
    {
        $part->setRawHeader(
            'Content-Type',
            "$mimeType;\r\n\tboundary=\""
                . $this->getUniqueBoundary($mimeType) . '"'
        );
    }

    /**
     * Sets the passed message as multipart/mixed.
     * 
     * If the message has content, a new part is created and added as a child of
     * the message.  The message's content and content headers are moved to the
     * new part.
     *
     * @param Message $message
     */
    public function setMessageAsMixed(Message $message)
    {
        if ($message->hasContent()) {
            $part = $this->genericHelper->createNewContentPartFrom($message);
            $message->addChild($part, 0);
        }
        $this->setMimeHeaderBoundaryOnPart($message, 'multipart/mixed');
        $atts = $message->getAllAttachmentParts();
        if (!empty($atts)) {
            foreach ($atts as $att) {
                $att->markAsChanged();
            }
        }
    }

    /**
     * Sets the passed message as multipart/alternative.
     *
     * If the message has content, a new part is created and added as a child of
     * the message.  The message's content and content headers are moved to the
     * new part.
     *
     * @param Message $message
     */
    public function setMessageAsAlternative(Message $message)
    {
        if ($message->hasContent()) {
            $part = $this->genericHelper->createNewContentPartFrom($message);
            $message->addChild($part, 0);
        }
        $this->setMimeHeaderBoundaryOnPart($message, 'multipart/alternative');
    }

    /**
     * Searches the passed $alternativePart for a part with the passed mime type
     * and returns its parent.
     *
     * Used for alternative mime types that have a multipart/mixed or
     * multipart/related child containing a content part of $mimeType, where
     * the whole mixed/related part should be removed.
     *
     * @param string $mimeType the content-type to find below $alternativePart
     * @param ParentHeaderPart $alternativePart The multipart/alternative part to look
     *        under
     * @return boolean|MimePart false if a part is not found
     */
    public function getContentPartContainerFromAlternative($mimeType, ParentHeaderPart $alternativePart)
    {
        $part = $alternativePart->getPart(0, PartFilter::fromInlineContentType($mimeType));
        $contPart = null;
        do {
            if ($part === null) {
                return false;
            }
            $contPart = $part;
            $part = $part->getParent();
        } while ($part !== $alternativePart);
        return $contPart;
    }

    /**
     * Removes all parts of $mimeType from $alternativePart.
     *
     * If $alternativePart contains a multipart/mixed or multipart/relative part
     * with other parts of different content-types, the multipart part is
     * removed, and parts of different content-types can optionally be moved to
     * the main message part.
     *
     * @param Message $message
     * @param string $mimeType
     * @param ParentHeaderPart $alternativePart
     * @param bool $keepOtherContent
     * @return bool
     */
    public function removeAllContentPartsFromAlternative(Message $message, $mimeType, ParentHeaderPart $alternativePart, $keepOtherContent)
    {
        $rmPart = $this->getContentPartContainerFromAlternative($mimeType, $alternativePart);
        if ($rmPart === false) {
            return false;
        }
        if ($keepOtherContent) {
            $this->moveAllPartsAsAttachmentsExcept($message, $rmPart, $mimeType);
            $alternativePart = $message->getPart(0, PartFilter::fromInlineContentType('multipart/alternative'));
        } else {
            $rmPart->removeAllParts();
        }
        $message->removePart($rmPart);
        if ($alternativePart !== null) {
            if ($alternativePart->getChildCount() === 1) {
                $this->genericHelper->replacePart($message, $alternativePart, $alternativePart->getChild(0));
            } elseif ($alternativePart->getChildCount() === 0) {
                $message->removePart($alternativePart);
            }
        }
        while ($message->getChildCount() === 1) {
            $this->genericHelper->replacePart($message, $message, $message->getChild(0));
        }
        return true;
    }

    /**
     * Creates a new mime part as a multipart/alternative and assigns the passed
     * $contentPart as a part below it before returning it.
     *
     * @param Message $message
     * @param MessagePart $contentPart
     * @return MimePart the alternative part
     */
    public function createAlternativeContentPart(Message $message, MessagePart $contentPart)
    {
        $altPart = $this->partBuilderFactory->newPartBuilder($this->mimePartFactory)->createMessagePart();
        $this->setMimeHeaderBoundaryOnPart($altPart, 'multipart/alternative');
        $message->removePart($contentPart);
        $message->addChild($altPart, 0);
        $altPart->addChild($contentPart, 0);
        return $altPart;
    }

    /**
     * Moves all parts under $from into this message except those with a
     * content-type equal to $exceptMimeType.  If the message is not a
     * multipart/mixed message, it is set to multipart/mixed first.
     *
     * @param Message $message
     * @param ParentHeaderPart $from
     * @param string $exceptMimeType
     */
    public function moveAllPartsAsAttachmentsExcept(Message $message, ParentHeaderPart $from, $exceptMimeType)
    {
        $parts = $from->getAllParts(new PartFilter([
            'multipart' => PartFilter::FILTER_EXCLUDE,
            'headers' => [
                PartFilter::FILTER_EXCLUDE => [
                    'Content-Type' => $exceptMimeType
                ]
            ]
        ]));
        if (strcasecmp($message->getContentType(), 'multipart/mixed') !== 0) {
            $this->setMessageAsMixed($message);
        }
        foreach ($parts as $part) {
            $from->removePart($part);
            $message->addChild($part);
        }
    }

    /**
     * Enforces the message to be a mime message for a non-mime (e.g. uuencoded
     * or unspecified) message.  If the message has uuencoded attachments, sets
     * up the message as a multipart/mixed message and creates a separate
     * content part.
     *
     * @param Message $message
     */
    public function enforceMime(Message $message)
    {
        if (!$message->isMime()) {
            if ($message->getAttachmentCount()) {
                $this->setMessageAsMixed($message);
            } else {
                $message->setRawHeader('Content-Type', "text/plain;\r\n\tcharset=\"iso-8859-1\"");
            }
            $message->setRawHeader('Mime-Version', '1.0');
        }
    }

    /**
     * Creates a multipart/related part out of 'inline' children of $parent and
     * returns it.
     *
     * @param ParentHeaderPart $parent
     * @return MimePart
     */
    public function createMultipartRelatedPartForInlineChildrenOf(ParentHeaderPart $parent)
    {
        $relatedPart = $this->partBuilderFactory->newPartBuilder($this->mimePartFactory)->createMessagePart();
        $this->setMimeHeaderBoundaryOnPart($relatedPart, 'multipart/related');
        foreach ($parent->getChildParts(PartFilter::fromDisposition('inline', PartFilter::FILTER_EXCLUDE)) as $part) {
            $parent->removePart($part);
            $relatedPart->addChild($part);
        }
        $parent->addChild($relatedPart, 0);
        return $relatedPart;
    }

    /**
     * Finds an alternative inline part in the message and returns it if one
     * exists.
     *
     * If the passed $mimeType is text/plain, searches for a text/html part.
     * Otherwise searches for a text/plain part to return.
     *
     * @param Message $message
     * @param string $mimeType
     * @return \ZBateson\MailMimeParser\Message\Part\MimeType or null if not
     *         found
     */
    public function findOtherContentPartFor(Message $message, $mimeType)
    {
        $altPart = $message->getPart(
            0,
            PartFilter::fromInlineContentType(($mimeType === 'text/plain') ? 'text/html' : 'text/plain')
        );
        if ($altPart !== null && $altPart->getParent() !== null && $altPart->getParent()->isMultiPart()) {
            $altPartParent = $altPart->getParent();
            if ($altPartParent->getChildCount(PartFilter::fromDisposition('inline', PartFilter::FILTER_EXCLUDE)) !== 1) {
                $altPart = $this->createMultipartRelatedPartForInlineChildrenOf($altPartParent);
            }
        }
        return $altPart;
    }

    /**
     * Creates a new content part for the passed mimeType and charset, making
     * space by creating a multipart/alternative if needed
     *
     * @param Message $message
     * @param string $mimeType
     * @param string $charset
     * @return \ZBateson\MailMimeParser\Message\Part\MimePart
     */
    public function createContentPartForMimeType(Message $message, $mimeType, $charset)
    {
        $builder = $this->partBuilderFactory->newPartBuilder($this->mimePartFactory);
        $builder->addHeader('Content-Type', "$mimeType;\r\n\tcharset=\"$charset\"");
        $builder->addHeader('Content-Transfer-Encoding', 'quoted-printable');
        $this->enforceMime($message);
        $mimePart = $builder->createMessagePart();

        $altPart = $this->findOtherContentPartFor($message, $mimeType);

        if ($altPart === $message) {
            $this->setMessageAsAlternative($message);
            $message->addChild($mimePart);
        } elseif ($altPart !== null) {
            $mimeAltPart = $this->createAlternativeContentPart($message, $altPart);
            $mimeAltPart->addChild($mimePart, 1);
        } else {
            $message->addChild($mimePart, 0);
        }

        return $mimePart;
    }

    /**
     * Creates and adds a MimePart for the passed content and options as an
     * attachment.
     *
     * @param Message $message
     * @param string|resource|Psr\Http\Message\StreamInterface\StreamInterface
     *        $resource
     * @param string $mimeType
     * @param string $disposition
     * @param string $filename
     * @param string $encoding
     * @return \ZBateson\MailMimeParser\Message\Part\MimePart
     */
    public function createAndAddPartForAttachment(Message $message, $resource, $mimeType, $disposition, $filename = null, $encoding = 'base64')
    {
        if ($filename === null) {
            $filename = 'file' . uniqid();
        }

        $safe = iconv('UTF-8', 'US-ASCII//translit//ignore', $filename);
        if ($message->isMime()) {
            $builder = $this->partBuilderFactory->newPartBuilder($this->mimePartFactory);
            $builder->addHeader('Content-Transfer-Encoding', $encoding);
            if (strcasecmp($message->getContentType(), 'multipart/mixed') !== 0) {
                $this->setMessageAsMixed($message);
            }
            $builder->addHeader('Content-Type', "$mimeType;\r\n\tname=\"$safe\"");
            $builder->addHeader('Content-Disposition', "$disposition;\r\n\tfilename=\"$safe\"");
        } else {
            $builder = $this->partBuilderFactory->newPartBuilder(
                $this->uuEncodedPartFactory
            );
            $builder->setProperty('filename', $safe);
        }
        $part = $builder->createMessagePart();
        $part->setContent($resource);
        $message->addChild($part);
    }

    /**
     * Removes the content part of the message with the passed mime type.  If
     * there is a remaining content part and it is an alternative part of the
     * main message, the content part is moved to the message part.
     *
     * If the content part is part of an alternative part beneath the message,
     * the alternative part is replaced by the remaining content part,
     * optionally keeping other parts if $keepOtherContent is set to true.
     *
     * @param Message $message
     * @param string $mimeType
     * @param bool $keepOtherContent
     * @return boolean true on success
     */
    public function removeAllContentPartsByMimeType(Message $message, $mimeType, $keepOtherContent = false)
    {
        $alt = $message->getPart(0, PartFilter::fromInlineContentType('multipart/alternative'));
        if ($alt !== null) {
            return $this->removeAllContentPartsFromAlternative($message, $mimeType, $alt, $keepOtherContent);
        }
        $message->removeAllParts(PartFilter::fromInlineContentType($mimeType));
        return true;
    }

    /**
     * Removes the 'inline' part with the passed contentType, at the given index
     * defaulting to the first
     *
     * @param Message $message
     * @param string $mimeType
     * @param int $index
     * @return boolean true on success
     */
    public function removePartByMimeType(Message $message, $mimeType, $index = 0)
    {
        $parts = $message->getAllParts(PartFilter::fromInlineContentType($mimeType));
        $alt = $message->getPart(0, PartFilter::fromInlineContentType('multipart/alternative'));
        if ($parts === null || !isset($parts[$index])) {
            return false;
        } elseif (count($parts) === 1) {
            return $this->removeAllContentPartsByMimeType($message, $mimeType, true);
        }
        $part = $parts[$index];
        $message->removePart($part);
        if ($alt !== null && $alt->getChildCount() === 1) {
            $this->genericHelper->replacePart($message, $alt, $alt->getChild(0));
        }
        return true;
    }

    /**
     * Either creates a mime part or sets the existing mime part with the passed
     * mimeType to $strongOrHandle.
     *
     * @param Message $message
     * @param string $mimeType
     * @param string|resource $stringOrHandle
     * @param string $charset
     */
    public function setContentPartForMimeType(Message $message, $mimeType, $stringOrHandle, $charset)
    {
        $part = ($mimeType === 'text/html') ? $message->getHtmlPart() : $message->getTextPart();
        if ($part === null) {
            $part = $this->createContentPartForMimeType($message, $mimeType, $charset);
        } else {
            $contentType = $part->getContentType();
            $part->setRawHeader('Content-Type', "$contentType;\r\n\tcharset=\"$charset\"");
        }
        $part->setContent($stringOrHandle);
    }
}
