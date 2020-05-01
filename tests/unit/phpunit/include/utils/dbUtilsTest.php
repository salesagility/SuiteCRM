<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once 'include/utils/db_utils.php';
/**
 * @internal
 */
class db_utilsTest extends SuitePHPUnitFrameworkTestCase
{
    public function db_convertProvider()
    {
        //array containing all possible types supported by db_convert
        return [
            [gmdate('Y-m-d H:i:s'), 'today', [], 'CURDATE()'],
            ['text', 'left', [2], 'LEFT(text,2)'],
            ['2015-11-16 19:10:52', 'date_format', [], 'DATE_FORMAT(2015-11-16 19:10:52,\'%Y-%m-%d\')'],
            ['2015-11-16 19:10:52', 'time_format', [], '2015-11-16 19:10:52'],
            ['2015-11-16', 'date', [], '2015-11-16'],
            ['19:10:52', 'time', [], '19:10:52'],
            ['2015-11-16 19:10:52', 'datetime', [], '2015-11-16 19:10:52'],
            [null, 'ifnull', [0], 'IFNULL(0)'],
            ['value1 ', 'concat', ['value2'], 'CONCAT(value1 ,value2)'],
            ['2015-11-16 19:10:52', 'quarter', [], 'QUARTER(2015-11-16 19:10:52)'],
            ['value1', 'length', [], 'LENGTH(value1)'],
            ['2015-11-16 19:32:29', 'month', [], 'MONTH(2015-11-16 19:32:29)'],
            ['2015-11-16', 'add_date', ['1', 'DAY'], 'DATE_ADD(2015-11-16, INTERVAL 1 DAY)'],
            ['19:10:52', 'add_time', ['1', 'HOUR'], 'DATE_ADD(19:10:52, INTERVAL + CONCAT(1, \':\', HOUR) HOUR_MINUTE)'],
            ['col', 'avg', [2], 'avg(col)'],
            ['2015-11-16 19:32:29', 'add_tz_offset', [], '2015-11-16 19:32:29 + INTERVAL 0 MINUTE'],
        ];
    }

    /**
     * @dataProvider db_convertProvider
     *
     * @param mixed $string
     * @param mixed $type
     * @param mixed $params
     * @param mixed $expected
     */
    public function testdbConvert($string, $type, $params, $expected)
    {
        //execute the method and test if it returns expected values for all types
        $actual = db_convert($string, $type, $params);
        $this->assertSame($expected, $actual);
    }

    public function testdbConcat()
    {
        //execute the method and test if it returns expected values

        $table = 'Table1';
        $fields = ['Col1', 'Col2', 'Col3'];
        $expected = "LTRIM(RTRIM(CONCAT(IFNULL(Table1.Col1,''),' ',IFNULL(Table1.Col2,''),' ',IFNULL(Table1.Col3,''))))";
        $actual = db_concat($table, $fields);
        $this->assertSame($expected, $actual);
    }

    public function testfromDbConvert()
    {
        //execute the method and test if it returns expected values

        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'date'));
        $this->assertSame('19:32:29', from_db_convert('19:32:29', 'time'));
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'datetime'));
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'datetimecombo'));
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'timestamp'));
    }

    public function testtoHtml()
    {
//        $this->markTestIncomplete('PHPUnit and codeception results are in conflict');
//        //execute the method and test if it returns expected values
//
//        $string = '';
//        $expected = '';
//        $actual = to_html($string);
//        $this->assertSame($expected, $actual);
//
//        $string = "'test'&trial<\">";
//        $expected = '&#039;test&#039;&amp;trial&lt;&quot;&gt;';
//        $actual = to_html($string, true);
//        $this->assertSame($expected, $actual);
    }

    public function testfromHtml()
    {
        $string = '';
        $expected = '';
        $actual = from_html($string);
        $this->assertSame($expected, $actual);

        $string = '&#039;test&#039;&trial&lt;&quot;&gt;';
        $expected = "'test'&trial<\">";
        $actual = from_html($string);
        $this->assertSame($expected, $actual);
    }

    public function testgetValidDBName()
    {
        $expected = '';
        $actual = getValidDBName('');
        $this->assertSame($expected, $actual);

        $expected = 'col';
        $actual = getValidDBName('Col');
        $this->assertSame($expected, $actual);
    }

    public function testisValidDBName()
    {
        //valid value
        $expected = true;
        $actual = isValidDBName('suitecrmtest', 'mysql');
        $this->assertSame($expected, $actual);

        //invalid value
        $expected = false;
        $actual = isValidDBName('suite/crm.test', 'mysql');
        $this->assertSame($expected, $actual);
    }
}
