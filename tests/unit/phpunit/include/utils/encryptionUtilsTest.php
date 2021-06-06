<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once 'include/utils/encryption_utils.php';
class encryption_utilsTest extends SuitePHPUnitFrameworkTestCase
{
    public function testsugarEncode(): void
    {
        //execute the method and test if it returns expected values
        //key param does nothing currently.

        //blank key and data
        $expected = '';
        $actual = sugarEncode('', '');
        self::assertSame($expected, $actual);

        //blank key and valid data
        $expected = 'RGF0YQ==';
        $actual = sugarEncode('', 'Data');
        self::assertSame($expected, $actual);

        //valid key and data
        $expected = 'RGF0YQ==';
        $actual = sugarEncode('key', 'Data');
        self::assertSame($expected, $actual);
    }

    public function testsugarDecode(): void
    {
        //execute the method and test if it returns expected values
        //key param does nothing currently.

        //blank key and data
        $expected = '';
        $actual = sugarDecode('', '');
        self::assertSame($expected, $actual);

        //blank key and valid data
        $expected = 'Data';
        $actual = sugarDecode('', 'RGF0YQ==');
        self::assertSame($expected, $actual);

        //valid key and data
        $expected = 'Data';
        $actual = sugarDecode('key', 'RGF0YQ==');
        self::assertSame($expected, $actual);
    }

    public function testblowfishGetKey(): void
    {
        //execute the method and test if it returns expected length string

        //test key
        $actual = blowfishGetKey('test');
        self::assertGreaterThanOrEqual(36, strlen($actual));

        //default key
        $actual = blowfishGetKey('rapelcg_svryq');
        self::assertGreaterThanOrEqual(36, strlen($actual));
    }

    public function testblowfishEncode(): void
    {
        //execute the method and test if it returns expected values
        //it won't work with blank key, will throw an error

        //valid key and blank data
        $expected = '';
        $actual = blowfishEncode('test', '');
        self::assertSame($expected, $actual);

        //valid key and valid data
        $expected = 'HI1/88NJJss=';
        $actual = blowfishEncode('test', 'Data');
        self::assertSame($expected, $actual);
    }

    public function testblowfishDecode(): void
    {
        //execute the method and test if it returns expected values
        //it won't work with blank key, will throw an error.

        //valid key and blank data
        $expected = '';
        $actual = blowfishDecode('test', '');
        self::assertSame($expected, $actual);

        //valid key and valid data
        $expected = 'Data';
        $actual = blowfishDecode('test', 'HI1/88NJJss=');
        self::assertSame($expected, $actual);
    }
}
