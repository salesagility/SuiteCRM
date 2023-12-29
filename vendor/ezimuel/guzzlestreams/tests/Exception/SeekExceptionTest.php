<?php
namespace GuzzleHttp\Tests\Stream\Exception;

use GuzzleHttp\Stream\Exception\SeekException;
use GuzzleHttp\Stream\Stream;
use PHPUnit\Framework\TestCase;

class SeekExceptionTest extends TestCase
{
    public function testHasStream()
    {
        $s = Stream::factory('foo');
        $e = new SeekException($s, 10);
        $this->assertSame($s, $e->getStream());
        $this->assertStringContainsString('10', $e->getMessage());
    }
}
