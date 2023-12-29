<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DriverCommand;
use Facebook\WebDriver\Remote\ExecuteMethod;
use InvalidArgumentException;

/**
 * Managing stuff you would do in a browser.
 */
class WebDriverOptions
{
    /**
     * @var ExecuteMethod
     */
    protected $executor;

    public function __construct(ExecuteMethod $executor)
    {
        $this->executor = $executor;
    }

    /**
     * Add a specific cookie.
     *
     * @see Cookie for description of possible cookie properties
     * @param Cookie|array $cookie Cookie object. May be also created from array for compatibility reasons.
     * @return WebDriverOptions The current instance.
     */
    public function addCookie($cookie)
    {
        if (is_array($cookie)) {
            $cookie = Cookie::createFromArray($cookie);
        }
        if (!$cookie instanceof Cookie) {
            throw new InvalidArgumentException('Cookie must be set from instance of Cookie class or from array.');
        }

        $this->executor->execute(
            DriverCommand::ADD_COOKIE,
            ['cookie' => $cookie->toArray()]
        );

        return $this;
    }

    /**
     * Delete all the cookies that are currently visible.
     *
     * @return WebDriverOptions The current instance.
     */
    public function deleteAllCookies()
    {
        $this->executor->execute(DriverCommand::DELETE_ALL_COOKIES);

        return $this;
    }

    /**
     * Delete the cookie with the give name.
     *
     * @param string $name
     * @return WebDriverOptions The current instance.
     */
    public function deleteCookieNamed($name)
    {
        $this->executor->execute(
            DriverCommand::DELETE_COOKIE,
            [':name' => $name]
        );

        return $this;
    }

    /**
     * Get the cookie with a given name.
     *
     * @param string $name
     * @return Cookie|null The cookie, or null if no cookie with the given name is presented.
     */
    public function getCookieNamed($name)
    {
        $cookies = $this->getCookies();
        foreach ($cookies as $cookie) {
            if ($cookie['name'] === $name) {
                return $cookie;
            }
        }

        return null;
    }

    /**
     * Get all the cookies for the current domain.
     *
     * @return Cookie[] The array of cookies presented.
     */
    public function getCookies()
    {
        $cookieArrays = $this->executor->execute(DriverCommand::GET_ALL_COOKIES);
        $cookies = [];

        foreach ($cookieArrays as $cookieArray) {
            $cookies[] = Cookie::createFromArray($cookieArray);
        }

        return $cookies;
    }

    /**
     * Return the interface for managing driver timeouts.
     *
     * @return WebDriverTimeouts
     */
    public function timeouts()
    {
        return new WebDriverTimeouts($this->executor);
    }

    /**
     * An abstraction allowing the driver to manipulate the browser's window
     *
     * @return WebDriverWindow
     * @see WebDriverWindow
     */
    public function window()
    {
        return new WebDriverWindow($this->executor);
    }

    /**
     * Get the log for a given log type. Log buffer is reset after each request.
     *
     * @param string $log_type The log type.
     * @return array The list of log entries.
     * @see https://github.com/SeleniumHQ/selenium/wiki/JsonWireProtocol#log-type
     */
    public function getLog($log_type)
    {
        return $this->executor->execute(
            DriverCommand::GET_LOG,
            ['type' => $log_type]
        );
    }

    /**
     * Get available log types.
     *
     * @return array The list of available log types.
     * @see https://github.com/SeleniumHQ/selenium/wiki/JsonWireProtocol#log-type
     */
    public function getAvailableLogTypes()
    {
        return $this->executor->execute(DriverCommand::GET_AVAILABLE_LOG_TYPES);
    }
}
