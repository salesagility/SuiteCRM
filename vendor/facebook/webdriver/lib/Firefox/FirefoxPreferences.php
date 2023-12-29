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

namespace Facebook\WebDriver\Firefox;

/**
 * Constants of common Firefox profile preferences (about:config values).
 * @see http://kb.mozillazine.org/Firefox_:_FAQs_:_About:config_Entries
 *
 * @codeCoverageIgnore
 */
class FirefoxPreferences
{
    /** @var string Port WebDriver uses to communicate with Firefox instance */
    const WEBDRIVER_FIREFOX_PORT = 'webdriver_firefox_port';
    /** @var string Should the reader view (FF 38+) be enabled? */
    const READER_PARSE_ON_LOAD_ENABLED = 'reader.parse-on-load.enabled';
    /** @var string Browser homepage */
    const BROWSER_STARTUP_HOMEPAGE = 'browser.startup.homepage';

    private function __construct()
    {
    }
}
