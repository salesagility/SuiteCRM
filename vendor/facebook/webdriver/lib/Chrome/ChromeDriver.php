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

namespace Facebook\WebDriver\Chrome;

use Facebook\WebDriver\Exception\WebDriverException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\DriverCommand;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\Service\DriverCommandExecutor;
use Facebook\WebDriver\Remote\WebDriverCommand;

class ChromeDriver extends RemoteWebDriver
{
    /**
     * @return static
     */
    public static function start(DesiredCapabilities $desired_capabilities = null, ChromeDriverService $service = null)
    {
        if ($desired_capabilities === null) {
            $desired_capabilities = DesiredCapabilities::chrome();
        }
        if ($service === null) {
            $service = ChromeDriverService::createDefaultService();
        }
        $executor = new DriverCommandExecutor($service);
        $driver = new static($executor, null, $desired_capabilities);
        $driver->startSession($desired_capabilities);

        return $driver;
    }

    public function startSession(DesiredCapabilities $desired_capabilities)
    {
        $command = new WebDriverCommand(
            null,
            DriverCommand::NEW_SESSION,
            [
                'desiredCapabilities' => $desired_capabilities->toArray(),
            ]
        );
        $response = $this->executor->execute($command);
        $this->sessionID = $response->getSessionID();
    }

    /**
     * Always throws an exception. Use ChromeDriver::start() instead.
     *
     * @param string $selenium_server_url
     * @param DesiredCapabilities|array $desired_capabilities
     * @param int|null $connection_timeout_in_ms
     * @param int|null $request_timeout_in_ms
     * @param string|null $http_proxy
     * @param int|null $http_proxy_port
     * @param DesiredCapabilities $required_capabilities
     * @throws WebDriverException
     * @return RemoteWebDriver
     */
    public static function create(
        $selenium_server_url = 'http://localhost:4444/wd/hub',
        $desired_capabilities = null,
        $connection_timeout_in_ms = null,
        $request_timeout_in_ms = null,
        $http_proxy = null,
        $http_proxy_port = null,
        DesiredCapabilities $required_capabilities = null
    ) {
        throw new WebDriverException('Please use ChromeDriver::start() instead.');
    }

    /**
     * Always throws an exception. Use ChromeDriver::start() instead.
     *
     * @param string $session_id The existing session id
     * @param string $selenium_server_url The url of the remote Selenium WebDriver server
     * @param int|null $connection_timeout_in_ms Set timeout for the connect phase to remote Selenium WebDriver server
     * @param int|null $request_timeout_in_ms Set the maximum time of a request to remote Selenium WebDriver server
     * @throws WebDriverException
     * @return RemoteWebDriver|void
     */
    public static function createBySessionID(
        $session_id,
        $selenium_server_url = 'http://localhost:4444/wd/hub',
        $connection_timeout_in_ms = null,
        $request_timeout_in_ms = null
    ) {
        throw new WebDriverException('Please use ChromeDriver::start() instead.');
    }
}
