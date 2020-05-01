<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once 'include/utils/progress_bar_utils.php';
/**
 * @internal
 */
class progress_bar_utilsTest extends SuitePHPUnitFrameworkTestCase
{
    public function testprogressBarFlush()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            progress_bar_flush(false);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testdisplayFlowBar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            ob_start();
            display_flow_bar('test', 0, 200, false);
            ob_end_clean();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function teststartFlowBar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            ob_start();
            start_flow_bar('test', 1, false);
            ob_end_clean();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testdestroyFlowBar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            ob_start();
            destroy_flow_bar('test', false);
            ob_end_clean();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testdisplayProgressBar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            ob_start();
            display_progress_bar('test', 80, 100, false);
            ob_end_clean();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testupdateProgressBar()
    {
        //execute the method and test if it doesn't throw an exception.
        //this method uses flush so we cannot get and verify content printed
        try {
            ob_start();
            update_progress_bar('test', 80, 100, false);
            ob_end_clean();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }
}
