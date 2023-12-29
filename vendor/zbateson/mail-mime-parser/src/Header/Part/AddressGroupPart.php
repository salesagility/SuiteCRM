<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Part;

use ZBateson\MbWrapper\MbWrapper;

/**
 * Holds a group of addresses, and an optional group name.
 * 
 * Because AddressGroupConsumer is only called once a colon (":") character is
 * found, an AddressGroupPart is initially constructed without a $name.  Once it is
 * returned to AddressConsumer, a new AddressGroupPart is created out of
 * AddressGroupConsumer's AddressGroupPart.
 *
 * @author Zaahid Bateson
 */
class AddressGroupPart extends MimeLiteralPart
{
    /**
     * @var AddressPart[] an array of AddressParts 
     */
    protected $addresses;
    
    /**
     * Creates an AddressGroupPart out of the passed array of AddressParts and an
     * optional name (which may be mime-encoded).
     * 
     * @param MbWrapper $charsetConverter
     * @param AddressPart[] $addresses
     * @param string $name
     */
    public function __construct(MbWrapper $charsetConverter, array $addresses, $name = '')
    {
        parent::__construct($charsetConverter, trim($name));
        $this->addresses = $addresses;
    }
    
    /**
     * Return the AddressGroupPart's array of addresses.
     * 
     * @return AddressPart[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
    
    /**
     * Returns the AddressPart at the passed index or null.
     * 
     * @param int $index
     * @return Address
     */
    public function getAddress($index)
    {
        if (!isset($this->addresses[$index])) {
            return null;
        }
        return $this->addresses[$index];
    }
    
    /**
     * Returns the name of the group
     * 
     * @return string
     */
    public function getName()
    {
        return $this->value;
    }
}
