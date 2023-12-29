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

use Facebook\WebDriver\Exception\IndexOutOfBoundsException;
use Facebook\WebDriver\Remote\DriverCommand;
use Facebook\WebDriver\Remote\ExecuteMethod;

/**
 * An abstraction allowing the driver to manipulate the browser's window
 */
class WebDriverWindow
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
     * Get the position of the current window, relative to the upper left corner
     * of the screen.
     *
     * @return WebDriverPoint The current window position.
     */
    public function getPosition()
    {
        $position = $this->executor->execute(
            DriverCommand::GET_WINDOW_POSITION,
            [':windowHandle' => 'current']
        );

        return new WebDriverPoint(
            $position['x'],
            $position['y']
        );
    }

    /**
     * Get the size of the current window. This will return the outer window
     * dimension, not just the view port.
     *
     * @return WebDriverDimension The current window size.
     */
    public function getSize()
    {
        $size = $this->executor->execute(
            DriverCommand::GET_WINDOW_SIZE,
            [':windowHandle' => 'current']
        );

        return new WebDriverDimension(
            $size['width'],
            $size['height']
        );
    }

    /**
     * Maximizes the current window if it is not already maximized
     *
     * @return WebDriverWindow The instance.
     */
    public function maximize()
    {
        $this->executor->execute(
            DriverCommand::MAXIMIZE_WINDOW,
            [':windowHandle' => 'current']
        );

        return $this;
    }

    /**
     * Set the size of the current window. This will change the outer window
     * dimension, not just the view port.
     *
     * @param WebDriverDimension $size
     * @return WebDriverWindow The instance.
     */
    public function setSize(WebDriverDimension $size)
    {
        $params = [
            'width' => $size->getWidth(),
            'height' => $size->getHeight(),
            ':windowHandle' => 'current',
        ];
        $this->executor->execute(DriverCommand::SET_WINDOW_SIZE, $params);

        return $this;
    }

    /**
     * Set the position of the current window. This is relative to the upper left
     * corner of the screen.
     *
     * @param WebDriverPoint $position
     * @return WebDriverWindow The instance.
     */
    public function setPosition(WebDriverPoint $position)
    {
        $params = [
            'x' => $position->getX(),
            'y' => $position->getY(),
            ':windowHandle' => 'current',
        ];
        $this->executor->execute(DriverCommand::SET_WINDOW_POSITION, $params);

        return $this;
    }

    /**
     * Get the current browser orientation.
     *
     * @return string Either LANDSCAPE|PORTRAIT
     */
    public function getScreenOrientation()
    {
        return $this->executor->execute(DriverCommand::GET_SCREEN_ORIENTATION);
    }

    /**
     * Set the browser orientation. The orientation should either
     * LANDSCAPE|PORTRAIT
     *
     * @param string $orientation
     * @throws IndexOutOfBoundsException
     * @return WebDriverWindow The instance.
     */
    public function setScreenOrientation($orientation)
    {
        $orientation = mb_strtoupper($orientation);
        if (!in_array($orientation, ['PORTRAIT', 'LANDSCAPE'])) {
            throw new IndexOutOfBoundsException(
                'Orientation must be either PORTRAIT, or LANDSCAPE'
            );
        }

        $this->executor->execute(
            DriverCommand::SET_SCREEN_ORIENTATION,
            ['orientation' => $orientation]
        );

        return $this;
    }
}
