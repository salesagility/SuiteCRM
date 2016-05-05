<?php

require_once 'include/utils.php';

/**
 * Class utilsTest
 */
class utilsTest extends PHPUnit_Framework_TestCase
{
    public function test_html_entity_decode_utf8()
    {
        $testString = 'aaabbbccc';
        $expectedString = 'aaabbbccc';
        $this->assertSame($expectedString, html_entity_decode_utf8($testString));

        $testString = 'aaa&#x0123456789ABCDEF;bbb';
        $expectedString = 'aaacode2utf(hexdec("123456789ABCDEF"))bbb';
        $this->assertSame($expectedString, html_entity_decode_utf8($testString));

        $testString = 'aaa&#0123456789;bbb';
        $expectedString = 'aaacode2utf(123456789)bbb';
        $this->assertSame($expectedString, html_entity_decode_utf8($testString));

        $testString = 'aaa&#x0123456789ABCDEF;bbb_aaa&#0123456789;bbb';
        $expectedString = 'aaacode2utf(hexdec("123456789ABCDEF"))bbb_aaacode2utf(123456789)bbb';
        $this->assertSame($expectedString, html_entity_decode_utf8($testString));

        //add some moer on "replace literal entities"
    }


}
