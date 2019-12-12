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

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');
class SugarFieldCollection extends SugarFieldBase
{
    public $tpl_path;
    
    public function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $nolink = array('Users');
        if (in_array($vardef['module'], $nolink)) {
            $displayParams['nolink']=true;
        } else {
            $displayParams['nolink']=false;
        }
        $json = getJSONobj();
        $displayParamsJSON = $json->encode($displayParams);
        $vardefJSON = $json->encode($vardef);
        $this->ss->assign('displayParamsJSON', '{literal}'.$displayParamsJSON.'{/literal}');
        $this->ss->assign('vardefJSON', '{literal}'.$vardefJSON.'{/literal}');
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        if (empty($this->tpl_path)) {
            $this->tpl_path = $this->findTemplate('DetailView');
        }
        return $this->fetch($this->tpl_path);
    }

    public function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false)
    {
        if ($searchView) {
            $form_name = 'search_form';
        } else {
            $form_name = 'EditView';
        }
        $json = getJSONobj();
        $displayParamsJSON = $json->encode($displayParams);
        $vardefJSON = $json->encode($vardef);
        $this->ss->assign('required', !empty($vardef['required']));
        $this->ss->assign('displayParamsJSON', '{literal}'.$displayParamsJSON.'{/literal}');
        $this->ss->assign('vardefJSON', '{literal}'.$vardefJSON.'{/literal}');

        $keys = $this->getAccessKey($vardef, 'COLLECTION', $vardef['module']);
        $displayParams['accessKeySelect'] = $keys['accessKeySelect'];
        $displayParams['accessKeySelectLabel'] = $keys['accessKeySelectLabel'];
        $displayParams['accessKeySelectTitle'] = $keys['accessKeySelectTitle'];
        $displayParams['accessKeyClear'] = $keys['accessKeyClear'];
        $displayParams['accessKeyClearLabel'] = $keys['accessKeyClearLabel'];
        $displayParams['accessKeyClearTitle'] = $keys['accessKeyClearTitle'];

        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        if (!$searchView) {
            if (empty($this->tpl_path)) {
                $this->tpl_path = $this->findTemplate('EditView');
            }
            return $this->fetch($this->tpl_path);
        }
    }

    public function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $this->getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, true);
    }
    /**
    * This should be called when the bean is saved. The bean itself will be passed by reference
    * @param SugarBean bean - the bean performing the save
    * @param array params - an array of paramester relevant to the save, most likely will be $_REQUEST
    */
    public function save(&$bean, $params, $field, $properties, $prefix = '')
    {
        if (isset($_POST["primary_" . $field . "_collection"])) {
            $save = false;
            $value_name = $field . "_values";
            $link_field = array();
            // populate $link_field from POST
            foreach ($_POST as $name=>$value) {
                if (strpos($name, $field . "_collection_") !== false) {
                    $num = substr($name, -1);
                    if (is_numeric($num)) {
                        $num = (int)$num;
                        if (strpos($name, $field . "_collection_extra_") !== false) {
                            $extra_field = substr($name, $field . "_collection_extra_" . $num);
                            $link_field[$num]['extra_field'][$extra_field]=$value;
                        } elseif ($name == $field . "_collection_" . $num) {
                            $link_field[$num]['name']=$value;
                        } elseif ($name == "id_" . $field . "_collection_" . $num) {
                            $link_field[$num]['id']=$value;
                        }
                    }
                }
            }
            // Set Primary
            if (isset($_POST["primary_" . $field . "_collection"])) {
                $primary = $_POST["primary_" . $field . "_collection"];
                $primary = (int)$primary;
                $link_field[$primary]['primary']=true;
            }
            // Create or update record and take care of the extra_field
            require('include/modules.php');
            require_once('data/Link.php');
            $class = load_link_class($bean->field_defs[$field]);
            
            $link_obj = new $class($bean->field_defs[$field]['relationship'], $bean, $bean->field_defs[$field]);
            $module = $link_obj->getRelatedModuleName();
            $beanName = $beanList[$module];
            require_once($beanFiles[$beanName]);
            foreach ($link_field as $k=>$v) {
                $save = false;
                $update_fields = array();
                $obj = new $beanName();
                if (!isset($link_field[$k]['name']) || empty($link_field[$k]['name'])) {
                    // There is no name so it is an empty record -> ignore it!
                    unset($link_field[$k]);
                    break;
                }
                if (!isset($link_field[$k]['id']) || empty($link_field[$k]['id']) || (isset($_POST[$field . "_new_on_update"]) && $_POST[$field . "_new_on_update"] === 'true')) {
                    // Create a new record
                    if (isset($_POST[$field . "_allow_new"]) && ($_POST[$field . "_allow_new"] === 'false' || $_POST[$field . "_allow_new"] === false)) {
                        // Not allow to create a new record so remove from $link_field
                        unset($link_field[$k]);
                        break;
                    }
                    if (!isset($link_field[$k]['id']) || empty($link_field[$k]['id'])) {
                        // There is no ID so it is a new record
                        $save = true;
                        $obj->name=$link_field[$k]['name'];
                    } else {
                        // We duplicate an existing record because new_on_update is set
                        $obj->retrieve($link_field[$k]['id']);
                        $obj->id='';
                        $obj->name = $obj->name . '_DUP';
                    }
                } else {
                    // id exist so retrieve the data
                    $obj->retrieve($link_field[$k]['id']);
                }
                // Update the extra field for the new or the existing record
                if (isset($v['extra_field']) && is_array($v['extra_field'])) {
                    // Retrieve the changed fields
                    if (isset($_POST["update_fields_{$field}_collection"]) && !empty($_POST["update_fields_{$field}_collection"])) {
                        $JSON = getJSONobj();
                        $update_fields = $JSON->decode(html_entity_decode($_POST["update_fields_{$field}_collection"]));
                    }
                    // Update the changed fields
                    foreach ($update_fields as $kk=>$vv) {
                        if (!isset($_POST[$field . "_allow_update"]) || ($_POST[$field . "_allow_update"] !== 'false' && $_POST[$field . "_allow_update"] !== false)) {
                            //allow to update the extra_field in the record
                            if (isset($v['extra_field'][$kk]) && $vv == true) {
                                $extra_field_name = str_replace("_".$field."_collection_extra_".$k, "", $kk);
                                if ($obj->$extra_field_name != $v['extra_field'][$kk]) {
                                    $save = true;
                                    $obj->$extra_field_name=$v['extra_field'][$kk];
                                }
                            }
                        }
                    }
                }
                // Save the new or updated record
                if ($save) {
                    if (!$obj->ACLAccess('save')) {
                        ACLController::displayNoAccess(true);
                        sugar_cleanup(true);
                    }
                    $obj->save();
                    $link_field[$k]['id']=$obj->id;
                }
            }
            // Save new relationship or delete deleted relationship
            if (!empty($link_field)) {
                if ($bean->load_relationship($field)) {
                    $oldvalues = $bean->$field->get(true);
                    $role_field = $bean->$field->_get_link_table_role_field($bean->$field->_relationship_name);
                    foreach ($link_field as $new_v) {
                        if (!empty($new_v['id'])) {
                            if (!empty($role_field)) {
                                if (isset($new_v['primary']) && $new_v['primary']) {
                                    $bean->$field->add($new_v['id'], array($role_field=>'primary'));
                                } else {
                                    $bean->$field->add($new_v['id'], array($role_field=>'NULL'));
                                }
                            } else {
                                $bean->$field->add($new_v['id'], array());
                            }
                        }
                    }
                    foreach ($oldvalues as $old_v) {
                        $match = false;
                        foreach ($link_field as $new_v) {
                            if ($new_v['id'] == $old_v['id']) {
                                $match = true;
                            }
                        }
                        if (!$match) {
                            $bean->$field->delete($bean->id, $old_v['id']);
                        }
                    }
                }
            }
        }
    }
}
