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

namespace Facebook\WebDriver\Net;

use Exception;
use Facebook\WebDriver\Exception\TimeOutException;

class URLChecker
{
    const POLL_INTERVAL_MS = 500;
    const CONNECT_TIMEOUT_MS = 500;

    public function waitUntilAvailable($timeout_in_ms, $url)
    {
        $end = microtime(true) + $timeout_in_ms / 1000;

        while ($end > microtime(true)) {
            if ($this->getHTTPResponseCode($url) === 200) {
                return $this;
            }
            usleep(self::POLL_INTERVAL_MS);
        }

        throw new TimeOutException(sprintf(
            'Timed out waiting for %s to become available after %d ms.',
            $url,
            $timeout_in_ms
        ));
    }

    public function waitUntilUnavailable($timeout_in_ms, $url)
    {
        $end = microtime(true) + $timeout_in_ms / 1000;

        while ($end > microtime(true)) {
            if ($this->getHTTPResponseCode($url) !== 200) {
                return $this;
            }
            usleep(self::POLL_INTERVAL_MS);
        }

        throw new TimeOutException(sprintf(
            'Timed out waiting for %s to become unavailable after %d ms.',
            $url,
            $timeout_in_ms
        ));
    }

    private function getHTTPResponseCode($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // The PHP doc indicates that CURLOPT_CONNECTTIMEOUT_MS constant is added in cURL 7.16.2
        // available since PHP 5.2.3.
        if (!defined('CURLOPT_CONNECTTIMEOUT_MS')) {
            define('CURLOPT_CONNECTTIMEOUT_MS', 156);  // default value for CURLOPT_CONNECTTIMEOUT_MS
        }
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, self::CONNECT_TIMEOUT_MS);

        $code = null;
        try {
            curl_exec($ch);
            $info = curl_getinfo($ch);
            $code = $info['http_code'];
        } catch (Exception $e) {
        }
        curl_close($ch);

        return $code;
    }
}
