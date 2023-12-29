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

namespace Hoa\Console\Test\Unit\Readline\Autocompleter;

use Hoa\Console\Readline\Autocompleter\Aggregate as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Readline\Autocompleter\Aggregate.
 *
 * Test suite of the readline autocompleter aggregator.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Aggregate extends Test\Unit\Suite
{
    public function case_get_word_definition()
    {
        $this
            ->given($autocompleter = new SUT([]))
            ->when($result = $autocompleter->getWordDefinition())
            ->then
                ->string($result)
                    ->isEqualTo('.*');
    }

    public function case_constructor()
    {
        $this
            ->given(
                $autocompleterA = new \Mock\Hoa\Console\Readline\Autocompleter\Autocompleter(),
                $autocompleterB = new \Mock\Hoa\Console\Readline\Autocompleter\Autocompleter()
            )
            ->when($result = new SUT([$autocompleterA, $autocompleterB]))
            ->then
                ->object($result)
                    ->isInstanceOf('Hoa\Console\Readline\Autocompleter\Autocompleter')
                ->let($autocompleters = $result->getAutocompleters())
                ->object($autocompleters)
                    ->isInstanceOf('ArrayObject')
                ->integer(count($autocompleters))
                    ->isEqualTo(2)
                ->object($autocompleters[0])
                    ->isIdenticalTo($autocompleterA)
                ->object($autocompleters[1])
                    ->isIdenticalTo($autocompleterB);
    }

    public function case_complete_no_solution()
    {
        $this
            ->given(
                $autocompleterA = new \Mock\Hoa\Console\Readline\Autocompleter\Autocompleter(),
                $autocompleterA->getWordDefinition = function () {
                    return 'aaa';
                },

                $autocompleterB = new \Mock\Hoa\Console\Readline\Autocompleter\Autocompleter(),
                $autocompleterB->getWordDefinition = function () {
                    return 'bbb';
                },

                $autocompleter = new SUT([$autocompleterA, $autocompleterB]),
                $prefix        = 'ccc'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->variable($result)
                    ->isNull()
                ->string($prefix)
                    ->isEqualTo('ccc');
    }

    public function case_complete_one_solution_first_autocompleter()
    {
        $self = $this;

        $this
            ->given(
                $autocompleterA = new \Mock\Hoa\Console\Readline\Autocompleter\Autocompleter(),
                $this->calling($autocompleterA)->getWordDefinition = function () {
                    return 'aaa';
                },
                $this->calling($autocompleterA)->complete = function ($prefix) use ($self) {
                    $self
                        ->string($prefix)
                            ->isEqualTo('aaa');

                    return 'AAA';
                },

                $autocompleterB = new \Mock\Hoa\Console\Readline\Autocompleter\Autocompleter(),
                $this->calling($autocompleterB)->getWordDefinition = function () {
                    return 'bbb';
                },
                $this->calling($autocompleterB)->complete = function ($prefix) use ($self) {
                    $self->fail('Bad autocompleter called.');
                },

                $autocompleter = new SUT([$autocompleterA, $autocompleterB]),
                $prefix        = 'aaa'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->string($result)
                    ->isEqualTo('AAA')
                ->string($prefix)
                    ->isEqualTo('aaa');
    }

    public function case_complete_one_solution_second_autocompleter()
    {
        $self = $this;

        $this
            ->given(
                $autocompleterA = new \Mock\Hoa\Console\Readline\Autocompleter\Autocompleter(),
                $this->calling($autocompleterA)->getWordDefinition = function () {
                    return 'aaa';
                },
                $this->calling($autocompleterA)->complete = function ($prefix) use ($self) {
                    $self->fail('Bad autocompleter called.');
                },

                $autocompleterB = new \Mock\Hoa\Console\Readline\Autocompleter\Autocompleter(),
                $this->calling($autocompleterB)->getWordDefinition = function () {
                    return 'bbb';
                },
                $this->calling($autocompleterB)->complete = function ($prefix) use ($self) {
                    $self
                        ->string($prefix)
                            ->isEqualTo('bbb');

                    return 'BBB';
                },

                $autocompleter = new SUT([$autocompleterA, $autocompleterB]),
                $prefix        = 'bbb'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->string($result)
                    ->isEqualTo('BBB')
                ->string($prefix)
                    ->isEqualTo('bbb');
    }
}
