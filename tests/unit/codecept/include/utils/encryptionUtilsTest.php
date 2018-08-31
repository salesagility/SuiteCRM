<?php

require_once 'include/utils/encryption_utils.php';
class encryption_utilsTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function testsugarEncode()
    {

        //execute the method and test if it returns expected values
        //key param does nothing currently.

        //blank key and data
        $expected = '';
        $actual = sugarEncode('', '');
        $this->assertSame($expected, $actual);

        //blank key and valid data
        $expected = 'RGF0YQ==';
        $actual = sugarEncode('', 'Data');
        $this->assertSame($expected, $actual);

        //valid key and data
        $expected = 'RGF0YQ==';
        $actual = sugarEncode('key', 'Data');
        $this->assertSame($expected, $actual);
    }

    public function testsugarDecode()
    {

        //execute the method and test if it returns expected values
        //key param does nothing currently.

        //blank key and data
        $expected = '';
        $actual = sugarDecode('', '');
        $this->assertSame($expected, $actual);

        //blank key and valid data
        $expected = 'Data';
        $actual = sugarDecode('', 'RGF0YQ==');
        $this->assertSame($expected, $actual);

        //valid key and data
        $expected = 'Data';
        $actual = sugarDecode('key', 'RGF0YQ==');
        $this->assertSame($expected, $actual);
    }

    public function testblowfishGetKey()
    {

        //execute the method and test if it returns expected length string

        //test key
        $actual = blowfishGetKey('test');
        $this->assertGreaterThanOrEqual(36, strlen($actual));
        //var_dump($actual);

        //default key
        $actual = blowfishGetKey('rapelcg_svryq');
        $this->assertGreaterThanOrEqual(36, strlen($actual));
    }

    public function testblowfishEncode()
    {

        //execute the method and test if it returns expected values
        //it won't work with blank key, will throw an error

        //valid key and blank data
        $expected = '';
        $actual = blowfishEncode('test', '');
        $this->assertSame($expected, $actual);

        //valid key and valid data
        $expected = 'HI1/88NJJss=';
        $actual = blowfishEncode('test', 'Data');
        $this->assertSame($expected, $actual);
    }

    public function testblowfishDecode()
    {

        //execute the method and test if it returns expected values
        //it won't work with blank key, will throw an error.

        //valid key and blank data
        $expected = '';
        $actual = blowfishDecode('test', '');
        $this->assertSame($expected, $actual);

        //valid key and valid data
        $expected = 'Data';
        $actual = blowfishDecode('test', 'HI1/88NJJss=');
        $this->assertSame($expected, $actual);
    }
}
