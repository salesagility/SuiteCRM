<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header;

use ZBateson\MailMimeParser\Header\Consumer\ConsumerService;
use ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory;

/**
 * Constructs various AbstractHeader types depending on the type of header
 * passed.
 * 
 * If the passed header resolves to a specific defined header type, it is parsed
 * as such.  Otherwise, a GenericHeader is instantiated and returned.  Headers
 * are mapped as follows:
 * 
 * AddressHeader: From, To, Cc, Bcc, Sender, Reply-To, Resent-From, Resent-To,
 * Resent-Cc, Resent-Bcc, Resent-Reply-To, Delivered-To, Return-Path
 * DateHeader: Date, Resent-Date, Delivery-Date, Expires, Expiry-Date, Reply-By
 * ParameterHeader: Content-Type, Content-Disposition
 * IdHeader: Message-ID, Content-ID, In-Reply-To, References
 * ReceivedHeader: Received
 *
 * @author Zaahid Bateson
 */
class HeaderFactory
{
    /**
     * @var ConsumerService the passed ConsumerService providing
     * AbstractConsumer singletons.
     */
    protected $consumerService;

    /**
     * @var \ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory for
     * mime decoding.
     */
    protected $mimeLiteralPartFactory;
    
    /**
     * @var string[][] maps AbstractHeader types to headers. 
     */
    protected $types = [
        'ZBateson\MailMimeParser\Header\AddressHeader' => [
            'from',
            'to',
            'cc',
            'bcc',
            'sender',
            'replyto',
            'resentfrom',
            'resentto',
            'resentcc',
            'resentbcc',
            'resentreplyto',
            'returnpath',
            'deliveredto',
        ],
        'ZBateson\MailMimeParser\Header\DateHeader' => [
            'date',
            'resentdate',
            'deliverydate',
            'expires',
            'expirydate',
            'replyby',
        ],
        'ZBateson\MailMimeParser\Header\ParameterHeader' => [
            'contenttype',
            'contentdisposition',
        ],
        'ZBateson\MailMimeParser\Header\SubjectHeader' => [
            'subject',
        ],
        'ZBateson\MailMimeParser\Header\IdHeader' => [
            'messageid',
            'contentid',
            'inreplyto',
            'references'
        ],
        'ZBateson\MailMimeParser\Header\ReceivedHeader' => [
            'received'
        ]
    ];
    
    /**
     * @var string Defines the generic AbstractHeader type to use for headers
     * that aren't mapped in $types
     */
    protected $genericType = 'ZBateson\MailMimeParser\Header\GenericHeader';
    
    /**
     * Instantiates member variables with the passed objects.
     * 
     * @param ConsumerService $consumerService
     * @param MimeLiteralPartFactory $mimeLiteralPartFactory
     */
    public function __construct(ConsumerService $consumerService, MimeLiteralPartFactory $mimeLiteralPartFactory)
    {
        $this->consumerService = $consumerService;
        $this->mimeLiteralPartFactory = $mimeLiteralPartFactory;
    }

    /**
     * Returns the string in lower-case, and with non-alphanumeric characters
     * stripped out.
     *
     * @param string $header
     * @return string
     */
    public function getNormalizedHeaderName($header)
    {
        return preg_replace('/[^a-z0-9]/', '', strtolower($header));
    }
    
    /**
     * Returns the name of an AbstractHeader class for the passed header name.
     * 
     * @param string $name
     * @return string
     */
    private function getClassFor($name)
    {
        $test = $this->getNormalizedHeaderName($name);
        foreach ($this->types as $class => $matchers) {
            foreach ($matchers as $matcher) {
                if ($test === $matcher) {
                    return $class;
                }
            }
        }
        return $this->genericType;
    }
    
    /**
     * Creates an AbstractHeader instance for the passed header name and value,
     * and returns it.
     * 
     * @param string $name
     * @param string $value
     * @return \ZBateson\MailMimeParser\Header\AbstractHeader
     */
    public function newInstance($name, $value)
    {
        $class = $this->getClassFor($name);
        if (is_a($class, 'ZBateson\MailMimeParser\Header\MimeEncodedHeader', true)) {
            return new $class(
                $this->mimeLiteralPartFactory,
                $this->consumerService,
                $name,
                $value
            );
        }
        return new $class($this->consumerService, $name, $value);
    }

    /**
     * Creates and returns a HeaderContainer.
     *
     * @return HeaderContainer;
     */
    public function newHeaderContainer()
    {
        return new HeaderContainer($this);
    }
}
