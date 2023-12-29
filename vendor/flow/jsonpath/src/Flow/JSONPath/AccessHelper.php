<?php
namespace Flow\JSONPath;

class AccessHelper
{
    public static function collectionKeys($collection)
    {
        if (is_object($collection)) {
            return array_keys(get_object_vars($collection));
        } else {
            return array_keys($collection);
        }
    }

    public static function isCollectionType($collection)
    {
        return is_array($collection) || is_object($collection);
    }

    public static function keyExists($collection, $key, $magicIsAllowed = false)
    {
        if ($magicIsAllowed && is_object($collection) && method_exists($collection, '__get')) {
            return true;
        }

        if (is_int($key) && $key < 0) {
            $key = abs((int)$key);
        }

        if (is_array($collection) || $collection instanceof \ArrayAccess) {
            return array_key_exists($key, $collection);
        } else if (is_object($collection)) {
            return property_exists($collection, $key);
        }

        return false;
    }

    public static function getValue($collection, $key, $magicIsAllowed = false)
    {
        if ($magicIsAllowed && is_object($collection) && method_exists($collection, '__get') && !$collection instanceof \ArrayAccess) {
            return $collection->__get($key);
        }

        if (is_object($collection) && !$collection instanceof \ArrayAccess) {
            return $collection->$key;
        }

        if (is_array($collection)) {
            if (is_int($key)) {
                return array_slice($collection, $key, 1, false)[0];
            } else {
                return $collection[$key];
            }
        }

        if (is_object($collection) && !$collection instanceof \ArrayAccess) {
            return $collection->$key;
        }

        /*
         * Find item in php collection by index
         * Written this way to handle instances ArrayAccess or Traversable objects
         */
        if (is_int($key)) {
            $i = 0;
            foreach ($collection as $val) {
                if ($i === $key) {
                    return $val;
                }
                $i += 1;
            }
            if ($key < 0) {
                $total = $i;
                $i = 0;
                foreach ($collection as $val) {
                    if ($i - $total === $key) {
                        return $val;
                    }
                    $i += 1;
                }
            }
        }

        // Finally, try anything
        return $collection[$key];
    }

    public static function setValue(&$collection, $key, $value)
    {
        if (is_object($collection) && ! $collection instanceof \ArrayAccess) {
            return $collection->$key = $value;
        } else {
            return $collection[$key] = $value;
        }
    }

    public static function unsetValue(&$collection, $key)
    {
        if (is_object($collection) && ! $collection instanceof \ArrayAccess) {
            unset($collection->$key);
        } else {
            unset($collection[$key]);
        }
    }

    public static function arrayValues($collection)
    {
        if (is_array($collection)) {
            return array_values($collection);
        } else if (is_object($collection)) {
            return array_values((array) $collection);
        }

        throw new JSONPathException("Invalid variable type for arrayValues");
    }

}
