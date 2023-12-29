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
use Hoa\Console\Mouse as SUT;
use Hoa\Event;
use Hoa\File;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Mouse.
 *
 * Test suite of the mouse.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Mouse extends Test\Unit\Suite
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

    public function case_track_button_left()
    {
        return $this->_case_track(
            7,
            42,
            SUT::BUTTON_LEFT,
            'mousedown',
            [
                'x'      => 7,
                'y'      => 42,
                'button' => 'left',
                'shift'  => false,
                'meta'   => false,
                'ctrl'   => false
            ]
        );
    }

    public function case_track_button_middle()
    {
        return $this->_case_track(
            7,
            42,
            SUT::BUTTON_MIDDLE,
            'mousedown',
            [
                'x'      => 7,
                'y'      => 42,
                'button' => 'middle',
                'shift'  => false,
                'meta'   => false,
                'ctrl'   => false
            ]
        );
    }

    public function case_track_button_right()
    {
        return $this->_case_track(
            7,
            42,
            SUT::BUTTON_RIGHT,
            'mousedown',
            [
                'x'      => 7,
                'y'      => 42,
                'button' => 'right',
                'shift'  => false,
                'meta'   => false,
                'ctrl'   => false
            ]
        );
    }

    public function case_track_button_release()
    {
        return $this->_case_track(
            7,
            42,
            SUT::BUTTON_RELEASE,
            'mouseup',
            [
                'x'      => 7,
                'y'      => 42,
                'button' => null,
                'shift'  => false,
                'meta'   => false,
                'ctrl'   => false
            ]
        );
    }

    public function case_track_wheelup()
    {
        return $this->_case_track(
            7,
            42,
            SUT::WHEEL_UP,
            'wheelup',
            [
                'x'      => 7,
                'y'      => 42,
                'button' => null,
                'shift'  => false,
                'meta'   => false,
                'ctrl'   => false
            ]
        );
    }

    public function case_track_wheeldown()
    {
        return $this->_case_track(
            7,
            42,
            SUT::WHEEL_DOWN,
            'wheeldown',
            [
                'x'      => 7,
                'y'      => 42,
                'button' => null,
                'shift'  => false,
                'meta'   => false,
                'ctrl'   => false
            ]
        );
    }

    public function _case_track($x, $y, $pointerActionCode, $listenerName, array $listenerData)
    {
        $this
            ->given(
                $self = $this,
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll(
                    "\033[M" .
                    chr(($pointerActionCode + 32) & ~28) .
                    chr($x + 32) .
                    chr($y + 32)
                ),
                $file->rewind(),
                $input = LUT::setInput(new LUT\Input($file)),

                $this->function->stream_select = function () {
                    static $i = 1;

                    if (1 === $i) {
                        return $i--;
                    }

                    return false;
                },

                SUT::getInstance()->on(
                    $listenerName,
                    function (Event\Bucket $bucket) use (&$_listenerData) {
                        $_listenerData = $bucket->getData();

                        return;
                    }
                )
            )
            ->when(SUT::track())
            ->then
                ->output
                    ->isEqualTo(
                        // Track.
                        "\033[1;2'z" .
                        "\033[?1000h" .
                        "\033[?1003h" .

                        // Untrack.
                        "\033[?1003l" .
                        "\033[?1000l"
                    )
                ->array($_listenerData)
                    ->isEqualTo($listenerData);
    }

    public function case_untrack_when_not_tracked()
    {
        $this
            ->when($result = SUT::untrack())
            ->then
                ->variable($result)
                    ->isNull()
                ->output
                    ->isEmpty();
    }
}
