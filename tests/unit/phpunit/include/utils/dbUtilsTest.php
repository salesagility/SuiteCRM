<?php

require_once 'include/utils/db_utils.php';
class db_utilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function db_convertProvider()
    {
        //array containing all possible types supported by db_convert
        return array(
                array(gmdate('Y-m-d H:i:s'), 'today', array(), 'CURDATE()'),
                array('text', 'left', array(2), 'LEFT(text,2)'),
                array('2015-11-16 19:10:52', 'date_format', array(), 'DATE_FORMAT(2015-11-16 19:10:52,\'%Y-%m-%d\')'),
                array('2015-11-16 19:10:52', 'time_format', array(), '2015-11-16 19:10:52'),
                array('2015-11-16', 'date', array(), '2015-11-16'),
                array('19:10:52', 'time', array(), '19:10:52'),
                array('2015-11-16 19:10:52', 'datetime', array(), '2015-11-16 19:10:52'),
                array(null, 'ifnull', array(0), 'IFNULL(0)'),
                array('value1 ', 'concat', array('value2'), 'CONCAT(value1 ,value2)'),
                array('2015-11-16 19:10:52', 'quarter', array(), 'QUARTER(2015-11-16 19:10:52)'),
                array('value1', 'length', array(), 'LENGTH(value1)'),
                array('2015-11-16 19:32:29', 'month', array(), 'MONTH(2015-11-16 19:32:29)'),
                array('2015-11-16', 'add_date', array('1', 'DAY'), 'DATE_ADD(2015-11-16, INTERVAL 1 DAY)'),
                array('19:10:52', 'add_time', array('1', 'HOUR'), 'DATE_ADD(19:10:52, INTERVAL + CONCAT(1, \':\', HOUR) HOUR_MINUTE)'),
                array('col', 'avg', array(2), 'avg(col)'),
                array('2015-11-16 19:32:29', 'add_tz_offset', array(), '2015-11-16 19:32:29 + INTERVAL 0 MINUTE'),

        );
    }

    /**
     * @dataProvider db_convertProvider
     */
    public function testdb_convert($string, $type, $params, $expected)
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        
        //execute the method and test if it returns expected values for all types
        $actual = db_convert($string, $type, $params);
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popTable('aod_indexevent');
    }

    public function testdb_concat()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        

        //execute the method and test if it returns expected values

        $table = 'Table1';
        $fields = array('Col1', 'Col2', 'Col3');
        $expected = "LTRIM(RTRIM(CONCAT(IFNULL(Table1.Col1,''),' ',IFNULL(Table1.Col2,''),' ',IFNULL(Table1.Col3,''))))";
        $actual = db_concat($table, $fields);
        $this->assertSame($expected, $actual);
        
        // clean up
    }

    public function testfrom_db_convert()
    {
        //execute the method and test if it returns expected values

        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'date'));
        $this->assertSame('19:32:29', from_db_convert('19:32:29', 'time'));
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'datetime'));
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'datetimecombo'));
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'timestamp'));
    }

    public function testto_html()
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

    public function testfrom_html()
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
