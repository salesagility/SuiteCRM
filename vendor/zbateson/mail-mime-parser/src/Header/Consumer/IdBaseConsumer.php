<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Consumer;

use ZBateson\MailMimeParser\Header\Part\CommentPart;

/**
 * Serves as a base-consumer for ID headers (like Message-ID and Content-ID).
 * 
 * IdBaseConsumer handles invalidly-formatted IDs not within '<' and '>'
 * characters.  Processing for validly-formatted IDs are passed on to its
 * sub-consumer, IdConsumer.
 *
 * @author Zaahid Bateson
 */
class IdBaseConsumer extends AbstractConsumer
{
    /**
     * Returns the following as sub-consumers:
     *  - \ZBateson\MailMimeParser\Header\Consumer\CommentConsumer
     *  - \ZBateson\MailMimeParser\Header\Consumer\QuotedStringConsumer
     *  - \ZBateson\MailMimeParser\Header\Consumer\IdConsumer
     *
     * @return AbstractConsumer[] the sub-consumers
     */
    protected function getSubConsumers()
    {
        return [
            $this->consumerService->getCommentConsumer(),
            $this->consumerService->getQuotedStringConsumer(),
            $this->consumerService->getIdConsumer()
        ];
    }
    
    /**
     * Returns '\s+' as a whitespace separator.
     * 
     * @return string[] an array of regex pattern matchers
     */
    protected function getTokenSeparators()
    {
        return ['\s+'];
    }

    /**
     * IdBaseConsumer doesn't have start/end tokens, and so always returns
     * false.
     * 
     * @param string $token
     * @return boolean false
     */
    protected function isEndToken($token)
    {
        return false;
    }
    
    /**
     * IdBaseConsumer doesn't have start/end tokens, and so always returns
     * false.
     * 
     * @codeCoverageIgnore
     * @param string $token
     * @return boolean false
     */
    protected function isStartToken($token)
    {
        return false;
    }
    
    /**
     * Returns null for whitespace, and LiteralPart for anything else.
     * 
     * @param string $token the token
     * @param bool $isLiteral set to true if the token represents a literal -
     *        e.g. an escaped token
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart|null the
     *         constructed header part or null if the token should be ignored
     */
    protected function getPartForToken($token, $isLiteral)
    {
        if (preg_match('/^\s+$/', $token)) {
            return null;
        }
        return $this->partFactory->newLiteralPart($token);
    }

    /**
     * Overridden to filter out any found CommentPart objects.
     *
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $parts
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[]
     */
    protected function processParts(array $parts)
    {
        return array_values(array_filter($parts, function ($part) {
            if (empty($part) || $part instanceof CommentPart) {
                return false;
            }
            return true;
        }));
    }
}
