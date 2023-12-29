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

namespace Hoa\Protocol\Test\Unit;

use Hoa\Protocol\Protocol as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Protocol\Test\Unit\Protocol.
 *
 * Test suite of the protocol class.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Protocol extends Test\Unit\Suite
{
    public function case_root_is_a_node()
    {
        $this
            ->when($result = SUT::getInstance())
            ->then
                ->object($result)
                    ->isInstanceOf('Hoa\Protocol\Node');
    }

    public function case_default_tree()
    {
        $this
            ->when($result = SUT::getInstance())
            ->then
                ->object($result['Application'])->isInstanceOf('Hoa\Protocol\Node\Node')
                    ->object($result['Application']['Public'])->isInstanceOf('Hoa\Protocol\Node\Node')
                ->object($result['Data'])->isInstanceOf('Hoa\Protocol\Node\Node')
                    ->object($result['Data']['Etc'])->isInstanceOf('Hoa\Protocol\Node\Node')
                        ->object($result['Data']['Etc']['Configuration'])->isInstanceOf('Hoa\Protocol\Node\Node')
                        ->object($result['Data']['Etc']['Locale'])->isInstanceOf('Hoa\Protocol\Node\Node')
                    ->object($result['Data']['Lost+found'])->isInstanceOf('Hoa\Protocol\Node\Node')
                    ->object($result['Data']['Temporary'])->isInstanceOf('Hoa\Protocol\Node\Node')
                    ->object($result['Data']['Variable'])->isInstanceOf('Hoa\Protocol\Node\Node')
                        ->object($result['Data']['Variable']['Cache'])->isInstanceOf('Hoa\Protocol\Node\Node')
                        ->object($result['Data']['Variable']['Database'])->isInstanceOf('Hoa\Protocol\Node\Node')
                        ->object($result['Data']['Variable']['Log'])->isInstanceOf('Hoa\Protocol\Node\Node')
                        ->object($result['Data']['Variable']['Private'])->isInstanceOf('Hoa\Protocol\Node\Node')
                        ->object($result['Data']['Variable']['Run'])->isInstanceOf('Hoa\Protocol\Node\Node')
                        ->object($result['Data']['Variable']['Test'])->isInstanceOf('Hoa\Protocol\Node\Node')
                ->object($result['Library'])->isInstanceOf('Hoa\Protocol\Node\Library')
                ->string($result['Library']->reach())
                    ->isEqualTo(
                        dirname(dirname(dirname(dirname(__DIR__)))) . DS . 'hoathis' . DS .
                        RS .
                        dirname(dirname(dirname(dirname(__DIR__)))) . DS . 'hoa' . DS
                    );
    }

    public function case_resolve_not_a_hoa_path()
    {
        $this
            ->given($protocol = SUT::getInstance())
            ->when($result = $protocol->resolve('/foo/bar'))
            ->then
                ->string($result)
                    ->isEqualTo('/foo/bar');
    }

    public function case_resolve_to_non_existing_resource()
    {
        $this
            ->given($protocol = SUT::getInstance())
            ->when($result = $protocol->resolve('hoa://Application/Foo/Bar'))
            ->then
                ->string($result)
                    ->isEqualTo(SUT::NO_RESOLUTION);
    }

    public function case_resolve_does_not_test_if_exists()
    {
        $this
            ->given($protocol = SUT::getInstance())
            ->when($result = $protocol->resolve('hoa://Application/Foo/Bar', false))
            ->then
                ->string($result)
                    ->isEqualTo('/Foo/Bar');
    }

    public function case_resolve_unfold_to_existing_resources()
    {
        $this
            ->given($protocol = SUT::getInstance())
            ->when($result = $protocol->resolve('hoa://Library', true, true))
            ->then
                ->array($result)
                    ->contains(
                        dirname(dirname(dirname(dirname(__DIR__)))) . DS . 'hoa'
                    );
    }

    public function case_resolve_unfold_to_non_existing_resources()
    {
        $this
            ->given(
                $parentHoaDirectory = dirname(dirname(dirname(dirname(__DIR__)))),
                $protocol           = SUT::getInstance()
            )
            ->when($result = $protocol->resolve('hoa://Library', false, true))
            ->then
                ->array($result)
                    ->isEqualTo([
                        $parentHoaDirectory . DS . 'hoathis',
                        $parentHoaDirectory . DS . 'hoa'
                    ]);
    }
}
