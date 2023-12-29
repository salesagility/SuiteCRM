<?php

namespace Grasmash\YamlExpander;

use Dflydev\DotAccessData\Data;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Expander
 * @package Grasmash\YamlExpander
 */
class Expander
{

    /**
     * Parses a YAML string and expands property placeholders.
     *
     * Placeholders should formatted as ${parent.child}.
     *
     * @param string $yaml_string
     *   A string of YAML.
     * @param array $reference_array
     *   Optional. An array of reference values. This is not operated upon but is used as a
     *   reference to provide supplemental values for property expansion.
     *
     * @return array
     *   The modified array in which placeholders have been replaced with
     *   values.
     */
    public static function parse($yaml_string, $reference_array = [])
    {
        $array = Yaml::parse($yaml_string);
        return self::expandArrayProperties($array, $reference_array);
    }


    /**
     * Expands property placeholders in an array.
     *
     * Placeholders should formatted as ${parent.child}.
     *
     * @param array $array
     *   An array containing properties to expand.
     *
     * @return array
     *   The modified array in which placeholders have been replaced with
     *   values.
     */
    public static function expandArrayProperties($array, $reference_array = [])
    {
        $data = new Data($array);
        if ($reference_array) {
            $reference_data = new Data($reference_array);
            self::doExpandArrayProperties($data, $array, '', $reference_data);
        } else {
            self::doExpandArrayProperties($data, $array);
        }

        return $data->export();
    }

    /**
     * Performs the actual property expansion.
     *
     * @param Data $data
     *   A data object, containing the $array.
     * @param array $array
     *   The original, unmodified array.
     * @param string $parent_keys
     *   The parent keys of the current key in dot notation. This is used to
     *   track the absolute path to the current key in recursive cases.
     * @param Data|null $reference_data
     *   A reference data object. This is not operated upon but is used as a
     *   reference to provide supplemental values for property expansion.
     */
    protected static function doExpandArrayProperties(
        $data,
        $array,
        $parent_keys = '',
        $reference_data = null
    ) {
        foreach ($array as $key => $value) {
            // Boundary condition(s).
            if (is_null($value) || is_bool($value)) {
                continue;
            }
            // Recursive case.
            if (is_array($value)) {
                self::doExpandArrayProperties($data, $value, $parent_keys . "$key.", $reference_data);
            } // Base case.
            else {
                self::expandStringProperties($data, $parent_keys, $reference_data, $value, $key);
            }
        }
    }

    /**
     * Expand a single property.
     *
     * @param Data $data
     *   A data object, containing the $array.
     * @param string $parent_keys
     *   The parent keys of the current key in dot notation. This is used to
     *   track the absolute path to the current key in recursive cases.
     * @param Data|null $reference_data
     *   A reference data object. This is not operated upon but is used as a
     *   reference to provide supplemental values for property expansion.
     * @param string $value
     *   The unexpanded property value.
     * @param string $key
     *   The immediate key of the property.
     *
     * @return mixed
     */
    protected static function expandStringProperties(
        $data,
        $parent_keys,
        $reference_data,
        $value,
        $key
    ) {
        // We loop through all placeholders in a given string.
        // E.g., '${placeholder1} ${placeholder2}' requires two replacements.
        while (strpos($value, '${') !== false) {
            $original_value = $value;
            $value = preg_replace_callback(
                '/\$\{([^\$}]+)\}/',
                function ($matches) use ($data, $reference_data) {
                    return self::expandStringPropertiesCallback(
                        $matches,
                        $data,
                        $reference_data
                    );
                },
                $value
            );

            // If no replacement occurred at all, break to prevent
            // infinite loop.
            if ($original_value == $value) {
                break;
            }

            // Set value on $data object.
            if ($parent_keys) {
                $full_key = $parent_keys . "$key";
            } else {
                $full_key = $key;
            }
            $data->set($full_key, $value);
        }
        return $value;
    }

    /**
     * Expansion callback used by preg_replace_callback() in expandProperty().
     *
     * @param array $matches
     *   An array of matches created by preg_replace_callback().
     * @param Data $data
     *   A data object containing the complete array being operated upon.
     * @param Data|null $reference_data
     *   A reference data object. This is not operated upon but is used as a
     *   reference to provide supplemental values for property expansion.
     *
     * @return mixed
     */
    public static function expandStringPropertiesCallback(
        $matches,
        $data,
        $reference_data = null
    ) {
        $property_name = $matches[1];
        $unexpanded_value = $matches[0];

        // Use only values within the subject array's data.
        if (!$reference_data) {
            return self::expandProperty($property_name, $unexpanded_value, $data);
        } // Search both the subject array's data and the reference data for a value.
        else {
            return self::expandPropertyWithReferenceData(
                $property_name,
                $unexpanded_value,
                $data,
                $reference_data
            );
        }
    }

    /**
     * Searches both the subject data and the reference data for value.
     *
     * @param string $property_name
     *   The name of the value for which to search.
     * @param string $unexpanded_value
     *   The original, unexpanded value, containing the placeholder.
     * @param Data $data
     *   A data object containing the complete array being operated upon.
     * @param Data|null $reference_data
     *   A reference data object. This is not operated upon but is used as a
     *   reference to provide supplemental values for property expansion.
     *
     * @return string
     *   The expanded string.
     */
    public static function expandPropertyWithReferenceData(
        $property_name,
        $unexpanded_value,
        $data,
        $reference_data
    ) {
        $expanded_value = self::expandProperty(
            $property_name,
            $unexpanded_value,
            $data
        );
        // If the string was not changed using the subject data, try using
        // the reference data.
        if ($expanded_value == $unexpanded_value) {
            $expanded_value = self::expandProperty(
                $property_name,
                $unexpanded_value,
                $reference_data
            );
        }

        return $expanded_value;
    }

    /**
     * Searches a data object for a value.
     *
     * @param string $property_name
     *   The name of the value for which to search.
     * @param string $unexpanded_value
     *   The original, unexpanded value, containing the placeholder.
     * @param Data $data
     *   A data object containing possible replacement values.
     *
     * @return mixed
     */
    public static function expandProperty($property_name, $unexpanded_value, $data)
    {
        if (strpos($property_name, "env.") === 0 &&
          !$data->has($property_name)) {
            $env_key = substr($property_name, 4);
            if (getenv($env_key)) {
                $data->set($property_name, getenv($env_key));
            }
        }

        if (!$data->has($property_name)) {
            self::log("Property \${'$property_name'} could not be expanded.");
            return $unexpanded_value;
        } else {
            $expanded_value = $data->get($property_name);
            if (is_array($expanded_value)) {
                $expanded_value = Yaml::dump($expanded_value, 0);
                return $expanded_value;
            }
            self::log("Expanding property \${'$property_name'} => $expanded_value.");
            return $expanded_value;
        }
    }

    /**
     * @param $message
     */
    public static function log($message)
    {
        // print "$message\n";
    }
}
