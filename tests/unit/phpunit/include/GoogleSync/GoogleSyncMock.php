<?php

require_once __DIR__ . '/../../../../../include/GoogleSync/GoogleSync.php';

/**
 * GoogleSyncMock
 *
 * @author gyula
 */
class GoogleSyncMock extends GoogleSync
{
    public function setProperty($key, $value)
    {
        $this->$key = $value;
    }
    
    public function getProperty($key)
    {
        if (!isset($this->$key)) {
            if (!isset(parent::$key)) {
                throw new Exception('Key is not set: ' . $key);
            }
            return parent::$key;
        }
        return $this->$key;
    }
    
    public function callMethod($name, $params = [])
    {
        if (!method_exists($this, $name)) {
            throw new Exception('Method is not exists: ' . $name);
        }
        $ret = call_user_func_array([$this, $name], (array)$params);
        return $ret;
    }
}
