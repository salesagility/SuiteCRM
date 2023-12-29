<?php

namespace Consolidation\Config\Util;

use Consolidation\Config\ConfigInterface;

/**
 * Provides configuration objects with an 'interpolate' method
 * that may be used to inject config values into tokens embedded
 * in strings..
 */
class Interpolator
{
    /**
     * interpolate replaces tokens in a string with the correspnding
     * value from this config object. Tokens are surrounded by double
     * curley braces, e.g. "{{key}}".
     *
     * Example:
     * If the message is 'Hello, {{user.name}}', then the key user.name
     * is fetched from the config object, and the token {{user.name}} is
     * replaced with the result.
     *
     * @param array|\Consolidation\Config\ConfigInterface $data
     * @param string $message
     *   Message containing tokens to be replaced.
     * @param string|bool $default
     *   The value to substitute for tokens that are not found in the
     *   configuration. If `false`, then missing tokens are not replaced.
     *
     * @return string
     */
    public function interpolate($data, $message, $default = '')
    {
        $replacements = $this->replacements($data, $message, $default);
        return strtr($message, $replacements);
    }

    public function mustInterpolate($data, $message)
    {
        $result = $this->interpolate($data, $message, false);
        $tokens = $this->findTokens($result);
        if (!empty($tokens)) {
            throw new \Exception('The following required keys were not found in configuration: ' . implode(',', $tokens));
        }
        return $result;
    }

    /**
     * Finds all of the tokens in the provided message.
     *
     * @param string $message
     *   String with tokens.
     *
     * @return string[]
     *   Map of token to key, e.g. {{key}} => key
     */
    public function findTokens($message)
    {
        if (!preg_match_all('#{{([a-zA-Z0-9._-]+)}}#', $message, $matches, PREG_SET_ORDER)) {
            return [];
        }
        $tokens = [];
        foreach ($matches as $matchSet) {
            [$sourceText, $key] = $matchSet;
            $tokens[$sourceText] = $key;
        }
        return $tokens;
    }

    /**
     * Replacements looks up all of the replacements in the configuration
     * object, given the token keys from the provided message. Keys that
     * do not exist in the configuration are replaced with the default value.
     *
     * @param array|\Consolidation\Config\ConfigInterface $data
     * @param string $message
     * @param mixed $default
     *
     * @return array
     */
    public function replacements($data, $message, $default = '')
    {
        $tokens = $this->findTokens($message);

        $replacements = [];
        foreach ($tokens as $sourceText => $key) {
            $replacementText = $this->get($data, $key, $default);
            if ($replacementText !== false) {
                    $replacements[$sourceText] = $replacementText;
            }
        }
        return $replacements;
    }

    /**
     * @param array|\Consolidation\Config\ConfigInterface $data
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    protected function get($data, $key, $default)
    {
        if (is_array($data)) {
            return array_key_exists($key, $data) ? $data[$key] : $default;
        }
        if ($data instanceof ConfigInterface) {
            return $data->get($key, $default);
        }
        throw new \Exception('Bad data type provided to Interpolator');
    }
}
