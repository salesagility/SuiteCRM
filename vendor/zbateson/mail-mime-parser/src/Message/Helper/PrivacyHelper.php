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
use ZBateson\MailMimeParser\Message\Part\ParentPart;
use ZBateson\MailMimeParser\Message\PartFilter;

/**
 * Provides routines to set or retrieve the signature part of a signed message.
 *
 * @author Zaahid Bateson
 */
class PrivacyHelper extends AbstractHelper
{
    /**
     * @var GenericHelper a GenericHelper instance
     */
    private $genericHelper;

    /**
     * @var MultipartHelper a MultipartHelper instance
     */
    private $multipartHelper;

    /**
     * Constructor
     * 
     * @param MimePartFactory $mimePartFactory
     * @param UUEncodedPartFactory $uuEncodedPartFactory
     * @param PartBuilderFactory $partBuilderFactory
     * @param GenericHelper $genericHelper
     * @param MultipartHelper $multipartHelper
     */
    public function __construct(
        MimePartFactory $mimePartFactory,
        UUEncodedPartFactory $uuEncodedPartFactory,
        PartBuilderFactory $partBuilderFactory,
        GenericHelper $genericHelper,
        MultipartHelper $multipartHelper
    ) {
        parent::__construct($mimePartFactory, $uuEncodedPartFactory, $partBuilderFactory);
        $this->genericHelper = $genericHelper;
        $this->multipartHelper = $multipartHelper;
    }

    /**
     * The passed message is set as multipart/signed, and a new part is created
     * below it with content headers, content and children copied from the
     * message.
     *
     * @param Message $message
     * @param string $micalg
     * @param string $protocol
     */
    public function setMessageAsMultipartSigned(Message $message, $micalg, $protocol)
    {
        if (strcasecmp($message->getContentType(), 'multipart/signed') !== 0) {
            $this->multipartHelper->enforceMime($message);
            $messagePart = $this->partBuilderFactory->newPartBuilder($this->mimePartFactory)->createMessagePart();
            $this->genericHelper->movePartContentAndChildren($message, $messagePart);
            $message->addChild($messagePart);
            $boundary = $this->multipartHelper->getUniqueBoundary('multipart/signed');
            $message->setRawHeader(
                'Content-Type',
                "multipart/signed;\r\n\tboundary=\"$boundary\";\r\n\tmicalg=\"$micalg\"; protocol=\"$protocol\""
            );
        }
        $this->overwrite8bitContentEncoding($message);
        $this->ensureHtmlPartFirstForSignedMessage($message);
        $this->setSignature($message, 'Empty');
    }

    /**
     * Sets the signature of the message to $body, creating a signature part if
     * one doesn't exist.
     *
     * @param Message $message
     * @param string $body
     */
    public function setSignature(Message $message, $body)
    {
        $signedPart = $message->getSignaturePart();
        if ($signedPart === null) {
            $signedPart = $this->partBuilderFactory->newPartBuilder($this->mimePartFactory)->createMessagePart();
            $message->addChild($signedPart);
        }
        $signedPart->setRawHeader(
            'Content-Type',
            $message->getHeaderParameter('Content-Type', 'protocol')
        );
        $signedPart->setContent($body);
    }

    /**
     * Loops over parts of the message and sets the content-transfer-encoding
     * header to quoted-printable for text/* mime parts, and to base64
     * otherwise for parts that are '8bit' encoded.
     *
     * Used for multipart/signed messages which doesn't support 8bit transfer
     * encodings.
     *
     * @param Message $message
     */
    public function overwrite8bitContentEncoding(Message $message)
    {
        $parts = $message->getAllParts(new PartFilter([
            'headers' => [ PartFilter::FILTER_INCLUDE => [
                'Content-Transfer-Encoding' => '8bit'
            ] ]
        ]));
        foreach ($parts as $part) {
            $contentType = strtolower($part->getContentType());
            if ($contentType === 'text/plain' || $contentType === 'text/html') {
                $part->setRawHeader('Content-Transfer-Encoding', 'quoted-printable');
            } else {
                $part->setRawHeader('Content-Transfer-Encoding', 'base64');
            }
        }
    }

    /**
     * Ensures a non-text part comes first in a signed multipart/alternative
     * message as some clients seem to prefer the first content part if the
     * client doesn't understand multipart/signed.
     *
     * @param Message $message
     */
    public function ensureHtmlPartFirstForSignedMessage(Message $message)
    {
        $alt = $message->getPartByMimeType('multipart/alternative');
        if ($alt !== null && $alt instanceof ParentPart) {
            $cont = $this->multipartHelper->getContentPartContainerFromAlternative('text/html', $alt);
            $children = $alt->getChildParts();
            $pos = array_search($cont, $children, true);
            if ($pos !== false && $pos !== 0) {
                $alt->removePart($children[0]);
                $alt->addChild($children[0]);
            }
        }
    }

    /**
     * Returns a stream that can be used to read the content part of a signed
     * message, which can be used to sign an email or verify a signature.
     *
     * The method simply returns the stream for the first child.  No
     * verification of whether the message is in fact a signed message is
     * performed.
     *
     * Note that unlike getSignedMessageAsString, getSignedMessageStream doesn't
     * replace new lines.
     *
     * @param Message $message
     * @return \Psr\Http\Message\StreamInterface or null if the message doesn't
     *         have any children
     */
    public function getSignedMessageStream(Message $message)
    {
        $child = $message->getChild(0);
        if ($child !== null) {
            return $child->getStream();
        }
        return null;
    }

    /**
     * Returns a string containing the entire body (content) of a signed message
     * for verification or calculating a signature.
     *
     * Non-CRLF new lines are replaced to always be CRLF.
     *
     * @param Message $message
     * @return string or null if the message doesn't have any children
     */
    public function getSignedMessageAsString(Message $message)
    {
        $stream = $this->getSignedMessageStream($message);
        if ($stream !== null) {
            return preg_replace(
                '/\r\n|\r|\n/',
                "\r\n",
                $stream->getContents()
            );
        }
        return null;
    }

    /**
     * Returns the signature part of a multipart/signed message or null.
     *
     * The signature part is determined to always be the 2nd child of a
     * multipart/signed message, the first being the 'body'.
     *
     * Using the 'protocol' parameter of the Content-Type header is unreliable
     * in some instances (for instance a difference of x-pgp-signature versus
     * pgp-signature).
     *
     * @param Message $message
     * @return \ZBateson\MailMimeParser\Message\Part\MimePart
     */
    public function getSignaturePart(Message $message)
    {
        if (strcasecmp($message->getContentType(), 'multipart/signed') === 0) {
            return $message->getChild(1);
        } else {
            return null;
        }
    }
}
