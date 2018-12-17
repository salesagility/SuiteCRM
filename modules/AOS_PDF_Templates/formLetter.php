<?php
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class formLetter
{
    public static function LVSmarty()
    {
        global $app_strings, $sugar_config;
        if (preg_match('/^6\./', $sugar_config['sugar_version'])) {
            $script = '<a href="#" class="menuItem" onmouseover="hiliteItem(this,\'yes\');
" onmouseout="unhiliteItem(this);" onclick="showPopup()">' . $app_strings['LBL_PRINT_AS_PDF'] . '</a>';
        } else {
            $script = ' <input class="button" type="button" value="' .
                $app_strings['LBL_PRINT_AS_PDF'] . '" ' . 'onClick="showPopup();">';
        }

        return $script;
    }

    public static function getModuleTemplates($module)
    {
        $db = DBManagerFactory::getInstance();
        $templates = array();

        $sql = "SELECT id,name FROM aos_pdf_templates WHERE type = '" . $module . "' AND deleted = 0  AND active = 1 ORDER BY name";
        $result = $db->query($sql);
        while ($row = $db->fetchByAssoc($result)) {
            $templates[$row['id']] = $row['name'];
        }

        return $templates;
    }

    public static function LVPopupHtml($module)
    {
        global $app_strings;

        $templates = formLetter::getModuleTemplates($module);

        if (!empty($templates)) {
            echo '	<div id="popupDiv_ara" style="display:none;position:fixed;top: 39%; left: 41%;opacity:1;z-index:9999;background:#FFFFFF;">
 				<table style="border: #000 solid 2px;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;font-size:110%;" >
					<tr height="20">
						<td colspan="2">
						<b>' . $app_strings['LBL_SELECT_TEMPLATE'] . ':-</b>
						</td>
					</tr>';
            foreach ($templates as $templateid => $template) {
                $js = "document.getElementById('popupDivBack_ara').style.display='none';document.getElementById('popupDiv_ara').style.display='none';";
                echo '<tr height="20">
					<td width="17" valign="center"><a href="#" onclick="document.getElementById(\'popupDiv_ara\').style.display=\'none\';sListView.send_form(true, \'' . $_REQUEST['module'] .
                    '\', \'index.php?templateID=' . $templateid . '&entryPoint=formLetter\',\'' . $app_strings['LBL_LISTVIEW_NO_SELECTED'] . '\');document.getElementById(\'popupDivBack_ara\').style.display=\'none\';"><img src="themes/default/images/txt_image_inline.gif" width="16" height="16" /></a></td>
					<td scope="row" align="left"><b><a href="#" onclick="document.getElementById(\'popupDiv_ara\').style.display=\'none\';sListView.send_form(true, \'' . $_REQUEST['module'] .
                    '\', \'index.php?templateID=' . $templateid . '&entryPoint=formLetter\',\'' . $app_strings['LBL_LISTVIEW_NO_SELECTED'] . '\');document.getElementById(\'popupDivBack_ara\').style.display=\'none\';">' . $template . '</a></b></td></tr>';
            }
            echo '<tr style="height:10px;"><tr><tr><td colspan="2"><button style=" display: block;margin-left: auto;margin-right: auto" onclick="document.getElementById(\'popupDivBack_ara\').style.display=\'none\';document.getElementById(\'popupDiv_ara\').style.display=\'none\';return false;">Cancel</button></td></tr>
			</table>
				</div>
				<div id="popupDivBack_ara" onclick="this.style.display=\'none\';document.getElementById(\'popupDiv_ara\').style.display=\'none\';" style="top:0px;left:0px;position:fixed;height:100%;width:100%;background:#000000;opacity:0.5;display:none;vertical-align:middle;text-align:center;z-index:9998;">
				</div>
				<script>
					function showPopup(){
					if(sugarListView.get_checks_count() < 1)
					{
						alert(\'' . $app_strings['LBL_LISTVIEW_NO_SELECTED'] . '\');
					}
					else
					{
						var ppd=document.getElementById(\'popupDivBack_ara\');
						var ppd2=document.getElementById(\'popupDiv_ara\');
						if(ppd!=null && ppd2!=null){
							ppd.style.display=\'block\';
							ppd2.style.display=\'block\';
						}else{
							alert(\'Error!\');
						}
					}
					}
				</script>';
        } else {
            echo '<script>
				function showPopup(){
				alert(\'' . $app_strings['LBL_NO_TEMPLATE'] . '\');		
				}
			</script>';
        }
    }

    public static function DVPopupHtml($module)
    {
        global $app_strings;

        $templates = formLetter::getModuleTemplates($module);

        if (!empty($templates)) {
            echo '	<div id="popupDiv_ara" style="display:none;position:fixed;top: 39%; left: 41%;opacity:1;z-index:9999;background:#FFFFFF;">
 				<form id="popupForm" action="index.php?entryPoint=formLetter" method="post">
 				<table style="border: #000 solid 2px;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;font-size:110%;" >
					<tr height="20">
						<td colspan="2">
						<b>' . $app_strings['LBL_SELECT_TEMPLATE'] . ':-</b>
						</td>
					</tr>';
            foreach ($templates as $templateid => $template) {
                $js = "document.getElementById('popupDivBack_ara').style.display='none';document.getElementById('popupDiv_ara').style.display='none';var form=document.getElementById('popupForm');if(form!=null){form.templateID.value='" . $templateid . "';form.submit();}else{alert('Error!');}";
                echo '<tr height="20">
					<td width="17" valign="center"><a href="#" onclick="' . $js . '"><img src="themes/default/images/txt_image_inline.gif" width="16" height="16" /></a></td>
					<td scope="row" align="left"><b><a href="#" onclick="' . $js . '">' . $template . '</a></b></td></tr>';
            }
            echo '		<input type="hidden" name="templateID" value="" />
				<input type="hidden" name="module" value="' . $module . '" />
				<input type="hidden" name="uid" value="' . $_REQUEST['record'] . '" />
				</form>
				<tr style="height:10px;"><tr><tr><td colspan="2"><button style=" display: block;margin-left: auto;margin-right: auto" onclick="document.getElementById(\'popupDivBack_ara\').style.display=\'none\';document.getElementById(\'popupDiv_ara\').style.display=\'none\';return false;">Cancel</button></td></tr>
				</table>
				</div>
				
				<div id="popupDivBack_ara" onclick="this.style.display=\'none\';document.getElementById(\'popupDiv_ara\').style.display=\'none\';" style="top:0px;left:0px;position:fixed;height:100%;width:100%;background:#000000;opacity:0.5;display:none;vertical-align:middle;text-align:center;z-index:9998;">
				</div>
				<script>
					function showPopup(){
						var ppd=document.getElementById(\'popupDivBack_ara\');
						var ppd2=document.getElementById(\'popupDiv_ara\');
						if(ppd!=null && ppd2!=null){
							ppd.style.display=\'block\';
							ppd2.style.display=\'block\';
						}else{
							alert(\'Error!\');
						}
					}
				</script>';
        } else {
            echo '<script>
				function showPopup(){
				alert(\'' . $app_strings['LBL_NO_TEMPLATE'] . '\');		
				}
			</script>';
        }
    }
}
