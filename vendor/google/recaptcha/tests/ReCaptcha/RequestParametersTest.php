<?php
/**
 * This is a PHP library that handles calling reCAPTCHA.
 *
 * BSD 3-Clause License
 * @copyright (c) 2019, Google Inc.
 * @link https://www.google.com/recaptcha
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright notice, this
 *    list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its
 *    contributors may be used to endorse or promote products derived from
 *    this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace ReCaptcha;

use PHPUnit\Framework\TestCase;

class RequestParametersTest extends Testcase
{
    public function provideValidData()
    {
        return array(
            array('SECRET', 'RESPONSE', 'REMOTEIP', 'VERSION',
                array('secret' => 'SECRET', 'response' => 'RESPONSE', 'remoteip' => 'REMOTEIP', 'version' => 'VERSION'),
                'secret=SECRET&response=RESPONSE&remoteip=REMOTEIP&version=VERSION'),
            array('SECRET', 'RESPONSE', null, null,
                array('secret' => 'SECRET', 'response' => 'RESPONSE'),
                'secret=SECRET&response=RESPONSE'),
        );
    }

    /**
     * @dataProvider provideValidData
     */
    public function testToArray($secret, $response, $remoteIp, $version, $expectedArray, $expectedQuery)
    {
        $params = new RequestParameters($secret, $response, $remoteIp, $version);
        $this->assertEquals($params->toArray(), $expectedArray);
    }

    /**
     * @dataProvider provideValidData
     */
    public function testToQueryString($secret, $response, $remoteIp, $version, $expectedArray, $expectedQuery)
    {
        $params = new RequestParameters($secret, $response, $remoteIp, $version);
        $this->assertEquals($params->toQueryString(), $expectedQuery);
    }
}
