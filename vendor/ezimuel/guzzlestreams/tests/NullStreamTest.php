<?php
namespace GuzzleHttp\Tests\Stream;

use GuzzleHttp\Stream\Exception\CannotAttachException;
use GuzzleHttp\Stream\NullStream;
use PHPUnit\Framework\TestCase;

class NullStreamTest extends TestCase
{
    public function testDoesNothing()
    {
        $b = new NullStream();
        $this->assertEquals('', $b->read(10));
        $this->assertEquals(4, $b->write('test'));
        $this->assertEquals('', (string) $b);
        $this->assertNull($b->getMetadata('a'));
        $this->assertEquals([], $b->getMetadata());
        $this->assertEquals(0, $b->getSize());
        $this->assertEquals('', $b->getContents());
        $this->assertEquals(0, $b->tell());

        $this->assertTrue($b->isReadable());
        $this->assertTrue($b->isWritable());
        $this->assertTrue($b->isSeekable());
        $this->assertFalse($b->seek(10));

        $this->assertTrue($b->eof());
        $b->detach();
        $this->assertTrue($b->eof());
        $b->close();
    }

    public function testCannotAttach()
    {
        $this->expectException(CannotAttachException::class);
        $p = new NullStream();
        $p->attach('a');
    }
}
