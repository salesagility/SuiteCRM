<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class SugarDateTimeTest extends SuitePHPUnitFrameworkTestCase
{
    public function testget_day_begin(): void
    {
        // Test that the get_day_begin function creates a SugarDateTime
        // object where the time is 00:00:00.
        $actual = (new SugarDateTime('2019-01-01'))->get_day_begin();
        $expected = new SugarDateTime('2019-01-01 00:00:00');
        self::assertEquals($expected, $actual);
    }

    public function testget_day_end(): void
    {
        // Test that the get_day_begin function creates a SugarDateTime
        // object where the time is 23:59:59.
        $actual = (new SugarDateTime('2019-01-01'))->get_day_end();
        $expected = new SugarDateTime('2019-01-01 23:59:59');
        self::assertEquals($expected, $actual);
    }

    public function testasDb(): void
    {
        // Test that the asDb function returns a string formatted for use in
        // the database.
        $actual = (new SugarDateTime('2019-1-1'))->asDb();
        $expected = '2019-01-01 00:00:00';
        self::assertEquals($expected, $actual);
    }

    public function testasDbDate(): void
    {
        // Test that the asDbDate function returns a string formatted for use
        // in the database.
        $actual = (new SugarDateTime('2019-1-1'))->asDbDate();
        $expected = '2019-01-01';
        self::assertEquals($expected, $actual);
    }

    public function testget_date_str(): void
    {
        // Test that the get_date_str function returns a string for use in
        // URL parameters.
        $actual = (new SugarDateTime('2019-1-1'))->get_date_str();
        $expected = '&year=2019&month=1&day=1&hour=0';
        self::assertEquals($expected, $actual);
    }

    public function testget_day_by_index_this_month(): void
    {
        // Test that the get_day_by_index_this_month function returns a
        // SugarDateTime representing the correct day of the month.
        $actual = (new SugarDateTime('2019-1-1'))->get_day_by_index_this_month(28);
        $expected = new SugarDateTime('2019-01-29');
        self::assertEquals($expected, $actual);
    }

    public function testget_day_by_index_this_monthWithExcessiveValue(): void
    {
        // Test that the get_day_by_index_this_month function returns a
        // SugarDateTime representing the correct day of the month, even when
        // the index provided is greater than the number of days in the month.
        $actual = (new SugarDateTime('2019-1-1'))->get_day_by_index_this_month(32);
        $expected = new SugarDateTime('2019-02-02');
        self::assertEquals($expected, $actual);
    }
}
