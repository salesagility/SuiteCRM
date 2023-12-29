<?php

namespace Consolidation\Config\Util;

/**
 * Useful array utilities.
 */
class ArrayUtil
{
    /**
     * Merges arrays recursively while preserving.
     *
     * @param array $array1
     * @param array $array2
     *
     * @return array
     *
     * @see http://php.net/manual/en/function.array-merge-recursive.php#92195
     * @see https://github.com/grasmash/bolt/blob/robo-rebase/src/Robo/Common/ArrayManipulator.php#L22
     */
    public static function mergeRecursiveDistinct(
        array &$array1,
        array &$array2
    ) {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            $merged[$key] = self::mergeRecursiveValue($merged, $key, $value);
        }
        return $merged;
    }

    /**
     * Process the value in an mergeRecursiveDistinct - make a recursive
     * call if needed.
     *
     * @param array $merged
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    protected static function mergeRecursiveValue(&$merged, $key, $value)
    {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            return self::mergeRecursiveDistinct($merged[$key], $value);
        }
        return $value;
    }


    /**
     * Merges arrays recursively while preserving.
     *
     * @param array $array1
     * @param array $array2
     * @param array $selectionList
     * @param string $keyPrefix
     *
     * @return array
     *
     * @see http://php.net/manual/en/function.array-merge-recursive.php#92195
     * @see https://github.com/grasmash/bolt/blob/robo-rebase/src/Robo/Common/ArrayManipulator.php#L22
     */
    public static function mergeRecursiveSelect(
        array &$array1,
        array &$array2,
        array $selectionList,
        $keyPrefix = ''
    ) {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            $merged[$key] = self::mergeRecursiveSelectValue($merged, $key, $value, $selectionList, $keyPrefix);
        }
        return $merged;
    }

    /**
     * Process the value in an mergeRecursiveDistinct - make a recursive
     * call if needed.
     *
     * @param array $merged
     * @param string $key
     * @param mixed $value
     * @param array $selectionList
     * @param string $keyPrefix
     *
     * @return mixed
     */
    protected static function mergeRecursiveSelectValue(&$merged, $key, $value, $selectionList, $keyPrefix)
    {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            if (self::selectMerge($keyPrefix, $key, $selectionList)) {
                return array_merge_recursive($merged[$key], $value);
            } else {
                return self::mergeRecursiveSelect($merged[$key], $value, $selectionList, "{$keyPrefix}{$key}.");
            }
        }
        return $value;
    }

    /**
     * @param string $keyPrefix
     * @param string $key
     * @param array $selectionList
     *
     * @return bool
     */
    protected static function selectMerge($keyPrefix, $key, $selectionList)
    {
        return in_array("{$keyPrefix}{$key}", $selectionList);
    }


    /**
     * Fills all of the leaf-node values of a nested array with the
     * provided replacement value.
     *
     * @param array $data
     * @param mixed $fill
     *
     * @return array
     */
    public static function fillRecursive(array $data, $fill)
    {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = $fill;
            if (self::isAssociative($value)) {
                $result[$key] = self::fillRecursive($value, $fill);
            }
        }
        return $result;
    }

    /**
     * Return true if the provided parameter is an array, and at least
     * one key is non-numeric.
     *
     * @param mixed $testArray
     *
     * @return bool
     */
    public static function isAssociative($testArray)
    {
        if (!is_array($testArray)) {
            return false;
        }
        foreach (array_keys($testArray) as $key) {
            if (!is_numeric($key)) {
                return true;
            }
        }
        return false;
    }
}
