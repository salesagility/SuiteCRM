<?php

require_once 'jssource/minify_utils.php';

/**
 * Test joinAndMinifyJSFiles function
 *
 * @category Test
 * @package  SuiteCRM
 * @author   Jose C. Massón <jose@gcoop.coop>
 * @license  GPLv3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/salesagility/SuiteCRM
 *
 * @return none
 */
class Minify_UtilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    /**
     * Test joinAndMinifyJSFiles function
     *
     * @author Jose C. Massón <jose@gcoop.coop>
     *
     * @return none
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test joinAndMinifyJSFiles function
     *
     * @author Jose C. Massón <jose@gcoop.coop>
     *
     * @return none
     */
    public function testjoinAndMinifyJSFiles()
    {

        $jsFiles = array (
            'jssource/src_files/modules/Accounts/Account.js',
            'jssource/src_files/modules/Contacts/Contact.js',
        );

        $jsMinified = joinAndMinifyJSFiles($jsFiles);
        $jsURI = getcwd().'/'.$jsMinified;
        $len = stripos($jsURI, '?');
        $jsURI = substr($jsURI, 0, $len);
        $jsContent = sugar_file_get_contents($jsURI);
        $this->assertGreaterThan(0, strlen($jsContent));
    } 

    /**
     * Test processJSFilesContents function
     *
     * @author Jose C. Massón <jose@gcoop.coop>
     *
     * @return none
     */    
    public function testprocessJSFilesContents()
    {

        $jsFiles = array (
            'jssource/src_files/modules/Accounts/Account.js',
            'jssource/src_files/modules/Contacts/Contact.js',
        );

        $jsContent = processJSFilesContents($jsFiles);
        $this->assertGreaterThan(0, strlen($jsContent));
    }

    /**
     * Test joinAndMinifyJSFiles and processJSFilesContents
     *
     * @author Jose C. Massón <jose@gcoop.coop>
     *
     * @return none
     */    
    public function testprocessJSFilesContentsVSjoinAndMinifyJSFiles()
    {

        $jsFiles = array (
            'jssource/src_files/modules/Accounts/Account.js',
            'jssource/src_files/modules/Contacts/Contact.js',
        );

        $jsMinified = joinAndMinifyJSFiles($jsFiles);
        $jsURI = getcwd().'/'.$jsMinified;
        $len = stripos($jsURI, '?');
        $jsURI = substr($jsURI, 0, $len);
        $jsContentMinified = sugar_file_get_contents($jsURI);
        $jsContent = processJSFilesContents($jsFiles);
        $this->assertGreaterThan(strlen($jsContentMinified), strlen($jsContent));
    }    
}
