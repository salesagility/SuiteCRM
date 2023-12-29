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

use Hoa\Console\Readline\Autocompleter\Word as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Readline\Autocompleter\Word.
 *
 * Test suite of the word autocompleter for the readline.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Word extends Test\Unit\Suite
{
    public function case_constructor()
    {
        $this
            ->given($words = ['foo', 'bar', 'baz', 'qux'])
            ->when($result = new SUT($words))
            ->then
                ->object($result)
                    ->isInstanceOf('Hoa\Console\Readline\Autocompleter\Autocompleter')
                ->array($result->getWords())
                    ->isEqualTo($words);
    }

    public function case_complete_no_solution()
    {
        $this
            ->given(
                $autocompleter = new SUT(['foo', 'bar']),
                $prefix        = 'q'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->variable($result)
                    ->isNull()
                ->string($prefix)
                    ->isEqualTo('q');
    }

    public function case_complete_one_solution()
    {
        $this
            ->given(
                $autocompleter = new SUT(['foo', 'bar']),
                $prefix        = 'f'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->string($result)
                    ->isEqualTo('foo')
                ->string($prefix)
                    ->isEqualTo('f');
    }

    public function case_complete_with_smallest_prefix()
    {
        $this
            ->given(
                $autocompleter = new SUT(['foo', 'bar', 'baz', 'qux']),
                $prefix        = 'b'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->array($result)
                    ->isEqualTo(['bar', 'baz'])
                ->string($prefix)
                    ->isEqualTo('b');
    }

    public function case_complete_with_longer_prefix()
    {
        $this
            ->given(
                $autocompleter = new SUT(['bara', 'barb', 'baza']),
                $prefix        = 'bar'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->array($result)
                    ->isEqualTo(['bara', 'barb'])
                ->string($prefix)
                    ->isEqualTo('bar');
    }

    public function case_get_word_definition()
    {
        $this
            ->given($autocompleter = new SUT([]))
            ->when($result = $autocompleter->getWordDefinition())
            ->then
                ->string($result)
                    ->isEqualTo('\b\w+');
    }

    public function case_set_words()
    {
        $this
            ->given(
                $words         = ['foo', 'bar', 'baz', 'qux'],
                $autocompleter = new SUT([])
            )
            ->when($result = $autocompleter->setWords($words))
            ->then
                ->array($result)
                    ->isEmpty();
    }

    public function case_get_words()
    {
        $this
            ->given(
                $words         = ['foo', 'bar', 'baz', 'qux'],
                $autocompleter = new SUT($words)
            )
            ->when($result = $autocompleter->getWords())
            ->then
                ->array($result)
                    ->isEqualTo($words);
    }
}
