<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

use TimeDate;

class TimeDateTest extends SuitePHPUnitFrameworkTestCase
{
    public function testget_date_format()
    {
        // Validate that it gets the date format from the user's preferences.
        $user = new User();
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('datef', 'Y-m-d');

        $timeDate = new TimeDate($user);
        $actual = $timeDate->get_date_format();
        $expected = 'Y-m-d';
        $this->assertEquals($actual, $expected);
    }

    public function testget_time_format()
    {
        // Validate that it gets the time format from the user's preferences.
        $user = new User();
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('timef', 'H:i:s');

        $timeDate = new TimeDate($user);
        $actual = $timeDate->get_time_format();
        $expected = 'H:i:s';
        $this->assertEquals($actual, $expected);
    }

    public function testget_date_time_format()
    {
        // Validate that it gets the date time format from the user's preferences.
        $user = new User();
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('datef', 'Y-m-d');
        $userPreference->setPreference('timef', 'H:i:s');

        $timeDate = new TimeDate($user);
        $actual = $timeDate->get_date_time_format();
        $expected = 'Y-m-d H:i:s';
        $this->assertEquals($actual, $expected);
    }

    public function testget_first_day_of_week()
    {
        // Validate that it gets the first day of the week from the user's
        // preferences.
        $user = new User();
        $user->retrieve('1');
        $userPreference = new UserPreference($user);
        $userPreference->setPreference('fdow', 1);

        $timeDate = new TimeDate($user);
        $actual = $timeDate->get_first_day_of_week();
        $expected = 1;
        $this->assertEquals($actual, $expected);
    }

    public function testget_first_day_of_week_defaultResponse()
    {
        // When no user is specified for the TimeDate,
        // it defaults to 0 aka Sunday.
        $timeDate = new TimeDate();
        $actual = $timeDate->get_first_day_of_week();
        $expected = 0;
        $this->assertEquals($actual, $expected);
    }

    public function testmerge_date_time()
    {
        // Merges the date and time formats given two strings.
        // Literally just puts a space in between them.
        $timeDate = new TimeDate();
        $actual = $timeDate->merge_date_time('Y-m-d', 'H:i:s');
        $expected = 'Y-m-d H:i:s';
        $this->assertEquals($actual, $expected);
    }

    public function testsplit_date_time()
    {
        // Splits the date time format into an array of two items when given 
        // a valid string.
        $timeDate = new TimeDate();
        $actual = $timeDate->split_date_time('Y-m-d H:i:s');
        $expected = ['Y-m-d', 'H:i:s'];
        $this->assertEquals($actual, $expected);
    }
}
