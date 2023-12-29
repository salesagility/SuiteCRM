<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header;

use ZBateson\MailMimeParser\Header\Consumer\AbstractConsumer;
use ZBateson\MailMimeParser\Header\Consumer\ConsumerService;
use ZBateson\MailMimeParser\Header\Part\AddressPart;
use ZBateson\MailMimeParser\Header\Part\AddressGroupPart;

/**
 * Reads an address list header using the AddressBaseConsumer.
 * 
 * An address list may consist of one or more addresses and address groups.
 * Each address separated by a comma, and each group separated by a semi-colon.
 * 
 * For full specifications, see https://www.ietf.org/rfc/rfc2822.txt
 *
 * @author Zaahid Bateson
 */
class AddressHeader extends AbstractHeader
{
    /**
     * @var \ZBateson\MailMimeParser\Header\Part\AddressPart[] array of
     * addresses 
     */
    protected $addresses = [];
    
    /**
     * @var \ZBateson\MailMimeParser\Header\Part\AddressGroupPart[] array of
     * address groups
     */
    protected $groups = [];
    
    /**
     * Returns an AddressBaseConsumer.
     * 
     * @param ConsumerService $consumerService
     * @return \ZBateson\MailMimeParser\Header\Consumer\AbstractConsumer
     */
    protected function getConsumer(ConsumerService $consumerService)
    {
        return $consumerService->getAddressBaseConsumer();
    }
    
    /**
     * Overridden to extract all addresses into addresses array.
     * 
     * @param AbstractConsumer $consumer
     */
    protected function setParseHeaderValue(AbstractConsumer $consumer)
    {
        parent::setParseHeaderValue($consumer);
        foreach ($this->parts as $part) {
            if ($part instanceof AddressPart) {
                $this->addresses[] = $part;
            } elseif ($part instanceof AddressGroupPart) {
                $this->addresses = array_merge($this->addresses, $part->getAddresses());
                $this->groups[] = $part;
            }
        }
    }
    
    /**
     * Returns all address parts in the header including all addresses that are
     * in groups.
     * 
     * @return \ZBateson\MailMimeParser\Header\Part\AddressPart[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
    
    /**
     * Returns all group parts in the header.
     * 
     * @return \ZBateson\MailMimeParser\Header\Part\AddressGroupPart[]
     */
    public function getGroups()
    {
        return $this->groups;
    }
    
    /**
     * Returns true if an address exists with the passed email address.
     * 
     * Comparison is done case insensitively.
     * 
     * @param string $email
     * @return boolean
     */
    public function hasAddress($email)
    {
        foreach ($this->addresses as $addr) {
            if (strcasecmp($addr->getEmail(), $email) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Same as getValue, but for clarity to match AddressPart.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getValue();
    }

    /**
     * Returns the name associated with the first email address to complement
     * getValue().
     * 
     * @return string
     */
    public function getPersonName()
    {
        if (!empty($this->parts)) {
            return $this->parts[0]->getName();
        }
        return null;
    }
}
