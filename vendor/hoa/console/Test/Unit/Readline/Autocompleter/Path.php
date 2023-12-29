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

use Hoa\Console\Readline\Autocompleter\Path as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Readline\Autocompleter\Path.
 *
 * Test suite of the path autocompleter for the readline.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Path extends Test\Unit\Suite
{
    public function case_get_word_definition()
    {
        $this
            ->given($autocompleter = new SUT())
            ->when($result = $autocompleter->getWordDefinition())
            ->then
                ->string($result)
                    ->isEqualTo('/?[\w\d\\_\-\.]+(/[\w\d\\_\-\.]*)*');
    }

    public function case_constructor()
    {
        $this
            ->given(
                $root            = 'foo',
                $iteratorFactory = function () {
                    return 42;
                }
            )
            ->when($result = new SUT($root, $iteratorFactory))
            ->then
                ->object($result)
                    ->isInstanceOf('Hoa\Console\Readline\Autocompleter\Autocompleter')
                ->string($result->getRoot())
                    ->isEqualTo($root)
                ->object($result->getIteratorFactory())
                    ->isIdenticalTo($iteratorFactory);
    }

    public function case_complete_no_solution()
    {
        $this
            ->given(
                resolve('hoa://Test/Vfs/Root?type=directory'),
                resolve('hoa://Test/Vfs/Root/Foo?type=file'),
                resolve('hoa://Test/Vfs/Root/Bar?type=file'),

                $autocompleter = new SUT('hoa://Test/Vfs/Root'),
                $prefix        = 'Q'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->variable($result)
                    ->isNull()
                ->string($prefix)
                    ->isEqualTo('Q');
    }

    public function case_complete_one_solution()
    {
        $this
            ->given(
                resolve('hoa://Test/Vfs/Root?type=directory'),
                resolve('hoa://Test/Vfs/Root/Foo?type=file'),
                resolve('hoa://Test/Vfs/Root/Bar?type=file'),

                $autocompleter = new SUT('hoa://Test/Vfs/Root'),
                $prefix        = 'F'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->string($result)
                    ->isEqualTo('Foo')
                ->string($prefix)
                    ->isEqualTo('F');
    }

    public function case_complete_with_smallest_prefix()
    {
        $this
            ->given(
                resolve('hoa://Test/Vfs/Root?type=directory'),
                resolve('hoa://Test/Vfs/Root/Foo?type=file'),
                resolve('hoa://Test/Vfs/Root/Bar?type=file'),
                resolve('hoa://Test/Vfs/Root/Baz?type=file'),
                resolve('hoa://Test/Vfs/Root/Qux?type=file'),

                $autocompleter = new SUT('hoa://Test/Vfs/Root'),
                $prefix        = 'B'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->array($result)
                    ->isEqualTo(['Bar', 'Baz'])
                ->string($prefix)
                    ->isEqualTo('B');
    }

    public function case_complete_with_longer_prefix()
    {
        $this
            ->given(
                resolve('hoa://Test/Vfs/Root?type=directory'),
                resolve('hoa://Test/Vfs/Root/Bara?type=file'),
                resolve('hoa://Test/Vfs/Root/Barb?type=file'),
                resolve('hoa://Test/Vfs/Root/Baza?type=file'),

                $autocompleter = new SUT('hoa://Test/Vfs/Root'),
                $prefix        = 'Bar'
            )
            ->when($result = $autocompleter->complete($prefix))
            ->then
                ->array($result)
                    ->isEqualTo(['Bara', 'Barb'])
                ->string($prefix)
                    ->isEqualTo('Bar');
    }

    public function case_set_root()
    {
        $this
            ->given($autocompleter = new SUT())
            ->when($result = $autocompleter->setRoot('foo'))
            ->then
                ->variable($result)
                    ->isNull()

            ->when($result = $autocompleter->setRoot('bar'))
            ->then
                ->string($result)
                    ->isEqualTo('foo');
    }

    public function case_get_root()
    {
        $this
            ->given(
                $autocompleter = new SUT(),
                $autocompleter->setRoot('foo')
            )
            ->when($result = $autocompleter->getRoot())
            ->then
                ->string($result)
                    ->isEqualTo('foo');
    }

    public function case_set_iterator_factory()
    {
        $this
            ->given($autocompleter = new SUT())
            ->when(
                $result = $autocompleter->setIteratorFactory(function () {
                    return 42;
                })
            )
            ->then
                ->variable($result)
                    ->isNull()

            ->when(
                $result = $autocompleter->setIteratorFactory(function () {
                    return 43;
                })
            )
            ->then
                ->integer($result())
                    ->isEqualTo(42);
    }

    public function case_get_iterator_factory()
    {
        $this
            ->given(
                $autocompleter = new SUT(),
                $autocompleter->setIteratorFactory(function () {
                    return 42;
                })
            )
            ->when(function () use (&$result, $autocompleter) {
                $result = $autocompleter->getIteratorFactory();
            })
            ->then
                ->integer($result())
                    ->isEqualTo(42);
    }

    public function case_get_default_iterator_factory()
    {
        $this
            ->when(function () use (&$result) {
                $result = SUT::getDefaultIteratorFactory();
            })
            ->then
                ->object($result)
                    ->isInstanceOf('Closure')
                ->object($result(__DIR__))
                    ->isInstanceOf('DirectoryIterator');
    }
}
