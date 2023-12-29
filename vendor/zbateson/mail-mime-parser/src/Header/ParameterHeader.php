<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header;

use ZBateson\MailMimeParser\Header\Consumer\ConsumerService;
use ZBateson\MailMimeParser\Header\Consumer\AbstractConsumer;
use ZBateson\MailMimeParser\Header\Part\ParameterPart;

/**
 * Represents a header containing a primary value part and subsequent name/value
 * parts using a ParameterConsumer.
 * 
 * @author Zaahid Bateson
 */
class ParameterHeader extends AbstractHeader
{
    /**
     * @var \ZBateson\MailMimeParser\Header\Part\ParameterPart[] key map of
     * lower-case parameter names and associated ParameterParts.
     */
    protected $parameters = [];
    
    /**
     * Returns a ParameterConsumer.
     * 
     * @param ConsumerService $consumerService
     * @return \ZBateson\MailMimeParser\Header\Consumer\AbstractConsumer
     */
    protected function getConsumer(ConsumerService $consumerService)
    {
        return $consumerService->getParameterConsumer();
    }
    
    /**
     * Overridden to assign ParameterParts to a map of lower-case parameter
     * names to ParameterParts.
     * 
     * @param AbstractConsumer $consumer
     */
    protected function setParseHeaderValue(AbstractConsumer $consumer)
    {
        parent::setParseHeaderValue($consumer);
        foreach ($this->parts as $part) {
            if ($part instanceof ParameterPart) {
                $this->parameters[strtolower($part->getName())] = $part;
            }
        }
    }
    
    /**
     * Returns true if a parameter exists with the passed name.
     * 
     * @param string $name
     * @return boolean
     */
    public function hasParameter($name)
    {
        return isset($this->parameters[strtolower($name)]);
    }
    
    /**
     * Returns the value of the parameter with the given name, or $defaultValue
     * if not set.
     * 
     * @param string $name
     * @param string $defaultValue
     * @return string
     */
    public function getValueFor($name, $defaultValue = null)
    {
        if (!$this->hasParameter($name)) {
            return $defaultValue;
        }
        return $this->parameters[strtolower($name)]->getValue();
    }
}
