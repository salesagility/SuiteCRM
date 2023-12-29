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

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Interactions\WebDriverActions;
use Facebook\WebDriver\JavaScriptExecutor;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverCapabilities;
use Facebook\WebDriver\WebDriverCommandExecutor;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverHasInputDevices;
use Facebook\WebDriver\WebDriverNavigation;
use Facebook\WebDriver\WebDriverOptions;
use Facebook\WebDriver\WebDriverWait;

class RemoteWebDriver implements WebDriver, JavaScriptExecutor, WebDriverHasInputDevices
{
    /**
     * @var HttpCommandExecutor|null
     */
    protected $executor;
    /**
     * @var WebDriverCapabilities
     */
    protected $capabilities;

    /**
     * @var string
     */
    protected $sessionID;
    /**
     * @var RemoteMouse
     */
    protected $mouse;
    /**
     * @var RemoteKeyboard
     */
    protected $keyboard;
    /**
     * @var RemoteTouchScreen
     */
    protected $touch;
    /**
     * @var RemoteExecuteMethod
     */
    protected $executeMethod;

    /**
     * @param HttpCommandExecutor $commandExecutor
     * @param string $sessionId
     * @param WebDriverCapabilities|null $capabilities
     */
    protected function __construct(
        HttpCommandExecutor $commandExecutor,
        $sessionId,
        WebDriverCapabilities $capabilities = null
    ) {
        $this->executor = $commandExecutor;
        $this->sessionID = $sessionId;

        if ($capabilities !== null) {
            $this->capabilities = $capabilities;
        }
    }

    /**
     * Construct the RemoteWebDriver by a desired capabilities.
     *
     * @param string $selenium_server_url The url of the remote Selenium WebDriver server
     * @param DesiredCapabilities|array $desired_capabilities The desired capabilities
     * @param int|null $connection_timeout_in_ms Set timeout for the connect phase to remote Selenium WebDriver server
     * @param int|null $request_timeout_in_ms Set the maximum time of a request to remote Selenium WebDriver server
     * @param string|null $http_proxy The proxy to tunnel requests to the remote Selenium WebDriver through
     * @param int|null $http_proxy_port The proxy port to tunnel requests to the remote Selenium WebDriver through
     * @param DesiredCapabilities $required_capabilities The required capabilities
     * @return static
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
        $selenium_server_url = preg_replace('#/+$#', '', $selenium_server_url);

        $desired_capabilities = self::castToDesiredCapabilitiesObject($desired_capabilities);

        // Hotfix: W3C WebDriver protocol is not yet supported by php-webdriver, so we must force Chromedriver to
        // not use the W3C protocol by default (which is what Chromedriver does starting with version 75).
        if ($desired_capabilities->getBrowserName() === WebDriverBrowserType::CHROME
            && mb_strpos($selenium_server_url, 'browserstack') === false // see https://github.com/facebook/php-webdriver/issues/644
        ) {
            $currentChromeOptions = $desired_capabilities->getCapability(ChromeOptions::CAPABILITY);
            $chromeOptions = !empty($currentChromeOptions) ? $currentChromeOptions : new ChromeOptions();

            if ($chromeOptions instanceof ChromeOptions && !isset($chromeOptions->toArray()['w3c'])) {
                $chromeOptions->setExperimentalOption('w3c', false);
            } elseif (is_array($chromeOptions) && !isset($chromeOptions['w3c'])) {
                $chromeOptions['w3c'] = false;
            }

            $desired_capabilities->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);
        }

        $executor = new HttpCommandExecutor($selenium_server_url, $http_proxy, $http_proxy_port);
        if ($connection_timeout_in_ms !== null) {
            $executor->setConnectionTimeout($connection_timeout_in_ms);
        }
        if ($request_timeout_in_ms !== null) {
            $executor->setRequestTimeout($request_timeout_in_ms);
        }

        if ($required_capabilities !== null) {
            // TODO: Selenium (as of v3.0.1) does accept requiredCapabilities only as a property of desiredCapabilities.
            // This will probably change in future with the W3C WebDriver spec, but is the only way how to pass these
            // values now.
            $desired_capabilities->setCapability('requiredCapabilities', $required_capabilities->toArray());
        }

        $command = new WebDriverCommand(
            null,
            DriverCommand::NEW_SESSION,
            ['desiredCapabilities' => $desired_capabilities->toArray()]
        );

        $response = $executor->execute($command);
        $returnedCapabilities = new DesiredCapabilities($response->getValue());

        $driver = new static($executor, $response->getSessionID(), $returnedCapabilities);

        return $driver;
    }

    /**
     * [Experimental] Construct the RemoteWebDriver by an existing session.
     *
     * This constructor can boost the performance a lot by reusing the same browser for the whole test suite.
     * You cannot pass the desired capabilities because the session was created before.
     *
     * @param string $selenium_server_url The url of the remote Selenium WebDriver server
     * @param string $session_id The existing session id
     * @param int|null $connection_timeout_in_ms Set timeout for the connect phase to remote Selenium WebDriver server
     * @param int|null $request_timeout_in_ms Set the maximum time of a request to remote Selenium WebDriver server
     * @return static
     */
    public static function createBySessionID(
        $session_id,
        $selenium_server_url = 'http://localhost:4444/wd/hub',
        $connection_timeout_in_ms = null,
        $request_timeout_in_ms = null
    ) {
        $executor = new HttpCommandExecutor($selenium_server_url);
        if ($connection_timeout_in_ms !== null) {
            $executor->setConnectionTimeout($connection_timeout_in_ms);
        }
        if ($request_timeout_in_ms !== null) {
            $executor->setRequestTimeout($request_timeout_in_ms);
        }

        return new static($executor, $session_id);
    }

    /**
     * Close the current window.
     *
     * @return RemoteWebDriver The current instance.
     */
    public function close()
    {
        $this->execute(DriverCommand::CLOSE, []);

        return $this;
    }

    /**
     * Find the first WebDriverElement using the given mechanism.
     *
     * @param WebDriverBy $by
     * @return RemoteWebElement NoSuchElementException is thrown in HttpCommandExecutor if no element is found.
     * @see WebDriverBy
     */
    public function findElement(WebDriverBy $by)
    {
        $params = ['using' => $by->getMechanism(), 'value' => $by->getValue()];
        $raw_element = $this->execute(
            DriverCommand::FIND_ELEMENT,
            $params
        );

        return $this->newElement($raw_element['ELEMENT']);
    }

    /**
     * Find all WebDriverElements within the current page using the given mechanism.
     *
     * @param WebDriverBy $by
     * @return RemoteWebElement[] A list of all WebDriverElements, or an empty array if nothing matches
     * @see WebDriverBy
     */
    public function findElements(WebDriverBy $by)
    {
        $params = ['using' => $by->getMechanism(), 'value' => $by->getValue()];
        $raw_elements = $this->execute(
            DriverCommand::FIND_ELEMENTS,
            $params
        );

        $elements = [];
        foreach ($raw_elements as $raw_element) {
            $elements[] = $this->newElement($raw_element['ELEMENT']);
        }

        return $elements;
    }

    /**
     * Load a new web page in the current browser window.
     *
     * @param string $url
     *
     * @return RemoteWebDriver The current instance.
     */
    public function get($url)
    {
        $params = ['url' => (string) $url];
        $this->execute(DriverCommand::GET, $params);

        return $this;
    }

    /**
     * Get a string representing the current URL that the browser is looking at.
     *
     * @return string The current URL.
     */
    public function getCurrentURL()
    {
        return $this->execute(DriverCommand::GET_CURRENT_URL);
    }

    /**
     * Get the source of the last loaded page.
     *
     * @return string The current page source.
     */
    public function getPageSource()
    {
        return $this->execute(DriverCommand::GET_PAGE_SOURCE);
    }

    /**
     * Get the title of the current page.
     *
     * @return string The title of the current page.
     */
    public function getTitle()
    {
        return $this->execute(DriverCommand::GET_TITLE);
    }

    /**
     * Return an opaque handle to this window that uniquely identifies it within this driver instance.
     *
     * @return string The current window handle.
     */
    public function getWindowHandle()
    {
        return $this->execute(
            DriverCommand::GET_CURRENT_WINDOW_HANDLE,
            []
        );
    }

    /**
     * Get all window handles available to the current session.
     *
     * @return array An array of string containing all available window handles.
     */
    public function getWindowHandles()
    {
        return $this->execute(DriverCommand::GET_WINDOW_HANDLES, []);
    }

    /**
     * Quits this driver, closing every associated window.
     */
    public function quit()
    {
        $this->execute(DriverCommand::QUIT);
        $this->executor = null;
    }

    /**
     * Inject a snippet of JavaScript into the page for execution in the context of the currently selected frame.
     * The executed script is assumed to be synchronous and the result of evaluating the script will be returned.
     *
     * @param string $script The script to inject.
     * @param array $arguments The arguments of the script.
     * @return mixed The return value of the script.
     */
    public function executeScript($script, array $arguments = [])
    {
        $params = [
            'script' => $script,
            'args' => $this->prepareScriptArguments($arguments),
        ];

        return $this->execute(DriverCommand::EXECUTE_SCRIPT, $params);
    }

    /**
     * Inject a snippet of JavaScript into the page for asynchronous execution in the context of the currently selected
     * frame.
     *
     * The driver will pass a callback as the last argument to the snippet, and block until the callback is invoked.
     *
     * You may need to define script timeout using `setScriptTimeout()` method of `WebDriverTimeouts` first.
     *
     * @param string $script The script to inject.
     * @param array $arguments The arguments of the script.
     * @return mixed The value passed by the script to the callback.
     */
    public function executeAsyncScript($script, array $arguments = [])
    {
        $params = [
            'script' => $script,
            'args' => $this->prepareScriptArguments($arguments),
        ];

        return $this->execute(
            DriverCommand::EXECUTE_ASYNC_SCRIPT,
            $params
        );
    }

    /**
     * Take a screenshot of the current page.
     *
     * @param string $save_as The path of the screenshot to be saved.
     * @return string The screenshot in PNG format.
     */
    public function takeScreenshot($save_as = null)
    {
        $screenshot = base64_decode(
            $this->execute(DriverCommand::SCREENSHOT)
        );
        if ($save_as) {
            file_put_contents($save_as, $screenshot);
        }

        return $screenshot;
    }

    /**
     * Construct a new WebDriverWait by the current WebDriver instance.
     * Sample usage:
     *
     * ```
     *   $driver->wait(20, 1000)->until(
     *     WebDriverExpectedCondition::titleIs('WebDriver Page')
     *   );
     * ```
     * @param int $timeout_in_second
     * @param int $interval_in_millisecond
     *
     * @return WebDriverWait
     */
    public function wait($timeout_in_second = 30, $interval_in_millisecond = 250)
    {
        return new WebDriverWait(
            $this,
            $timeout_in_second,
            $interval_in_millisecond
        );
    }

    /**
     * An abstraction for managing stuff you would do in a browser menu. For example, adding and deleting cookies.
     *
     * @return WebDriverOptions
     */
    public function manage()
    {
        return new WebDriverOptions($this->getExecuteMethod());
    }

    /**
     * An abstraction allowing the driver to access the browser's history and to navigate to a given URL.
     *
     * @return WebDriverNavigation
     * @see WebDriverNavigation
     */
    public function navigate()
    {
        return new WebDriverNavigation($this->getExecuteMethod());
    }

    /**
     * Switch to a different window or frame.
     *
     * @return RemoteTargetLocator
     * @see RemoteTargetLocator
     */
    public function switchTo()
    {
        return new RemoteTargetLocator($this->getExecuteMethod(), $this);
    }

    /**
     * @return RemoteMouse
     */
    public function getMouse()
    {
        if (!$this->mouse) {
            $this->mouse = new RemoteMouse($this->getExecuteMethod());
        }

        return $this->mouse;
    }

    /**
     * @return RemoteKeyboard
     */
    public function getKeyboard()
    {
        if (!$this->keyboard) {
            $this->keyboard = new RemoteKeyboard($this->getExecuteMethod());
        }

        return $this->keyboard;
    }

    /**
     * @return RemoteTouchScreen
     */
    public function getTouch()
    {
        if (!$this->touch) {
            $this->touch = new RemoteTouchScreen($this->getExecuteMethod());
        }

        return $this->touch;
    }

    /**
     * Construct a new action builder.
     *
     * @return WebDriverActions
     */
    public function action()
    {
        return new WebDriverActions($this);
    }

    /**
     * Set the command executor of this RemoteWebdriver
     *
     * @deprecated To be removed in the future. Executor should be passed in the constructor.
     * @internal
     * @codeCoverageIgnore
     * @param WebDriverCommandExecutor $executor Despite the typehint, it have be an instance of HttpCommandExecutor.
     * @return RemoteWebDriver
     */
    public function setCommandExecutor(WebDriverCommandExecutor $executor)
    {
        $this->executor = $executor;

        return $this;
    }

    /**
     * Get the command executor of this RemoteWebdriver
     *
     * @return HttpCommandExecutor
     */
    public function getCommandExecutor()
    {
        return $this->executor;
    }

    /**
     * Set the session id of the RemoteWebDriver.
     *
     * @deprecated To be removed in the future. Session ID should be passed in the constructor.
     * @internal
     * @codeCoverageIgnore
     * @param string $session_id
     * @return RemoteWebDriver
     */
    public function setSessionID($session_id)
    {
        $this->sessionID = $session_id;

        return $this;
    }

    /**
     * Get current selenium sessionID
     *
     * @return string
     */
    public function getSessionID()
    {
        return $this->sessionID;
    }

    /**
     * Get capabilities of the RemoteWebDriver.
     *
     * @return WebDriverCapabilities
     */
    public function getCapabilities()
    {
        return $this->capabilities;
    }

    /**
     * Returns a list of the currently active sessions.
     *
     * @param string $selenium_server_url The url of the remote Selenium WebDriver server
     * @param int $timeout_in_ms
     * @return array
     */
    public static function getAllSessions($selenium_server_url = 'http://localhost:4444/wd/hub', $timeout_in_ms = 30000)
    {
        $executor = new HttpCommandExecutor($selenium_server_url);
        $executor->setConnectionTimeout($timeout_in_ms);

        $command = new WebDriverCommand(
            null,
            DriverCommand::GET_ALL_SESSIONS,
            []
        );

        return $executor->execute($command)->getValue();
    }

    public function execute($command_name, $params = [])
    {
        $command = new WebDriverCommand(
            $this->sessionID,
            $command_name,
            $params
        );

        if ($this->executor) {
            $response = $this->executor->execute($command);

            return $response->getValue();
        }

        return null;
    }

    /**
     * Prepare arguments for JavaScript injection
     *
     * @param array $arguments
     * @return array
     */
    protected function prepareScriptArguments(array $arguments)
    {
        $args = [];
        foreach ($arguments as $key => $value) {
            if ($value instanceof WebDriverElement) {
                $args[$key] = ['ELEMENT' => $value->getID()];
            } else {
                if (is_array($value)) {
                    $value = $this->prepareScriptArguments($value);
                }
                $args[$key] = $value;
            }
        }

        return $args;
    }

    /**
     * @return RemoteExecuteMethod
     */
    protected function getExecuteMethod()
    {
        if (!$this->executeMethod) {
            $this->executeMethod = new RemoteExecuteMethod($this);
        }

        return $this->executeMethod;
    }

    /**
     * Return the WebDriverElement with the given id.
     *
     * @param string $id The id of the element to be created.
     * @return RemoteWebElement
     */
    protected function newElement($id)
    {
        return new RemoteWebElement($this->getExecuteMethod(), $id);
    }

    /**
     * Cast legacy types (array or null) to DesiredCapabilities object. To be removed in future when instance of
     * DesiredCapabilities will be required.
     *
     * @param array|DesiredCapabilities|null $desired_capabilities
     * @return DesiredCapabilities
     */
    protected static function castToDesiredCapabilitiesObject($desired_capabilities = null)
    {
        if ($desired_capabilities === null) {
            return new DesiredCapabilities();
        }

        if (is_array($desired_capabilities)) {
            return new DesiredCapabilities($desired_capabilities);
        }

        return $desired_capabilities;
    }
}
