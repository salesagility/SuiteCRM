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

namespace Facebook\WebDriver\Remote;

use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Firefox\FirefoxDriver;
use Facebook\WebDriver\Firefox\FirefoxPreferences;
use Facebook\WebDriver\Firefox\FirefoxProfile;
use Facebook\WebDriver\WebDriverCapabilities;
use Facebook\WebDriver\WebDriverPlatform;

class DesiredCapabilities implements WebDriverCapabilities
{
    /**
     * @var array
     */
    private $capabilities;

    public function __construct(array $capabilities = [])
    {
        $this->capabilities = $capabilities;
    }

    /**
     * @return string The name of the browser.
     */
    public function getBrowserName()
    {
        return $this->get(WebDriverCapabilityType::BROWSER_NAME, '');
    }

    /**
     * @param string $browser_name
     * @return DesiredCapabilities
     */
    public function setBrowserName($browser_name)
    {
        $this->set(WebDriverCapabilityType::BROWSER_NAME, $browser_name);

        return $this;
    }

    /**
     * @return string The version of the browser.
     */
    public function getVersion()
    {
        return $this->get(WebDriverCapabilityType::VERSION, '');
    }

    /**
     * @param string $version
     * @return DesiredCapabilities
     */
    public function setVersion($version)
    {
        $this->set(WebDriverCapabilityType::VERSION, $version);

        return $this;
    }

    /**
     * @param string $name
     * @return mixed The value of a capability.
     */
    public function getCapability($name)
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return DesiredCapabilities
     */
    public function setCapability($name, $value)
    {
        $this->set($name, $value);

        return $this;
    }

    /**
     * @return string The name of the platform.
     */
    public function getPlatform()
    {
        return $this->get(WebDriverCapabilityType::PLATFORM, '');
    }

    /**
     * @param string $platform
     * @return DesiredCapabilities
     */
    public function setPlatform($platform)
    {
        $this->set(WebDriverCapabilityType::PLATFORM, $platform);

        return $this;
    }

    /**
     * @param string $capability_name
     * @return bool Whether the value is not null and not false.
     */
    public function is($capability_name)
    {
        return (bool) $this->get($capability_name);
    }

    /**
     * @todo Remove in next major release (BC)
     * @deprecated All browsers are always JS enabled except HtmlUnit and it's not meaningful to disable JS execution.
     * @return bool Whether javascript is enabled.
     */
    public function isJavascriptEnabled()
    {
        return $this->get(WebDriverCapabilityType::JAVASCRIPT_ENABLED, false);
    }

    /**
     * This is a htmlUnit-only option.
     *
     * @param bool $enabled
     * @throws Exception
     * @return DesiredCapabilities
     * @see https://github.com/SeleniumHQ/selenium/wiki/DesiredCapabilities#read-write-capabilities
     */
    public function setJavascriptEnabled($enabled)
    {
        $browser = $this->getBrowserName();
        if ($browser && $browser !== WebDriverBrowserType::HTMLUNIT) {
            throw new Exception(
                'isJavascriptEnabled() is a htmlunit-only option. ' .
                'See https://github.com/SeleniumHQ/selenium/wiki/DesiredCapabilities#read-write-capabilities.'
            );
        }

        $this->set(WebDriverCapabilityType::JAVASCRIPT_ENABLED, $enabled);

        return $this;
    }

    /**
     * @todo Remove side-effects - not change ie. ChromeOptions::CAPABILITY from instance of ChromeOptions to an array
     * @return array
     */
    public function toArray()
    {
        if (isset($this->capabilities[ChromeOptions::CAPABILITY]) &&
            $this->capabilities[ChromeOptions::CAPABILITY] instanceof ChromeOptions
        ) {
            $this->capabilities[ChromeOptions::CAPABILITY] =
                $this->capabilities[ChromeOptions::CAPABILITY]->toArray();
        }

        if (isset($this->capabilities[FirefoxDriver::PROFILE]) &&
            $this->capabilities[FirefoxDriver::PROFILE] instanceof FirefoxProfile
        ) {
            $this->capabilities[FirefoxDriver::PROFILE] =
                $this->capabilities[FirefoxDriver::PROFILE]->encode();
        }

        return $this->capabilities;
    }

    /**
     * @return static
     */
    public static function android()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::ANDROID,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::ANDROID,
        ]);
    }

    /**
     * @return static
     */
    public static function chrome()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::CHROME,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::ANY,
        ]);
    }

    /**
     * @return static
     */
    public static function firefox()
    {
        $caps = new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::FIREFOX,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::ANY,
        ]);

        // disable the "Reader View" help tooltip, which can hide elements in the window.document
        $profile = new FirefoxProfile();
        $profile->setPreference(FirefoxPreferences::READER_PARSE_ON_LOAD_ENABLED, false);
        $caps->setCapability(FirefoxDriver::PROFILE, $profile);

        return $caps;
    }

    /**
     * @return static
     */
    public static function htmlUnit()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::HTMLUNIT,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::ANY,
        ]);
    }

    /**
     * @return static
     */
    public static function htmlUnitWithJS()
    {
        $caps = new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::HTMLUNIT,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::ANY,
        ]);

        return $caps->setJavascriptEnabled(true);
    }

    /**
     * @return static
     */
    public static function internetExplorer()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::IE,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::WINDOWS,
        ]);
    }

    /**
     * @return static
     */
    public static function microsoftEdge()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::MICROSOFT_EDGE,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::WINDOWS,
        ]);
    }

    /**
     * @return static
     */
    public static function iphone()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::IPHONE,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::MAC,
        ]);
    }

    /**
     * @return static
     */
    public static function ipad()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::IPAD,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::MAC,
        ]);
    }

    /**
     * @return static
     */
    public static function opera()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::OPERA,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::ANY,
        ]);
    }

    /**
     * @return static
     */
    public static function safari()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::SAFARI,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::ANY,
        ]);
    }

    /**
     * @return static
     */
    public static function phantomjs()
    {
        return new static([
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS,
            WebDriverCapabilityType::PLATFORM => WebDriverPlatform::ANY,
        ]);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return DesiredCapabilities
     */
    private function set($key, $value)
    {
        $this->capabilities[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    private function get($key, $default = null)
    {
        return isset($this->capabilities[$key])
            ? $this->capabilities[$key]
            : $default;
    }
}
