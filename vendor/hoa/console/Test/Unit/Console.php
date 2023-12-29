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
use Hoa\Console\Console as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Console.
 *
 * Test suite of the console class.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Console extends Test\Unit\Suite
{
    public function case_get_mode_fifo()
    {
        return $this->_case_get_mode_xxx(0010000, SUT::IS_FIFO);
    }

    public function case_get_mode_character()
    {
        return $this->_case_get_mode_xxx(0020000, SUT::IS_CHARACTER);
    }

    public function case_get_mode_directory()
    {
        return $this->_case_get_mode_xxx(0040000, SUT::IS_DIRECTORY);
    }

    public function case_get_mode_block()
    {
        return $this->_case_get_mode_xxx(0060000, SUT::IS_BLOCK);
    }

    public function case_get_mode_regular()
    {
        return $this->_case_get_mode_xxx(0100000, SUT::IS_REGULAR);
    }

    public function case_get_mode_link()
    {
        return $this->_case_get_mode_xxx(0120000, SUT::IS_LINK);
    }

    public function case_get_mode_socket()
    {
        return $this->_case_get_mode_xxx(0140000, SUT::IS_SOCKET);
    }

    public function case_get_mode_whiteout()
    {
        return $this->_case_get_mode_xxx(0160000, SUT::IS_WHITEOUT);
    }

    public function case_get_mode_unknown()
    {
        return $this->_case_get_mode_xxx(0170000, -1);
    }

    protected function _case_get_mode_xxx($mask, $expect)
    {
        $this
            ->given($this->function->fstat = ['mode' => $mask & 0170000])
            ->when($result = SUT::getMode(null))
            ->then
                ->integer($result)
                    ->isEqualTo($expect);
    }

    public function case_set_input()
    {
        $this
            ->given($input = new LUT\Input())
            ->when($result = SUT::setInput($input))
            ->then
                ->variable($result)
                    ->isNull()
                ->object(SUT::getInput())
                    ->isIdenticalTo($input);
    }

    public function case_get_input()
    {
        $this
            ->when($result = SUT::getInput())
            ->then
                ->object($result)
                    ->isInstanceOf('Hoa\Console\Input')
                    ->isIdenticalTo(SUT::getInput());
    }

    public function case_set_output()
    {
        $this
            ->given($output = new LUT\Output())
            ->when($result = SUT::setOutput($output))
            ->then
                ->variable($result)
                    ->isNull()
                ->object(SUT::getOutput())
                    ->isIdenticalTo($output);
    }

    public function case_get_output()
    {
        $this
            ->when($result = SUT::getOutput())
            ->then
                ->object($result)
                    ->isInstanceOf('Hoa\Console\Output')
                    ->isIdenticalTo(SUT::getOutput());
    }

    public function case_set_tput()
    {
        $this
            ->given($tput = new LUT\Tput('hoa://Library/Console/Terminfo/78/xterm'))
            ->when($result = SUT::setTput($tput))
            ->then
                ->variable($result)
                    ->isNull()
                ->object(SUT::getTput())
                    ->isIdenticalTo($tput);
    }

    public function case_get_tput()
    {
        $this
            ->when($result = SUT::getTput())
            ->then
                ->object($result)
                    ->isInstanceOf('Hoa\Console\Tput')
                    ->isIdenticalTo(SUT::getTput());
    }

    public function case_is_tmux_running()
    {
        $this
            ->given($_SERVER['TMUX'] = 'foo')
            ->when($result = SUT::isTmuxRunning())
            ->then
                ->boolean($result)
                    ->isTrue();
    }

    public function case_is_not_tmux_running()
    {
        unset($_SERVER['TMUX']);

        $this
            ->when($result = SUT::isTmuxRunning())
            ->then
                ->boolean($result)
                    ->isFalse();
    }
}
