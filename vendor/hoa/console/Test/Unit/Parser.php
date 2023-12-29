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

use Hoa\Console\Parser as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Parser.
 *
 * Test suite of the parser.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Parser extends Test\Unit\Suite
{
    public function case_short_options()
    {
        return $this->_case(
            '-a -b -c',
            ['a' => true, 'b' => true, 'c' => true]
        );
    }

    public function case_single_dashed_short_options()
    {
        return $this->_case(
            '-abc',
            ['a' => true, 'b' => true, 'c' => true]
        );
    }

    public function case_long_options()
    {
        return $this->_case(
            '--foo --bar --b-a-z',
            ['foo' => true, 'bar' => true, 'b-a-z' => true]
        );
    }

    public function case_boolean_switches()
    {
        return $this->_case(
            '-a -a --foo --foo --bar --bar --bar',
            ['a' => false, 'foo' => false, 'bar' => true]
        );
    }

    public function case_valued_switches_equal_simple()
    {
        return $this->_case(
            '-a=foo --long=bar',
            ['a' => 'foo', 'long' => 'bar']
        );
    }

    public function case_valued_switches_equal_with_escaped_space()
    {
        return $this->_case(
            '-a=fo\ o --long=b\ a\ r',
            ['a' => 'fo o', 'long' => 'b a r']
        );
    }

    public function case_valued_switches_equal_double_quoted()
    {
        return $this->_case(
            '-a="fo\"o" --long="b\"a\'r"',
            ['a' => 'fo"o', 'long' => 'b"a\'r']
        );
    }

    public function case_valued_switches_equal_single_quoted()
    {
        return $this->_case(
            '-a=\'fo\\\'"o\' --long=\'b\\\'a"r\'',
            ['a' => 'fo\'"o', 'long' => 'b\'a"r']
        );
    }

    public function case_valued_switches_space_simple()
    {
        return $this->_case(
            '-a foo --long bar',
            ['a' => 'foo', 'long' => 'bar']
        );
    }

    public function case_valued_switches_space_with_escaped_space()
    {
        return $this->_case(
            '-a fo\ o --long b\ a\ r',
            ['a' => 'fo o', 'long' => 'b a r']
        );
    }

    public function case_valued_switches_space_double_quoted()
    {
        return $this->_case(
            '-a "fo\"o" --long "b\"a\'r"',
            ['a' => 'fo"o', 'long' => 'b"a\'r']
        );
    }

    public function case_valued_switches_space_single_quoted()
    {
        return $this->_case(
            '-a \'fo\\\'"o\' --long \'b\\\'a"r\'',
            ['a' => 'fo\'"o', 'long' => 'b\'a"r']
        );
    }

    public function case_valued_switch_equal_negative_value()
    {
        return $this->_case(
            '-a=-foo --long=-bar',
            ['a' => '-foo', 'long' => '-bar']
        );
    }

    public function case_special_valued_switch()
    {
        return $this->_case(
            '-a f,o,o --long b,a,r',
            ['a' => 'f,o,o', 'long' => 'b,a,r']
        );
    }

    public function case_input_associated_to_a_short_option()
    {
        return $this->_case(
            '-a input',
            ['a' => 'input']
        );
    }

    public function case_double_dashes_input()
    {
        return $this->_case(
            '-a --long bar -- inputA inputB',
            ['a' => true, 'long' => 'bar'],
            ['inputA', 'inputB']
        );
    }

    public function case_simple_input()
    {
        return $this->_case(
            'inputA inputB',
            [],
            ['inputA', 'inputB']
        );
    }

    public function case_valued_switch_followed_by_an_input()
    {
        return $this->_case(
            '-a foo --long bar inputA inputB',
            ['a' => 'foo', 'long' => 'bar'],
            ['inputA', 'inputB']
        );
    }

    public function case_unordered()
    {
        return $this->_case(
            'inputA -a foo inputB --long bar inputC',
            ['a' => 'foo', 'long' => 'bar'],
            ['inputA', 'inputB', 'inputC']
        );
    }

    protected function _case($command, array $switches, array $inputs = [])
    {
        $this
            ->given($parser = new SUT())
            ->when($result = $parser->parse($command))
            ->then
                ->variable($result)
                    ->isNull()
                ->array($parser->getSwitches())
                    ->isIdenticalTo($switches)
                ->array($parser->getInputs())
                    ->isIdenticalTo($inputs);
    }

    public function case_state_is_reset()
    {
        $this
            ->given($parser = new SUT())
            ->when($result = $parser->parse('--foo=bar baz'))
            ->then
                ->variable($result)
                    ->isNull()
                ->array($parser->getSwitches())
                    ->isIdenticalTo(['foo' => 'bar'])
                ->array($parser->getInputs())
                    ->isIdenticalTo(['baz'])

            ->when($result = $parser->parse('--bar=baz qux'))
                ->variable($result)
                    ->isNull()
                ->array($parser->getSwitches())
                    ->isIdenticalTo(['bar' => 'baz'])
                ->array($parser->getInputs())
                    ->isIdenticalTo(['qux']);
    }

    public function case_parse_special_value_list()
    {
        $this
            ->given($parser = new SUT())
            ->when($result = $parser->parseSpecialValue('foo,bar,baz'))
            ->then
                ->array($result)
                    ->isIdenticalTo([
                        'foo',
                        'bar',
                        'baz'
                    ]);
    }

    public function case_parse_special_value_list_with_keywords()
    {
        $this
            ->given($parser = new SUT())
            ->when($result = $parser->parseSpecialValue('foo,bar,QUX', ['QUX' => 'baz']))
            ->then
                ->array($result)
                    ->isIdenticalTo([
                        'foo',
                        'bar',
                        'baz'
                    ]);
    }

    public function case_parse_special_value_list_with_range()
    {
        $this
            ->given($parser = new SUT())
            ->when($result = $parser->parseSpecialValue('foo,bar,1:3'))
            ->then
                ->array($result)
                    ->isIdenticalTo([
                        1,
                        2,
                        3,
                        'foo',
                        'bar'
                    ]);
    }

    public function case_set_long_only()
    {
        $this
            ->given($parser = new SUT())
            ->when(
                $parser->setLongOnly(true),
                $result = $parser->parse('-abc')
            )
            ->then
                ->boolean($parser->getLongOnly())
                    ->isTrue()
                ->variable($result)
                    ->isNull()
                ->array($parser->getSwitches())
                    ->isIdenticalTo([
                        'abc' => true,
                    ])
                ->array($parser->getInputs())
                    ->isEmpty();
    }
}
