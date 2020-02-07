<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */


/**
 * Created on Oct 7, 2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once('soap/SoapHelperFunctions.php');
require_once('modules/MailMerge/MailMerge.php');
require_once('include/upload_file.php');

global  $beanList, $beanFiles;
global $app_strings;
global $app_list_strings;
global $mod_strings;

$xtpl = new XTemplate('modules/MailMerge/Merge.html');
$xtpl->assign("MAILMERGE_IS_REDIRECT", false);

$mTime = microtime();
$redirectUrl = 'index.php?action=index&step=5&module=MailMerge&mtime=' . $mTime;

/**
 * Bug #42275
 * Just refresh download page to get file which was banned by IE security
 */
if (empty($_SESSION['MAILMERGE_MODULE']) && !empty($_SESSION['mail_merge_file_location']) && !empty($_SESSION['mail_merge_file_name'])) {
    $xtpl->assign("MAILMERGE_REDIRECT", true);
} else {
    $module = $_SESSION['MAILMERGE_MODULE'];
    $document_id = $_SESSION['MAILMERGE_DOCUMENT_ID'];
    $selObjs = urldecode($_SESSION['SELECTED_OBJECTS_DEF']);
    $relObjs = (isset($_SESSION['MAILMERGE_RELATED_CONTACTS']) ? $_SESSION['MAILMERGE_RELATED_CONTACTS'] : '');

    $relModule = '';
    if (!empty($_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO'])) {
        $relModule = $_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO'];
    }

    if ($_SESSION['MAILMERGE_MODULE'] == null) {
        sugar_die("Error during Mail Merge process.  Please try again.");
    }

    $_SESSION['MAILMERGE_MODULE'] = null;
    $_SESSION['MAILMERGE_DOCUMENT_ID'] = null;
    $_SESSION['SELECTED_OBJECTS_DEF'] = null;
    $_SESSION['MAILMERGE_SKIP_REL'] = null;
    $_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO'] = null;
    $item_ids = array();
    parse_str(stripslashes(html_entity_decode($selObjs, ENT_QUOTES)), $item_ids);

    if ($module == 'CampaignProspects') {
        $module = 'Prospects';
        if (!empty($_SESSION['MAILMERGE_CAMPAIGN_ID'])) {
            $targets = array_keys($item_ids);
            require_once('modules/Campaigns/utils.php');
            campaign_log_mail_merge($_SESSION['MAILMERGE_CAMPAIGN_ID'], $targets);
        }
    }
    $class_name = $beanList[$module];
    $includedir = $beanFiles[$class_name];
    require_once($includedir);
    $seed = new $class_name();

    $fields =  get_field_list($seed);

    $document = new DocumentRevision();//new Document();
    $document->retrieve($document_id);

    if (!empty($relModule)) {
        $rel_class_name = $beanList[$relModule ];
        require_once($beanFiles[$rel_class_name]);
        $rel_seed = new $rel_class_name();
    }

    global $sugar_config;

    $filter = array();
    if (array_key_exists('mailmerge_filter', $sugar_config)) {
        //$filter = $sugar_config['mailmerge_filter'];
    }
    array_push($filter, 'link');

    $merge_array = array();
    $merge_array['master_module'] = $module;
    $merge_array['related_module'] = $relModule;
    //rrs log merge
    $ids = array();

    foreach ($item_ids as $key=>$value) {
        if (!empty($relObjs[$key])) {
            $ids[$key] = $relObjs[$key];
        } else {
            $ids[$key] = '';
        }
    }//rof
    $merge_array['ids'] = $ids;

    $dataDir = getcwd() . '/' . sugar_cached('MergedDocuments/');
    if (!file_exists($dataDir)) {
        sugar_mkdir($dataDir);
    }
    mt_srand((double)microtime()*1000000);
    $dataFileName = 'sugardata' . $mTime . '.php';
    write_array_to_file('merge_array', $merge_array, $dataDir . $dataFileName);
    //Save the temp file so we can remove when we are done
    $_SESSION['MAILMERGE_TEMP_FILE_' . $mTime] = $dataDir . $dataFileName;
    $site_url = $sugar_config['site_url'];
    //$templateFile = $site_url . '/' . UploadFile::get_upload_url($document);
    $templateFile = $site_url . '/' . UploadFile::get_url(from_html($document->filename), $document->id);
    $dataFile =$dataFileName;
    $startUrl = 'index.php?action=index&module=MailMerge&reset=true';

    $relModule = trim($relModule);
    $contents = "SUGARCRM_MAIL_MERGE_TOKEN#$templateFile#$dataFile#$module#$relModule";

    $rtfFileName = 'sugartokendoc' . $mTime . '.doc';
    $fp = sugar_fopen($dataDir . $rtfFileName, 'w');
    fwrite($fp, $contents);
    fclose($fp);

    $_SESSION['mail_merge_file_location'] = sugar_cached('MergedDocuments/') . $rtfFileName;
    $_SESSION['mail_merge_file_name'] = $rtfFileName;

    $xtpl->assign("MAILMERGE_FIREFOX_URL", $site_url . '/' . $GLOBALS['sugar_config']['cache_dir'] . 'MergedDocuments/' . $rtfFileName);
    $xtpl->assign("MAILMERGE_START_URL", $startUrl);
    $xtpl->assign("MAILMERGE_TEMPLATE_FILE", $templateFile);
    $xtpl->assign("MAILMERGE_DATA_FILE", $dataFile);
    $xtpl->assign("MAILMERGE_MODULE", $module);

    $xtpl->assign("MAILMERGE_REL_MODULE", $relModule);
}

$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("MAILMERGE_REDIRECT_URL", $redirectUrl);
$xtpl->parse("main");
$xtpl->out("main");
