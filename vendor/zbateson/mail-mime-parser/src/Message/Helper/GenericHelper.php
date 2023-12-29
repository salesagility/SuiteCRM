<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Helper;

use ZBateson\MailMimeParser\MailMimeParser;
use ZBateson\MailMimeParser\Message;
use ZBateson\MailMimeParser\Message\Part\MimePart;
use ZBateson\MailMimeParser\Message\Part\ParentHeaderPart;

/**
 * Provides common Message helper routines for Message manipulation.
 *
 * @author Zaahid Bateson
 */
class GenericHelper extends AbstractHelper
{
    /**
     * @var string[] List of content headers grabbed from
     *      https://tools.ietf.org/html/rfc4021#section-2.2
     */
    private static $contentHeaders = [
        'Content-Type',
        'Content-Transfer-Encoding',
        'Content-Disposition',
        'Content-ID',
        'Content-Description',
        'Content-Language',
        'Content-Base',
        'Content-Location',
        'Content-features',
        'Content-Alternative',
        'Content-MD5',
        'Content-Duration'
    ];
    
    /**
     * Copies the passed $header from $from, to $to or sets the header to
     * $default if it doesn't exist in $from.
     *
     * @param ParentHeaderPart $from
     * @param ParentHeaderPart $to
     * @param string $header
     * @param string $default
     */
    public function copyHeader(ParentHeaderPart $from, ParentHeaderPart $to, $header, $default = null)
    {
        $fromHeader = $from->getHeader($header);
        $set = ($fromHeader !== null) ? $fromHeader->getRawValue() : $default;
        if ($set !== null) {
            $to->setRawHeader($header, $set);
        }
    }

    /**
     * Removes Content-* headers (permanent ones as defined in 
     * https://tools.ietf.org/html/rfc4021#section-2.2) from the passed part,
     * then detaches its content stream.
     * 
     * @param ParentHeaderPart $part
     */
    public function removeContentHeadersAndContent(ParentHeaderPart $part)
    {
        foreach (self::$contentHeaders as $header) {
            $part->removeHeader($header);
        }
        $part->detachContentStream();
    }

    /**
     * Copies Content-* headers (permanent ones as defined in 
     * https://tools.ietf.org/html/rfc4021#section-2.2)
     * from the $from header into the $to header. If the Content-Type header
     * isn't defined in $from, defaults to text/plain with utf-8 and
     * quoted-printable.
     *
     * @param ParentHeaderPart $from
     * @param ParentHeaderPart $to
     * @param bool $move
     */
    public function copyContentHeadersAndContent(ParentHeaderPart $from, ParentHeaderPart $to, $move = false)
    {
        $this->copyHeader($from, $to, 'Content-Type', 'text/plain; charset=utf-8');
        if ($from->getHeader('Content-Type') === null) {
            $this->copyHeader($from, $to, 'Content-Transfer-Encoding', 'quoted-printable');
        } else {
            $this->copyHeader($from, $to, 'Content-Transfer-Encoding');
        }
        $rem = array_diff(self::$contentHeaders, [ 'Content-Type', 'Content-Transfer-Encoding']);
        foreach ($rem as $header) {
            $this->copyHeader($from, $to, $header);
        }
        if ($from->hasContent()) {
            $to->attachContentStream($from->getContentStream(), MailMimeParser::DEFAULT_CHARSET);
        }
        if ($move) {
            $this->removeContentHeadersAndContent($from);
        }
    }

    /**
     * Creates a new content part from the passed part, allowing the part to be
     * used for something else (e.g. changing a non-mime message to a multipart
     * mime message).
     *
     * @param ParentHeaderPart $part
     * @return MimePart the newly-created MimePart
    */
    public function createNewContentPartFrom(ParentHeaderPart $part)
    {
        $mime = $this->partBuilderFactory->newPartBuilder($this->mimePartFactory)->createMessagePart();
        $this->copyContentHeadersAndContent($part, $mime, true);
        return $mime;
    }

    /**
     * Copies type headers (Content-Type, Content-Disposition,
     * Content-Transfer-Encoding) from the $from MimePart to $to.  Attaches the
     * content resource handle of $from to $to, and loops over child parts,
     * removing them from $from and adding them to $to.
     *
     * @param ParentHeaderPart $from
     * @param ParentHeaderPart $to
     */
    public function movePartContentAndChildren(ParentHeaderPart $from, ParentHeaderPart $to)
    {
        $this->copyContentHeadersAndContent($from, $to, true);
        foreach ($from->getChildParts() as $child) {
            $from->removePart($child);
            $to->addChild($child);
        }
    }

    /**
     * Replaces the $part ParentHeaderPart with $replacement.
     *
     * Essentially removes $part from its parent, and adds $replacement in its
     * same position.  If $part is this Message, then $part can't be removed and
     * replaced, and instead $replacement's type headers are copied to $message,
     * and any children below $replacement are added directly below $message.
     *
     * @param Message $message
     * @param ParentHeaderPart $part
     * @param ParentHeaderPart $replacement
     */
    public function replacePart(Message $message, ParentHeaderPart $part, ParentHeaderPart $replacement)
    {
        $position = $message->removePart($replacement);
        if ($part === $message) {
            $this->movePartContentAndChildren($replacement, $part);
            return;
        }
        $parent = $part->getParent();
        $parent->addChild($replacement, $position);
    }
}
