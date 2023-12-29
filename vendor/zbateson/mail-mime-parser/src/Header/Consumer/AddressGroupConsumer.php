<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Consumer;

use ZBateson\MailMimeParser\Header\Part\AddressGroupPart;

/**
 * Parses a single group of addresses (as a named-group part of an address
 * header).
 * 
 * Finds addresses using its AddressConsumer sub-consumer separated by commas,
 * and ends processing once a semi-colon is found.
 * 
 * Prior to returning to its calling client, AddressGroupConsumer constructs a
 * single Part\AddressGroupPart object filling it with all located addresses, and
 * returns it.
 * 
 * The AddressGroupConsumer extends AddressBaseConsumer to define start/end
 * tokens, token separators, and construct a Part\AddressGroupPart for returning to
 * clients.
 * 
 * @author Zaahid Bateson
 */
class AddressGroupConsumer extends AddressBaseConsumer
{
    /**
     * Overridden to return patterns matching the beginning and end markers of a
     * group address: colon and semi-colon (":" and ";") characters.
     * 
     * @return string[] the patterns
     */
    public function getTokenSeparators()
    {
        return [':', ';'];
    }
    
    /**
     * AddressGroupConsumer returns true if the passed token is a semi-colon.
     * 
     * @param string $token
     * @return boolean false
     */
    protected function isEndToken($token)
    {
        return ($token === ';');
    }
    
    /**
     * AddressGroupConsumer returns true if the passed token is a colon.
     * 
     * @param string $token
     * @return boolean false
     */
    protected function isStartToken($token)
    {
        return ($token === ':');
    }
    
    /**
     * Performs post-processing on parsed parts.
     * 
     * AddressGroupConsumer returns an array with a single Part\AddressGroupPart
     * element with all email addresses from this and any sub-groups.
     * 
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $parts
     * @return AddressGroupPart[]|array
     */
    protected function processParts(array $parts)
    {
        $emails = [];
        foreach ($parts as $part) {
            if ($part instanceof AddressGroupPart) {
                $emails = array_merge($emails, $part->getAddresses());
                continue;
            }
            $emails[] = $part;
        }
        $group = $this->partFactory->newAddressGroupPart($emails);
        return [$group];
    }
}
