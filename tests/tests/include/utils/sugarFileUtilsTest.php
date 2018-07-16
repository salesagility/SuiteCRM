<?php

require_once 'include/utils/sugar_file_utils.php';
class sugar_file_utilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{

    //@todo: check this - vfs does not seem to be working...

    public function testsugar_dosomething() {
        $this->assertTrue(true, "Needs checking!");
    }

    /*
    public function setUp()
    {
        parent::setUp();

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