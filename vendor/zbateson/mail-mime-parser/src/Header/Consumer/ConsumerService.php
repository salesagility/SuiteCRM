<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Consumer;

use ZBateson\MailMimeParser\Header\Part\HeaderPartFactory;
use ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory;
use ZBateson\MailMimeParser\Header\Consumer\Received\DomainConsumer;
use ZBateson\MailMimeParser\Header\Consumer\Received\GenericReceivedConsumer;
use ZBateson\MailMimeParser\Header\Consumer\Received\ReceivedDateConsumer;

/**
 * Simple service provider for consumer singletons.
 *
 * @author Zaahid Bateson
 */
class ConsumerService
{
    /**
     * @var \ZBateson\MailMimeParser\Header\Part\HeaderPartFactory the
     * HeaderPartFactory instance used to create HeaderParts.
     */
    protected $partFactory;
    
    /**
     * @var \ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory used for
     * GenericConsumer instances.
     */
    protected $mimeLiteralPartFactory;

    /**
     * @var Received\DomainConsumer[]|Received\GenericReceivedConsumer[]|Received\ReceivedDateConsumer[]
     *      an array of sub-received header consumer instances.
     */
    protected $receivedConsumers = [
        'from' => null,
        'by' => null,
        'via' => null,
        'with' => null,
        'id' => null,
        'for' => null,
        'date' => null
    ];
    
    /**
     * Sets up the HeaderPartFactory member variable.
     * 
     * @param HeaderPartFactory $partFactory
     * @param MimeLiteralPartFactory $mimeLiteralPartFactory
     */
    public function __construct(HeaderPartFactory $partFactory, MimeLiteralPartFactory $mimeLiteralPartFactory)
    {
        $this->partFactory = $partFactory;
        $this->mimeLiteralPartFactory = $mimeLiteralPartFactory;
    }
    
    /**
     * Returns the AddressBaseConsumer singleton instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\AddressBaseConsumer
     */
    public function getAddressBaseConsumer()
    {
        return AddressBaseConsumer::getInstance($this, $this->partFactory);
    }
    
    /**
     * Returns the AddressConsumer singleton instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\AddressConsumer
     */
    public function getAddressConsumer()
    {
        return AddressConsumer::getInstance($this, $this->partFactory);
    }
    
    /**
     * Returns the AddressGroupConsumer singleton instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\AddressGroupConsumer
     */
    public function getAddressGroupConsumer()
    {
        return AddressGroupConsumer::getInstance($this, $this->partFactory);
    }
    
    /**
     * Returns the CommentConsumer singleton instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\CommentConsumer
     */
    public function getCommentConsumer()
    {
        return CommentConsumer::getInstance($this, $this->partFactory);
    }
    
    /**
     * Returns the GenericConsumer singleton instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\GenericConsumer
     */
    public function getGenericConsumer()
    {
        return GenericConsumer::getInstance($this, $this->mimeLiteralPartFactory);
    }

    /**
     * Returns the SubjectConsumer singleton instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\SubjectConsumer
     */
    public function getSubjectConsumer()
    {
        return SubjectConsumer::getInstance($this, $this->mimeLiteralPartFactory);
    }
    
    /**
     * Returns the QuotedStringConsumer singleton instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\QuotedStringConsumer
     */
    public function getQuotedStringConsumer()
    {
        return QuotedStringConsumer::getInstance($this, $this->partFactory);
    }
    
    /**
     * Returns the DateConsumer singleton instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\DateConsumer
     */
    public function getDateConsumer()
    {
        return DateConsumer::getInstance($this, $this->partFactory);
    }
    
    /**
     * Returns the ParameterConsumer singleton instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\ParameterConsumer
     */
    public function getParameterConsumer()
    {
        return ParameterConsumer::getInstance($this, $this->partFactory);
    }

    /**
     * Returns the consumer instance corresponding to the passed part name of a
     * Received header.
     *
     * @param string $partName
     * @return \ZBateson\MailMimeParser\Header\Consumer\Received\FromConsumer
     */
    public function getSubReceivedConsumer($partName)
    {
        if (empty($this->receivedConsumers[$partName])) {
            $consumer = null;
            if ($partName === 'from' || $partName === 'by') {
                $consumer = new DomainConsumer($this, $this->partFactory, $partName);
            } else if ($partName === 'date') {
                $consumer = new ReceivedDateConsumer($this, $this->partFactory);
            } else {
                $consumer = new GenericReceivedConsumer($this, $this->partFactory, $partName);
            }
            $this->receivedConsumers[$partName] = $consumer;
        }
        return $this->receivedConsumers[$partName];
    }

    /**
     * Returns the ReceivedConsumer singleton instance.
     *
     * @return \ZBateson\MailMimeParser\Header\Consumer\ReceivedConsumer
     */
    public function getReceivedConsumer()
    {
        return ReceivedConsumer::getInstance($this, $this->partFactory);
    }

    /**
     * Returns the IdConsumer singleton instance.
     *
     * @return \ZBateson\MailMimeParser\Header\Consumer\IdConsumer
     */
    public function getIdConsumer()
    {
        return IdConsumer::getInstance($this, $this->partFactory);
    }

    /**
     * Returns the IdBaseConsumer singleton instance.
     *
     * @return \ZBateson\MailMimeParser\Header\Consumer\IdBaseConsumer
     */
    public function getIdBaseConsumer()
    {
        return IdBaseConsumer::getInstance($this, $this->partFactory);
    }
}
