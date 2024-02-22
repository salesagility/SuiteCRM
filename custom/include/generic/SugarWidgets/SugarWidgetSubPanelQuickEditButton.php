<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * This custom class, allows you to create a button in each record of the subpanel
 * which open the QuickCreate View to edit the record.
 */
class SugarWidgetSubPanelQuickEditButton extends SugarWidgetField
{
    public function displayList(&$layout_def)
	{
		global $app_strings;
        global $subpanel_item_count;
		$return_module = $_REQUEST['module'];
		$return_id = $_REQUEST['record']; 
		$module_name = $layout_def['module'];
		$record_id = $layout_def['fields']['ID'];
		$subpanel = $layout_def['subpanel_id'];
        $unique_id = $layout_def['subpanel_id']."_form_".$subpanel_item_count; //bug 51512
		
		// @see SugarWidgetSubPanelTopButtonQuickCreate::get_subpanel_relationship_name()
		$relationship_name = '';
		if (!empty($layout_def['linked_field'])) {
			$relationship_name = $layout_def['linked_field'];
			$bean = BeanFactory::getBean($layout_def['module']);
			if (!empty($bean->field_defs[$relationship_name]['relationship'])) {
				$relationship_name = $bean->field_defs[$relationship_name]['relationship'];
			}
		}

		
		$subpanel = $layout_def['subpanel_id'];
		if (isset($layout_def['linked_field_set']) && !empty($layout_def['linked_field_set'])) {
			$linked_field= $layout_def['linked_field_set'] ;
		} else {
			$linked_field = $layout_def['linked_field'];
		}

		$labelText = "Quick Edit";
		$label = null;
		if (isset($layout_def['vname'])) {
			$label = $layout_def['vname'];
		} elseif (isset($layout_def['label'])) {
			$label = $layout_def['label'];
		}
		if ($label != null) {
			if (isset($app_strings[$label])) {
				$labelText = $app_strings[$label];
			} elseif (isset($mod_strings[$label])) {
				$labelText = $mod_strings[$label];
			}
		}

		$html = '
		<form onsubmit="return SUGAR.subpanelUtils.sendAndRetrieve(this.id, \'subpanel_'.$subpanel.'\', \'Loading ...\');" action="index.php" method="post" name="form" id="'.$unique_id.'">
		<input type="hidden" name="record" value="'.$record_id.'">
		<input type="hidden" name="target_module" value="'.$module_name.'">
		<input type="hidden" name="tpl" value="QuickCreate.tpl">
		<input type="hidden" name="return_module" value="'.$return_module.'">
		<input type="hidden" name="return_action" value="SubPanelViewer">
		<input type="hidden" name="return_id" value="'.$return_id.'">
		<input type="hidden" name="return_relationship" value="'.$relationship_name.'">
		<input type="hidden" name="action" value="SubpanelCreates">
		<input type="hidden" name="module" value="Home">
		<input type="hidden" name="target_action" value="QuickEdit">
		<input type="hidden" name="return_name" value="XXXX">
		<input type="hidden" name="parent_type" value="'.$return_module.'">
		<input type="hidden" name="parent_name" value="XXXX">
		<input type="hidden" name="parent_id" value="'.$return_id.'">
		<input title="'.$labelText.'" accesskey="N" class="button" type="submit" name="'.$module_name.'_quickedit_button" id="'.$record_id.'_quickedit_button" value="'.$labelText.'">
		</form>';
		
				
		return $html;

	}
	

}
