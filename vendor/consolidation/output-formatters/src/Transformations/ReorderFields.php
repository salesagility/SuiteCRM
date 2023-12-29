<?php

namespace Consolidation\OutputFormatters\Transformations;

use Symfony\Component\Finder\Glob;
use Consolidation\OutputFormatters\Exception\UnknownFieldException;

/**
 * Reorder the field labels based on the user-selected fields
 * to display.
 */
class ReorderFields
{
    /**
     * Given a simple list of user-supplied field keys or field labels,
     * return a reordered version of the field labels matching the
     * user selection.
     *
     * @param string|array $fields The user-selected fields
     * @param array $fieldLabels An associative array mapping the field
     *   key to the field label
     * @param array $data The data that will be rendered.
     *
     * @return array
     */
    public function reorder($fields, $fieldLabels, $data)
    {
        $firstRow = reset($data);
        if (!$firstRow) {
            $firstRow = $fieldLabels;
        }
        if (empty($fieldLabels) && !empty($data)) {
            $fieldLabels = array_combine(array_keys($firstRow), array_map('ucfirst', array_keys($firstRow)));
        }
        $fields = $this->getSelectedFieldKeys($fields, $fieldLabels);
        if (empty($fields)) {
            return array_intersect_key($fieldLabels, $firstRow);
        }
        return $this->reorderFieldLabels($fields, $fieldLabels, $data);
    }

    protected function reorderFieldLabels($fields, $fieldLabels, $data)
    {
        $result = [];
        $firstRow = reset($data);
        if (!$firstRow) {
            $firstRow = $fieldLabels;
        }
        foreach ($fields as $field) {
            if (array_key_exists($field, $firstRow)) {
                if (array_key_exists($field, $fieldLabels)) {
                    $result[$field] = $fieldLabels[$field];
                }
            }
        }
        return $result;
    }

    protected function getSelectedFieldKeys($fields, $fieldLabels)
    {
        if (empty($fieldLabels)) {
            return [];
        }
        if (is_string($fields)) {
            $fields = explode(',', $fields);
        }
        $selectedFields = [];
        foreach ($fields as $field) {
            $matchedFields = $this->matchFieldInLabelMap($field, $fieldLabels);
            if (empty($matchedFields)) {
                throw new UnknownFieldException($field);
            }
            $selectedFields = array_merge($selectedFields, $matchedFields);
        }
        return $selectedFields;
    }

    protected function matchFieldInLabelMap($field, $fieldLabels)
    {
        $fieldRegex = $this->convertToRegex($field);
        return
            array_filter(
                array_keys($fieldLabels),
                function ($key) use ($fieldRegex, $fieldLabels) {
                    $value = $fieldLabels[$key];
                    return preg_match($fieldRegex, $value) || preg_match($fieldRegex, $key);
                }
            );
    }

    /**
     * Convert the provided string into a regex suitable for use in
     * preg_match.
     *
     * Matching occurs in the same way as the Symfony Finder component:
     * http://symfony.com/doc/current/components/finder.html#file-name
     */
    protected function convertToRegex($str)
    {
        return $this->isRegex($str) ? $str : Glob::toRegex($str);
    }

    /**
     * Checks whether the string is a regex.  This function is copied from
     * MultiplePcreFilterIterator in the Symfony Finder component.
     *
     * @param string $str
     *
     * @return bool Whether the given string is a regex
     */
    protected function isRegex($str)
    {
        if (preg_match('/^(.{3,}?)[imsxuADU]*$/', $str, $m)) {
            $start = substr($m[1], 0, 1);
            $end = substr($m[1], -1);

            if ($start === $end) {
                return !preg_match('/[*?[:alnum:] \\\\]/', $start);
            }

            foreach (array(array('{', '}'), array('(', ')'), array('[', ']'), array('<', '>')) as $delimiters) {
                if ($start === $delimiters[0] && $end === $delimiters[1]) {
                    return true;
                }
            }
        }

        return false;
    }
}
