<?php

namespace Robo\State;

/**
 * A State\Data object contains a "message" (the primary result) and a
 * data array (the persistent state). The message is transient, and does
 * not move into the persistent state unless explicitly copied there.
 */
class Data extends \ArrayObject
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @param string $message
     * @param array $data
     */
    public function __construct($message = '', $data = [])
    {
        $this->message = $message;
        parent::__construct($data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->getArrayCopy();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Merge another result into this result.  Data already
     * existing in this result takes precedence over the
     * data in the Result being merged.
     *
     * @param \Robo\State\Data $result
     *
     * @return $this
     */
    public function merge(Data $result)
    {
        $mergedData = $this->getArrayCopy() + $result->getArrayCopy();
        $this->exchangeArray($mergedData);
        return $this;
    }

    /**
     * Update the current data with the data provided in the parameter.
     * Provided data takes precedence.
     *
     * @param \ArrayObject $update
     *
     * @return $this
     */
    public function update(\ArrayObject $update)
    {
        $iterator = $update->getIterator();

        while ($iterator->valid()) {
            $this[$iterator->key()] = $iterator->current();
            $iterator->next();
        }

        return $this;
    }

    /**
     * Merge another result into this result.  Data already
     * existing in this result takes precedence over the
     * data in the Result being merged.
     *
     * $data['message'] is handled specially, and is appended
     * to $this->message if set.
     *
     * @param array $data
     *
     * @return array
     */
    public function mergeData(array $data)
    {
        $mergedData = $this->getArrayCopy() + $data;
        $this->exchangeArray($mergedData);
        return $mergedData;
    }

    /**
     * @return bool
     */
    public function hasExecutionTime()
    {
        return isset($this['time']);
    }

    /**
     * @return null|float
     */
    public function getExecutionTime()
    {
        if (!$this->hasExecutionTime()) {
            return null;
        }
        return $this['time'];
    }

    /**
     * Accumulate execution time
     *
     * @param array|float $duration
     *
     * @return null|float
     */
    public function accumulateExecutionTime($duration)
    {
        // Convert data arrays to scalar
        if (is_array($duration)) {
            $duration = isset($duration['time']) ? $duration['time'] : 0;
        }
        $this['time'] = $this->getExecutionTime() + $duration;
        return $this->getExecutionTime();
    }

    /**
     * Accumulate the message.
     *
     * @param string $message
     *
     * @return string
     */
    public function accumulateMessage($message)
    {
        if (!empty($this->message)) {
            $this->message .= "\n";
        }
        $this->message .= $message;
        return $this->getMessage();
    }
}
