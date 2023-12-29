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

namespace Facebook\WebDriver\Support;

class XPathEscaper
{
    /**
     * Converts xpath strings with both quotes and ticks into:
     *   `foo'"bar` -> `concat('foo', "'" ,'"bar')`
     *
     * @param string $xpathToEscape The xpath to be converted.
     * @return string The escaped string.
     */
    public static function escapeQuotes($xpathToEscape)
    {
        // Single quotes not present => we can quote in them
        if (mb_strpos($xpathToEscape, "'") === false) {
            return sprintf("'%s'", $xpathToEscape);
        }

        // Double quotes not present => we can quote in them
        if (mb_strpos($xpathToEscape, '"') === false) {
            return sprintf('"%s"', $xpathToEscape);
        }

        // Both single and double quotes are present
        return sprintf(
            "concat('%s')",
            str_replace("'", "', \"'\" ,'", $xpathToEscape)
        );
    }
}
