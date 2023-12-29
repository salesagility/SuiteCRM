<?php

namespace Robo\Common;

/**
 * Simplifies generating of configuration chanined methods.
 * You can only define configuration properties and use magic methods to set them.
 * Methods will be named the same way as properties.
 * * Boolean properties are switched on/off if no values is provided.
 * * Array properties can accept non-array values, in this case value will be appended to array.
 * You should also define phpdoc for methods.
 */
trait DynamicParams
{
    /**
     * @param string $property
     * @param array $args
     *
     * @return $this
     */
    public function __call($property, $args)
    {
        if (!property_exists($this, $property)) {
            throw new \RuntimeException("Property $property in task " . get_class($this) . ' does not exists');
        }

        // toggle boolean values
        if (!isset($args[0]) and (is_bool($this->$property))) {
            $this->$property = !$this->$property;
            return $this;
        }

        // append item to array
        if (is_array($this->$property)) {
            if (is_array($args[0])) {
                $this->$property = $args[0];
            } else {
                array_push($this->$property, $args[0]);
            }
            return $this;
        }

        $this->$property = $args[0];
        return $this;
    }
}
