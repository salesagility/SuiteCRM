<?php
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

require_once('include/SugarFields/Fields/Relate/SugarFieldRelate.php');

class SugarFieldParent extends SugarFieldRelate {
   
	function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
		$nolink = array('Users', 'Teams');
		if(in_array($vardef['module'], $nolink)){
			$this->ss->assign('nolink', true);
		}else{
			$this->ss->assign('nolink', false);
		}
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch($this->findTemplate('DetailView'));
    }
    
    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
    	$form_name = 'EditView';
    	if(isset($displayParams['formName'])) {
    		$form_name = $displayParams['formName'];
    	}

    	$popup_request_data = array(
			'call_back_function' => 'set_return',
			'form_name' => $form_name,
			'field_to_name_array' => array(
											'id' => $vardef['id_name'],
											'name' => $vardef['name'],
									 ),
		);


		global $app_list_strings;
		$parent_types = $app_list_strings['record_type_display'];
		
		$disabled_parent_types = ACLController::disabledModuleList($parent_types,false, 'list');
		foreach($disabled_parent_types as $disabled_parent_type){
			if($disabled_parent_type != $focus->parent_type){
				unset($parent_types[$disabled_parent_type]);
			}
		}
		asort($parent_types);
		$json = getJSONobj();
		$displayParams['popupData'] = '{literal}'.$json->encode($popup_request_data).'{/literal}';
    	$displayParams['disabled_parent_types'] = '<script>var disabledModules='. $json->encode($disabled_parent_types).';</script>';
    	$this->ss->assign('quickSearchCode', $this->createQuickSearchCode($form_name, $vardef));

        $keys = $this->getAccessKey($vardef,'PARENT',$vardef['module']);
        $displayParams['accessKeySelect'] = $keys['accessKeySelect'];
        $displayParams['accessKeySelectLabel'] = $keys['accessKeySelectLabel'];
        $displayParams['accessKeySelectTitle'] = $keys['accessKeySelectTitle'];
        $displayParams['accessKeyClear'] = $keys['accessKeyClear'];
        $displayParams['accessKeyClearLabel'] = $keys['accessKeyClearLabel'];
        $displayParams['accessKeyClearTitle'] = $keys['accessKeyClearTitle'];

    	$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);        
        return $this->fetch($this->findTemplate('EditView'));
    }
 	
    function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
		$form_name = 'search_form';
				
    	if(isset($displayParams['formName'])) {
    		$form_name = $displayParams['formName'];
    	}
    	
    	if(preg_match('/(_basic|_advanced)$/', $vardef['name'], $match))
    	{
    	   $vardef['type_name'] = $vardef['type_name'] . $match[1];
    	}
    	
    	$this->ss->assign('form_name', $form_name);

    	$popup_request_data = array(
			'call_back_function' => 'set_return',
			'form_name' => $form_name,
			'field_to_name_array' => array(
											'id' => $vardef['id_name'],
											'name' => $vardef['name'],
									 ),
		);


		global $app_list_strings;
		$parent_types = $app_list_strings['record_type_display'];
		$disabled_parent_types = ACLController::disabledModuleList($parent_types,false, 'list');
		foreach($disabled_parent_types as $disabled_parent_type){
			if($disabled_parent_type != $focus->parent_type){
				unset($parent_types[$disabled_parent_type]);
			}
		}

		$json = getJSONobj();
		$displayParams['popupData'] = '{literal}'.$json->encode($popup_request_data).'{/literal}';
    	$displayParams['disabled_parent_types'] = '<script>var disabledModules='. $json->encode($disabled_parent_types).';</script>';
    	$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);        
        return $this->fetch($this->findTemplate('SearchView'));
    }
    
    /**
     * @see SugarFieldBase::importSanitize()
     */
    public function importSanitize(
        $value,
        $vardef,
        $focus,
        ImportFieldSanitize $settings
        )
    {
        global $beanList;
        
        if ( isset($vardef['type_name']) ) {
            $moduleName = $vardef['type_name'];
            if ( isset($focus->$moduleName) && isset($beanList[$focus->$moduleName]) ) {
                $vardef['module'] = $focus->$moduleName;
                $vardef['rname'] = 'name';
                $relatedBean = loadBean($focus->$moduleName);
                $vardef['table'] = $relatedBean->table_name;
                return parent::importSanitize($value,$vardef,$focus,$settings);
            }
        }
        
        return false;
    }
    
    function createQuickSearchCode($formName = 'EditView', $vardef){
        
        require_once('include/QuickSearchDefaults.php');
        $json = getJSONobj();
        
        $dynamicParentTypePlaceHolder = "**@**"; //Placeholder for dynamic parent so smarty tags are not escaped in json encoding.
        $dynamicParentType = '{/literal}{if !empty($fields.parent_type.value)}{$fields.parent_type.value}{else}Accounts{/if}{literal}';
        
        //Get the parent sqs definition
        $qsd = QuickSearchDefaults::getQuickSearchDefaults();
        $qsd->setFormName($formName);
        $sqsFieldArray = $qsd->getQSParent($dynamicParentTypePlaceHolder);
        $qsFieldName = $formName . "_" . $vardef['name'];
        
        //Build the javascript
        $quicksearch_js = '<script language="javascript">';
        $quicksearch_js.= "if(typeof sqs_objects == 'undefined'){var sqs_objects = new Array;}";
        $quicksearch_js .= "sqs_objects['$qsFieldName']=" . str_replace($dynamicParentTypePlaceHolder, $dynamicParentType,$json->encode($sqsFieldArray)) .';';

        return $quicksearch_js .= '</script>';
    }
    
    /**
     * getSearchInput
     * 
     * This function allows the SugarFields to handle returning the search input value given arguments (typically from $_REQUEST/$_POST)
     * and a search string.
     * 
     * @param $key String value of key to search for
     * @param $args Mixed value containing haystack to search for value in
     * @return $value Mixed value that the SugarField should return
     */    
    function getSearchInput($key='', $args=array()) 
    {
    	//Nothing specified return empty string
    	if(empty($key) || empty($args))
    	{
    		return ''; 
    	}
    	
    	//We are probably getting "parent_type" as the $key value, but this is likely not set since there are
    	//advanced and basic tabs.  This next section attempts to resolve this issue.
    	$isBasicSearch = isset($args['searchFormTab']) && $args['searchFormTab'] == 'basic_search' ? true : false;
    	$searchKey = $isBasicSearch ? "{$key}_basic" : "{$key}_advanced";
    	
    	if(isset($args[$searchKey]))
    	{
    	   return $args[$searchKey];  
    	}
    	
    	return isset($args[$key]) ? $args[$key] : '';
    }    
}
?>
