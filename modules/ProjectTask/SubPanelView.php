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






global $app_strings;
global $currentModule;
global $theme;
global $focus;
global $action;
global $focus_list;

//we don't want the parent module's string file, but rather the string file specifc to this subpanel
global $current_language;

$current_module_strings = return_module_language($current_language, 'ProjectTask');
$project_module_strings = return_module_language($current_language, 'Project');




// focus_list is the means of passing data to a SubPanelView.

$button  = "<form action='index.php' method='post' name='form' id='form'>\n";
$button .= "<input type='hidden' name='module' value='ProjectTask' />\n";
$button .= "<input type='hidden' name='parent_id' value='{$focus->id}' />\n";
$button .= "<input type='hidden' name='parent_name' value='{$focus->name}' />\n";
$button .= "<input type='hidden' name='project_relation_id' value='{$focus->id}' />\n";
$button .= "<input type='hidden' name='project_relation_type' value='$currentModule' />\n";
$button .= "<input type='hidden' name='return_module' value='$currentModule' />\n";
$button .= "<input type='hidden' name='return_action' value='$action' />\n";
$button .= "<input type='hidden' name='return_id' value='{$focus->id}' />\n";
$button .= "<input type='hidden' name='action' />\n";

$button .= "<input title='"
	. $app_strings['LBL_NEW_BUTTON_TITLE']
	. "' accessyKey='".$app_strings['LBL_NEW_BUTTON_KEY']
	. "' class='button' onclick=\"this.form.action.value='EditView'\" type='submit' name='New' value='  "
	. $app_strings['LBL_NEW_BUTTON_LABEL']."  ' />\n";

$button .= "</form>\n";

$ListView = new ListView();
$ListView->initNewXTemplate( 'modules/ProjectTask/SubPanelView.html',$current_module_strings);
$ListView->xTemplateAssign("EDIT_INLINE_PNG",
	SugarThemeRegistry::current()->getImage('edit_inline','align="absmiddle" border="0"',null,null,'.gif',$app_strings['LNK_EDIT']));
$ListView->xTemplateAssign("RETURN_URL",
	"&return_module=".$currentModule."&return_action=DetailView&return_id=".$focus->id);

$header_text = '';
if(is_admin($current_user)
	&& $_REQUEST['module'] != 'DynamicLayout'
	&& !empty($_SESSION['editinplace']))
{
	$header_text = " <a href='index.php?action=index"
		. "&module=DynamicLayout"
		. "&from_action=SubPanelView"
		. "&from_module=ProjectTask"
		. "'>"
		.SugarThemeRegistry::current()->getImage("EditLayout", "border='0' align='bottom'"
,null,null,'.gif',$mod_strings['LBL_EDITLAYOUT'])."</a>";
}
$ListView->setHeaderTitle($project_module_strings['LBL_PROJECT_TASK_SUBPANEL_TITLE'] . $header_text);

$ListView->setHeaderText($button);
$ListView->setQuery('', '', 'order_number', 'project_task');
$ListView->processListView($focus_list, 'main', 'project_task');

?>