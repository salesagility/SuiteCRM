<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2017, Hoa community. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Hoa\Console;

use Hoa\Consistency;
use Hoa\Event;

/**
 * Class \Hoa\Console\Mouse.
 *
 * Allow to listen the mouse.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Mouse implements Event\Listenable
{
    use Event\Listens;

    /**
     * Pointer code for left button.
     *
     * @const int
     */
    const BUTTON_LEFT    = 0;

    /**
     * Pointer code for the middle button.
     *
     * @const int
     */
    const BUTTON_MIDDLE  = 1;

    /**
     * Pointer code for the right button.
     *
     * @const int
     */
    const BUTTON_RIGHT   = 2;

    /**
     * Pointer code for the release of the button.
     *
     * @const int
     */
    const BUTTON_RELEASE = 3;

    /**
     * Pointer code for the wheel up.
     *
     * @const int
     */
    const WHEEL_UP       = 64;

    /**
     * Pointer code for the wheel down.
     *
     * @const int
     */
    const WHEEL_DOWN     = 65;

    /**
     * Singleton.
     *
     * @var \Hoa\Console\Mouse
     */
    protected static $_instance = null;

    /**
     * Whether the mouse is tracked or not.
     *
     * @var bool
     */
    protected static $_enabled  = false;



    /**
     * Constructor.
     *
     */
    private function __construct()
    {
        $this->setListener(
            new Event\Listener(
                $this,
                [
                    'mouseup',
                    'mousedown',
                    'wheelup',
                    'wheeldown',
                ]
            )
        );

        return;
    }

    /**
     * Singleton.
     *
     * @return  \Hoa\Console\Mouse
     */
    public static function getInstance()
    {
        if (null === static::$_instance) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    /**
     * Track the mouse.
     *
     * @return  bool
     */
    public static function track()
    {
        if (true === static::$_enabled) {
            return;
        }

        static::$_enabled = true;

        Console::getOutput()->writeAll(
            "\033[1;2'z" .
            "\033[?1000h" .
            "\033[?1003h"
        );

        $instance = static::getInstance();
        $bucket   = [
            'x'      => 0,
            'y'      => 0,
            'button' => null,
            'shift'  => false,
            'meta'   => false,
            'ctrl'   => false
        ];
        $input = Console::getInput();
        $read  = [$input->getStream()->getStream()];

        while (true) {
            if (false === @stream_select($read, $write, $except, 30)) {
                static::untrack();

                break;
            }

            $string = $input->readCharacter();

            if ("\033" !== $string) {
                continue;
            }

            $char = $input->readCharacter();

            if ('[' !== $char) {
                continue;
            }

            $char = $input->readCharacter();

            if ('M' !== $char) {
                continue;
            }

            $data = $input->read(3);
            $cb   = ord($data[0]);
            $cx   = ord($data[1]) - 32;
            $cy   = ord($data[2]) - 32;

            $bucket['x']     = $cx;
            $bucket['y']     = $cy;
            $bucket['shift'] = 0 !== ($cb &  4);
            $bucket['meta']  = 0 !== ($cb &  8);
            $bucket['ctrl']  = 0 !== ($cb & 16);

            $cb  = ($cb | 28) ^ 28; // 28 = 4 | 8 | 16
            $cb -= 32;

            switch ($cb) {
                case static::WHEEL_UP:
                    $instance->getListener()->fire(
                        'wheelup',
                        new Event\Bucket($bucket)
                    );

                    break;

                case static::WHEEL_DOWN:
                    $instance->getListener()->fire(
                        'wheeldown',
                        new Event\Bucket($bucket)
                    );

                    break;

                case static::BUTTON_RELEASE:
                    $instance->getListener()->fire(
                        'mouseup',
                        new Event\Bucket($bucket)
                    );
                    $bucket['button'] = null;

                    break;

                default:
                    if (static::BUTTON_LEFT === $cb) {
                        $bucket['button'] = 'left';
                    } elseif (static::BUTTON_MIDDLE === $cb) {
                        $bucket['button'] = 'middle';
                    } elseif (static::BUTTON_RIGHT === $cb) {
                        $bucket['button'] = 'right';
                    } else {
                        // hover
                        continue 2;
                    }

                    $instance->getListener()->fire(
                        'mousedown',
                        new Event\Bucket($bucket)
                    );
            }
        }

        return;
    }

    /**
     * Untrack the mouse.
     *
     * @return  void
     */
    public static function untrack()
    {
        if (false === static::$_enabled) {
            return;
        }

        Console::getOutput()->writeAll(
            "\033[?1003l" .
            "\033[?1000l"
        );

        static::$_enabled = false;

        return;
    }
}

/**
 * Advanced interaction.
 */
Console::advancedInteraction();

/**
 * Untrack mouse.
 */
Consistency::registerShutdownFunction(xcallable('Hoa\Console\Mouse::untrack'));
