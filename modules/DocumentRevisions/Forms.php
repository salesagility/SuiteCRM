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

/*********************************************************************************

 * Description:  Contains a variety of utility functions used to display UI
 * components such as form headers and footers.  Intended to be modified on a per
 * theme basis.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

/**
 * Create javascript to validate the data entered into a record.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_validate_record_document_revision_js () {
global $mod_strings;
global $app_strings;

$lbl_version = $mod_strings['LBL_DOC_VERSION'];
$lbl_filename = $mod_strings['LBL_FILENAME'];


$err_missing_required_fields = $app_strings['ERR_MISSING_REQUIRED_FIELDS'];


$the_script  = <<<EOQ

<script type="text/javascript" language="Javascript">

function verify_data(form) {
	var isError = false;
	var errorMessage = "";
	if (trim(form.revision.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_version";
	}	
	if (trim(form.uploadfile.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_filename";
	}

	if (isError == true) {
		alert("$err_missing_required_fields" + errorMessage);
		return false;
	}

	return true;
}
</script>

EOQ;

return $the_script;
}

function get_chooser_js()
{
$the_script  = <<<EOQ

<script type="text/javascript" language="Javascript">
<!--  to hide script contents from old browsers

function set_chooser()
{



var display_tabs_def = '';

for(i=0; i < object_refs['display_tabs'].options.length ;i++)
{
         display_tabs_def += "display_tabs[]="+object_refs['display_tabs'].options[i].value+"&";
}

document.EditView.display_tabs_def.value = display_tabs_def;



}
// end hiding contents from old browsers  -->
</script>
EOQ;

return $the_script;
}
function get_validate_record_js(){
	
global $mod_strings;
global $app_strings;

$lbl_name = $mod_strings['ERR_DOC_NAME'];
$lbl_start_date = $mod_strings['ERR_DOC_ACTIVE_DATE'];
$lbl_file_name = $mod_strings['ERR_FILENAME'];
$lbl_file_version=$mod_strings['ERR_DOC_VERSION'];
$sqs_no_match = $app_strings['ERR_SQS_NO_MATCH'];
$err_missing_required_fields = $app_strings['ERR_MISSING_REQUIRED_FIELDS'];

if(isset($_REQUEST['record'])) {
//do not validate upload file
	$the_upload_script="";


} else 
{

$the_upload_script  = <<<EOQ

	if (trim(form.uploadfile.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_file_name";
	}
EOQ;

}

$the_script  = <<<EOQ

<script type="text/javascript" language="Javascript">

function verify_data(form) {
	var isError = false;
	var errorMessage = "";
	if (trim(form.document_name.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_name";
	}
	
	$the_upload_script
	
	if (trim(form.active_date.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_start_date";
	}
	if (trim(form.revision.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_file_version";
	}

	
	if (isError == true) {
		alert("$err_missing_required_fields" + errorMessage);
		return false;
	}
	
	//make sure start date is <= end_date

	return true;
}
</script>

EOQ;

return $the_script;
}

