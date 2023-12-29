<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Part;

use ZBateson\MbWrapper\MbWrapper;

/**
 * Constructs and returns HeaderPart objects.
 *
 * @author Zaahid Bateson
 */
class HeaderPartFactory
{
    /**
     * @var MbWrapper $charsetConverter passed to HeaderPart constructors
     *      for converting strings in HeaderPart::convertEncoding
     */
    protected $charsetConverter;
    
    /**
     * Sets up dependencies.
     * 
     * @param MbWrapper $charsetConverter
     */
    public function __construct(MbWrapper $charsetConverter)
    {
        $this->charsetConverter = $charsetConverter;
    }
    
    /**
     * Creates and returns a default HeaderPart for this factory, allowing
     * subclass factories for specialized HeaderParts.
     * 
     * The default implementation returns a new Token.
     * 
     * @param string $value
     * @return HeaderPart
     */
    public function newInstance($value)
    {
        return $this->newToken($value);
    }
    
    /**
     * Initializes and returns a new Token.
     * 
     * @param string $value
     * @return \ZBateson\MailMimeParser\Header\Part\Token
     */
    public function newToken($value)
    {
        return new Token($this->charsetConverter, $value);
    }
    
    /**
     * Instantiates and returns a SplitParameterToken with the given name.
     * 
     * @param string $name
     * @return SplitParameterToken
     */
    public function newSplitParameterToken($name)
    {
        return new SplitParameterToken($this->charsetConverter, $name);
    }
    
    /**
     * Initializes and returns a new LiteralPart.
     * 
     * @param string $value
     * @return \ZBateson\MailMimeParser\Header\Part\LiteralPart
     */
    public function newLiteralPart($value)
    {
        return new LiteralPart($this->charsetConverter, $value);
    }
    
    /**
     * Initializes and returns a new MimeLiteralPart.
     * 
     * @param string $value
     * @return \ZBateson\MailMimeParser\Header\Part\MimeLiteralPart
     */
    public function newMimeLiteralPart($value)
    {
        return new MimeLiteralPart($this->charsetConverter, $value);
    }
    
    /**
     * Initializes and returns a new CommentPart.
     * 
     * @param string $value
     * @return \ZBateson\MailMimeParser\Header\Part\CommentPart
     */
    public function newCommentPart($value)
    {
        return new CommentPart($this->charsetConverter, $value);
    }
    
    /**
     * Initializes and returns a new AddressPart.
     * 
     * @param string $name
     * @param string $email
     * @return \ZBateson\MailMimeParser\Header\Part\AddressPart
     */
    public function newAddressPart($name, $email)
    {
        return new AddressPart($this->charsetConverter, $name, $email);
    }
    
    /**
     * Initializes and returns a new AddressGroupPart
     * 
     * @param array $addresses
     * @param string $name
     * @return \ZBateson\MailMimeParser\Header\Part\AddressGroupPart
     */
    public function newAddressGroupPart(array $addresses, $name = '')
    {
        return new AddressGroupPart($this->charsetConverter, $addresses, $name);
    }
    
    /**
     * Initializes and returns a new DatePart
     * 
     * @param string $value
     * @return \ZBateson\MailMimeParser\Header\Part\DatePart
     */
    public function newDatePart($value)
    {
        return new DatePart($this->charsetConverter, $value);
    }
    
    /**
     * Initializes and returns a new ParameterPart.
     * 
     * @param string $name
     * @param string $value
     * @param string $language
     * @return \ZBateson\MailMimeParser\Header\Part\ParameterPart
     */
    public function newParameterPart($name, $value, $language = null)
    {
        return new ParameterPart($this->charsetConverter, $name, $value, $language);
    }

    /**
     * Initializes and returns a new ReceivedPart.
     *
     * @param string $name
     * @param string $value
     * @return \ZBateson\MailMimeParser\Header\Part\ReceivedPart
     */
    public function newReceivedPart($name, $value)
    {
        return new ReceivedPart($this->charsetConverter, $name, $value);
    }

    /**
     * Initializes and returns a new ReceivedDomainPart.
     *
     * @param string $name
     * @param string $value
     * @param string $ehloName
     * @param string $hostName
     * @param string $hostAddress
     * @return \ZBateson\MailMimeParser\Header\Part\ReceivedDomainPart
     */
    public function newReceivedDomainPart(
        $name,
        $value,
        $ehloName = null,
        $hostName = null,
        $hostAddress = null
    ) {
        return new ReceivedDomainPart(
            $this->charsetConverter,
            $name,
            $value,
            $ehloName,
            $hostName,
            $hostAddress
        );
    }
}
