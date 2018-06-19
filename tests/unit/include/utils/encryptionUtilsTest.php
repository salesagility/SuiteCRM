<?php

require_once 'include/utils/encryption_utils.php';
class encryption_utilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testsugarEncode()
    {

        
        

        
        $expected = '';
        $actual = sugarEncode('', '');
        $this->assertSame($expected, $actual);

        
        $expected = 'RGF0YQ==';
        $actual = sugarEncode('', 'Data');
        $this->assertSame($expected, $actual);

        
        $expected = 'RGF0YQ==';
        $actual = sugarEncode('key', 'Data');
        $this->assertSame($expected, $actual);
    }

    public function testsugarDecode()
    {

        
        

        
        $expected = '';
        $actual = sugarDecode('', '');
        $this->assertSame($expected, $actual);

        
        $expected = 'Data';
        $actual = sugarDecode('', 'RGF0YQ==');
        $this->assertSame($expected, $actual);

        
        $expected = 'Data';
        $actual = sugarDecode('key', 'RGF0YQ==');
        $this->assertSame($expected, $actual);
    }

    public function testblowfishGetKey()
    {

        

        
        $actual = blowfishGetKey('test');
        $this->assertGreaterThanOrEqual(36, strlen($actual));
        

        
        $actual = blowfishGetKey('rapelcg_svryq');
        $this->assertGreaterThanOrEqual(36, strlen($actual));
    }

    public function testblowfishEncode()
    {

        
        

        
        $expected = '';
        $actual = blowfishEncode('test', '');
        $this->assertSame($expected, $actual);

        
        $expected = 'HI1/88NJJss=';
        $actual = blowfishEncode('test', 'Data');
        $this->assertSame($expected, $actual);
    }

    public function testblowfishDecode()
    {

        
        

        
        $expected = '';
        $actual = blowfishDecode('test', '');
        $this->assertSame($expected, $actual);

        
        $expected = 'Data';
        $actual = blowfishDecode('test', 'HI1/88NJJss=');
        $this->assertSame($expected, $actual);
    }
}
