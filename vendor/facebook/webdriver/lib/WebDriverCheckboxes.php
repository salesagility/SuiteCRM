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

/**
 * Provides helper methods for checkboxes.
 */
class WebDriverCheckboxes extends AbstractWebDriverCheckboxOrRadio
{
    public function __construct(WebDriverElement $element)
    {
        parent::__construct($element);

        $this->type = $element->getAttribute('type');
        if ($this->type !== 'checkbox') {
            throw new WebDriverException('The input must be of type "checkbox".');
        }
    }

    public function isMultiple()
    {
        return true;
    }

    public function deselectAll()
    {
        foreach ($this->getRelatedElements() as $checkbox) {
            $this->deselectOption($checkbox);
        }
    }

    public function deselectByIndex($index)
    {
        $this->byIndex($index, false);
    }

    public function deselectByValue($value)
    {
        $this->byValue($value, false);
    }

    public function deselectByVisibleText($text)
    {
        $this->byVisibleText($text, false, false);
    }

    public function deselectByVisiblePartialText($text)
    {
        $this->byVisibleText($text, true, false);
    }
}
