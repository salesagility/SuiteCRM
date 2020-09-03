<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class SugarDateTimeTest extends SuitePHPUnitFrameworkTestCase
{
    public function testget_day_begin()
    {
        // Test that the get_day_begin function creates a SugarDateTime
        // object where the time is 00:00:00.
        $day = new SugarDateTime('2019-01-01');
        $actual = $day->get_day_begin();
        $expected = new SugarDateTime('2019-01-01 00:00:00');
        $this->assertEquals($expected, $actual);
    }

    public function testget_day_end()
    {
        // Test that the get_day_begin function creates a SugarDateTime
        // object where the time is 23:59:59.
        $day = new SugarDateTime('2019-01-01');
        $actual = $day->get_day_end();
        $expected = new SugarDateTime('2019-01-01 23:59:59');
        $this->assertEquals($expected, $actual);
    }

    public function testasDb()
    {
        // Test that the asDb function returns a string formatted for use in
        // the database.
        $day = new SugarDateTime('2019-1-1');
        $actual = $day->asDb();
        $expected = '2019-01-01 00:00:00';
        $this->assertEquals($expected, $actual);
    }

    public function testasDbDate()
    {
        // Test that the asDbDate function returns a string formatted for use
        // in the database.
        $day = new SugarDateTime('2019-1-1');
        $actual = $day->asDbDate();
        $expected = '2019-01-01';
        $this->assertEquals($expected, $actual);
    }

    public function testget_date_str()
    {
        // Test that the get_date_str function returns a string for use in
        // URL parameters.
        $day = new SugarDateTime('2019-1-1');
        $actual = $day->get_date_str();
        $expected = '&year=2019&month=1&day=1&hour=0';
        $this->assertEquals($expected, $actual);
    }

    public function testget_day_by_index_this_month()
    {
        // Test that the get_day_by_index_this_month function returns a
        // SugarDateTime representing the correct day of the month.
        $day = new SugarDateTime('2019-1-1');
        $actual = $day->get_day_by_index_this_month(28);
        $expected = new SugarDateTime('2019-01-29');
        $this->assertEquals($expected, $actual);
    }

    public function testget_day_by_index_this_monthWithExcessiveValue()
    {
        // Test that the get_day_by_index_this_month function returns a
        // SugarDateTime representing the correct day of the month, even when
        // the index provided is greater than the number of days in the month.
        $day = new SugarDateTime('2019-1-1');
        $actual = $day->get_day_by_index_this_month(32);
        $expected = new SugarDateTime('2019-02-02');
        $this->assertEquals($expected, $actual);
    }
}
