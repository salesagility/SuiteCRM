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

namespace Hoa\Console\Test\Unit;

use Hoa\Console as LUT;
use Hoa\Console\Window as SUT;
use Hoa\File;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Window.
 *
 * Test suite of the window.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Window extends Test\Unit\Suite
{
    public function beforeTestMethod($methodName)
    {
        parent::beforeTestMethod($methodName);
        LUT::setTput(new LUT\Tput('hoa://Library/Console/Terminfo/78/xterm-256color'));

        return;
    }

    public function case_get_instance()
    {
        $this
            ->when($result = SUT::getInstance())
            ->then
                ->object($result)
                    ->isIdenticalTo(SUT::getInstance());
    }

    public function case_set_size()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::setSize(7, 42))
            ->then
                ->output
                    ->isEqualTo("\033[8;42;7t");
    }

    public function case_set_size_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::setSize(7, 42))
            ->then
                ->output
                    ->isEmpty();
    }

    public function case_move_to()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::moveTo(7, 42))
            ->then
                ->output
                    ->isEqualTo("\033[3;7;42t");
    }

    public function case_move_to_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::moveTo(7, 42))
            ->then
                ->output
                ->isEmpty();
    }

    public function case_get_position()
    {
        $this
            ->given(
                $this->constant->OS_WIN = false,

                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll("\033[3;7;42t"),
                $file->rewind(),
                $input  = LUT::setInput(new LUT\Input($file))
            )
            ->when($result = SUT::getPosition())
            ->then
                ->output
                    ->isEqualTo("\033[13t")
                ->array($result)
                    ->isEqualTo([
                        'x' => 7,
                        'y' => 42
                    ]);
    }

    public function case_get_position_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when($result = SUT::getPosition())
            ->then
                ->variable($result)
                    ->isNull()
                ->output
                    ->isEmpty();
    }

    public function case_scroll_u()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::scroll('u'))
            ->then
                ->output
                    ->isEqualTo("\033[1S");
    }

    public function case_scroll_up()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::scroll('up'))
            ->then
                ->output
                    ->isEqualTo("\033[1S");
    }

    public function case_scroll_d()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::scroll('d'))
            ->then
                ->output
                    ->isEqualTo("\033[1T");
    }

    public function case_scroll_down()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::scroll('d'))
            ->then
                ->output
                    ->isEqualTo("\033[1T");
    }

    public function case_scroll_u_d_up_down()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::scroll('u d up down'))
            ->then
                ->output
                    ->isEqualTo("\033[2S\033[2T");
    }

    public function case_scroll_up_repeated()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::scroll('up', 3))
            ->then
                ->output
                    ->isEqualTo("\033[3S");
    }

    public function case_scroll_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::scroll('u'))
            ->then
                ->output
                    ->isEmpty();
    }

    public function case_minimize()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::minimize())
            ->then
                ->output
                    ->isEqualTo("\033[2t");
    }

    public function case_minimize_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::minimize())
            ->then
                ->output
                    ->isEmpty();
    }

    public function case_restore()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::restore())
            ->then
                ->output
                    ->isEqualTo("\033[1t");
    }

    public function case_restore_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::restore())
            ->then
                ->output
                    ->isEmpty();
    }

    public function case_raise()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::raise())
            ->then
                ->output
                    ->isEqualTo("\033[5t");
    }

    public function case_raise_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::raise())
            ->then
                ->output
                    ->isEmpty();
    }

    public function case_lower()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::lower())
            ->then
                ->output
                    ->isEqualTo("\033[6t");
    }

    public function case_lower_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::lower())
            ->then
                ->output
                    ->isEmpty();
    }

    public function case_set_title()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::setTitle('foobar 😄'))
            ->then
                ->output
                    ->isEqualTo("\033]0;foobar 😄\033\\");
    }

    public function case_set_title_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::setTitle('foobar 😄'))
            ->then
                ->output
                    ->isEmpty();
    }

    public function case_get_title()
    {
        $this
            ->given(
                $this->constant->OS_WIN = false,

                $title = 'hello 🌍',
                $file  = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll("\033]l" . $title . "\033\\"),
                $file->rewind(),
                $input  = LUT::setInput(new LUT\Input($file)),
                $this->function->stream_select = function () {
                    return 1;
                }
            )
            ->when($result = SUT::getTitle())
            ->then
                ->output
                    ->isEqualTo("\033[21t")
                ->string($result)
                    ->isEqualTo($title);
    }

    public function case_get_title_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when($result = SUT::getTitle())
            ->then
                ->variable($result)
                    ->isNull()
                ->output
                    ->isEmpty();
    }

    public function case_get_title_timed_out()
    {
        $this
            ->given(
                $this->function->stream_select = function () {
                    return 0;
                }
            )
            ->when($result = SUT::getTitle())
            ->then
                ->output
                    ->isEqualTo("\033[21t")
                ->variable($result)
                    ->isNull();
    }

    public function case_get_label()
    {
        $this
            ->given(
                $this->constant->OS_WIN = false,

                $label = 'hello 🌍',
                $file  = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll("\033]L" . $label . "\033\\"),
                $file->rewind(),
                $input  = LUT::setInput(new LUT\Input($file)),
                $this->function->stream_select = function () {
                    return 1;
                }
            )
            ->when($result = SUT::getLabel())
            ->then
                ->output
                    ->isEqualTo("\033[20t")
                ->string($result)
                    ->isEqualTo($label);
    }

    public function case_get_label_timed_out()
    {
        $this
            ->given(
                $this->function->stream_select = function () {
                    return 0;
                }
            )
            ->when($result = SUT::getLabel())
            ->then
                ->output
                    ->isEqualTo("\033[20t")
                ->variable($result)
                    ->isNull();
    }

    public function case_get_label_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when($result = SUT::getLabel())
            ->then
                ->variable($result)
                    ->isNull()
                ->output
                    ->isEmpty();
    }

    public function case_refresh()
    {
        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::refresh())
            ->then
                ->output
                    ->isEqualTo("\033[7t");
    }

    public function case_refresh_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::refresh())
            ->then
                ->output
                    ->isEmpty();
    }

    public function case_copy()
    {
        unset($_SERVER['TMUX']);

        $this
            ->given($this->constant->OS_WIN = false)
            ->when(SUT::copy('bla'))
            ->then
                ->output
                    ->isEqualTo("\033]52;;" . base64_encode('bla') . "\033\\");
    }

    public function case_copy_on_tmux()
    {
        $this
            ->given(
                $_SERVER['TMUX']        = 'foo',
                $this->constant->OS_WIN = false
            )
            ->when(SUT::copy('bla'))
            ->then
                ->output
                    ->isEqualTo(
                        "\033Ptmux;" .
                            "\033\033]52;;" . base64_encode('bla') . "\033\033\\" .
                        "\033\\"
                    );
    }

    public function case_copy_on_windows()
    {
        $this
            ->given($this->constant->OS_WIN = true)
            ->when(SUT::copy('bla'))
            ->then
                ->output
                    ->isEmpty();
    }
}
