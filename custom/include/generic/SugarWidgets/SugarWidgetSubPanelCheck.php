<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

include_once('include/generic/SugarWidgets/SugarWidgetField.php');


class SugarWidgetSubPanelCheck extends SugarWidgetField
{
    function displayListPlain($layout_def) {

        $value= $this->_get_list_value($layout_def);

        if (isset($layout_def['widget_type']) && $layout_def['widget_type'] =='checkbox') {

            if ($value != '' &&  ($value == 'on' || intval($value) == 1 || $value == 'yes'))
            {
                return "&nbsp;<input name='checkbox_display' class='checkbox' type='checkbox' disabled='true' checked>";
            }
            //Modification to allow checkboxes to be displayed correctly in subpanel
            if ($layout_def['checkbox_value']=='true'){
                return "&nbsp;<input name='".$layout_def['module']."checkbox_display[]' class='checkbox' type='checkbox' id='".$layout_def['module']."checkbox_display_id[]' value=\"".$layout_def['fields']['ID']."\" onclick=''>";
            }

            return "&nbsp;<input name='checkbox_display' class='checkbox' type='checkbox' disabled='true'>";
        }
        return $value;
    }

}