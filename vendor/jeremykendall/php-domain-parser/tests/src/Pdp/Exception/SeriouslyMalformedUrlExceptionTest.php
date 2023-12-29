<?php

namespace Pdp\Exception;

class SeriouslyMalformedUrlExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanceOfPdpException()
    {
        $this->assertInstanceOf(
            'Pdp\Exception\PdpException',
            new SeriouslyMalformedUrlException()
        );
    }

    public function testInstanceOfInvalidArgumentException()
    {
        $this->assertInstanceOf(
            'InvalidArgumentException',
            new SeriouslyMalformedUrlException()
        );
    }

    public function testMessage()
    {
        $url = 'http:///example.com';
        $this->setExpectedException(
            'Pdp\Exception\SeriouslyMalformedUrlException',
            sprintf('"%s" is one seriously malformed url.', $url)
        );

        throw new SeriouslyMalformedUrlException($url);
    }
}
