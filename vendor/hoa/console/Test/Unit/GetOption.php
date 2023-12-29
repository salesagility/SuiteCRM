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
use Hoa\Console\GetOption as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\GetOption.
 *
 * Test suite of the option reader.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class GetOption extends Test\Unit\Suite
{
    public function case_empty()
    {
        $this
            ->given(
                $parser = new LUT\Parser(),
                $parser->parse(''),

                $options = new SUT([], $parser)
            )
            ->when($result = $options->getOption($value))
            ->then
                ->boolean($options->isPipetteEmpty())
                    ->isTrue()
                ->boolean($result)
                    ->isFalse()
                ->variable($value)
                    ->isNull();
    }

    public function case_one_entry()
    {
        $this
            ->given(
                $parser = new LUT\Parser(),
                $parser->parse('--foo'),

                $options = new SUT(
                    [
                        ['foo', SUT::NO_ARGUMENT, 'f']
                    ],
                    $parser
                )
            )
            ->when($result = $options->getOption($value))
            ->then
                ->boolean($options->isPipetteEmpty())
                    ->isFalse()
                ->string($result)
                    ->isEqualTo('f')
                ->boolean($value)
                    ->isTrue()

            ->when($result = $options->getOption($value))
                ->boolean($options->isPipetteEmpty())
                    ->isFalse()
                ->boolean($result)
                    ->isFalse()
                ->variable($value)
                    ->isNull();
    }

    public function case_more_entries()
    {
        $this
            ->given(
                $parser = new LUT\Parser(),
                $parser->parse('--foo --bar baz'),

                $options = new SUT(
                    [
                        ['foo', SUT::NO_ARGUMENT,       'f'],
                        ['bar', SUT::REQUIRED_ARGUMENT, 'b']
                    ],
                    $parser
                )
            )
            ->when($result = $options->getOption($value))
            ->then
                ->boolean($options->isPipetteEmpty())
                    ->isFalse()
                ->string($result)
                    ->isEqualTo('f')
                ->boolean($value)
                    ->isTrue()

            ->when($result = $options->getOption($value))
            ->then
                ->boolean($options->isPipetteEmpty())
                    ->isFalse()
                ->string($result)
                    ->isEqualTo('b')
                ->string($value)
                    ->isEqualTo('baz')

            ->when($result = $options->getOption($value))
            ->then
                ->boolean($options->isPipetteEmpty())
                    ->isFalse()
                ->boolean($result)
                    ->isFalse()
                ->variable($value)
                    ->isNull();
    }

    public function case_ambiguous()
    {
        $this
            ->given(
                $parser = new LUT\Parser(),
                $parser->parse('--baz'),

                $options = new SUT(
                    [
                        ['foo', SUT::NO_ARGUMENT,       'f'],
                        ['bar', SUT::REQUIRED_ARGUMENT, 'b']
                    ],
                    $parser
                )
            )
            ->when($result = $options->getOption($value))
            ->then
                ->boolean($options->isPipetteEmpty())
                    ->isFalse()
                ->string($result)
                    ->isEqualTo('__ambiguous')
                ->array($value)
                    ->isEqualTo([
                        'solutions' => ['bar'],
                        'value'     => true,
                        'option'    => 'baz'
                    ]);
    }

    public function case_resolve_option_ambiguity_no_solution()
    {
        $this
            ->given(
                $parser = new LUT\Parser(),
                $parser->parse(''),

                $options = new SUT([], $parser),

                $solutions = [
                    'solutions' => [],
                    'value'     => true,
                    'option'    => 'baz'
                ]
            )
            ->exception(function () use ($options, $solutions) {
                $options->resolveOptionAmbiguity($solutions);
            })
                ->isInstanceOf('Hoa\Console\Exception');
    }

    public function case_resolve_option_ambiguity()
    {
        $this
            ->given(
                $parser = new LUT\Parser(),
                $parser->parse('--baz'),

                $options = new SUT(
                    [
                        ['bar', SUT::NO_ARGUMENT, 'b']
                    ],
                    $parser
                )
            )
            ->when($result = $options->getOption($value))
            ->then
                ->string($result)
                    ->isEqualTo('__ambiguous')
                ->array($value)
                    ->isEqualTo([
                        'solutions' => ['bar'],
                        'value'     => true,
                        'option'    => 'baz'
                    ])

            ->when($result = $options->resolveOptionAmbiguity($value))
            ->then
                ->variable($result)
                    ->isNull()

            ->when($result = $options->getOption($value))
            ->then
                ->string($result)
                    ->isEqualTo('b')
                ->boolean($value)
                    ->isEqualTo(true);
    }
}
