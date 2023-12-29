<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Part\Factory;

use ZBateson\MailMimeParser\Stream\StreamFactory;
use ZBateson\MailMimeParser\Message\Part\PartStreamFilterManager;

/**
 * Responsible for creating PartStreamFilterManager instances.
 *
 * @author Zaahid Bateson
 */
class PartStreamFilterManagerFactory
{
    /**
     * @var StreamFactory the StreamFactory needed to
     *      initialize a new PartStreamFilterManager.
     */
    protected $streamFactory;
    
    /**
     * Initializes dependencies
     *
     * @param StreamFactory $streamFactory
     */
    public function __construct(StreamFactory $streamFactory) {
        $this->streamFactory = $streamFactory;
    }
    
    /**
     * Constructs a new PartStreamFilterManager object and returns it.
     * 
     * @return \ZBateson\MailMimeParser\Message\Part\PartStreamFilterManager
     */
    public function newInstance()
    {
        return new PartStreamFilterManager($this->streamFactory);
    }
}
