<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

require_once 'include/utils/sugar_file_utils.php';

/**
 * Class sugar_file_utilsTest
 */
class sugar_file_utilsTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    
    //@todo: check this - vfs does not seem to be working...
    
    public function testsugar_dosomething()
    {
        $this->assertTrue(true, "Needs checking!");
    }
    
    /*
    public function setUp() {
        $rootFs = org\bovigo\vfs\vfsStream::setup('root');
        $rootFs->addChild(org\bovigo\vfs\vfsStream::newDirectory('testDir'));
        $rootFs->addChild(org\bovigo\vfs\vfsStream::newFile('test.txt')->withContent("Hello world!"));
    }

	public function testsugar_mkdir()
	{
		//execute the method and test if it returns true and created dir exists

		$dir = "vfs://root";

		//non recursive
		$result = sugar_mkdir($dir . "/mkdirTest");
		$this->assertFileExists($dir . "/mkdirTest");
		$this->assertTrue($result);

		//recursive
		$result = sugar_mkdir($dir . "/mkdirTest/test",null,true);
		$this->assertFileExists($dir . "/mkdirTest/test");
		$this->assertTrue($result);
	}

	public function testsugar_fopen()
	{
		//execute the method and test if it doesn't returns false
		$result = sugar_fopen('vfs://root/test.txt', 'r');
		$this->assertNotFalse($result);
	}


	public function testsugar_file_put_contents()
	{
		//execute the method and test if it doesn't returns false and returns the number of bytes written

        $dir = "vfs://root";
		$result = sugar_file_put_contents( $dir . '/testfile.txt', 'some test data');
		$this->assertNotFalse($result);
		$this->assertEquals(14,$result);
	}



	public function testsugar_file_put_contents_atomic()
	{
        $this->markTestSkipped('Atomic file put cannot be tested with vfsStream');
		//execute the method and test if it returns success(true)
        $dir = "vfs://root";
		$result = sugar_file_put_contents_atomic( $dir . '/atomictestfile.txt', 'some test data');
		$this->assertTrue($result);
	}


	public function testsugar_file_get_contents()
	{
		//execute the method and test if it doesn't returns false and returns the expected contents
        $dir = "vfs://root";
		$result = file_get_contents( $dir . '/test.txt');

		$this->assertNotFalse($result);
		$this->assertEquals('Hello world!',$result);
	}


	public function testsugar_touch()
	{
		//execute the method and test if it returns success(true)

        $dir = "vfs://root";
		$test_dt = time() - 3600 ;
		$expected = date("m d Y H:i:s",  time() - 3600 );

		//test wihout modified date param
		$result = sugar_touch( $dir . '/testfiletouch.txt');
		$this->assertTrue($result);

		//test wih modified date param
		$result = sugar_touch( $dir . '/testfiletouch.txt',$test_dt,$test_dt);
		$file_dt = date ("m d Y H:i:s", filemtime($dir . '/testfiletouch.txt')) ;

		$this->assertTrue($result);
		$this->assertSame($file_dt, $expected );
	}


	public function testsugar_chmod()
	{
        $this->markTestSkipped('Permissions cannot be tested with vfsStream');
		//execute the method and test if it returns success(true)
        $dir = "vfs://test";
		$result = sugar_chmod($dir . '/test.txt',0777);
		$this->assertTrue($result);
	}


	public function testsugar_chown()
	{
        $this->markTestSkipped('Permissions cannot be tested with vfsStream');
		//execute the method and test if it returns success(true)
        $dir = "vfs://test";
		$result = sugar_chown($dir . '/test.txt');
		$this->assertFalse($result);

        $result = sugar_chown($dir . '/test.txt',org\bovigo\vfs\vfsStream::getCurrentUser());
        $this->assertTrue($result);

	}


	public function testsugar_chgrp()
	{
        $this->markTestSkipped('Permissions cannot be tested with vfsStream');
		//execute the method and test if it returns success(true)
        $dir = "vfs://test";
		$result = sugar_chgrp($dir . '/test.txt');
		$this->assertFalse($result);

        $result = sugar_chgrp($dir . '/test.txt',org\bovigo\vfs\vfsStream::getCurrentGroup());
        $this->assertFalse($result);
	}


	public function testget_mode()
	{
		//test with all mods defined in config
		$this->assertSame(1528,get_mode());
		$this->assertSame(1528,get_mode('dir_mode', 10));
		$this->assertSame(493,get_mode('file_mode', 10));
		$this->assertSame('',get_mode('user', 10));
		$this->assertSame('',get_mode('group', 10));
	}

	public function testsugar_is_dir()
	{
		$dir = "vfs://root";

		$this->assertFalse(sugar_is_dir('')); //invalid dir
        $this->assertFalse(sugar_is_dir($dir."/foo")); //invalid dir
		$this->assertTrue(sugar_is_dir($dir."/testDir")); //valid dir

	}

	public function testsugar_is_file()
	{
		$this->assertFalse(sugar_is_file('')); //invalid file
		$this->assertFalse(sugar_is_file('vfs://config')); //invalid file
		$this->assertTrue(is_file('vfs://root/test.txt')); //valid file
	}


	public function testsugar_cached()
	{
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');

		$this->assertSame($cache_dir . '/', sugar_cached('')); //invalid file
		$this->assertSame($cache_dir . '/config', sugar_cached('config')); //valid file
		$this->assertSame($cache_dir . '/modules' , sugar_cached('modules')); //valid file

	}
    */
    
}