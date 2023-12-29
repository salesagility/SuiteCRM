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

use Hoa\Protocol as LUT;
use Hoa\Protocol\Node\Node as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Protocol\Test\Unit\Node\Node.
 *
 * Test suite of the node class.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Node extends Test\Unit\Suite
{
    public function case_implements()
    {
        $this
            ->when($result = new SUT())
            ->then
                ->object($result)
                    ->isInstanceOf('ArrayAccess')
                    ->isInstanceOf('IteratorAggregate');
    }

    public function case_empty_constructor()
    {
        $this
            ->when($result = new SUT())
            ->then
                ->variable($result->getName())
                    ->isNull()
                ->array(iterator_to_array($result->getIterator()))
                    ->isEmpty();
    }

    public function case_constructor_with_a_name()
    {
        $this
            ->given($name = 'foo')
            ->when($result = new SUT($name))
            ->then
                ->string($result->getName())
                    ->isEqualTo($name)
                ->array(iterator_to_array($result->getIterator()))
                    ->isEmpty();
    }

    public function case_constructor_with_a_name_and_children()
    {
        $this
            ->given(
                $name     = 'foo',
                $children = [new SUT('bar'), new SUT('baz')]
            )
            ->when($result = new SUT($name, '', $children))
            ->then
                ->string($result->getName())
                    ->isEqualTo($name)
                ->array(iterator_to_array($result->getIterator()))
                    ->hasSize(2);
    }

    public function case_offset_set()
    {
        $this
            ->given(
                $root             = new SUT(),
                $name             = 'foo',
                $node             = new SUT(),
                $oldCountChildren = count(iterator_to_array($root->getIterator()))
            )
            ->when($result = $root->offsetSet($name, $node))
            ->then
                ->integer(count(iterator_to_array($root->getIterator())))
                    ->isEqualTo($oldCountChildren + 1)
                ->object($root[$name])
                    ->isIdenticalTo($node);
    }

    public function case_offset_set_not_a_node()
    {
        $this
            ->given($root = new SUT())
            ->exception(function () use ($root) {
                $root->offsetSet('foo', null);
            })
                ->isInstanceOf('Hoa\Protocol\Exception');
    }

    public function case_offset_set_no_name()
    {
        $this
            ->given($root = new SUT())
            ->exception(function () use ($root) {
                $root->offsetSet(null, new SUT());
            })
                ->isInstanceOf('Hoa\Protocol\Exception');
    }

    public function case_offset_get()
    {
        $this
            ->given(
                $root        = new SUT(),
                $child       = new SUT(),
                $root['foo'] = $child
            )
            ->when($result = $root->offsetGet('foo'))
            ->then
            ->object($result)
                ->isIdenticalTo($child);
    }

    public function case_offset_get_an_unknown_name()
    {
        $this
            ->given($root = new SUT())
            ->exception(function () use ($root) {
                $root->offsetGet('foo');
            })
                ->isInstanceOf('Hoa\Protocol\Exception');
    }

    public function case_offset_exists()
    {
        $this
            ->given(
                $root        = new SUT(),
                $child       = new SUT(),
                $root['foo'] = $child
            )
            ->when($result = $root->offsetExists('foo'))
            ->then
                ->boolean($result)
                    ->isTrue();
    }

    public function case_offset_not_exists()
    {
        $this
            ->given($root = new SUT())
            ->when($result = $root->offsetExists('foo'))
            ->then
                ->boolean($result)
                    ->isFalse();
    }

    public function case_offset_unset()
    {
        $this
            ->given(
                $root        = new SUT(),
                $child       = new SUT(),
                $root['foo'] = $child
            )
            ->when($result = $root->offsetUnset('foo'))
            ->then
                ->boolean($root->offsetExists('foo'))
                    ->isFalse();
    }

    public function case_reach()
    {
        $this
            ->given(
                $reach = 'bar',
                $node  = new SUT('foo', $reach)
            )
            ->when($result = $node->reach())
            ->then
                ->string($result)
                    ->isEqualTo($reach);
    }

    public function case_reach_with_a_queue()
    {
        $this
            ->given(
                $queue = 'baz',
                $node  = new SUT('foo', 'bar')
            )
            ->when($result = $node->reach('baz'))
            ->then
                ->string($result)
                    ->isEqualTo($queue);
    }

    public function case_reach_id()
    {
        $this
            ->given($node = new SUT())
            ->exception(function () use ($node) {
                $node->reachId('foo');
            })
                ->isInstanceOf('Hoa\Protocol\Exception');
    }

    public function case_set_reach()
    {
        $this
            ->given(
                $reach = 'bar',
                $node  = new SUT('foo', $reach)
            )
            ->when($result = $node->setReach('baz'))
            ->then
                ->string($result)
                    ->isEqualTo($reach)
                ->string($node->reach())
                    ->isEqualTo('baz');
    }

    public function case_get_name()
    {
        $this
            ->given(
                $name = 'foo',
                $node = new SUT($name)
            )
            ->when($result = $node->getName())
            ->then
                ->string($result)
                    ->isEqualTo($name);
    }

    public function case_get_iterator()
    {
        $this
            ->given(
                $childA   = new SUT('bar'),
                $childB   = new SUT('baz'),
                $children = [$childA, $childB]
            )
            ->when($result = new SUT('foo', '', $children))
            ->then
                ->object($result->getIterator())
                    ->isInstanceOf('ArrayIterator')
                ->array(iterator_to_array($result->getIterator()))
                    ->isEqualTo([
                        'bar' => $childA,
                        'baz' => $childB
                    ]);
    }

    public function case_get_root()
    {
        $this
            ->when($result = SUT::getRoot())
            ->then
                ->object($result)
                    ->isIdenticalTo(LUT::getInstance());
    }

    public function case_to_string_as_leaf()
    {
        $this
            ->given($node = new SUT('foo'))
            ->when($result = $node->__toString())
            ->then
                ->string($result)
                    ->isEqualTo('foo' . "\n");
    }

    public function case_to_string_as_node()
    {
        $this
            ->given(
                $node   = new SUT('foo'),
                $node[] = new SUT('bar'),
                $node[] = new SUT('baz')
            )
            ->when($result = $node->__toString())
            ->then
                ->string($result)
                    ->isEqualTo(
                        'foo' . "\n" .
                        '  bar' . "\n" .
                        '  baz' . "\n"
                    );
    }
}
