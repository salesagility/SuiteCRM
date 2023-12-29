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

use Hoa\Console\Output as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Output.
 *
 * Test suite of the output object.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Output extends Test\Unit\Suite
{
    public function case_is_a_stream()
    {
        $this
            ->when($result = new SUT())
            ->then
                ->object($result)
                    ->isInstanceOf('Hoa\Stream\IStream\Out');
    }

    public function case_write()
    {
        $this
            ->given($output = new SUT())
            ->when($output->write('foobar', 3))
            ->then
                ->output
                    ->isIdenticalTo('foo');
    }

    public function case_write_string()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeString(123))
            ->then
                ->output
                    ->isIdenticalTo('123');
    }

    public function case_write_character()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeCharacter('foo'))
            ->then
                ->output
                    ->isIdenticalTo('f');
    }

    public function case_write_boolean_true()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeBoolean(true))
            ->then
                ->output
                    ->isIdenticalTo('1');
    }

    public function case_write_boolean_false()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeBoolean(false))
            ->then
                ->output
                    ->isIdenticalTo('0');
    }

    public function case_write_integer()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeInteger(-42))
            ->then
                ->output
                    ->isIdenticalTo('-42');
    }

    public function case_write_float()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeFloat(-4.2))
            ->then
                ->output
                    ->isIdenticalTo('-4.2');
    }

    public function case_write_array()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeArray(['foo' => 'bar']))
            ->then
                ->output
                    ->isIdenticalTo(
                        'array (' . "\n" .
                        '  \'foo\' => \'bar\',' . "\n" .
                        ')'
                    );
    }

    public function case_write_line_no_newline()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeLine('foo'))
            ->then
                ->output
                    ->isIdenticalTo('foo' . "\n");
    }

    public function case_write_line_with_newline()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeLine('foo' . "\n"))
            ->then
                ->output
                    ->isIdenticalTo('foo' . "\n");
    }

    public function case_write_line_with_newlines()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeLine('foo' . "\n" . 'bar' . "\n"))
            ->then
                ->output
                    ->isIdenticalTo('foo' . "\n");
    }

    public function case_write_all()
    {
        $this
            ->given($output = new SUT())
            ->when($output->writeAll('foobar'))
            ->then
                ->output
                    ->isIdenticalTo('foobar');
    }

    public function case_truncate()
    {
        $this
            ->given($output = new SUT())
            ->when($result = $output->truncate(42))
            ->then
                ->boolean($result)
                    ->isFalse();
    }

    public function case_default_multiplexer_consideration()
    {
        $this
            ->given($output = new SUT())
            ->when($result = $output->isMultiplexerConsidered())
            ->then
                ->boolean($result)
                    ->isFalse();
    }

    public function case_consider_multiplexer()
    {
        $this
            ->given($output = new SUT())
            ->when(
                $output->considerMultiplexer(true),
                $result = $output->isMultiplexerConsidered()
            )
            ->then
                ->boolean($result)
                    ->isTrue();
    }
}
