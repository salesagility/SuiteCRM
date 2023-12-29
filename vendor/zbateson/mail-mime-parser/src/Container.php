<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser;

use ZBateson\MailMimeParser\Header\Consumer\ConsumerService;
use ZBateson\MailMimeParser\Header\HeaderFactory;
use ZBateson\MailMimeParser\Header\Part\HeaderPartFactory;
use ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory;
use ZBateson\MailMimeParser\Message\Helper\MessageHelperService;
use ZBateson\MailMimeParser\Message\MessageParser;
use ZBateson\MailMimeParser\Message\Part\Factory\PartBuilderFactory;
use ZBateson\MailMimeParser\Message\Part\Factory\PartFactoryService;
use ZBateson\MailMimeParser\Message\Part\Factory\PartStreamFilterManagerFactory;
use ZBateson\MbWrapper\MbWrapper;

/**
 * Dependency injection container for use by ZBateson\MailMimeParser - because a
 * more complex one seems like overkill.
 * 
 * Constructs objects and whatever dependencies they require.
 *
 * @author Zaahid Bateson
 */
class Container
{
    /**
     * @var PartBuilderFactory The PartBuilderFactory instance
     */
    protected $partBuilderFactory;
    
    /**
     * @var PartFactoryService The PartFactoryService instance
     */
    protected $partFactoryService;
    
    /**
     * @var PartFilterFactory The PartFilterFactory instance
     */
    protected $partFilterFactory;
    
    /**
     * @var PartStreamFilterManagerFactory The PartStreamFilterManagerFactory
     *      instance
     */
    protected $partStreamFilterManagerFactory;
    
    /**
     * @var \ZBateson\MailMimeParser\Header\HeaderFactory singleton 'service'
     * instance
     */
    protected $headerFactory;
    
    /**
     * @var \ZBateson\MailMimeParser\Header\Part\HeaderPartFactory singleton
     * 'service' instance
     */
    protected $headerPartFactory;
    
    /**
     * @var \ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory
     * singleton 'service' instance
     */
    protected $mimeLiteralPartFactory;
    
    /**
     * @var \ZBateson\MailMimeParser\Header\Consumer\ConsumerService singleton
     * 'service' instance
     */
    protected $consumerService;
    
    /**
     * @var MessageHelperService Used to get MessageHelper singletons
     */
    protected $messageHelperService;

    /**
     * @var StreamFactory
     */
    protected $streamFactory;
    
    /**
     * Constructs a Container - call singleton() to invoke
     */
    public function __construct()
    {
    }

    /**
     * Returns a singleton 'service' instance for the given service named $var
     * with a class type of $class.
     * 
     * @param string $var the name of the service
     * @param string $class the name of the class
     * @return mixed the service object
     */
    protected function getInstance($var, $class)
    {
        if ($this->$var === null) {
            $this->$var = new $class();
        }
        return $this->$var;
    }
    
    /**
     * Constructs and returns a new MessageParser object.
     * 
     * @return \ZBateson\MailMimeParser\Message\MessageParser
     */
    public function newMessageParser()
    {
        return new MessageParser(
            $this->getPartFactoryService(),
            $this->getPartBuilderFactory()
        );
    }
    
    /**
     * Returns a MessageHelperService instance.
     * 
     * @return MessageHelperService
     */
    public function getMessageHelperService()
    {
        if ($this->messageHelperService === null) {
            $this->messageHelperService = new MessageHelperService(
                $this->getPartBuilderFactory()
            );
            $this->messageHelperService->setPartFactoryService(
                $this->getPartFactoryService()
            );
        }
        return $this->messageHelperService;
    }

    /**
     * Returns a PartFilterFactory instance
     *
     * @return PartFilterFactory
     */
    public function getPartFilterFactory()
    {
        return $this->getInstance(
            'partFilterFactory',
            __NAMESPACE__ . '\Message\PartFilterFactory'
        );
    }
    
    /**
     * Returns a PartFactoryService singleton.
     * 
     * @return PartFactoryService
     */
    public function getPartFactoryService()
    {
        if ($this->partFactoryService === null) {
            $this->partFactoryService = new PartFactoryService(
                $this->getPartFilterFactory(),
                $this->getStreamFactory(),
                $this->getPartStreamFilterManagerFactory(),
                $this->getMessageHelperService()
            );
        }
        return $this->partFactoryService;
    }

    /**
     * Returns a PartBuilderFactory instance.
     * 
     * @return PartBuilderFactory
     */
    public function getPartBuilderFactory()
    {
        if ($this->partBuilderFactory === null) {
            $this->partBuilderFactory = new PartBuilderFactory(
                $this->getHeaderFactory()
            );
        }
        return $this->partBuilderFactory;
    }
    
    /**
     * Returns the header factory service instance.
     * 
     * @return \ZBateson\MailMimeParser\Header\HeaderFactory
     */
    public function getHeaderFactory()
    {
        if ($this->headerFactory === null) {
            $this->headerFactory = new HeaderFactory(
                $this->getConsumerService(),
                $this->getMimeLiteralPartFactory()
            );
        }
        return $this->headerFactory;
    }

    /**
     * Returns a StreamFactory.
     *
     * @return StreamFactory
     */
    public function getStreamFactory()
    {
        return $this->getInstance(
            'streamFactory',
            __NAMESPACE__ . '\Stream\StreamFactory'
        );
    }

    /**
     * Returns a PartStreamFilterManagerFactory.
     * 
     * @return PartStreamFilterManagerFactory
     */
    public function getPartStreamFilterManagerFactory()
    {
        if ($this->partStreamFilterManagerFactory === null) {
            $this->partStreamFilterManagerFactory = new PartStreamFilterManagerFactory(
                $this->getStreamFactory()
            );
        }
        return $this->getInstance(
            'partStreamFilterManagerFactory',
            __NAMESPACE__ . '\Message\Part\PartStreamFilterManagerFactory'
        );
    }

    /**
     * Returns a MbWrapper.
     * 
     * @return MbWrapper
     */
    public function getCharsetConverter()
    {
        return new MbWrapper();
    }
    
    /**
     * Returns the part factory service
     * 
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPartFactory
     */
    public function getHeaderPartFactory()
    {
        if ($this->headerPartFactory === null) {
            $this->headerPartFactory = new HeaderPartFactory($this->getCharsetConverter());
        }
        return $this->headerPartFactory;
    }
    
    /**
     * Returns the MimeLiteralPartFactory service
     * 
     * @return \ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory
     */
    public function getMimeLiteralPartFactory()
    {
        if ($this->mimeLiteralPartFactory === null) {
            $this->mimeLiteralPartFactory = new MimeLiteralPartFactory($this->getCharsetConverter());
        }
        return $this->mimeLiteralPartFactory;
    }
    
    /**
     * Returns the header consumer service
     * 
     * @return \ZBateson\MailMimeParser\Header\Consumer\ConsumerService
     */
    public function getConsumerService()
    {
        if ($this->consumerService === null) {
            $this->consumerService = new ConsumerService(
                $this->getHeaderPartFactory(),
                $this->getMimeLiteralPartFactory()
            );
        }
        return $this->consumerService;
    }
    
}
