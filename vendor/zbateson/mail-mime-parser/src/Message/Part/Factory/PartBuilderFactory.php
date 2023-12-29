<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Part\Factory;

use ZBateson\MailMimeParser\Header\HeaderFactory;
use ZBateson\MailMimeParser\Message\Part\PartBuilder;

/**
 * Responsible for creating PartBuilder instances.
 * 
 * The PartBuilder instance must be constructed with a MessagePartFactory
 * instance to construct a MessagePart sub-class after parsing a message into
 * PartBuilder instances.
 *
 * @author Zaahid Bateson
 */
class PartBuilderFactory
{
    /**
     * @var \ZBateson\MailMimeParser\Header\HeaderFactory the HeaderFactory
     *      instance
     */
    protected $headerFactory;
    
    /**
     * Initializes dependencies
     * 
     * @param HeaderFactory $headerFactory
     */
    public function __construct(HeaderFactory $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }
    
    /**
     * Constructs a new PartBuilder object and returns it
     * 
     * @param \ZBateson\MailMimeParser\Message\Part\Factory\MessagePartFactory
     *        $messagePartFactory 
     * @return \ZBateson\MailMimeParser\Message\Part\PartBuilder
     */
    public function newPartBuilder(MessagePartFactory $messagePartFactory)
    {
        return new PartBuilder(
            $messagePartFactory,
            $this->headerFactory->newHeaderContainer()
        );
    }
}
