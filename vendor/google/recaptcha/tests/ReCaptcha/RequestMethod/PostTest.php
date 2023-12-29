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

namespace ReCaptcha\RequestMethod;

use \ReCaptcha\ReCaptcha;
use ReCaptcha\RequestParameters;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public static $assert = null;
    protected $parameters = null;
    protected $runcount = 0;

    public function setUp()
    {
        $this->parameters = new RequestParameters('secret', 'response', 'remoteip', 'version');
    }

    public function tearDown()
    {
        self::$assert = null;
    }

    public function testHTTPContextOptions()
    {
        $req = new Post();
        self::$assert = array($this, 'httpContextOptionsCallback');
        $req->submit($this->parameters);
        $this->assertEquals(1, $this->runcount, 'The assertion was ran');
    }

    public function testSSLContextOptions()
    {
        $req = new Post();
        self::$assert = array($this, 'sslContextOptionsCallback');
        $req->submit($this->parameters);
        $this->assertEquals(1, $this->runcount, 'The assertion was ran');
    }

    public function testOverrideVerifyUrl()
    {
        $req = new Post('https://over.ride/some/path');
        self::$assert = array($this, 'overrideUrlOptions');
        $req->submit($this->parameters);
        $this->assertEquals(1, $this->runcount, 'The assertion was ran');
    }

    public function testConnectionFailureReturnsError()
    {
        $req = new Post('https://bad.connection/');
        self::$assert = array($this, 'connectionFailureResponse');
        $response = $req->submit($this->parameters);
        $this->assertEquals('{"success": false, "error-codes": ["'.ReCaptcha::E_CONNECTION_FAILED.'"]}', $response);
    }

    public function connectionFailureResponse()
    {
        return false;
    }
    public function overrideUrlOptions(array $args)
    {
        $this->runcount++;
        $this->assertEquals('https://over.ride/some/path', $args[0]);
    }

    public function httpContextOptionsCallback(array $args)
    {
        $this->runcount++;
        $this->assertCommonOptions($args);

        $options = stream_context_get_options($args[2]);
        $this->assertArrayHasKey('http', $options);

        $this->assertArrayHasKey('method', $options['http']);
        $this->assertEquals('POST', $options['http']['method']);

        $this->assertArrayHasKey('content', $options['http']);
        $this->assertEquals($this->parameters->toQueryString(), $options['http']['content']);

        $this->assertArrayHasKey('header', $options['http']);
        $headers = array(
            'Content-type: application/x-www-form-urlencoded',
        );
        foreach ($headers as $header) {
            $this->assertContains($header, $options['http']['header']);
        }
    }

    public function sslContextOptionsCallback(array $args)
    {
        $this->runcount++;
        $this->assertCommonOptions($args);

        $options = stream_context_get_options($args[2]);
        $this->assertArrayHasKey('http', $options);
        $this->assertArrayHasKey('verify_peer', $options['http']);
        $this->assertTrue($options['http']['verify_peer']);
    }

    protected function assertCommonOptions(array $args)
    {
        $this->assertCount(3, $args);
        $this->assertStringStartsWith('https://www.google.com/', $args[0]);
        $this->assertFalse($args[1]);
        $this->assertTrue(is_resource($args[2]), 'The context options should be a resource');
    }
}

function file_get_contents()
{
    if (PostTest::$assert) {
        return call_user_func(PostTest::$assert, func_get_args());
    }
    // Since we can't represent maxlen in userland...
    return call_user_func_array('file_get_contents', func_get_args());
}
