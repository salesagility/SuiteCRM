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

use Hoa\Console\Input as SUT;
use Hoa\File;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Input.
 *
 * Test suite of the input object.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Input extends Test\Unit\Suite
{
    public function case_is_a_stream()
    {
        $this
            ->when($result = new SUT())
            ->then
                ->object($result)
                    ->isInstanceOf('Hoa\Stream\IStream\In');
    }

    public function case_eof()
    {
        $this
            ->given(
                $file  = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $input = new SUT($file)
            )
            ->when($result = $input->eof())
            ->then
                ->boolean($result)
                    ->isEqualTo($file->eof());
    }

    public function case_read()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('foobar'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->read(3))
            ->then
                ->string($result)
                    ->isEqualTo('foo');
    }

    public function case_read_string()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('foobar'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->readString(3))
            ->then
                ->string($result)
                    ->isEqualTo('foo');
    }

    public function case_read_character()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('foobar'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->readCharacter(1))
            ->then
                ->string($result)
                    ->isEqualTo('f');
    }

    public function case_read_boolean_true()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('1'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->readBoolean())
            ->then
                ->boolean($result)
                    ->isTrue();
    }

    public function case_read_boolean_false()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('0'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->readBoolean())
            ->then
                ->boolean($result)
                    ->isFalse();
    }

    public function case_read_integer()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('42'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->readInteger(2))
            ->then
                ->integer($result)
                    ->isEqualTo(42);
    }

    public function case_read_float()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('4.2'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->readFloat(3))
            ->then
                ->float($result)
                    ->isEqualTo(4.2);
    }

    public function case_read_array()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('foo bar'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->readArray('%s %s'))
            ->then
                ->array($result)
                    ->isEqualTo([
                        0 => 'foo',
                        1 => 'bar'
                    ]);
    }

    public function case_read_line()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('foo' . "\n" . 'bar'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->readLine())
            ->then
                ->string($result)
                    ->isEqualTo('foo' . "\n");
    }

    public function case_read_all()
    {
        $this
            ->given(
                $content = '4.2foo' . "\n" . 'bar',
                $file    = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll($content),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->readAll())
            ->then
                ->string($result)
                    ->isEqualTo($content);
    }

    public function case_scanf()
    {
        $this
            ->given(
                $file = new File\ReadWrite('hoa://Test/Vfs/Input?type=file'),
                $file->writeAll('foo 42' . "\n" . 'bar 153'),
                $file->rewind(),
                $input = new SUT($file)
            )
            ->when($result = $input->scanf('%s %d'))
            ->then
                ->array($result)
                    ->isEqualTo([
                        0 => 'foo',
                        1 => 42
                    ])

            ->when($result = $input->scanf('%s %d'))
            ->then
                ->array($result)
                    ->isEqualTo([
                        0 => 'bar',
                        1 => 153
                    ]);
    }
}
