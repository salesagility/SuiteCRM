<?php
namespace Flow\JSONPath\Filters;

use Flow\JSONPath\JSONPath;
use Flow\JSONPath\JSONPathException;
use Flow\JSONPath\JSONPathToken;

abstract class AbstractFilter
{
    /**
     * @var JSONPathToken
     */
    protected $token;

    /** @var  int */
    protected $options;

    /** @var  bool */
    protected $magicIsAllowed;

    public function __construct(JSONPathToken $token, $options = 0)
    {
        $this->token = $token;
        $this->options = $options;
        $this->magicIsAllowed = $this->options & JSONPath::ALLOW_MAGIC;
    }

    public function isMagicAllowed()
    {
        return $this->magicIsAllowed;
    }

    /**
     * @param $collection
     * @return array
     */
    abstract public function filter($collection);
}
 