<?php

use org\bovigo\vfs\vfsStream;

require_once 'include/utils/file_utils.php';
class file_utilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        $this->rootFs = org\bovigo\vfs\vfsStream::setup('root');
        $this->rootFs->addChild(org\bovigo\vfs\vfsStream::newDirectory('testDir'));
        $this->rootFs->addChild(org\bovigo\vfs\vfsStream::newFile('test.txt')->withContent('Hello world!'));
    }

    public function testclean_path()
    {
        //execute the method and test if it returns expected values

        //invalid path
        $expected = '';
        $path = '';
        $actual = clean_path($path);
        $this->assertSame($expected, $actual);

        //a simple valid path
        $expected = '/SuiteCRM-develop/include/utils';
        $path = '\SuiteCRM-develop\include\utils';
        $actual = clean_path($path);
        $this->assertSame($expected, $actual);

        //valid network path 
        $expected = '//SuiteCRM-develop/include/utils';
        $path = '\\\\/SuiteCRM-develop/include/utils';
        $actual = clean_path($path);
        $this->assertSame($expected, $actual);

        $expected = '/SuiteCRM-develop/include/utils';
        $path = '/SuiteCRM-develop/./include/utils';
        $actual = clean_path($path);
        $this->assertSame($expected, $actual);

        $expected = '/SuiteCRM-develop/include/utils';
        $path = '/SuiteCRM-develop//include/utils';
        $actual = clean_path($path);
        $this->assertSame($expected, $actual);
    }

    public function testcreate_cache_directory()
    {
        //execute the method and test if it created file/dir exists

        $cache_dir = rtrim($GLOBALS['sugar_config']['cache_dir'], '/\\');
        $file = 'Test/';

        if ($this->rootFs->hasChild($file)  == true) {
            rmdir($cache_dir.'/'.$file);
        }

        $actual = create_cache_directory($file);
        $this->assertFileExists($actual);

        if ($this->rootFs->hasChild($file)  == true) {
            rmdir($cache_dir.'/'.$file);
        }
    }

    public function testget_module_dir_list()
    {
        //execute the method and test if it returns expected values

        $expected = array(
            0 => 'ACL',
            1 => 'ACLActions',
            2 => 'ACLRoles',
            3 => 'AM_ProjectTemplates',
            4 => 'AM_TaskTemplates',
            5 => 'AOBH_BusinessHours',
            6 => 'AOD_Index',
            7 => 'AOD_IndexEvent',
            8 => 'AOK_KnowledgeBase',
            9 => 'AOK_Knowledge_Base_Categories',
            10 => 'AOP_Case_Events',
            11 => 'AOP_Case_Updates',
            12 => 'AOR_Charts',
            13 => 'AOR_Conditions',
            14 => 'AOR_Fields',
            15 => 'AOR_Reports',
            16 => 'AOR_Scheduled_Reports',
            17 => 'AOS_Contracts',
            18 => 'AOS_Invoices',
            19 => 'AOS_Line_Item_Groups',
            20 => 'AOS_PDF_Templates',
            21 => 'AOS_Product_Categories',
            22 => 'AOS_Products',
            23 => 'AOS_Products_Quotes',
            24 => 'AOS_Quotes',
            25 => 'AOW_Actions',
            26 => 'AOW_Conditions',
            27 => 'AOW_Processed',
            28 => 'AOW_WorkFlow',
            29 => 'Accounts',
            30 => 'Activities',
            31 => 'Administration',
            32 => 'Alerts',
            33 => 'Audit',
            34 => 'Bugs',
            35 => 'Calendar',
            36 => 'Calls',
            37 => 'Calls_Reschedule',
            38 => 'CampaignLog',
            39 => 'CampaignTrackers',
            40 => 'Campaigns',
            41 => 'Cases',
            42 => 'Charts',
            43 => 'Configurator',
            44 => 'Connectors',
            45 => 'Contacts',
            46 => 'Currencies',
            47 => 'Delegates',
            48 => 'DocumentRevisions',
            49 => 'Documents',
            50 => 'DynamicFields',
            51 => 'EAPM',
            52 => 'EmailAddresses',
            53 => 'EmailMan',
            54 => 'EmailMarketing',
            55 => 'EmailTemplates',
            56 => 'EmailText',
            57 => 'Emails',
            58 => 'Employees',
            59 => 'FP_Event_Locations',
            60 => 'FP_events',
            61 => 'Favorites',
            62 => 'Groups',
            63 => 'Help',
            64 => 'History',
            65 => 'Home',
            66 => 'Import',
            67 => 'InboundEmail',
            68 => 'LabelEditor',
            69 => 'Leads',
            70 => 'MailMerge',
            71 => 'Meetings',
            72 => 'MergeRecords',
            73 => 'ModuleBuilder',
            74 => 'MySettings',
            75 => 'Notes',
            76 => 'OAuthKeys',
            77 => 'OAuthTokens',
            78 => 'Opportunities',
            79 => 'OptimisticLock',
            80 => 'OutboundEmailAccounts',
            81 => 'Project',
            82 => 'ProjectTask',
            83 => 'ProspectLists',
            84 => 'Prospects',
            85 => 'Relationships',
            86 => 'Releases',
            87 => 'Reminders',
            88 => 'Reminders_Invitees',
            89 => 'ResourceCalendar',
            90 => 'Roles',
            91 => 'SavedSearch',
            92 => 'Schedulers',
            93 => 'SchedulersJobs',
            94 => 'SecurityGroups',
            95 => 'Spots',
            96 => 'Studio',
            97 => 'SugarFeed',
            98 => 'Tasks',
            99 => 'TemplateSectionLine',
            100 => 'Trackers',
            101 => 'UpgradeWizard',
            102 => 'UserPreferences',
            103 => 'Users',
            104 => 'iCals',
            105 => 'jjwg_Address_Cache',
            106 => 'jjwg_Areas',
            107 => 'jjwg_Maps',
            108 => 'jjwg_Markers',
            109 => 'vCals',
        );

        $actual = get_module_dir_list();
        sort($actual);
        sort($expected);
        $this->assertSame($expected, $actual);
    }

    public function testmk_temp_dir()
    {
        self::markTestIncomplete('Test failing in php 7.1 and 7.2: tempnam(): file created in the system\'s temporary directory');
        //execute the method and test if created dir/file exists

        //without prefix
        $actual = mk_temp_dir('vfs://root', '');
        $this->assertFileExists($actual);

        //with prefix
        $actual = mk_temp_dir('vfs://root', 'pfx');
        $this->assertFileExists($actual);
    }

    public function testremove_file_extension()
    {
        //execute the method and test if it returns expected values

        //no file extension
        $expected = '';
        $actual = remove_file_extension('fileNoExt');
        $this->assertSame($expected, $actual);

        //simple file extension
        $expected = 'file1';
        $actual = remove_file_extension('file1.txt');
        $this->assertSame($expected, $actual);

        //complex filename
        $expected = 'file2.ext1';
        $actual = remove_file_extension('file2.ext1.ext2');
        $this->assertSame($expected, $actual);
    }

    public function testwrite_array_to_file()
    {
        $this->markTestSkipped('write_array_to_file cannot be tested with vfsStream');
        //execute the method and test if it returns true and verify contents

        $cache_dir = 'vfs://root';
        $tempArray = array('Key1' => array('Key2' => 'value2', 'Key3' => 'value3'));

        //without header
        $expected = "<?php\n// created: ".date('Y-m-d H:i:s')."\n\$tempArray = array (\n  'Key1' => \n  array (\n    'Key2' => 'value2',\n    'Key3' => 'value3',\n  ),\n);";
        $actual = write_array_to_file('tempArray', $tempArray, $cache_dir.'\tempArray.txt');
        $this->assertTrue($actual);
        $actual_contents = file_get_contents($cache_dir.'\tempArray.txt');
        $this->assertSame($expected, $actual_contents);
        unlink($cache_dir.'\tempArray.txt');

        //with header
        $expected = "test header \$tempArray = array (\n  'Key1' => \n  array (\n    'Key2' => 'value2',\n    'Key3' => 'value3',\n  ),\n);";
        $actual = write_array_to_file('tempArray', $tempArray, $cache_dir.'\tempArray.txt', 'w', 'test header ');
        $this->assertTrue($actual);
        $actual_contents = file_get_contents($cache_dir.'\tempArray.txt');
        $this->assertSame($expected, $actual_contents);
        unlink($cache_dir.'\tempArray.txt');
    }

    public function testwrite_encoded_file()
    {
        //execute the method and test if it created file exists

        $cache_dir = 'vfs://root';

        //without filename 
        $tempArray = array('filename' => 'soap_array.txt', 'md5' => '523ef67de860fc54794f27117dba4fac', 'data' => 'some soap data');
        $actual = write_encoded_file($tempArray, $cache_dir, '');
        $this->assertFileExists($actual);
        unlink($actual);

        //with filename
        $tempArray = array('md5' => '523ef67de860fc54794f27117dba4fac', 'data' => 'some soap data');
        $actual = write_encoded_file($tempArray, $cache_dir, 'soap_array.txt');
        $this->assertFileExists($actual);
        unlink($actual);
    }

    public function testcreate_custom_directory()
    {
        //execute the method and test if it created file/dir exists

        $file = 'Test/';

        $vfs = $this->rootFs;
        if ($vfs->hasChild($file)  == true) {
            rmdir('custom/'.$file);
        }

        $actual = create_custom_directory($file);
        $this->assertFileExists($actual);

        if ($vfs->hasChild($file)  == true) {
            rmdir('custom/'.$file);
        }
    }

    public function testgenerateMD5array()
    {
        
        self::markTestIncomplete('environment dependency');
        
        //execute the method and test if it returns expected values

        $expected = array(
            'data/Relationships/EmailAddressRelationship.php' => '2f04780ddd15f7b65a35c75c303ed5d7',
            'data/Relationships/M2MRelationship.php' => 'd892195344955fe5b344fd48c3f0290a',
            'data/Relationships/One2MBeanRelationship.php' => '687f93e57b8a8acdd9bb911bc153598d',
            'data/Relationships/One2MRelationship.php' => '8a2fbfed8d6b74faf2851eb0a6c6bad3',
            'data/Relationships/One2OneBeanRelationship.php' => '765b8785d5ca576a8530db99bdf4d411',
            'data/Relationships/One2OneRelationship.php' => '0385f7577687a402d9603ef26984257e',
            'data/Relationships/RelationshipFactory.php' => '3bf18f0ff637fb3700d3ac0b75a0fb1b',
            'data/Relationships/SugarRelationship.php' => '87e9151907a03823b1045402d46f022c',
        );

        $actual = generateMD5array('data/Relationships/');
        $this->assertSame($expected, $actual);
    }

    public function testmd5DirCompare()
    {
        //execute the method and test if it returns expected values

        $expected = array();

        $actual = md5DirCompare('include/MVC/', 'include/MVC/', array('views'));
        $this->assertSame($expected, $actual);
    }

    public function testgetFiles()
    {
        //execute the method and test if it returns expected values

        //test without pattern
        $expected = array(
            'include/MVC/Controller/ControllerFactory.php',
            'include/MVC/Controller/file_access_control_map.php',
            'include/MVC/Controller/action_file_map.php',
            'include/MVC/Controller/action_view_map.php',
            'include/MVC/Controller/entry_point_registry.php',
            'include/MVC/Controller/SugarController.php',
        );
        $actual = array();
        getFiles($actual, 'include/MVC/Controller');
        sort($actual);
        sort($expected);
        $this->assertSame($expected, $actual);

        //test with pattern
        $expected = array(
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
        $actual = array();
        getFiles($actual, 'include/MVC', '@view@');
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testreadfile_chunked()
    {
        //execute the method and test if it returns expected values

        $expected = file_get_contents('config.php');

        //retbytes parameter false
        ob_start();
        $actual = readfile_chunked('config.php', false);
        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertTrue($actual);
        $this->assertSame($expected, $renderedContent);

        //retbytes parameter true/default
        ob_start();
        $actual = readfile_chunked('config.php');
        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($actual, strlen($renderedContent));
        $this->assertSame($expected, $renderedContent);
    }

    public function testsugar_rename()
    {
        //execute the method and test if it returns true/success

        $dir = 'vfs://root';
        $file = 'test.txt';
        $vfs = $this->rootFs;
        if ($vfs->hasChild($file)  != true) {
            write_array_to_file('', '', $dir.'/'.$file);
        }

        //test with empty file names
        $actual = sugar_rename('', '');
        $this->assertFalse($actual);

        //test with valid file names 
        $actual = sugar_rename($dir.'/'.$file, $dir.'/'.'newtest.txt');
        $this->assertTrue($actual);

        unlink($dir.'/'.'newtest.txt');
    }

    public function testfileToHash()
    {
        
        if(isset($_SESSION)) {
            $_session = $_SESSION;
        }
        
        //execute the method and test if it returns expected values

        //test with empty filename string
        $expected = 'd41d8cd98f00b204e9800998ecf8427e';
        $hash = fileToHash('');
        $this->assertSame($expected, $hash);
        $this->assertSame('', $_SESSION['file2Hash'][$hash]);

        //test with valid filename
        $expected = '9e5e2527d69c009a81b8ecd730f3957e';
        $hash = fileToHash('config.php');
        $this->assertSame($expected, $hash);
        $this->assertSame('config.php', $_SESSION['file2Hash'][$hash]);

        // clean up

        if(isset($_session)) {
            $_SESSION = $_session;
        } else {
            unset($_SESSION);
        }
    }

    public function testhashToFile()
    {
        
        if(isset($_SESSION)) {
            $_session = $_SESSION;
        }
        
        //execute the method and test if it returns expected values

        //test with invalid hash.
        $actual = hashToFile('');
        $this->assertFalse($actual);

        //test with a newly generated hash
        $hash = fileToHash('config.php');
        $actual = hashToFile($hash);
        $this->assertSame('config.php', $actual);

        // clean up

        if(isset($_session)) {
            $_SESSION = $_session;
        } else {
            unset($_SESSION);
        }
    }

    public function testget_file_extension()
    {
        //execute the method and test if it returns expected values

        $file = ''; // Only variables should be passed by reference in php7
        $this->assertSame('', get_file_extension($file));
        
        $file = 'test.txt'; // Only variables should be passed by reference in php7
        $this->assertSame('txt', get_file_extension($file));
        
        $file = 'test.ext.Txt'; // Only variables should be passed by reference in php7
        $this->assertSame('Txt', get_file_extension($file, false));
        
        $file = 'test.ext.TXT'; // Only variables should be passed by reference in php7
        $this->assertSame('txt', get_file_extension($file, true));
    }

    public function testget_mime_content_type_from_filename()
    {
        //execute the method and test if it returns expected values

        $this->assertSame('', get_mime_content_type_from_filename(''));
        $this->assertSame('application/octet-stream', get_mime_content_type_from_filename('file.tmp'));
        $this->assertSame('text/plain', get_mime_content_type_from_filename('file.txt'));
        $this->assertSame('application/x-shockwave-flash', get_mime_content_type_from_filename('file.swf'));
        $this->assertSame('video/x-flv', get_mime_content_type_from_filename('file.flv'));
    }

    public function testcleanFileName()
    {
        //execute the method and test if it returns expected values

        $this->assertSame('file.txt', cleanFileName('file<?>.txt'));
        $this->assertSame('file_1.txt', cleanFileName('file_1<?>.txt'));
        $this->assertSame('file.txt', cleanFileName('file.txt'));
    }

    public function testcleanDirName()
    {
        //execute the method and test if it returns expected values

        $this->assertSame('testDir', cleanDirName('./testDir'));
        $this->assertSame('testDir', cleanDirName('..\\testDir'));
        $this->assertSame('testDir', cleanDirName('\\test/Dir/'));
    }
}
