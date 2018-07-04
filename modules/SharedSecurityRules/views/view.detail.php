<?php
 /**
 * 
 * 
 * @package 
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
require_once 'include/MVC/View/views/view.detail.php';
require_once 'modules/AOW_WorkFlow/aow_utils.php';
require_once 'modules/AOR_Reports/aor_utils.php';
class SharedSecurityRulesViewDetail extends ViewDetail {

    public function __construct()
    {
        parent::__construct();
    }

    function display()
    {
        //   global $app_list_strings;
        //   $matrix = new SharedSecurityRules();
        //   $bean = BeanFactory::getBean($this->bean->report_module);
        //    $app_list_strings['aomr_field_list'] = $matrix->getFieldDefs($bean->field_defs, $this->bean->report_module);
        parent::display();
    }
    private function getConditionLines(){
        if(!$this->bean->id){
            return array();
        }
        $sql = "SELECT id FROM sharedsecurityrulesconditions WHERE sa_shared_sec_rules_id = '".$this->bean->id."' AND deleted = 0 ORDER BY condition_order ASC";
        $result = $this->bean->db->query($sql);
        $conditions = array();
        while ($row = $this->bean->db->fetchByAssoc($result)) {
            //$condition_name = new AOMR_Condition();
            $condition_name = new SharedSecurityRulesConditions();

            $condition_name->retrieve($row['id']);
            //      if(!$condition_name->parenthesis) {
            //          $condition_name->module_path = implode(":", unserialize(base64_decode($condition_name->module_path)));
            //      }
            if($condition_name->value_type == 'Date'){
                $condition_name->value = unserialize(base64_decode($condition_name->value));
            }
            $condition_item = $condition_name->toArray();

            if(!$condition_name->parenthesis) {
                $display = $this->getDisplayForField($condition_name->module_path, $condition_name->field, $this->bean->flow_module);
                $condition_item['module_path_display'] = $display['module'];
                $condition_item['field_label'] = $display['field'];
            }
            if(isset($conditions[$condition_item['condition_order']])) {
                $conditions[] = $condition_item;
            }
            else {
                $conditions[$condition_item['condition_order']] = $condition_item;
            }
        }
        return $conditions;
    }
    public function preDisplay()
    {
        $conditions = $this->getConditionLines();
        echo "<script>var conditionLines = ".json_encode($conditions)."</script>";


        parent::preDisplay();


    }

    private function getDisplayForField($modulePath, $field, $reportModule)
    {
        global $app_list_strings;
        $modulePathDisplay = array();
        $currentBean = BeanFactory::getBean($reportModule);
        $modulePathDisplay[] = $currentBean->module_name;
        if (is_array($modulePath)) {
            $split = $modulePath;
        } else {
            $split = explode(':', $modulePath);
        }
        if ($split && $split[0] == $currentBean->module_dir) {
            array_shift($split);
        }
        foreach ($split as $relName) {
            if (empty($relName)) {
                continue;
            }
            if (!empty($currentBean->field_name_map[$relName]['vname'])) {
                $moduleLabel = trim(translate($currentBean->field_name_map[$relName]['vname'], $currentBean->module_dir), ':');
            }
            $thisModule = getRelatedModule($currentBean->module_dir, $relName);
            $currentBean = BeanFactory::getBean($thisModule);

            if (!empty($moduleLabel)) {
                $modulePathDisplay[] = $moduleLabel;
            } else {
                $modulePathDisplay[] = $currentBean->module_name;
            }
        }
        $fieldDisplay = $currentBean->field_name_map[$field]['vname'];
        $fieldDisplay = translate($fieldDisplay, $currentBean->module_dir);
        $fieldDisplay = trim($fieldDisplay, ':');
        foreach($modulePathDisplay as &$module) {
            $module = isset($app_list_strings['aor_moduleList'][$module]) ? $app_list_strings['aor_moduleList'][$module] : (
            isset($app_list_strings['moduleList'][$module]) ? $app_list_strings['moduleList'][$module] : $module
            );
        }
        return array('field' => $fieldDisplay, 'module' => str_replace(' ', '&nbsp;', implode(' : ', $modulePathDisplay)));
    }


}
