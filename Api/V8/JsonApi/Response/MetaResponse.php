<?php
namespace Api\V8\JsonApi\Response;

class MetaResponse implements \JsonSerializable
{
    /**
     * @var array
     */
    protected $properties = [];

    /**
     * Meta object can contain any properties.
     *
     * @param array $properties
     */
    public function __construct($properties = [])
    {
        if (!is_array($properties) && !$properties instanceof \stdClass) {
            throw new \InvalidArgumentException('The properties must be an array or sdtClass');
        }

        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->properties;
    }
}
