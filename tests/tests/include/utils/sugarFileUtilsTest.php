<?php

require_once 'include/utils/sugar_file_utils.php';
class sugar_file_utilsTest extends PHPUnit_Framework_TestCase
{

	public function testsugar_mkdir() 
	{
		//execute the method and test if it returns true and created dir exists
		
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		
		//non recursive
		$result = sugar_mkdir($cache_dir . "/mkdirTest");
		$this->assertFileExists($cache_dir . "/mkdirTest");
		$this->assertTrue($result);
		
		//recursive
		$result = sugar_mkdir($cache_dir . "/mkdirTest/test",null,true);
		$this->assertFileExists($cache_dir . "/mkdirTest/test");
		$this->assertTrue($result);
	
		rmdir($cache_dir . "/mkdirTest/test");
		rmdir($cache_dir . "/mkdirTest");
		
	}
	
	
	public function testsugar_fopen()
	{
		//execute the method and test if it doesn't returns false
		$result = sugar_fopen('config.php', 'r');
		$this->assertNotFalse($result);
	}
	
	
	public function testsugar_file_put_contents()
	{
		//execute the method and test if it doesn't returns false and returns the number of bytes written
		
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$result = sugar_file_put_contents( $cache_dir . '/testfile.txt', 'some test data');
		$this->assertNotFalse($result);
		$this->assertEquals(14,$result);
		
		//unlink( $cache_dir . '/testfile.txt');
	}
	
	
	
	public function testsugar_file_put_contents_atomic()
	{
		//execute the method and test if it returns success(true)
		
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$result = sugar_file_put_contents_atomic( $cache_dir . '/atomictestfile.txt', 'some test data');
		$this->assertTrue($result);
	
		unlink( $cache_dir . '/atomictestfile.txt');
	}
	
	
	public function testsugar_file_get_contents()
	{
		//execute the method and test if it doesn't returns false and returns the expected contents
		
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$result = sugar_file_get_contents( $cache_dir . '/testfile.txt');
		
		$this->assertNotFalse($result);
		$this->assertEquals('some test data',$result);
		
		
		unlink( $cache_dir . '/testfile.txt');
	}
	
	
	public function testsugar_touch() 
	{
		//execute the method and test if it returns success(true)
		
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$test_dt = time() - 3600 ; 
		$expected = date("m d Y H:i:s",  time() - 3600 );
		
		//test wihout modified date param
		$result = sugar_touch( $cache_dir . '/testfiletouch.txt');
		$this->assertTrue($result);		
		
		//test wih modified date param
		$result = sugar_touch( $cache_dir . '/testfiletouch.txt',$test_dt,$test_dt);
		$file_dt = date ("m d Y H:i:s", filemtime($cache_dir . '/testfiletouch.txt')) ;
		
		$this->assertTrue($result);
		$this->assertSame($file_dt, $expected );
	
		//unlink( $cache_dir . '/testfiletouch.txt');
	}
	
	
	public function testsugar_chmod() 
	{
		//execute the method and test if it returns success(true)
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$result = sugar_chmod($cache_dir . '/testfiletouch.txt','777');
		$this->assertTrue($result);
		//unlink( $cache_dir . '/testfiletouch.txt');
	}
	
	
	public function testsugar_chown() 
	{
		//execute the method and test if it returns success(true)
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$result = sugar_chown($cache_dir . '/testfiletouch.txt');
		$this->assertTrue($result);
		//unlink( $cache_dir . '/testfiletouch.txt')
	}
	
	
	public function testsugar_chgrp() 
	{
		//execute the method and test if it returns success(true)
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$result = sugar_chgrp($cache_dir . '/testfiletouch.txt');
		$this->assertTrue($result);
		//unlink( $cache_dir . '/testfiletouch.txt');
		
	}
	
	
	public function testget_mode()
	{
		//test with all mods defined in config
		$this->assertSame(0,get_mode()); 
		$this->assertSame(10,get_mode('dir_mode', 10));
		$this->assertSame(10,get_mode('file_mode', 10));
		$this->assertSame(10,get_mode('user', 10));
		$this->assertSame(10,get_mode('group', 10));	
	}
	
	public function testsugar_is_dir()
	{
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		
		$this->assertFalse(sugar_is_dir('')); //invalid dir
		$this->assertTrue(sugar_is_dir($cache_dir)); //valid dir
		
	}
	
	public function testsugar_is_file()
	{
		$this->assertFalse(sugar_is_file('')); //invalid file
		$this->assertFalse(sugar_is_file('config')); //invalid file
		$this->assertTrue(sugar_is_file('config.php')); //valid file 
	}
	
	
	public function testsugar_cached()
	{
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		
		$this->assertSame($cache_dir . '/', sugar_cached('')); //invalid file
		$this->assertSame($cache_dir . '/config', sugar_cached('config')); //valid file		
		$this->assertSame($cache_dir . '/modules' , sugar_cached('modules')); //valid file
		
	}

	
}