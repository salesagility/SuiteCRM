<?php
namespace GuzzleHttp\Ring\Future;

/**
 * Represents a future array that has been completed successfully.
 */
class CompletedFutureArray extends CompletedFutureValue implements FutureArrayInterface
{
    public function __construct(array $result)
    {
        parent::__construct($result);
    }

    #[\ReturnTypeWillChange]
    /**
     * @return bool 
     */
    public function offsetExists($offset)
    {
        return isset($this->result[$offset]);
    }

    #[\ReturnTypeWillChange]
    /**
     * @return mixed 
     */
    public function offsetGet($offset)
    {
        return $this->result[$offset];
    }

    #[\ReturnTypeWillChange]
    /**
     * @return void 
     */
    public function offsetSet($offset, $value)
    {
        $this->result[$offset] = $value;
    }

    #[\ReturnTypeWillChange]
    /**
     * @return void 
     */
    public function offsetUnset($offset)
    {
        unset($this->result[$offset]);
    }

    #[\ReturnTypeWillChange]
    /**
     * @return int 
     */
    public function count()
    {
        return count($this->result);
    }

    #[\ReturnTypeWillChange]
    /**
     * @return \ArrayIterator 
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->result);
    }
}
