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

$db = DBManagerFactory::getInstance();
if(!$db->supports('fix:expandDatabase')) {
	echo "<BR>";
	echo "<p>".$mod_strings['ERR_NOT_IMPLEMENTED']."</p>";
	echo "<BR>";
	sugar_die('');
}
global $current_user,$beanFiles;

set_time_limit(3600);
if(is_admin($current_user) || isset($from_sync_client)){

	$execute = false;
	$export = false;


	if(isset($_REQUEST['do_action'])){
		switch($_REQUEST['do_action']){
			case 'display':
				break;
			case 'execute':
				$execute = true;
				break;
			case 'export':
				header('Location: index.php?module=Administration&action=expandDatabase&do_action=do_export&to_pdf=true');
				die();
			case 'do_export':
				$export = true;
				break;
		}

		if(!$export && empty($_REQUEST['repair_silent'])){
			echo getClassicModuleTitle($mod_strings['LBL_EXPAND_DATABASE_COLUMNS'], array($mod_strings['LBL_EXPAND_DATABASE_COLUMNS'],$_REQUEST['do_action']), true);
		}

        $alter_queries = array();
        $restore_quries = array();
        $sql = "SELECT SO.name AS table_name, SC.name AS column_name, CONVERT(int, SC.length) AS length, SC.isnullable, type_name(SC.xusertype) AS type
                FROM sys.sysobjects AS SO INNER JOIN sys.syscolumns AS SC ON SC.id = SO.id
                WHERE (SO.type = 'U')
                AND (type_name(SC.xusertype) IN ('varchar', 'char', ' text '))
                AND (SC.name NOT LIKE '%_id') AND (SC.name NOT LIKE 'id_%') AND (SC.name <> 'id')
                ORDER BY SO.name, column_name";
        $result = $db->query($sql);


        $theAlterQueries = '';
        $theRestoreQueries = '';
        $alter_queries = array();
        while ($row = $db->fetchByAssoc($result)) {
   	      $length = (int)$row['length'];
   	      if($length < 255) {
   	         $newLength = ($length * 3 < 255) ? $length * 3 : 255;
   	         $sql = 'ALTER TABLE ' . $row['table_name'] . ' ALTER COLUMN ' . $row['column_name'] . ' ' . $row['type'] . ' (' . $newLength . ')';
             $theAlterQueries .= $sql . "\n";
             $alter_queries[] = $sql;

             $sql2 = 'ALTER TABLE ' . $row['table_name'] . ' ALTER COLUMN ' . $row['column_name'] . ' ' . $row['type'] . ' (' . $length . ')';
             $theRestoreQueries .= $sql2 . "\n";
          }
        } //while

        //If there are no ALTER queries to run, echo message
        if(count($alter_queries) == 0) {
           echo $mod_strings['ERR_NO_COLUMNS_TO_EXPAND'];
        } else {

	        // Create a backup file to restore columns to original length
	        if($execute) {
	           $fh = sugar_fopen('restoreExpand.sql', 'w');
	           if(-1 == fwrite($fh, $theRestoreQueries)) {
	           	  $GLOBALS['log']->error($mod_strings['ERR_CANNOT_CREATE_RESTORE_FILE']);
	           	  echo($mod_strings['ERR_CANNOT_CREATE_RESTORE_FILE']);
	           } else {
	           	  $GLOBALS['log']->info($mod_strings['LBL_CREATE_RESOTRE_FILE']);
	           	  echo($mod_strings['LBL_CREATE_RESOTRE_FILE']);
	           }

	           foreach($alter_queries as $key=>$value) {
	           	       $db->query($value);
	           }
	        }

			if($export) {
		   		header("Content-Disposition: attachment; filename=expandSugarDB.sql");
				header("Content-Type: text/sql; charset={$app_strings['LBL_CHARSET']}");
				header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
				header( "Last-Modified: " . TimeDate::httpTime() );
				header( "Cache-Control: post-check=0, pre-check=0", false );
				header("Content-Length: ".strlen($theAlterQueries));
		   		echo $theAlterQueries;
		   		die();
			} else {
				if(empty($_REQUEST['repair_silent'])) {
					echo nl2br($theAlterQueries);
				}
			}

        } //if-else
	} // end do_action

	if(empty($_REQUEST['repair_silent']) && empty($_REQUEST['do_action'])) {
		if(!file_exists('restoreExpand.sql')) {
		        echo "	<b>{$mod_strings['LBL_REPAIR_ACTION']}</b><br>
				<form name='repairdb'>
					<input type='hidden' name='action' value='expandDatabase'>
					<input type='hidden' name='module' value='Administration'>

					<select name='do_action'>
							<option value='display'>".$mod_strings['LBL_REPAIR_DISPLAYSQL']."
							<option value='export'>".$mod_strings['LBL_REPAIR_EXPORTSQL']."
							<option value='execute'>".$mod_strings['LBL_REPAIR_EXECUTESQL']."
					</select><input type='submit' class='button' value='".$mod_strings['LBL_GO']."'>
				</form><br><br>
				".$mod_strings['LBL_EXPAND_DATABASE_TEXT'];
		} else {
			    echo "<b>{$mod_strings['LBL_EXPAND_DATABASE_FINISHED_ERROR']}</b><br>";
		} //if-else
	} //if
}else{
	sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}


?>
