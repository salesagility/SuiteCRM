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

namespace Hoa\Protocol\Test\Unit\Node;

use Hoa\Protocol\Node\Library as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Protocol\Test\Unit\Node\Library.
 *
 * Test suite of the library node class.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Library extends Test\Unit\Suite
{
    public function case_reach_without_composer_without_a_queue()
    {
        $this
            ->given(
                $this->constant->WITH_COMPOSER = false,
                $node = new SUT('foo', 'bar')
            )
            ->when($result = $node->reach())
            ->then
                ->string($result)
                    ->isEqualTo('bar');
    }

    public function case_reach_without_composer_with_a_queue()
    {
        $this
            ->given(
                $this->constant->WITH_COMPOSER = false,
                $node = new SUT('foo', 'bar')
            )
            ->when($result = $node->reach('baz'))
            ->then
                ->string($result)
                    ->isEqualTo('baz');
    }

    public function case_reach_with_composer_without_a_queue_and_a_single_reach()
    {
        $this
            ->given(
                $this->constant->WITH_COMPOSER = true,
                $node = new SUT('foo', 'Bar' . DS . 'Baz' . DS . 'Qux' . DS)
            )
            ->when($result = $node->reach())
            ->then
                ->string($result)
                    ->isEqualTo('Bar' . DS . 'Baz' . DS . 'qux' . DS);
    }

    public function case_reach_with_composer_without_a_queue_and_a_multiple_reaches()
    {
        $this
            ->given(
                $this->constant->WITH_COMPOSER = true,
                $node = new SUT(
                    'foo',
                    'Bar' . DS . 'Baz' . DS . 'Qux' . DS . RS .
                    'Hello' . DS . 'Mister' . DS . 'Anderson' . DS
                )
            )
            ->when($result = $node->reach())
            ->then
                ->string($result)
                    ->isEqualTo(
                        'Bar' . DS . 'Baz' . DS . 'qux' . DS . RS .
                        'Hello' . DS . 'Mister' . DS . 'anderson' . DS
                    );
    }

    public function case_reach_with_composer_with_a_simple_queue()
    {
        $this
            ->given(
                $this->constant->WITH_COMPOSER = true,
                $node = new SUT('foo', 'Bar' . DS . 'Baz' . DS . 'Qux' . DS)
            )
            ->when($result = $node->reach('Hello'))
            ->then
            ->string($result)
                ->isEqualTo(
                    "\r" . 'Bar' . DS . 'Baz' . DS . 'Qux' . DS . 'hello' . RS .
                    "\r" . dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))
                );
    }

    public function case_reach_with_composer_with_a_queue()
    {
        $this
            ->given(
                $this->constant->WITH_COMPOSER = true,
                $node = new SUT('foo', 'Bar' . DS)
            )
            ->when($result = $node->reach('Hello/Mister/Anderson'))
            ->then
            ->string($result)
                ->isEqualTo(
                    "\r" . 'Bar' . DS . 'hello' . DS . 'Mister' . DS . 'Anderson' . RS .
                    "\r" . dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) . DS . 'Mister' . DS . 'Anderson'
                );
    }
}
