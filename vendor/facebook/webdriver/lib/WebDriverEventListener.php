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

use Facebook\WebDriver\Exception\WebDriverException;
use Facebook\WebDriver\Support\Events\EventFiringWebDriver;
use Facebook\WebDriver\Support\Events\EventFiringWebElement;

interface WebDriverEventListener
{
    /**
     * @param string $url
     * @param EventFiringWebDriver $driver
     */
    public function beforeNavigateTo($url, EventFiringWebDriver $driver);

    /**
     * @param string $url
     * @param EventFiringWebDriver $driver
     */
    public function afterNavigateTo($url, EventFiringWebDriver $driver);

    /**
     * @param EventFiringWebDriver $driver
     */
    public function beforeNavigateBack(EventFiringWebDriver $driver);

    /**
     * @param EventFiringWebDriver $driver
     */
    public function afterNavigateBack(EventFiringWebDriver $driver);

    /**
     * @param EventFiringWebDriver $driver
     */
    public function beforeNavigateForward(EventFiringWebDriver $driver);

    /**
     * @param EventFiringWebDriver $driver
     */
    public function afterNavigateForward(EventFiringWebDriver $driver);

    /**
     * @param WebDriverBy $by
     * @param EventFiringWebElement|null $element
     * @param EventFiringWebDriver $driver
     */
    public function beforeFindBy(WebDriverBy $by, $element, EventFiringWebDriver $driver);

    /**
     * @param WebDriverBy $by
     * @param EventFiringWebElement|null $element
     * @param EventFiringWebDriver $driver
     */
    public function afterFindBy(WebDriverBy $by, $element, EventFiringWebDriver $driver);

    /**
     * @param string $script
     * @param EventFiringWebDriver $driver
     */
    public function beforeScript($script, EventFiringWebDriver $driver);

    /**
     * @param string $script
     * @param EventFiringWebDriver $driver
     */
    public function afterScript($script, EventFiringWebDriver $driver);

    /**
     * @param EventFiringWebElement $element
     */
    public function beforeClickOn(EventFiringWebElement $element);

    /**
     * @param EventFiringWebElement $element
     */
    public function afterClickOn(EventFiringWebElement $element);

    /**
     * @param EventFiringWebElement $element
     */
    public function beforeChangeValueOf(EventFiringWebElement $element);

    /**
     * @param EventFiringWebElement $element
     */
    public function afterChangeValueOf(EventFiringWebElement $element);

    /**
     * @param WebDriverException $exception
     * @param EventFiringWebDriver $driver
     */
    public function onException(WebDriverException $exception, EventFiringWebDriver $driver = null);
}
