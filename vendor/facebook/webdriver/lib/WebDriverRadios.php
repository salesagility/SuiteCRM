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

use Facebook\WebDriver\Exception\UnsupportedOperationException;
use Facebook\WebDriver\Exception\WebDriverException;

/**
 * Provides helper methods for radio buttons.
 */
class WebDriverRadios extends AbstractWebDriverCheckboxOrRadio
{
    public function __construct(WebDriverElement $element)
    {
        parent::__construct($element);

        $this->type = $element->getAttribute('type');
        if ($this->type !== 'radio') {
            throw new WebDriverException('The input must be of type "radio".');
        }
    }

    public function isMultiple()
    {
        return false;
    }

    public function deselectAll()
    {
        throw new UnsupportedOperationException('You cannot deselect radio buttons');
    }

    public function deselectByIndex($index)
    {
        throw new UnsupportedOperationException('You cannot deselect radio buttons');
    }

    public function deselectByValue($value)
    {
        throw new UnsupportedOperationException('You cannot deselect radio buttons');
    }

    public function deselectByVisibleText($text)
    {
        throw new UnsupportedOperationException('You cannot deselect radio buttons');
    }

    public function deselectByVisiblePartialText($text)
    {
        throw new UnsupportedOperationException('You cannot deselect radio buttons');
    }
}
