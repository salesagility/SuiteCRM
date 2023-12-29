<?php
namespace GuzzleHttp\Tests\Stream;

use GuzzleHttp\Stream\GuzzleStreamWrapper;
use GuzzleHttp\Stream\Stream;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers GuzzleHttp\Stream\GuzzleStreamWrapper
 */
class GuzzleStreamWrapperTest extends TestCase
{
    public function testResource()
    {
        $stream = Stream::factory('foo');
        $handle = GuzzleStreamWrapper::getResource($stream);
        $this->assertSame('foo', fread($handle, 3));
        $this->assertSame(3, ftell($handle));
        $this->assertSame(3, fwrite($handle, 'bar'));
        $this->assertSame(0, fseek($handle, 0));
        $this->assertSame('foobar', fread($handle, 6));
        $this->assertEmpty(fread($handle, 1));
        $this->assertTrue(feof($handle));

        // This fails on HHVM for some reason
        if (!defined('HHVM_VERSION')) {
            $this->assertEquals([
                'dev'     => 0,
                'ino'     => 0,
                'mode'    => 33206,
                'nlink'   => 0,
                'uid'     => 0,
                'gid'     => 0,
                'rdev'    => 0,
                'size'    => 6,
                'atime'   => 0,
                'mtime'   => 0,
                'ctime'   => 0,
                'blksize' => 0,
                'blocks'  => 0,
                0         => 0,
                1         => 0,
                2         => 33206,
                3         => 0,
                4         => 0,
                5         => 0,
                6         => 0,
                7         => 6,
                8         => 0,
                9         => 0,
                10        => 0,
                11        => 0,
                12        => 0,
            ], fstat($handle));
        }

        $this->assertTrue(fclose($handle));
        $this->assertSame('foobar', (string) $stream);
    }

    public function testValidatesStream()
    {
        $this->expectException(InvalidArgumentException::class);
        $stream = $this->getMockBuilder('GuzzleHttp\Stream\StreamInterface')
            ->getMockForAbstractClass();
        $stream->expects($this->once())
            ->method('isReadable')
            ->will($this->returnValue(false));
        $stream->expects($this->once())
            ->method('isWritable')
            ->will($this->returnValue(false));
        GuzzleStreamWrapper::getResource($stream);
    }

    public function testReturnsFalseWhenStreamDoesNotExist()
    {
        
        $this->expectWarning();
        fopen('guzzle://foo', 'r');
    }

    public function testCanOpenReadonlyStream()
    {
        $stream = $this->getMockBuilder('GuzzleHttp\Stream\StreamInterface')
            ->getMockForAbstractClass();
        $stream->expects($this->once())
            ->method('isReadable')
            ->will($this->returnValue(false));
        $stream->expects($this->once())
            ->method('isWritable')
            ->will($this->returnValue(true));
        $r = GuzzleStreamWrapper::getResource($stream);
        $this->assertIsResource($r);
        fclose($r);
    }
}
