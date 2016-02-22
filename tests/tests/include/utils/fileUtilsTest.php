<?php

use org\bovigo\vfs\vfsStream,
org\bovigo\vfs\vfsStreamDirectory;

require_once 'include/utils/file_utils.php';
class file_utilsTest extends PHPUnit_Framework_TestCase
{

	public function testclean_path()
	{
		//execute the method and test if it returns expected values
		
		//invalid path
		$expected = "";
		$path = "";
		$actual = clean_path($path);
		$this->assertSame($expected,$actual);
		

		//a simple valid path
		$expected = "/SuiteCRM-develop/include/utils";
		$path = "\SuiteCRM-develop\include\utils";
		$actual = clean_path($path);
		$this->assertSame($expected,$actual);

		
		//valid network path 
		$expected = "\\\\/SuiteCRM-develop/include/utils";
		$path = "\\\\/SuiteCRM-develop/include/utils";
		$actual = clean_path($path);
		$this->assertSame($expected,$actual);
		
		
	}
	
	public function testcreate_cache_directory()
	{
		//execute the method and test if it created file/dir exists
		
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$file = "Test/";
		
		$vfs = vfsStream::setup($cache_dir);
		
		if ( $vfs->hasChild($file)  == true) 
			rmdir($cache_dir . "/" . $file);
		
		$actual = create_cache_directory($file);
		$this->assertFileExists($actual);
		
		if ( $vfs->hasChild($file)  == true) 
			rmdir($cache_dir . "/" . $file);
		
	}
	
	public function testget_module_dir_list()
	{
		//execute the method and test if it returns expected values
		
		$expected  = array (
				'Accounts' => 'Accounts',
				'ACL' => 'ACL',
				'ACLActions' => 'ACLActions',
				'ACLRoles' => 'ACLRoles',
				'Activities' => 'Activities',
				'Administration' => 'Administration',
				'Alerts' => 'Alerts',
				'AM_ProjectTemplates' => 'AM_ProjectTemplates',
				'AM_TaskTemplates' => 'AM_TaskTemplates',
				'AOD_Index' => 'AOD_Index',
				'AOD_IndexEvent' => 'AOD_IndexEvent',
				'AOK_KnowledgeBase' => 'AOK_KnowledgeBase',
				'AOK_Knowledge_Base_Categories' => 'AOK_Knowledge_Base_Categories',
				'AOP_Case_Events' => 'AOP_Case_Events',
				'AOP_Case_Updates' => 'AOP_Case_Updates',
				'AOR_Charts' => 'AOR_Charts',
				'AOR_Conditions' => 'AOR_Conditions',
				'AOR_Fields' => 'AOR_Fields',
				'AOR_Reports' => 'AOR_Reports',
				'AOR_Scheduled_Reports' => 'AOR_Scheduled_Reports',
				'AOS_Contracts' => 'AOS_Contracts',
				'AOS_Invoices' => 'AOS_Invoices',
				'AOS_Line_Item_Groups' => 'AOS_Line_Item_Groups',
				'AOS_PDF_Templates' => 'AOS_PDF_Templates',
				'AOS_Products' => 'AOS_Products',
				'AOS_Products_Quotes' => 'AOS_Products_Quotes',
				'AOS_Product_Categories' => 'AOS_Product_Categories',
				'AOS_Quotes' => 'AOS_Quotes',
				'AOW_Actions' => 'AOW_Actions',
				'AOW_Conditions' => 'AOW_Conditions',
				'AOW_Processed' => 'AOW_Processed',
				'AOW_WorkFlow' => 'AOW_WorkFlow',
				'Audit' => 'Audit',
				'Bugs' => 'Bugs',
				'Calendar' => 'Calendar',
				'Calls' => 'Calls',
				'Calls_Reschedule' => 'Calls_Reschedule',
				'CampaignLog' => 'CampaignLog',
				'Campaigns' => 'Campaigns',
				'CampaignTrackers' => 'CampaignTrackers',
				'Cases' => 'Cases',
				'Charts' => 'Charts',
				'Configurator' => 'Configurator',
				'Connectors' => 'Connectors',
				'Contacts' => 'Contacts',
				'Currencies' => 'Currencies',
				'Delegates' => 'Delegates',
				'DocumentRevisions' => 'DocumentRevisions',
				'Documents' => 'Documents',
				'DynamicFields' => 'DynamicFields',
				'EAPM' => 'EAPM',
				'EmailAddresses' => 'EmailAddresses',
				'EmailMan' => 'EmailMan',
				'EmailMarketing' => 'EmailMarketing',
				'Emails' => 'Emails',
				'EmailTemplates' => 'EmailTemplates',				
				'EmailText' => 'EmailText',
				'Employees' => 'Employees',
				'Favorites' => 'Favorites',
				'FP_events' => 'FP_events',
				'FP_Event_Locations' => 'FP_Event_Locations',
				'Groups' => 'Groups',
				'Help' => 'Help',
				'History' => 'History',
				'Home' => 'Home',
				'iCals' => 'iCals',
				'Import' => 'Import',
				'InboundEmail' => 'InboundEmail',
				'jjwg_Address_Cache' => 'jjwg_Address_Cache',
				'jjwg_Areas' => 'jjwg_Areas',
				'jjwg_Maps' => 'jjwg_Maps',
				'jjwg_Markers' => 'jjwg_Markers',
				'LabelEditor' => 'LabelEditor',
				'Leads' => 'Leads',
				'MailMerge' => 'MailMerge',
				'Meetings' => 'Meetings',
				'MergeRecords' => 'MergeRecords',
				'ModuleBuilder' => 'ModuleBuilder',
				'MySettings' => 'MySettings',
				'Notes' => 'Notes',
				'OAuthKeys' => 'OAuthKeys',
				'OAuthTokens' => 'OAuthTokens',
				'Opportunities' => 'Opportunities',
				'OptimisticLock' => 'OptimisticLock',
				'Project' => 'Project',
				'ProjectTask' => 'ProjectTask',
				'ProspectLists' => 'ProspectLists',
				'Prospects' => 'Prospects',
				'Relationships' => 'Relationships',
				'Releases' => 'Releases',
				'Roles' => 'Roles',
				'SavedSearch' => 'SavedSearch',
				'Schedulers' => 'Schedulers',
				'SchedulersJobs' => 'SchedulersJobs',
				'SecurityGroups' => 'SecurityGroups',
				'Studio' => 'Studio',
				'SugarFeed' => 'SugarFeed',
				'Tasks' => 'Tasks',
				'Trackers' => 'Trackers',
				'UpgradeWizard' => 'UpgradeWizard',
				'UserPreferences' => 'UserPreferences',
				'Users' => 'Users',
				'vCals' => 'vCals',
				'Versions' => 'Versions',
				);
		
		
		$actual = get_module_dir_list();
		$this->assertSame($expected,$actual);
		
	}
	
	public function testmk_temp_dir(  )
	{
		//execute the method and test if created dir/file exists
		
		//without prefix
		$actual = mk_temp_dir('Test', '' );
		$this->assertFileExists($actual);

		//with prefix
		$actual = mk_temp_dir('Test', 'pfx' );
		$this->assertFileExists($actual);
		
	}
	
	public function testremove_file_extension(  )
	{
		//execute the method and test if it returns expected values
		
		//no file extension
		$expected = "";
		$actual = remove_file_extension('fileNoExt');
		$this->assertSame($expected,$actual);
		
		
		//simple file extension
		$expected = "file1";
		$actual = remove_file_extension('file1.txt');
		$this->assertSame($expected,$actual);
		
		
		//complex filename
		$expected = "file2.ext1";
		$actual =  remove_file_extension('file2.ext1.ext2');
		$this->assertSame($expected,$actual);
		
	}
	
	public function testwrite_array_to_file()
	{
		//execute the method and test if it returns true and verify contents
		
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$tempArray = Array("Key1" => Array( "Key2" => "value2" , "Key3" => "value3" ));
		
		
		//without header
		$expected = "<?php\n// created: " . date('Y-m-d H:i:s') . "\n\$tempArray = array (\n  'Key1' => \n  array (\n    'Key2' => 'value2',\n    'Key3' => 'value3',\n  ),\n);" ;
		$actual = write_array_to_file('tempArray', $tempArray, $cache_dir . '\tempArray.txt');
		$this->assertTrue($actual);
		$actual_contents = file_get_contents($cache_dir . '\tempArray.txt');
		$this->assertSame($expected,$actual_contents);
		unlink($cache_dir . '\tempArray.txt');
		
		//with header
		$expected = "test header \$tempArray = array (\n  'Key1' => \n  array (\n    'Key2' => 'value2',\n    'Key3' => 'value3',\n  ),\n);" ;
		$actual = write_array_to_file('tempArray', $tempArray, $cache_dir . '\tempArray.txt','w' ,'test header ');
		$this->assertTrue($actual);
		$actual_contents = file_get_contents($cache_dir . '\tempArray.txt');
		$this->assertSame($expected,$actual_contents);
		unlink($cache_dir . '\tempArray.txt');
		
		
	}
	
	public function testwrite_encoded_file( )
	{
		//execute the method and test if it created file exists
		
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		
		//without filename 
		$tempArray = Array("filename" =>'soap_array.txt' , "md5" => "523ef67de860fc54794f27117dba4fac" , "data" => "some soap data" );
		$actual = write_encoded_file( $tempArray, $cache_dir, "" );
		$this->assertFileExists($actual);
		unlink($actual);
		
		
		//with filename
		$tempArray = Array("md5" => "523ef67de860fc54794f27117dba4fac" , "data" => "some soap data" );
		$actual = write_encoded_file( $tempArray, $cache_dir, "soap_array.txt" );
		$this->assertFileExists($actual);
		unlink($actual);
		
	}
	
	public function testcreate_custom_directory()
	{
		//execute the method and test if it created file/dir exists
		
		$file = "Test/";
		
		$vfs = vfsStream::setup('custom');
		if ( $vfs->hasChild($file)  == true)
			rmdir("custom/" . $file);
		
		$actual = create_custom_directory($file);
		$this->assertFileExists($actual);

		if ( $vfs->hasChild($file)  == true)
			rmdir("custom/" . $file);
		
		
	}
	
	
	public function testgenerateMD5array()
	{
		//execute the method and test if it returns expected values
		
		$expected= array (
				'data/Relationships/EmailAddressRelationship.php' => '2f04780ddd15f7b65a35c75c303ed5d7',
				'data/Relationships/M2MRelationship.php' => 'df0167bcbea484df41a6b5d311525065',
				'data/Relationships/One2MBeanRelationship.php' => 'cb7fa293cefb2f5785f77ef25eb1ebfe',
				'data/Relationships/One2MRelationship.php' => '588ad87910bd9d885fe27da77ad13e30',
				'data/Relationships/One2OneBeanRelationship.php' => '765b8785d5ca576a8530db99bdf4d411',
				'data/Relationships/One2OneRelationship.php' => '0385f7577687a402d9603ef26984257e',
				'data/Relationships/RelationshipFactory.php' => '3bd7cc6998beaf82a13808f54bff1c2d',
				'data/Relationships/SugarRelationship.php' => '8d0fa8ae0f41ac34eb5d0c04f0e02825',
		); 
		
		$actual = generateMD5array('tests/data');
		$this->assertSame($expected,$actual);
			
	}
	
	
	public function testmd5DirCompare()
	{
		//execute the method and test if it returns expected values
		
		$expected= array (
		  'include/MVC/Controller/ControllerFactory.php' => '38060ca7e9a3e2f08c0c2368d66ec221',
		  'include/MVC/Controller/SugarController.php' => 'fda59ab6f1b51c3b93a54a0dac74847a',
		  'include/MVC/Controller/action_file_map.php' => 'b75dc5a5e6ca9c039619052baea4625a',
		  'include/MVC/Controller/action_view_map.php' => 'e767e84f4ef171e0cf69c3050a4e965f',
		  'include/MVC/Controller/entry_point_registry.php' => 'f56160d421ca14e5df81bee0d066c2eb',
		  'include/MVC/Controller/file_access_control_map.php' => '202ea5076ebb20e1df793fec0e11a52a',
		  'include/MVC/SugarApplication.php' => '8d5b15269025d47fbac970ed6859fa35',
		  'include/MVC/SugarModule.php' => '24721e55f2a5d8abaff5e2750850046f',
		  'include/MVC/SugarModule.php.bak' => '5291665bed27d4619ea29d9b55aa0036',
		  'include/MVC/View/SugarView.php' => '2e5bfb83e4b70c4d9ff449c16d075553',
		  'include/MVC/View/ViewFactory.php' => 'dfe438d9501e3d0cef8eeb54add4d210',
		  'include/MVC/View/tpls/Importvcard.tpl' => '32a76e3b4ff0cf69e0d2f8d260e343e2',
		  'include/MVC/View/tpls/favorites.tpl' => 'c64d62373955df7ea6bbcff8fd25db3e',
		  'include/MVC/View/tpls/modulelistmenu.tpl' => 'c508e8e10e264e90721ee275c570fa3c',
		  'include/MVC/View/tpls/xsrf.tpl' => '4341ab092daa6b6861550537a3778588',
		  'include/MVC/preDispatch.php' => '72a9d95e024727f0b221b802d49a3a72',
		);
		
		$actual = md5DirCompare('include/MVC/', 'custom/include/MVC/',array('views'));
		$this->assertSame($expected,$actual);
		
	}
	
	
	public function testgetFiles() 
	{
		//execute the method and test if it returns expected values
		
		//test without pattern
		$expected = array (
            'include/MVC/Controller/ControllerFactory.php',
            'include/MVC/Controller/file_access_control_map.php',
            'include/MVC/Controller/action_file_map.php',
            'include/MVC/Controller/action_view_map.php',
            'include/MVC/Controller/entry_point_registry.php',
            'include/MVC/Controller/SugarController.php',
		);
		$actual = Array();
		getFiles($actual, 'include/MVC/Controller');
		$this->assertSame($expected,$actual);
		
		
		
		
		//test with pattern
		$expected = array (
				'include/MVC/Controller/action_view_map.php',
				'include/MVC/View/views/view.ajax.php',
				'include/MVC/View/views/view.ajaxui.php',
				'include/MVC/View/views/view.classic.config.php',
				'include/MVC/View/views/view.classic.php',
				'include/MVC/View/views/view.config.php',
				'include/MVC/View/views/view.detail.config.php',
				'include/MVC/View/views/view.detail.php',
				'include/MVC/View/views/view.edit.php',
				'include/MVC/View/views/view.favorites.php',
				'include/MVC/View/views/view.html.php',
				'include/MVC/View/views/view.importvcard.php',
				'include/MVC/View/views/view.importvcardsave.php',
				'include/MVC/View/views/view.json.php',
				'include/MVC/View/views/view.list.php',
				'include/MVC/View/views/view.metadata.php',
				'include/MVC/View/views/view.modulelistmenu.php',
				'include/MVC/View/views/view.multiedit.php',
				'include/MVC/View/views/view.noaccess.php',
				'include/MVC/View/views/view.popup.php',
				'include/MVC/View/views/view.quick.php',
				'include/MVC/View/views/view.quickcreate.php',
				'include/MVC/View/views/view.quickedit.php',
				'include/MVC/View/views/view.serialized.php',
				'include/MVC/View/views/view.sugarpdf.config.php',
				'include/MVC/View/views/view.sugarpdf.php',
				'include/MVC/View/views/view.vcard.php',
				'include/MVC/View/views/view.xml.php',
		);
		$actual = Array();
		getFiles($actual, 'include/MVC','@view@');
        sort($expected);
        sort($actual);
		$this->assertEquals($expected,$actual);

	}
	
	
	public function testreadfile_chunked()
	{
		//execute the method and test if it returns expected values
	
		$expected = file_get_contents('config.php');
		
		
		//retbytes parameter false
		ob_start();		
		$actual = readfile_chunked('config.php',false);		
		$renderedContent = ob_get_contents();
		ob_end_clean();		 
		
		$this->assertTrue($actual);
		$this->assertSame($expected,$renderedContent);

		
		
		//retbytes parameter true/default
		ob_start();
		$actual = readfile_chunked('config.php');
		$renderedContent = ob_get_contents();
		ob_end_clean();
		
		$this->assertEquals($actual,strlen($renderedContent));
		$this->assertSame($expected,$renderedContent);
		
	}
	
	public function testsugar_rename( )
	{
		//execute the method and test if it returns true/success
	
		$cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
		$file = "test.txt";
		$vfs = vfsStream::setup($cache_dir);
		if ( $vfs->hasChild($file)  != true)
			write_array_to_file('', '', $cache_dir . '/' . $file);
		
		//test with empty file names
		$actual = sugar_rename('','');
		$this->assertFalse($actual);
		
		
		//test with valid file names 
		$actual = sugar_rename($cache_dir . '/' . $file, $cache_dir . '/' . 'newtest.txt');
		$this->assertTrue($actual);
		
		unlink($cache_dir . '/' . 'newtest.txt');
		
	}
	
	public function testfileToHash()
	{
		//execute the method and test if it returns expected values
		
		//test with empty filename string
		$expected  = "d41d8cd98f00b204e9800998ecf8427e";
		$hash = fileToHash("");
		$this->assertSame($expected,$hash);
		$this->assertSame("",$_SESSION['file2Hash'][$hash]);
		
		//test with valid filename
		$expected = "9e5e2527d69c009a81b8ecd730f3957e";
		$hash = fileToHash('config.php');
		$this->assertSame($expected,$hash);
		$this->assertSame('config.php', $_SESSION['file2Hash'][$hash]);
		
	}
	
	public function testhashToFile()
	{
		//execute the method and test if it returns expected values
		
		//test with invalid hash.
		$actual = hashToFile("");
		$this->assertFalse($actual);
		
		//test with a newly generated hash
		$hash = fileToHash('config.php');
		$actual = hashToFile($hash);
		$this->assertSame('config.php', $actual);
	}
	
	
	public function testget_file_extension()
	{
		//execute the method and test if it returns expected values
		
		$this->assertSame('', get_file_extension(''));
		$this->assertSame('txt', get_file_extension('test.txt'));
		$this->assertSame('Txt', get_file_extension('test.ext.Txt',false));
		$this->assertSame('txt', get_file_extension('test.ext.TXT',true));
		
	}
	
	
	public function testget_mime_content_type_from_filename()
	{
		//execute the method and test if it returns expected values
		
		$this->assertSame('', get_mime_content_type_from_filename('') );
		$this->assertSame('application/octet-stream', get_mime_content_type_from_filename('file.tmp') );
		$this->assertSame('text/plain', get_mime_content_type_from_filename('file.txt') );
		$this->assertSame('application/x-shockwave-flash', get_mime_content_type_from_filename('file.swf') );
		$this->assertSame('video/x-flv', get_mime_content_type_from_filename('file.flv') );	
		
	}
	
	public function testcleanFileName()
	{
		//execute the method and test if it returns expected values
		
		$this->assertSame("file.txt", cleanFileName("file<?>.txt") );
		$this->assertSame("file_1.txt", cleanFileName("file_1<?>.txt") );
		$this->assertSame("file.txt", cleanFileName("file.txt") );
	}
	
	public function testcleanDirName()
	{
		//execute the method and test if it returns expected values
		
		$this->assertSame("testDir", cleanDirName("./testDir") );
		$this->assertSame("testDir", cleanDirName("..\\testDir") );
		$this->assertSame("testDir", cleanDirName("\\test/Dir/") );
		
	}

}