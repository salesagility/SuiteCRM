<?php

require_once 'include/utils/mvc_utils.php';
class mvc_utilsTest extends PHPUnit_Framework_TestCase
{
    public function testloadParentView()
    {
        //execute the method and test if it doesn't throws an exception
        try {
            loadParentView('classic');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testgetPrintLink()
    {
        error_reporting(E_ERROR | E_PARSE);

        //test without setting REQUEST param
        $expected = "javascript:void window.open('index.php?','printwin','menubar=1,status=0,resizable=1,scrollbars=1,toolbar=0,location=1')";
        $actual = getPrintLink();
        $this->assertSame($expected, $actual);

        //test with required REQUEST param set
        $_REQUEST['action'] = 'ajaxui';
        $expected = 'javascript:SUGAR.ajaxUI.print();';
        $actual = getPrintLink();
        $this->assertSame($expected, $actual);
    }

    public function testajaxBannedModules()
    {
        //execute the method and test verify it returns true
        $result = ajaxBannedModules();
        $this->assertTrue(is_array($result));
    }

    public function testajaxLink()
    {
        //execute the method and test if it returns expected contents

        $this->assertSame('?action=ajaxui#ajaxUILoc=', ajaxLink());
        $this->assertSame('index.php?module=Users&action=detail&record=1', ajaxLink('index.php?module=Users&action=detail&record=1'));
        $this->assertSame('?action=ajaxui#ajaxUILoc=module%3DHome%26action%3Ddetail', ajaxLink('module=Home&action=detail'));
    }
}
