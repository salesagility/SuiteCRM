<?php

namespace Consolidation\Config\Util;

use Consolidation\Config\ConfigInterface;

/**
 * Provides configuration objects with an 'interpolate' method
 * that may be used to inject config values into tokens embedded
 * in strings.
 */
interface ConfigInterpolatorInterface extends ConfigInterface
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
     * @param string $message
     *   Message containing tokens to be replaced.
     * @param string|bool $default
     *   The value to substitute for tokens that are not found in the
     *   configuration. If `false`, then missing tokens are not replaced.
     *
     * @return string
     */
    public function interpolate($message, $default = '');

    /**
     * mustInterpolate works exactly like interpolate, save for the fact
     * that an exception is thrown is any of the tokens are not replaced.
     */
    public function mustInterpolate($message);
}
