<?php

require_once 'include/utils/progress_bar_utils.php';
class progress_bar_utilsTest extends PHPUnit_Framework_TestCase
{
    public function testprogress_bar_flush()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            progress_bar_flush();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testdisplay_flow_bar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            display_flow_bar('test', 0);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function teststart_flow_bar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            start_flow_bar('test', 1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testdestroy_flow_bar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            destroy_flow_bar('test');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testdisplay_progress_bar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            display_progress_bar('test', 80, 100);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testupdate_progress_bar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            update_progress_bar('test', 80, 100);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }
}
