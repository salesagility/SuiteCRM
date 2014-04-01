<?php
/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
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
 * @author SalesAgility <info@salesagility.com>
 */


require_once("modules/AOW_WorkFlow/aow_utils.php");

class AOR_ReportsController extends SugarController {

    protected function action_getModuleFields()
    {
        if (!empty($_REQUEST['aor_module']) && $_REQUEST['aor_module'] != '') {
            if(isset($_REQUEST['rel_field']) &&  $_REQUEST['rel_field'] != ''){
                $module = getRelatedModule($_REQUEST['aor_module'],$_REQUEST['rel_field']);
            } else {
                $module = $_REQUEST['aor_module'];
            }
            echo getModuleFields($module,$_REQUEST['view'],$_REQUEST['aor_value']);
        }
        die;

    }

    protected function action_getModuleRelationships()
    {
        if (!empty($_REQUEST['aor_module']) && $_REQUEST['aor_module'] != '') {
            echo getModuleRelationships($_REQUEST['aor_module']);
        }
        die;
    }

    protected function action_changeReportPage(){
        echo $this->bean->build_report_html($_REQUEST['offset'], true,$_REQUEST['group']);
        die();
    }

    protected function action_addToProspectList(){
        global $beanList;

        require_once('modules/Relationships/Relationship.php');
        require_once('modules/ProspectLists/ProspectList.php');

        $prospectList = new ProspectList();
        $prospectList->retrieve($_REQUEST['prospect_id']);

        $module = new $beanList[$this->bean->report_module]();

        $key = Relationship::retrieve_by_modules($this->bean->report_module, 'ProspectLists', $GLOBALS['db']);
        if (!empty($key)) {

            $sql = $this->bean->build_report_query();
            $result = $this->bean->db->query($sql);
            $beans = array();
            while ($row = $this->bean->db->fetchByAssoc($result)) {
                if (isset($row[$module->table_name.'_id'])){
                    $beans[] = $row[$module->table_name.'_id'];
                }
            }
            if(!empty($beans)){
                foreach($prospectList->field_defs as $field=>$def){
                    if($def['type'] == 'link' && !empty($def['relationship']) && $def['relationship'] == $key){
                        $prospectList->load_relationship($field);
                        $prospectList->$field->add($beans);
                    }
                }
            }
        }
        die;
    }

    protected function action_chartReport()
    {
        $this->bean->build_report_chart();

        die;
    }

    protected function action_export()
    {
        $this->bean->build_report_csv();
        die;
    }

    protected function action_downloadPDF()
    {
        error_reporting(0);
        require_once('modules/AOS_PDF_Templates/PDF_Lib/mpdf.php');

        $d_image = explode('?',SugarThemeRegistry::current()->getImageURL('company_logo.png'));
        $head =  '<table style="width: 100%; font-family: Arial; text-align: center;" border="0" cellpadding="2" cellspacing="2">
                <tbody style="text-align: left;">
                <tr style="text-align: left;">
                <td style="text-align: left;">
                <p><img src="'.$d_image[0].'" style="float: left;"/>&nbsp;</p>
                </td>
                <tr style="text-align: left;">
                <td style="text-align: left;"></td>
                </tr>
                 <tr style="text-align: left;">
                <td style="text-align: left;">
                </td>
                <tr style="text-align: left;">
                <td style="text-align: left;"></td>
                </tr>
                <tr style="text-align: left;">
                <td style="text-align: left;">
                <b>'.strtoupper($this->bean->name).'</b>
                </td>
                </tr>
                </tbody>
                </table><br />';


        $printable = $this->bean->build_group_report(-1,false);
        $stylesheet = file_get_contents('themes/Suite7/css/style.css');

        ob_clean();
        try{
            $pdf=new mPDF('en','A4','','DejaVuSansCondensed');
            $pdf->setAutoFont();
            $pdf->WriteHTML($stylesheet,1);
            $pdf->WriteHTML($head,2);
            $pdf->WriteHTML($printable,3);
            $pdf->Output($this->bean->name, "D");

        }catch(mPDF_exception $e){
            echo $e;
        }

        die;
    }

    protected function action_getModuleFunctionField(){
        global $app_list_strings;

        $view = $_REQUEST['view'];
        $value = $_REQUEST['aor_value'];
        $module = $_REQUEST['aor_module'];
        $fieldname = $_REQUEST['aor_fieldname'];
        $aor_field = $_REQUEST['aor_newfieldname'];

        if($view == 'EditView'){
            echo "<select type='text' style='width:100px;' name='$aor_field' id='$aor_field ' title='' tabindex='116'>". get_select_options_with_id($app_list_strings['aor_function_list'], $value) ."</select>";
        }else{
            echo $app_list_strings['aor_function_list'][$value];
        }
        die;
    }


    protected function action_getModuleOperatorField(){

        global $app_list_strings, $beanFiles, $beanList;

        if(isset($_REQUEST['rel_field']) &&  $_REQUEST['rel_field'] != ''){
            $module = getRelatedModule($_REQUEST['aor_module'],$_REQUEST['rel_field']);
        } else {
            $module = $_REQUEST['aor_module'];
        }
        $fieldname = $_REQUEST['aor_fieldname'];
        $aor_field = $_REQUEST['aor_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aor_value'])) $value = $_REQUEST['aor_value'];
        else $value = '';


        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        switch($vardef['type']) {
            case 'double':
            case 'decimal':
            case 'float':
            case 'currency':
                $valid_opp = array('Equal_To','Not_Equal_To','Greater_Than','Less_Than','Greater_Than_or_Equal_To','Less_Than_or_Equal_To');
                break;
            case 'uint':
            case 'ulong':
            case 'long':
            case 'short':
            case 'tinyint':
            case 'int':
                $valid_opp = array('Equal_To','Not_Equal_To','Greater_Than','Less_Than','Greater_Than_or_Equal_To','Less_Than_or_Equal_To');
                break;
            case 'date':
            case 'datetime':
            case 'datetimecombo':
                $valid_opp = array('Equal_To','Not_Equal_To','Greater_Than','Less_Than','Greater_Than_or_Equal_To','Less_Than_or_Equal_To');
                break;
            case 'enum':
            case 'multienum':
                $valid_opp = array('Equal_To','Not_Equal_To');
                break;
            default:
                $valid_opp = array('Equal_To','Not_Equal_To');
                break;
        }

        foreach($app_list_strings['aor_operator_list'] as $key => $keyValue){
            if(!in_array($key, $valid_opp)){
                unset($app_list_strings['aor_operator_list'][$key]);
            }
        }



        $app_list_strings['aor_operator_list'];
        if($view == 'EditView'){
            echo "<select type='text' style='width:178px;' name='$aor_field' id='$aor_field ' title='' tabindex='116'>". get_select_options_with_id($app_list_strings['aor_operator_list'], $value) ."</select>";
        }else{
            echo $app_list_strings['aor_operator_list'][$value];
        }
        die;

    }

    protected function action_getFieldTypeOptions(){

        global $app_list_strings, $beanFiles, $beanList;

        if(isset($_REQUEST['rel_field']) &&  $_REQUEST['rel_field'] != ''){
            $module = getRelatedModule($_REQUEST['aor_module'],$_REQUEST['rel_field']);
        } else {
            $module = $_REQUEST['aor_module'];
        }
        $fieldname = $_REQUEST['aor_fieldname'];
        $aor_field = $_REQUEST['aor_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aor_value'])) $value = $_REQUEST['aor_value'];
        else $value = '';


        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        switch($vardef['type']) {
            case 'double':
            case 'decimal':
            case 'float':
            case 'currency':
                $valid_opp = array('Value','Field');
                break;
            case 'uint':
            case 'ulong':
            case 'long':
            case 'short':
            case 'tinyint':
            case 'int':
                $valid_opp = array('Value','Field');
                break;
            case 'date':
            case 'datetime':
            case 'datetimecombo':
                $valid_opp = array('Value','Field', 'Date');
                break;
            case 'enum':
            case 'multienum':
                $valid_opp = array('Value','Field', 'Multi');
                break;
            default:
                $valid_opp = array('Value','Field');
                break;
        }

        foreach($app_list_strings['aor_condition_type_list'] as $key => $keyValue){
            if(!in_array($key, $valid_opp)){
                unset($app_list_strings['aor_condition_type_list'][$key]);
            }
        }

        if($view == 'EditView'){
            echo "<select type='text' style='width:178px;' name='$aor_field' id='$aor_field' title='' tabindex='116'>". get_select_options_with_id($app_list_strings['aor_condition_type_list'], $value) ."</select>";
        }else{
            echo $app_list_strings['aor_condition_type_list'][$value];
        }
        die;

    }

    protected function action_getActionFieldTypeOptions(){

        global $app_list_strings, $beanFiles, $beanList;

        if(isset($_REQUEST['rel_field']) &&  $_REQUEST['rel_field'] != ''){
            $module = getRelatedModule($_REQUEST['aor_module'],$_REQUEST['rel_field']);
        } else {
            $module = $_REQUEST['aor_module'];
        }

        $fieldname = $_REQUEST['aor_fieldname'];
        $aor_field = $_REQUEST['aor_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aor_value'])) $value = $_REQUEST['aor_value'];
        else $value = '';


        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        switch($vardef['type']) {
            case 'double':
            case 'decimal':
            case 'float':
            case 'currency':
                $valid_opp = array('Value','Field');
                break;
            case 'uint':
            case 'ulong':
            case 'long':
            case 'short':
            case 'tinyint':
            case 'int':
                $valid_opp = array('Value','Field');
                break;
            case 'date':
            case 'datetime':
            case 'datetimecombo':
                $valid_opp = array('Value','Field', 'Date');
                break;
            case 'enum':
            case 'multienum':
                $valid_opp = array('Value','Field');
                break;
            case 'relate':
                $valid_opp = array('Value','Field');
                if($vardef['module'] == 'Users') $valid_opp = array('Value','Field','Round_Robin','Least_Busy','Random');
                break;
            default:
                $valid_opp = array('Value','Field');
                break;
        }

        foreach($app_list_strings['aor_action_type_list'] as $key => $keyValue){
            if(!in_array($key, $valid_opp)){
                unset($app_list_strings['aor_action_type_list'][$key]);
            }
        }

        if($view == 'EditView'){
            echo "<select type='text' style='width:178px;' name='$aor_field' id='$aor_field' title='' tabindex='116'>". get_select_options_with_id($app_list_strings['aor_action_type_list'], $value) ."</select>";
        }else{
            echo $app_list_strings['aor_action_type_list'][$value];
        }
        die;

    }

    protected function action_getModuleFieldType()
    {
        if(isset($_REQUEST['rel_field']) &&  $_REQUEST['rel_field'] != ''){
            $rel_module = getRelatedModule($_REQUEST['aor_module'],$_REQUEST['rel_field']);
        } else {
            $rel_module = $_REQUEST['aor_module'];
        }
        $module = $_REQUEST['aor_module'];

        $fieldname = $_REQUEST['aor_fieldname'];
        $aor_field = $_REQUEST['aor_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aor_value'])) $value = $_REQUEST['aor_value'];
        else $value = '';

        switch($_REQUEST['aor_type']) {
            case 'Field':
                if(isset($_REQUEST['alt_module']) && $_REQUEST['alt_module'] != '') $module = $_REQUEST['alt_module'];
                if($view == 'EditView'){
                    echo "<select type='text' style='width:178px;' name='$aor_field' id='$aor_field ' title='' tabindex='116'>". getModuleFields($module, $view, $value) ."</select>";
                }else{
                    echo getModuleFields($module, $view, $value);
                }
                break;
            case 'Date':
                echo getDateField($module, $aor_field, $view, $value, false);
                break;
            case 'Multi':
                echo getModuleField($rel_module,$fieldname, $aor_field, $view, $value,'multienum');
                break;
            case 'Value':
            default:
                echo getModuleField($rel_module,$fieldname, $aor_field, $view, $value );
                break;
        }
        die;

    }

    protected function action_getModuleFieldTypeSet()
    {
        $module = $_REQUEST['aor_module'];
        $fieldname = $_REQUEST['aor_fieldname'];
        $aor_field = $_REQUEST['aor_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aor_value'])) $value = $_REQUEST['aor_value'];
        else $value = '';

        switch($_REQUEST['aor_type']) {
            case 'Field':
                if(isset($_REQUEST['alt_module']) && $_REQUEST['alt_module'] != '') $module = $_REQUEST['alt_module'];
                if($view == 'EditView'){
                    echo "<select type='text' style='width:178px;' name='$aor_field' id='$aor_field ' title='' tabindex='116'>". getModuleFields($module, $view, $value) ."</select>";
                }else{
                    echo getModuleFields($module, $view, $value);
                }
                break;
            case 'Date':
                if(isset($_REQUEST['alt_module']) && $_REQUEST['alt_module'] != '') $module = $_REQUEST['alt_module'];
                echo getDateField($module, $aor_field, $view, $value);
                break;
            Case 'Round_Robin';
            Case 'Least_Busy';
            Case 'Random';
                echo getAssignField($aor_field, $view, $value);
                break;
            case 'Value':
            default:
                echo getModuleField($module,$fieldname, $aor_field, $view, $value );
                break;
        }
        die;

    }

    protected function action_getModuleField()
    {
        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aor_value'])) $value = $_REQUEST['aor_value'];
        else $value = '';

        echo getModuleField($_REQUEST['aor_module'],$_REQUEST['aor_fieldname'], $_REQUEST['aor_newfieldname'], $view, $value );
        die;
    }

    protected function action_getRelFieldTypeSet()
    {
        $module = $_REQUEST['aor_module'];
        $fieldname = $_REQUEST['aor_fieldname'];
        $aor_field = $_REQUEST['aor_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aor_value'])) $value = $_REQUEST['aor_value'];
        else $value = '';

        switch($_REQUEST['aor_type']) {
            case 'Field':
                if(isset($_REQUEST['alt_module']) && $_REQUEST['alt_module'] != '') $module = $_REQUEST['alt_module'];
                if($view == 'EditView'){
                    echo "<select type='text' style='width:178px;' name='$aor_field' id='$aor_field ' title='' tabindex='116'>". getModuleFields($module, $view, $value) ."</select>";
                }else{
                    echo getModuleFields($module, $view, $value);
                }
                break;
            case 'Value':
            default:
                echo getModuleField($module,$fieldname, $aor_field, $view, $value );
                break;
        }
        die;

    }

    protected function action_getRelActionFieldTypeOptions(){

        global $app_list_strings, $beanFiles, $beanList;

        $module = $_REQUEST['aor_module'];
        $alt_module = $_REQUEST['alt_module'];
        $fieldname = $_REQUEST['aor_fieldname'];
        $aor_field = $_REQUEST['aor_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aor_value'])) $value = $_REQUEST['aor_value'];
        else $value = '';


        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);


        /*if($vardef['module'] == $alt_module){
            $valid_opp = array('Value','Field');
        }
        else{
            $valid_opp = array('Value');
        }*/
        $valid_opp = array('Value');

        foreach($app_list_strings['aor_rel_action_type_list'] as $key => $keyValue){
            if(!in_array($key, $valid_opp)){
                unset($app_list_strings['aor_rel_action_type_list'][$key]);
            }
        }

        if($view == 'EditView'){
            echo "<select type='text' style='width:178px;' name='$aor_field' id='$aor_field' title='' tabindex='116'>". get_select_options_with_id($app_list_strings['aor_rel_action_type_list'], $value) ."</select>";
        }else{
            echo $app_list_strings['aor_rel_action_type_list'][$value];
        }
        die;

    }

}