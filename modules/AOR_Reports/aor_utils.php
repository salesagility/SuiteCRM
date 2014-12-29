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

/**
 * Returns the display labels for a module path and field.
 * @param $modulePath
 * @param $field
 * @return array
 */
function getDisplayForField($modulePath, $field, $reportModule){
    $modulePathDisplay = array();
    $currentBean = BeanFactory::getBean($reportModule);
    $modulePathDisplay[] = $currentBean->module_name;
    $split = explode(':',$modulePath);
    if($split && $split[0] == $currentBean->module_dir){
        array_shift($split);
    }
    foreach($split as $relName){
        if(empty($relName)){
            continue;
        }
        if(!empty($currentBean->field_name_map[$relName]['vname'])){
            $moduleLabel = trim(translate($currentBean->field_name_map[$relName]['vname'],$currentBean->module_dir),':');
        }
        $thisModule = getRelatedModule($currentBean->module_dir, $relName);
        $currentBean = BeanFactory::getBean($thisModule);

        if(!empty($moduleLabel)){
            $modulePathDisplay[] = $moduleLabel;
        }else {
            $modulePathDisplay[] = $currentBean->module_name;
        }
    }
    $fieldDisplay = $currentBean->field_name_map[$field]['vname'];
    $fieldDisplay = translate($fieldDisplay,$currentBean->module_dir);
    $fieldDisplay = trim($fieldDisplay,':');
    return array('field'=>$fieldDisplay,'module'=>implode(' : ',$modulePathDisplay));
}