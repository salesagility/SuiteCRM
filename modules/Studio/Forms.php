<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/




//for users
function user_get_validate_record_js() {
}
function user_get_chooser_js() {
}
function user_get_confsettings_js() {
};
//end for users
function get_chooser_js() {
	// added here for compatibility
}
function get_validate_record_js() {
}
function get_new_record_form() {

	if(empty($_SESSION['studio']['module']))return '';

	global $mod_strings;
	$module_name = $_SESSION['studio']['module'];
	$debug = true;
	$html = "";


	$html = get_left_form_header($mod_strings['LBL_TOOLBOX']);
	$add_field_icon = SugarThemeRegistry::current()->getImage("plus_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_ADD_FIELD']);
	$minus_field_icon = SugarThemeRegistry::current()->getImage("minus_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_ADD_FIELD']);
	$edit_field_icon = SugarThemeRegistry::current()->getImage("edit_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_ADD_FIELD']);
	$delete = SugarThemeRegistry::current()->getImage("delete_inline", "border='0' style='margin-left:4px;margin-right:4px;'",null,null,'.gif',$mod_strings['LBL_DELETE']);
	$show_bin = true;
	if (isset ($_REQUEST['edit_subpanel_MSI']))
	global $sugar_version, $sugar_config;
		$show_bin = false;

	$html .= "

			<script type=\"text/javascript\" src=\"modules/DynamicLayout/DynamicLayout_3.js\">
			</script>
			<p>
		";

	if (isset ($_REQUEST['edit_col_MSI'])) {
		// do nothing
	} else {
		$html .= <<<EOQ


	   <link rel="stylesheet" type="text/css" href="include/javascript/yui-old/assets/container.css" />
		            	<script type="text/javascript" src="include/javascript/yui-old/container.js"></script>
					<script type="text/javascript" src="include/javascript/yui-old/PanelEffect.js"></script>



EOQ;

		$field_style = '';
		$bin_style = '';

		$add_icon = SugarThemeRegistry::current()->getImage("plus_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_MAXIMIZE']);
		$min_icon = SugarThemeRegistry::current()->getImage("minus_inline", 'style="margin-left:4px;margin-right:4px;"  border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_MINIMIZE']);
	   $del_icon = SugarThemeRegistry::current()->getImage("delete_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_MINIMIZE']);
		$html .=<<<EOQ
		              <br><br><table  cellpadding="0" cellspacing="0" border="1" width="100%"   id='s_field_delete'>
							<tr><td colspan='2' align='center'>
					       $del_icon <br>Drag Fields Here To Delete
						</td></tr></table>
					<div id="s_fields_MSIlink" style="display:none">
						<a href="#" onclick="toggleDisplay('s_fields_MSI');">
							 $add_icon {$mod_strings['LBL_VIEW_SUGAR_FIELDS']}
						</a>
					</div>
					<div id="s_fields_MSI" style="display:inline">

						<table  cellpadding="0" cellspacing="0" border="0" width="100%" id="studio_fields">
							<tr><td colspan='2'>

									<a href="#" onclick="toggleDisplay('s_fields_MSI');">$min_icon</a>{$mod_strings['LBL_SUGAR_FIELDS_STAGE']}
								    <br><select id='studio_display_type' onChange='filterStudioFields(this.value)'><option value='all'>All<option value='custom'>Custom</select>
									</td>
							</tr>
						</table>
					</div>

EOQ;

	}
	$html .= get_left_form_footer();
	if (!$debug)
		return $html;
	return $html.<<<EOQ

EOQ;
}
?>
