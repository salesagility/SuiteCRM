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

require_once 'modules/stic_Web_Forms/Assistant/AssistantView.php';

class stic_Web_FormsViewSelectFields extends stic_Web_FormsAssistantView
{
    /**
     * Do what is needed before showing the view
     */
    public function preDisplay()
    {
        parent::preDisplay();
        $this->tpl = "SelectFields.tpl";

        // Recover the fields to display
        $availableFields = $this->view_object_map['AVAILABLE_FIELDS'];
        $col1Fields = $this->view_object_map['COL1_FIELDS'];
        $col2Fields = $this->view_object_map['COL2_FIELDS'];
        global $app_list_strings;
        $this->view_object_map['SELECTION_MODULE_LABEL'] = $app_list_strings['moduleList'][$this->view_object_map['SELECTION_MODULE_NAME']];

        // Assign the html of the field selection grid
        $this->ss->assign('DRAG_DROP_CHOOSER_WEB_TO_LEAD', $this->constructGrids($availableFields, $col1Fields, $col2Fields, "SUGAR_GRID"));
    }

    /**
     * Returns the necessary html for the field selection grid
     * @return String
     */
    public function constructGrids($availableFields, $col1Fields, $col2Fields, $classname)
    {
        require_once "include/templates/TemplateDragDropChooser.php";
        global $mod_strings;
        $d2 = array();

        //now call function that creates javascript for invoking DDChooser object
        $dd_chooser = new TemplateDragDropChooser();
        $dd_chooser->args['classname'] = $classname;
        $dd_chooser->args['left_header'] = $mod_strings['LBL_AVALAIBLE_FIELDS_HEADER'];
        $dd_chooser->args['mid_header'] = $mod_strings['LBL_WEBFORMS_FIRST_HEADER'];
        $dd_chooser->args['right_header'] = $mod_strings['LBL_WEBFORMS_SECOND_HEADER'];
        $dd_chooser->args['left_data'] = $availableFields;
        $dd_chooser->args['mid_data'] = $col1Fields;
        $dd_chooser->args['right_data'] = $col2Fields;
        $dd_chooser->args['title'] = ' ';
        $dd_chooser->args['left_div_name'] = 'ddgrid2';
        $dd_chooser->args['mid_div_name'] = 'ddgrid3';
        $dd_chooser->args['right_div_name'] = 'ddgrid4';
        $dd_chooser->args['gridcount'] = 'three';

        $str = $dd_chooser->displayScriptTags();
        $str .= $dd_chooser->displayDefinitionScript();
        $str .= $dd_chooser->display();
        $str .= "<script>
       			    //function post rows
       			    function postMoveRows(){
       			 	    //Call other function when this is called
       			    }
       	        </script>";
        $str .= "<script>
					function displayAddRemoveDragButtons(addAllFields, removeAllFields)
					{
                        var addRemove = document.getElementById('lead_add_remove_button');
						if (" . $dd_chooser->args['classname'] . "_grid0.getDataModel().getTotalRowCount() == 0)
						{
				            addRemove.setAttribute('value',removeAllFields);
				            addRemove.setAttribute('title',removeAllFields);
                        }
						else if (" . $dd_chooser->args['classname'] . "_grid1.getDataModel().getTotalRowCount() ==0 && " . $dd_chooser->args['classname'] . "_grid2.getDataModel().getTotalRowCount() ==0)
						{
                            addRemove.setAttribute('value',addAllFields);
                            addRemove.setAttribute('title',addAllFields);
                        }
                    }
                </script>";

        return $str;
    }
}
