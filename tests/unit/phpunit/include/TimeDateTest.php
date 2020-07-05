<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class TimeDateTest extends SuitePHPUnitFrameworkTestCase
{
    public function testget_date_format()
    {
        // Validate that it gets the date format from the user's preferences.
        $user = BeanFactory::newBean('Users');
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('datef', 'Y-m-d');

        $timeDate = new TimeDate($user);
        $actual = $timeDate->get_date_format();
        $expected = 'Y-m-d';
        $this->assertEquals($expected, $actual);
    }

    public function testget_time_format()
    {
        // Validate that it gets the time format from the user's preferences.
        $user = BeanFactory::newBean('Users');
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('timef', 'H:i:s');

        $timeDate = new TimeDate($user);
        $actual = $timeDate->get_time_format();
        $expected = 'H:i:s';
        $this->assertEquals($expected, $actual);
    }

    public function testget_date_time_format()
    {
        // Validate that it gets the date time format from the user's preferences.
        $user = BeanFactory::newBean('Users');
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('datef', 'Y-m-d');
        $userPreference->setPreference('timef', 'H:i:s');

        $timeDate = new TimeDate($user);
        $actual = $timeDate->get_date_time_format();
        $expected = 'Y-m-d H:i:s';
        $this->assertEquals($expected, $actual);
    }

    public function testget_first_day_of_week()
    {
        // Validate that it gets the first day of the week from the user's
        // preferences.
        $user = BeanFactory::newBean('Users');
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('fdow', 1);

        $timeDate = new TimeDate($user);
        $actual = $timeDate->get_first_day_of_week();
        $expected = 1;
        $this->assertEquals($expected, $actual);
    }

    public function testget_first_day_of_week_defaultResponse()
    {
        // When no user is specified for the TimeDate,
        // it defaults to 0 aka Sunday.
        $timeDate = new TimeDate();
        $actual = $timeDate->get_first_day_of_week();
        $expected = 0;
        $this->assertEquals($expected, $actual);
    }

    public function testmerge_date_time()
    {
        // Merges the date and time formats given two strings.
        // Literally just puts a space in between them.
        $timeDate = new TimeDate();
        $actual = $timeDate->merge_date_time('Y-m-d', 'H:i:s');
        $expected = 'Y-m-d H:i:s';
        $this->assertEquals($expected, $actual);
    }

    public function testsplit_date_time()
    {
        // Splits the date time format into an array of two items when given 
        // a valid string.
        $timeDate = new TimeDate();
        $actual = $timeDate->split_date_time('Y-m-d H:i:s');
        $expected = ['Y-m-d', 'H:i:s'];
        $this->assertEquals($expected, $actual);
    }

    public function testhttpTime()
    {
        // Returns a timestamp in the format defined by RFC 2616.
        $timeDate = new TimeDate();
        $actual = $timeDate->httpTime(1546300800);
        $expected = 'Tue, 01 Jan 2019 00:00:00 GMT';
        $this->assertEquals($expected, $actual);
    }

    public function testto_db_time()
    {
        // Test that the function returns the time but not the date, even if
        // a date is provided.
        $user = BeanFactory::newBean('Users');
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('datef', 'Y-m-d');
        $userPreference->setPreference('timef', 'H:i:s');

        $timeDate = new TimeDate($user);

        $actual = $timeDate->to_db_time('2019-01-01 11:00:00');
        $expected = '11:00:00';
        $this->assertEquals($expected, $actual);

        $actual2 = $timeDate->to_db_time('23:30:00');
        $expected2 = '23:30:00';
        $this->assertEquals($expected2, $actual2);
    }

    public function testto_db_date_time()
    {
        // Test that the function returns the full date time as an array.
        // We create a user here, but it doesn't actually take the user's
        // preferences into account. This should probably be fixed at some
        // point.
        $user = BeanFactory::newBean('Users');
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('datef', 'Y-m-d');
        $userPreference->setPreference('timef', 'H:i:s');
        $timeDate = new TimeDate($user);

        $actual = $timeDate->to_db_date_time('2019-01-01', '11:00:00');
        $expected = ['2019-01-01', '11:00:00'];
        $this->assertEquals($expected, $actual);
    }

    public function testsplitTime()
    {
        // Split time when the input is only a time represented as a string.
        $timeDate = new TimeDate();

        $actual = $timeDate->splitTime('11:30:00', 'H:i:s');
        $expected = [
            'h' => '11',
            'm' => '30',
            's' => '00'
        ];
        $this->assertEquals($expected, $actual);
    }

    public function testsplitTimeWith24HourDateTime()
    {
        // Split time when it has a full date time and uses 24-hour time.
        $timeDate = new TimeDate();
        $actual = $timeDate->splitTime('2019-01-01 23:30:15', 'Y-m-d H:i:s');
        $expected = [
            'h' => '23',
            'm' => '30',
            's' => '15'
        ];
        $this->assertEquals($expected, $actual);
    }

    public function testsplitTimeWithPM()
    {
        // Split time when it has a full date time and AM/PM.
        $timeDate = new TimeDate();
        $actual = $timeDate->splitTime('2019-01-01 9:15:01 PM', 'Y-m-d H:i:s A');
        $expected = [
            'h' => '9',
            'm' => '15',
            's' => '01',
            'a' => 'PM'
        ];
        $this->assertEquals($expected, $actual);
    }
}
