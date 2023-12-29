<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Consumer;

use Iterator;

/**
 * Serves as a base-consumer for recipient/sender email address headers (like
 * From and To).
 * 
 * AddressBaseConsumer passes on token processing to its sub-consumer, an
 * AddressConsumer, and collects Part\AddressPart objects processed and returned
 * by AddressConsumer.
 *
 * @author Zaahid Bateson
 */
class AddressBaseConsumer extends AbstractConsumer
{
    /**
     * Returns \ZBateson\MailMimeParser\Header\Consumer\AddressConsumer as a
     * sub-consumer.
     * 
     * @return AbstractConsumer[] the sub-consumers
     */
    protected function getSubConsumers()
    {
        return [
            $this->consumerService->getAddressConsumer()
        ];
    }
    
    /**
     * Returns an empty array.
     * 
     * @return string[] an array of regex pattern matchers
     */
    protected function getTokenSeparators()
    {
        return [];
    }
    
    /**
     * Disables advancing for start tokens.
     * 
     * The start token for AddressBaseConsumer is part of an AddressPart (or a
     * sub-consumer) and so must be passed on.
     * 
     * @param Iterator $tokens
     * @param bool $isStartToken
     */
    protected function advanceToNextToken(Iterator $tokens, $isStartToken)
    {
        if ($isStartToken) {
            return;
        }
        parent::advanceToNextToken($tokens, $isStartToken);
    }
    
    /**
     * AddressBaseConsumer doesn't have start/end tokens, and so always returns
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
     * AddressBaseConsumer doesn't have start/end tokens, and so always returns
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
     * Overridden so tokens aren't handled at this level, and instead are passed
     * on to AddressConsumer.
     *
     * @param Iterator $tokens
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[]|array
     */
    protected function getTokenParts(Iterator $tokens)
    {
        return $this->getConsumerTokenParts($tokens);
    }
    
    /**
     * Never reached by AddressBaseConsumer. Overridden to satisfy
     * AbstractConsumer.
     * 
     * @codeCoverageIgnore
     * @param string $token the token
     * @param bool $isLiteral set to true if the token represents a literal -
     *        e.g. an escaped token
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart the constructed
     *         header part or null if the token should be ignored
     */
    protected function getPartForToken($token, $isLiteral)
    {
        return null;
    }
}
