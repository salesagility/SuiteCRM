<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Consumer;

/**
 * Represents a quoted part of a header value starting at a single quote, and
 * ending at the next single quote.
 * 
 * A quoted-pair part in a header is a literal.  There are no sub-consumers for
 * it and a Part\LiteralPart is returned.
 *
 * Newline characters (CR and LF) are stripped entirely from the quoted part.
 * This is based on the example at:
 *
 * https://tools.ietf.org/html/rfc822#section-3.1.1
 *
 * And https://www.w3.org/Protocols/rfc1341/7_2_Multipart.html in section 7.2.1
 * splitting the boundary.
 *
 * @author Zaahid Bateson
 */
class QuotedStringConsumer extends GenericConsumer
{
    /**
     * QuotedStringConsumer doesn't have any sub-consumers.  This method returns
     * an empty array.
     * 
     * @return array
     */
    public function getSubConsumers()
    {
        return [];
    }
    
    /**
     * Returns true if the token is a double quote.
     * 
     * @param string $token
     * @return bool
     */
    protected function isStartToken($token)
    {
        return ($token === '"');
    }
    
    /**
     * Returns true if the token is a double quote.
     * 
     * @param string $token
     * @return boolean
     */
    protected function isEndToken($token)
    {
        return ($token === '"');
    }
    
    /**
     * Returns a single regex pattern for a double quote.
     * 
     * @return string[]
     */
    protected function getTokenSeparators()
    {
        return ['\"'];
    }
    
    /**
     * Constructs a Part\LiteralPart and returns it.
     * 
     * @param string $token
     * @param bool $isLiteral not used - everything in a quoted string is a
     *        literal
     * @return \ZBateson\MailMimeParser\Header\Part\LiteralPart
     */
    protected function getPartForToken($token, $isLiteral)
    {
        return $this->partFactory->newLiteralPart($token);
    }
}
