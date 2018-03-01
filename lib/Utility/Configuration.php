<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 3/1/18
 * Time: 7:53 PM
 */

namespace SuiteCRM\Utility;


use SuiteCRM\Exception\Exception;

class Configuration implements \ArrayAccess
{

    private $container = array();

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        global $sugar_config;
        require_once 'modules/Configurator/Configurator.php';
        $configurator = new \Configurator();
        $this->container = $configurator->config;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws Exception
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            throw new Exception('[Configuration][missing offset]');
        }

        if (!isset($this->container[$offset])) {
            throw new Exception('[Configuration][not found]');
        }

        $this->container[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}