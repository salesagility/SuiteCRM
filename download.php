<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 ********************************************************************************/


global $db;

if((!isset($_REQUEST['isProfile']) && empty($_REQUEST['id'])) || empty($_REQUEST['type']) || !isset($_SESSION['authenticated_user_id'])) {
	die("Not a Valid Entry Point");
}
else {
    require_once("data/BeanFactory.php");
    $file_type=''; // bug 45896
    require_once("data/BeanFactory.php");
    ini_set('zlib.output_compression','Off');//bug 27089, if use gzip here, the Content-Length in header may be incorrect.
    // cn: bug 8753: current_user's preferred export charset not being honored
    $GLOBALS['current_user']->retrieve($_SESSION['authenticated_user_id']);
    $GLOBALS['current_language'] = $_SESSION['authenticated_user_language'];
    $app_strings = return_application_language($GLOBALS['current_language']);
    $mod_strings = return_module_language($GLOBALS['current_language'], 'ACL');
	$file_type = strtolower($_REQUEST['type']);
    if(!isset($_REQUEST['isTempFile'])) {
	    //Custom modules may have capitalizations anywhere in their names. We should check the passed in format first.
		require('include/modules.php');
		$module = $db->quote($_REQUEST['type']);
		if(empty($beanList[$module])) {
			//start guessing at a module name
			$module = ucfirst($file_type);
	    	if(empty($beanList[$module])) {
	       		die($app_strings['ERROR_TYPE_NOT_VALID']);
	    	}
		}
    	$bean_name = $beanList[$module];
	    if(!file_exists('modules/' . $module . '/' . $bean_name . '.php')) {
	         die($app_strings['ERROR_TYPE_NOT_VALID']);
	    }

	    $focus = BeanFactory::newBean($module);
        if(!$focus->ACLAccess('view')){
            die($mod_strings['LBL_NO_ACCESS']);
	    } // if
        $focus->retrieve($_REQUEST['id']);
        // Pull up the document revision, if it's of type Document
        if ( isset($focus->object_name) && $focus->object_name == 'Document' ) {
            // It's a document, get the revision that really stores this file
            $focusRevision = new DocumentRevision();
            $focusRevision->retrieve($_REQUEST['id']);

            if ( empty($focusRevision->id) ) {
                // This wasn't a document revision id, it's probably actually a document id,
                // we need to grab the latest revision and use that
                $focusRevision->retrieve($focus->document_revision_id);

                if ( !empty($focusRevision->id) ) {
                    $_REQUEST['id'] = $focusRevision->id;
                }
            }
        }

        // See if it is a remote file, if so, send them that direction
        if ( isset($focus->doc_url) && !empty($focus->doc_url) ) {
            header('Location: '.$focus->doc_url);
            sugar_die("Remote file detected, location header sent.");
        }

        if ( isset($focusRevision) && isset($focusRevision->doc_url) && !empty($focusRevision->doc_url) ) {
            header('Location: '.$focusRevision->doc_url);
            sugar_die("Remote file detected, location header sent.");
        }

    } // if

    if(isset($_REQUEST['ieId']) && isset($_REQUEST['isTempFile'])) {
		$local_location = sugar_cached("modules/Emails/{$_REQUEST['ieId']}/attachments/{$_REQUEST['id']}");
    } elseif(isset($_REQUEST['isTempFile']) && $file_type == "import") {
    	$local_location = "upload://import/{$_REQUEST['tempName']}";
    } else {
		$local_location = "upload://{$_REQUEST['id']}";
    }

	if(isset($_REQUEST['isTempFile']) && ($_REQUEST['type']=="SugarFieldImage")) {
	    $local_location =  "upload://{$_REQUEST['id']}";
    }
    
    if(isset($_REQUEST['isTempFile']) && ($_REQUEST['type']=="SugarFieldImage") && (isset($_REQUEST['isProfile'])) && empty($_REQUEST['id'])) {
    	$local_location = "include/images/default-profile.png";
    }
    
	if(!file_exists( $local_location ) || strpos($local_location, "..")) {
		die($app_strings['ERR_INVALID_FILE_REFERENCE']);
	} else {
		$doQuery = true;

		if($file_type == 'documents') {
			// cn: bug 9674 document_revisions table has no 'name' column.
			$query = "SELECT filename name FROM document_revisions INNER JOIN documents ON documents.id = document_revisions.document_id ";
			$query .= "WHERE document_revisions.id = '".$db->quote($_REQUEST['id'])."' ";
		} elseif($file_type == 'kbdocuments') {
				$query="SELECT document_revisions.filename name	FROM document_revisions INNER JOIN kbdocument_revisions ON document_revisions.id = kbdocument_revisions.document_revision_id INNER JOIN kbdocuments ON kbdocument_revisions.kbdocument_id = kbdocuments.id ";
            $query .= "WHERE document_revisions.id = '" . $db->quote($_REQUEST['id']) ."'";
		}  elseif($file_type == 'notes') {
            $query = "SELECT filename name, file_mime_type FROM notes ";
			$query .= "WHERE notes.id = '" . $db->quote($_REQUEST['id']) ."'";
		} elseif( !isset($_REQUEST['isTempFile']) && !isset($_REQUEST['tempName'] ) && isset($_REQUEST['type']) && $file_type!='temp' ){ //make sure not email temp file.
			$query = "SELECT filename name FROM ". $file_type ." ";
			$query .= "WHERE ". $file_type .".id= '".$db->quote($_REQUEST['id'])."'";
		}elseif( $file_type == 'temp'){
			$doQuery = false;
		}

        $mime_type = 'application/octet-stream';
		if($doQuery && isset($query)) {
            $rs = $GLOBALS['db']->query($query);
			$row = $GLOBALS['db']->fetchByAssoc($rs);

			if(empty($row)){
				die($app_strings['ERROR_NO_RECORD']);
			}
			$name = $row['name'];

            // expose original mime type only for images, otherwise the content of arbitrary type
            // may be interpreted/executed by browser
            if (isset($row['file_mime_type']) && strpos($row['file_mime_type'], 'image/') === 0) {
                $mime_type = $row['file_mime_type'];
            }
			$download_location = "upload://{$_REQUEST['id']}";
		} else if(isset(  $_REQUEST['tempName'] ) && isset($_REQUEST['isTempFile']) ){
			// downloading a temp file (email 2.0)
			$download_location = $local_location;
			$name = isset($_REQUEST['tempName'])?$_REQUEST['tempName']:'';
		} else if(isset($_REQUEST['isTempFile']) && ($_REQUEST['type']=="SugarFieldImage")) {
			$download_location = $local_location;
			$name = isset($_REQUEST['tempName'])?$_REQUEST['tempName']:'';
		}

		if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']))
		{
			$name = urlencode($name);
			$name = str_replace("+", "_", $name);
		}

		header("Pragma: public");
		header("Cache-Control: maxage=1, post-check=0, pre-check=0");
		if(isset($_REQUEST['isTempFile']) && ($_REQUEST['type']=="SugarFieldImage")) {
			$mime = getimagesize($download_location);
		   	if(!empty($mime)) {
			    header("Content-Type: {$mime['mime']}");
		    } else {
		        header("Content-Type: image/png");
		    }
		} else {
            header('Content-type: ' . $mime_type);
               header("Content-Disposition: attachment; filename=\"".$name."\";");
            
		}
		// disable content type sniffing in MSIE
		header("X-Content-Type-Options: nosniff");
		header("Content-Length: " . filesize($local_location));
		header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
		set_time_limit(0);

        // When output_buffering = On, ob_get_level() may return 1 even if ob_end_clean() returns false 
        // This happens on some QA stacks. See Bug#64860
        while (ob_get_level() && @ob_end_clean());

	        readfile($download_location);
	}
}
