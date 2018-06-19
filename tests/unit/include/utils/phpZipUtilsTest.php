<?php


require_once 'include/upload_file.php';
require_once 'include/utils/php_zip_utils.php';
class php_zip_utilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testunzip()
    {
        

        $cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
        $files_list = array('config.php', 'config_override.php');
        $file = $cache_dir.'/zipTest.zip';

        
        if (!file_exists($file)) {
            zip_files_list($file, $files_list);
        }

        $result = unzip($file, $cache_dir);
        $this->assertTrue($result);

        $this->markTestIncomplete('File handling doesnt works in localy');



        unlink($cache_dir.'/config.php');
        unlink($cache_dir.'/config_override.php');
    }

    public function testunzip_file()
    {

        

        $cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
        $files_list = array('config.php', 'config_override.php');
        $file = $cache_dir.'/zipTest.zip';

        
        if (!file_exists($file)) {
            zip_files_list($file, $files_list);
        }

        $result = unzip_file($file, null, $cache_dir);
        $this->assertTrue($result);

        $this->markTestIncomplete('File handling doesnt works in localy');



        unlink($cache_dir.'/config.php');
        unlink($cache_dir.'/config_override.php');
    }

    public function testzip_dir()
    {
        
        $cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
        $file = $cache_dir.'/zipTest.zip';

        if (file_exists($file)) {
            unlink($file);
        }

        zip_dir($cache_dir.'/modules', $file);

        $this->assertFileExists($file);

        unlink($file);
    }

    public function testzip_files_list()
    {

        
        $cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
        $file = $cache_dir.'/ziplistTest.zip';
        $files_list = array('config.php', 'config_override.php');

        if (file_exists($file)) {
            unlink($file);
        }

        $result = zip_files_list($file, $files_list);

        $this->assertTrue($result);
        $this->assertFileExists($file);

        unlink($file);
    }
}
