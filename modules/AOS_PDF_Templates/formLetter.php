<?php
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Products
 * @copyright SalesAgility Ltd http://www.salesagility.com
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */

class formLetter{

	function LVSmarty(){
		global $app_strings, $mod_strings, $sugar_config;
		if (preg_match('/^6\./', $sugar_config['sugar_version'])) {
			$script = '<a href="#" style="width: 150px" class="menuItem" onmouseover="hiliteItem(this,\'yes\');" onmouseout="unhiliteItem(this);" onclick="showPopup()">'.$app_strings['LBL_GENERATE_LETTER'].'</a>';
		}
		else{
			$script = ' <input class="button" type="button" value="'.$app_strings['LBL_GENERATE_LETTER'].'" ' .'onClick="showPopup();">';
    		}

		return $script;
        }

	function LVPopupHtml($module){
		global $app_list_strings,$app_strings;
		
		$sql = "SELECT * FROM aos_pdf_templates WHERE type = '".$module."' AND deleted = 0  AND active = 1";
		$result = $this->bean->db->query($sql);
		$countLine = $this->bean->db->getRowCount($result);
		
		if($countLine != 0){
		echo '	<div id="popupDiv_ara" style="display:none;position:fixed;top: 39%; left: 41%;opacity:1;z-index:9999;background:#FFFFFF;">
 				<table style="border: #000 solid 2px;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;font-size:110%;" >
					<tr height="20">
						<td colspan="2">
						<b>'.$app_strings['LBL_SELECT_TEMPLATE'].':-</b>
						</td>
					</tr>';
			while ($row = $this->bean->db->fetchByAssoc($result)) {
				$js = "document.getElementById('popupDivBack_ara').style.display='none';document.getElementById('popupDiv_ara').style.display='none';";
				$templateid = $row['id'];
				echo '<tr height="20">
					<td width="17" valign="center"><a href="#" onclick="document.getElementById(\'popupDiv_ara\').style.display=\'none\';sListView.send_form(true, \''.$_REQUEST['module'].
                                '\', \'index.php?templateID='.$templateid.'&entryPoint=formLetter\',\''.$app_strings['LBL_LISTVIEW_NO_SELECTED'].'\');document.getElementById(\'popupDivBack_ara\').style.display=\'none\';"><img src="themes/default/images/txt_image_inline.gif" width="16" height="16" /></a></td>
					<td scope="row" align="left"><b><a href="#" onclick="document.getElementById(\'popupDiv_ara\').style.display=\'none\';sListView.send_form(true, \''.$_REQUEST['module'].
                                '\', \'index.php?templateID='.$templateid.'&entryPoint=formLetter\',\''.$app_strings['LBL_LISTVIEW_NO_SELECTED'].'\');document.getElementById(\'popupDivBack_ara\').style.display=\'none\';">'.$row['name'].'</a></b></td></tr>';
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
						alert(\''.$app_strings['LBL_LISTVIEW_NO_SELECTED'].'\');
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
			}
		else{
			echo '<script>
				function showPopup(){
				alert(\''.$app_strings['LBL_NO_TEMPLATE'].'\');		
				}
			</script>';
		}
	}
	
	function DVPopupHtml($module){
		global $app_list_strings,$app_strings;
		
		$sql = "SELECT * FROM aos_pdf_templates WHERE type = '".$module."' AND deleted = 0  AND active = 1";
		$result = $this->bean->db->query($sql);
		$countLine = $this->bean->db->getRowCount($result);
		
		if($countLine != 0){
		echo '	<div id="popupDiv_ara" style="display:none;position:fixed;top: 39%; left: 41%;opacity:1;z-index:9999;background:#FFFFFF;">
 				<form id="popupForm" action="index.php?entryPoint=formLetter" method="post">
 				<table style="border: #000 solid 2px;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;font-size:110%;" >
					<tr height="20">
						<td colspan="2">
						<b>'.$app_strings['LBL_SELECT_TEMPLATE'].':-</b>
						</td>
					</tr>';
			while ($row = $this->bean->db->fetchByAssoc($result)) {
				$templateid = $row['id'];
				$js = "document.getElementById('popupDivBack_ara').style.display='none';document.getElementById('popupDiv_ara').style.display='none';var form=document.getElementById('popupForm');if(form!=null){form.templateID.value='".$templateid."';form.submit();}else{alert('Error!');}";
					echo '<tr height="20">
					<td width="17" valign="center"><a href="#" onclick="'.$js.'"><img src="themes/default/images/txt_image_inline.gif" width="16" height="16" /></a></td>
					<td scope="row" align="left"><b><a href="#" onclick="'.$js.'">'.$row['name'].'</a></b></td></tr>';
			}
		echo '		<input type="hidden" name="templateID" value="" />
				<input type="hidden" name="module" value="'.$_REQUEST['module'].'" />
				<input type="hidden" name="uid" value="'.$this->bean->id.'" />
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
		}
		else{
			echo '<script>
				function showPopup(){
				alert(\''.$app_strings['LBL_NO_TEMPLATE'].'\');		
				}
			</script>';
		}
	}
}

?>
