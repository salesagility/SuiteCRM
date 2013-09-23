<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

require_once('include/connectors/sources/SourceFactory.php');
require_once('include/connectors/ConnectorFactory.php');
require_once('include/MVC/Controller/SugarController.php');

class ConnectorsController extends SugarController {

	var $admin_actions = array('ConnectorSettings', 'DisplayProperties', 'MappingProperties', 'ModifyMapping', 'ModifyDisplay', 'ModifyProperties',
	                           'ModifySearch', 'SearchProperties', 'SourceProperties',
	                           'SavedModifyDisplay', 'SaveModifyProperties', 'SaveModifySearch');


	function process() {
		if(!is_admin($GLOBALS['current_user']) && in_array($this->action, $this->admin_actions)) {
			$this->hasAccess = false;
		}
		parent::process();
	}


	/**
	 * When the user clicks the Search button, the form is posted back here and this action sets the
	 * search parameters in the session.  Once this call returns, the tabs will then call RetrieveSource to load
	 * the data that was saved in the session.
	 *
	 */
	function action_SetSearch(){
		if(empty($_REQUEST)) {
		   return;
		}

		$this->view = 'ajax';
		require_once('include/connectors/utils/ConnectorUtils.php');
        $searchdefs = ConnectorUtils::getSearchDefs();
		$merge_module = $_REQUEST['merge_module'];
		$record_id = $_REQUEST['record'];
		$searchDefs = isset($searchdefs) ? $searchdefs : array();
		unset($_SESSION['searchDefs'][$merge_module][$record_id]);
		$sMap = array();

		$search_source = $_REQUEST['source_id'];
		$source_instance = ConnectorFactory::getInstance($search_source);
		$source_map = $source_instance->getModuleMapping($merge_module);
		$module_fields = array();
		foreach($_REQUEST as $search_term => $val){
			if(!empty($source_map[$search_term])){
				$module_fields[$source_map[$search_term]] = $val;
			}
		}

		foreach($module_fields as $search_term => $val){
			foreach($searchDefs as $source => $modules){
				if(empty($sMap[$source])){
					$instance = ConnectorFactory::getInstance($source);
					$sMap[$source] = array_flip($instance->getModuleMapping($merge_module));
				}

				if(!empty($sMap[$source][$search_term])){
					$source_key = $sMap[$source][$search_term];
					$_SESSION['searchDefs'][$merge_module][$record_id][$source][$source_key] = $val;
	        	}
	        }
		}
	}

	/**
	 * This action it meant to handle the hover action on the listview.
	 *
	 */
	function action_RetrieveSourceDetails() {
		$this->view = 'ajax';
		$source_id = $_REQUEST['source_id'];
        $record_id = $_REQUEST['record_id'];

        if(empty($source_id) || empty($record_id)) {
           //display error here
           return;
        }
    	$source = ConnectorFactory::getInstance($source_id);
    	$module = $_SESSION['merge_module'];

		$result = $source->fillBean(array('id' => $record_id), $module);
		require_once('include/connectors/utils/ConnectorUtils.php');
        $connector_strings = ConnectorUtils::getConnectorStrings($source_id);

        $fields = $source->getModuleMapping($module);
		$fieldDefs = $source->getFieldDefs();
		$str = '';

		foreach($fields as $key=>$field){

			$label = $field;
			if(isset($fieldDefs[$key])) {
			   $label = isset($connector_strings[$fieldDefs[$key]['vname']]) ? $connector_strings[$fieldDefs[$key]['vname']] : $label;
			}

			$val = $result->$field;
			if(!empty($val)){
			   if(strlen($val) > 50) {
			   	  $val = substr($val, 0, 47) . '...';
			   }
			   $str .= $label . ': ' .  $val.'<br/>';
			}
		}
		global $theme;
		$json = getJSONobj();
		$retArray = array();

		$retArray['body'] = !empty($str) ? str_replace(array("\rn", "\r", "\n"), array('','','<br />'), $str) : $GLOBALS['mod_strings']['ERROR_NO_ADDITIONAL_DETAIL'];
		$retArray['caption'] = "<div style='float:left'>{$GLOBALS['app_strings']['LBL_ADDITIONAL_DETAILS']}</div>";
	    $retArray['width'] = (empty($results['width']) ? '300' : $results['width']);
	    $retArray['theme'] = $theme;
	    echo 'result = ' . $json->encode($retArray);
	}


	function action_GetSearchForm(){
        $this->view = 'ajax';
		if(!empty($_REQUEST['source_id'])){
			//get the search fields and return the search form

			$ss = new Sugar_Smarty();
		    require_once('include/connectors/utils/ConnectorUtils.php');
            $searchdefs = ConnectorUtils::getSearchDefs();
			$merge_module = $_REQUEST['merge_module'];
			$seed = loadBean($merge_module);
			$_searchDefs = isset($searchdefs) ? $searchdefs : array();
			$_trueFields = array();
			$source = $_REQUEST['source_id'];

			$searchLabels = ConnectorUtils::getConnectorStrings($source);
			$record = $_REQUEST['record'];
			$sourceObj = SourceFactory::getSource($source);
			$field_defs = $sourceObj->getFieldDefs();

	 	    if(!empty($_searchDefs[$source][$merge_module])) {
				foreach($_searchDefs[$source][$merge_module] as $key) {
					if(!empty($_SESSION['searchDefs'][$merge_module][$record][$source][$key])){
						$_trueFields[$key]['value'] = $_SESSION['searchDefs'][$merge_module][$record][$source][$key];
					}else{
						$_trueFields[$key]['value'] = '';
					}
					if(!empty($field_defs[$key]) && isset($searchLabels[$field_defs[$key]['vname']])){
						$_trueFields[$key]['label'] = $searchLabels[$field_defs[$key]['vname']];
					}else{
						$_trueFields[$key]['label'] = $key;
					}
				  }//foreach
			}//fi

			$ss->assign('mod', $GLOBALS['mod_strings']);
			$ss->assign('search_fields', $_trueFields);
			$ss->assign('source_id', $source);
			$ss->assign('fields', $seed->field_defs);
			$ss->assign('module', $merge_module);
			$ss->assign('RECORD', $record);
			$ss->assign('APP', $GLOBALS['app_strings']);
			$ss->assign('MOD', $GLOBALS['mod_strings']);
			echo $ss->fetch('modules/Connectors/tpls/search_form.tpl');
		}
	}


	function pre_save(){}
	function post_save(){}


    function action_CallConnectorFunc() {
        $this->view = 'ajax';
        $json = getJSONobj();

        if(!empty($_REQUEST['source_id']))
        {
            $source_id = $_REQUEST['source_id'];
            require_once('include/connectors/sources/SourceFactory.php');
            $source = SourceFactory::getSource($source_id);

            $method = 'ext_'.$_REQUEST['source_func'];
            if ( method_exists($source,$method) ) {
                echo $json->encode($source->$method($_REQUEST));
            } else {
                echo $json->encode(array('error'=>true,'errorMessage'=>'Could Not Find Function: '.$method.' in class: '.get_class($source)));
            }
        }
        else
        {
            echo $json->encode(array('error'=>true,'errorMessage'=>'Source Id is not specified.'));
        }
    }

	function action_CallRest() {
		$this->view = 'ajax';

		if(false === ($result=@file_get_contents($_REQUEST['url']))) {
           echo '';
		} else if(!empty($_REQUEST['xml'])){
		   $values = array();
		   $p = xml_parser_create();
		   xml_parse_into_struct($p, $result, $values);
		   xml_parser_free($p);
		   $json = getJSONobj();
		   echo $json->encode($values);
		} else {
		   echo $result;
		}
	}

	function action_CallSoap() {
	    $this->view = 'ajax';
	    $source_id = $_REQUEST['source_id'];
	    $module = $_REQUEST['module_id'];
	    $return_params = explode(',', $_REQUEST['fields']);
	    require_once('include/connectors/ConnectorFactory.php');
	    $component = ConnectorFactory::getInstance($source_id);
	    $beans = $component->fillBeans($_REQUEST, $module);
		if(!empty($beans) && !empty($return_params)) {
		    $results = array();
			$count = 0;
			foreach($beans as $bean) {
				foreach($return_params as $field) {
					$results[$count][$field] = $bean->$field;
				}
				$count++;
			}
		    $json = getJSONobj();
		    echo $json->encode($results);
	    } else {
	        echo '';
	    }
	}


	function action_DefaultSoapPopup() {
		$this->view = 'ajax';
	    $source_id = $_REQUEST['source_id'];
	    $module = $_REQUEST['module_id'];
	    $id = $_REQUEST['record_id'];
	    $mapping = $_REQUEST['mapping'];

	    $mapping = explode(',', $mapping);
	    //Error checking

	    //Load bean
	    $bean = loadBean($module);
	    $bean->retrieve($id);

	    require_once('include/connectors/ConnectorFactory.php');
	    $component = ConnectorFactory::getInstance($source_id);
	    //Create arguments
	    $args = array();
	    $field_defs = $bean->getFieldDefinitions();
	    foreach($field_defs as $id=>$field) {
	    	    if(!empty($bean->$id)) {
	    	       $args[$id] = $bean->$id;
	    	    }
	    }

	    $beans = $component->fillBeans($args, $module);
		if(!empty($beans) && !empty($mapping)) {
		    $results = array();
			$count = 0;
			foreach($beans as $bean) {
				foreach($mapping as $field) {
					$results[$count][$field] = $bean->$field;
				}
				$count++;
			}
		    $json = getJSONobj();
		    echo $json->encode($results);
	    } else {
	    	$GLOBALS['log']->error($GLOBALS['app_strings']['ERR_MISSING_MAPPING_ENTRY_FORM_MODULE']);
	        echo '';
	    }
	}

	function action_SaveModifyProperties() {
		require_once('include/connectors/sources/SourceFactory.php');
		$sources = array();
		$properties = array();
		foreach($_REQUEST as $name=>$value) {
		        if(preg_match("/^source[0-9]+$/", $name, $matches)) {
	                $source_id = $value;
	                $properties = array();
			        foreach($_REQUEST as $arg=>$val) {
				        if(preg_match("/^{$source_id}_(.*?)$/", $arg, $matches2)) {
				           $properties[$matches2[1]] = $val;
				    	}
					}
					$source = SourceFactory::getSource($source_id);
					if(!empty($properties)) {
					    $source->setProperties($properties);
					    $source->saveConfig();
					}
		    	}
		}

		require_once('include/connectors/utils/ConnectorUtils.php');
		ConnectorUtils::updateMetaDataFiles();
	    // BEGIN SUGAR INT
	    if(empty($_REQUEST['from_unit_test'])) {
	    // END SUGAR INT
   	    header("Location: index.php?action=ConnectorSettings&module=Connectors");
	    // BEGIN SUGAR INT
	    }
	    // END SUGAR INT
	}

	function action_SaveModifyDisplay() {
			if(empty($_REQUEST['display_sources'])) {
			   return;
			}

			require_once('include/connectors/utils/ConnectorUtils.php');
			require_once('include/connectors/sources/SourceFactory.php');

			$connectors = ConnectorUtils::getConnectors();
			$connector_keys = array_keys($connectors);

			$modules_sources = ConnectorUtils::getDisplayConfig();
			if ( !is_array($modules_sources) ) {
			    $modules_sources = (array) $modules_sources;
			}

			$sources = array();
			$values = array();
			$new_modules_sources = array();

			if(!empty($_REQUEST['display_values'])) {
				$display_values = explode(',', $_REQUEST['display_values']);
			    foreach($display_values as $value) {
			    	    $entry = explode(':', $value);
                                    $mod = get_module_from_singular($entry[1]); // get the internal module name
                                    $new_modules_sources[$mod][$entry[0]] = $entry[0];
			    }
			}

			//These are the sources that were modified.
			//We only update entries for these sources that have been changed
		    $display_sources = explode(',', $_REQUEST['display_sources']);
		    foreach($display_sources as $source) {
		    	    $sources[$source] = $source;
		    } //foreach

		    $removedModules = array();

            //Unset entries that have all sources removed
	    	foreach($modules_sources as $module=>$source_entries) {
    	 	     foreach($source_entries as $source_id) {
    	 	     	     if(!empty($sources[$source_id]) && empty($new_modules_sources[$module][$source_id])) {
    	 	     	     	unset($modules_sources[$module][$source_id]);
    	 	     	     	$removedModules[$module] = true;
    	 	     	     }
    	 	     }
    	 	}
    	 	$removedModules = array_keys($removedModules);
    	 	foreach($removedModules as $key){
    	 		if(empty($new_modules_sources[$key])){
    	 			ConnectorUtils::cleanMetaDataFile($key);
    	 		}
    	 	}

		    //Update based on new_modules_sources
		    foreach($new_modules_sources as $module=>$enabled_sources) {
		    	 //If the module is not in $modules_sources add it there
		    	 if(empty($modules_sources[$module])) {
		    	 	$modules_sources[$module] = $enabled_sources;
		    	 } else {
		    	 	foreach($enabled_sources as $source_id) {
		    	 		    if(empty($modules_sources[$module][$source_id])) {
		    	 		       $modules_sources[$module][$source_id] = $source_id;
		    	 		    }
		    	 	} //foreach
		    	 }
		    } //foreach

			//Should we just remove entries where all sources are disabled?
		    $unset_modules = array();
		    foreach($modules_sources as $module=>$mapping) {
		    	if(empty($mapping)) {
		    	   $unset_modules[] = $module;
		    	}
		    }

		    foreach($unset_modules as $mod) {
		    	unset($modules_sources[$mod]);
		    }

			if(!write_array_to_file('modules_sources', $modules_sources, CONNECTOR_DISPLAY_CONFIG_FILE)) {
	           //Log error and return empty array
	     	   $GLOBALS['log']->fatal("Cannot write \$modules_sources to " . CONNECTOR_DISPLAY_CONFIG_FILE);
	   	    }

	   	    $sources_modules = array();
	   	    foreach($modules_sources as $module=>$source_entries) {
		    	foreach($source_entries as $id) {
		    		    $sources_modules[$id][$module] = $module;
		    	}
	   	    }


            //Now update the searchdefs and field mapping entries accordingly
            require('modules/Connectors/metadata/searchdefs.php');
            $originalSearchDefs = $searchdefs;
			$connectorSearchDefs = ConnectorUtils::getSearchDefs();

			$searchdefs = array();
            foreach($sources_modules as $source_id=>$modules) {
           	    foreach($modules as $module) {
					$searchdefs[$source_id][$module] = !empty($connectorSearchDefs[$source_id][$module]) ? $connectorSearchDefs[$source_id][$module] : (!empty($originalSearchDefs[$source_id][$module]) ? $originalSearchDefs[$source_id][$module] : array());
           	    }
            }

			//Write the new searchdefs out
		    if(!write_array_to_file('searchdefs', $searchdefs, 'custom/modules/Connectors/metadata/searchdefs.php')) {
		       $GLOBALS['log']->fatal("Cannot write file custom/modules/Connectors/metadata/searchdefs.php");
		    }

		    //Unset the $_SESSION['searchDefs'] variable
		    if (isset($_SESSION['searchDefs'])) {
			    unset($_SESSION['searchDefs']);
		    }



		    //Clear mapping file if needed (this happens when all modules are removed from a source
			foreach($sources as $id) {
		    	    if(empty($sources_modules[$source])) {
		    	        //Now write the new mapping entry to the custom folder
					    $dir = $connectors[$id]['directory'];
						if(!preg_match('/^custom\//', $dir)) {
						   $dir = 'custom/' . $dir;
						}

					    if(!file_exists("{$dir}")) {
			       		   mkdir_recursive("{$dir}");
			    		}

                        $fakeMapping = array('beans'=>array());
					    if(!write_array_to_file('mapping', $fakeMapping, "{$dir}/mapping.php")) {
					       $GLOBALS['log']->fatal("Cannot write file {$dir}/mapping.php");
					    }
                        $s = SourceFactory::getSource($id);
                        $s->saveMappingHook($fakeMapping);
		    	    } //if
		    } //foreach

		    //Now update the field mapping entries
		    foreach($sources_modules as $id=>$modules) {
				    $source = SourceFactory::getSource($id);
				    $mapping = $source->getMapping();
				    $mapped_modules = array_keys($mapping['beans']);

		            foreach($mapped_modules as $module) {
                    	   if(empty($sources_modules[$id][$module])) {
                    	   	  unset($mapping['beans'][$module]);
                    	   }
                    }

                    //Remove modules from the mapping entries
                    foreach($modules as $module) {
							if(empty($mapping['beans'][$module])) {
								$originalMapping = $source->getOriginalMapping();
								if(empty($originalMapping['beans'][$module])) {
								    $defs = $source->getFieldDefs();
								    $keys = array_keys($defs);
								    $new_mapping_entry = array();
								    foreach($keys as $key) {
								    	    $new_mapping_entry[$key] = '';
								    }
								    $mapping['beans'][$module] = $new_mapping_entry;
								} else {
 									$mapping['beans'][$module] = $originalMapping['beans'][$module];
								}
							} //if

                    } //foreach

				    //Now write the new mapping entry to the custom folder
				    $dir = $connectors[$id]['directory'];
					if(!preg_match('/^custom\//', $dir)) {
					   $dir = 'custom/' . $dir;
					}

				    if(!file_exists("{$dir}")) {
		       		   mkdir_recursive("{$dir}");
		    		}

				    if(!write_array_to_file('mapping', $mapping, "{$dir}/mapping.php")) {
				       $GLOBALS['log']->fatal("Cannot write file {$dir}/mapping.php");
				    }
                    $source->saveMappingHook($mapping);

		    } //foreach

		    // save eapm configs
		    foreach($connectors as $connector_name => $data) {
		        if(isset($sources[$connector_name]) && !empty($data["eapm"])) {
		            // if we touched it AND it has EAPM data
		            $connectors[$connector_name]["eapm"]["enabled"] = !empty($_REQUEST[$connector_name."_external"]);
		        }
		    }
		    ConnectorUtils::saveConnectors($connectors);

		    ConnectorUtils::updateMetaDataFiles();
		    // BEGIN SUGAR INT
		    if(empty($_REQUEST['from_unit_test'])) {
		    // END SUGAR INT
	   	    header("Location: index.php?action=ConnectorSettings&module=Connectors");
		    // BEGIN SUGAR INT
		    }
		    // END SUGAR INT
	}




	/**
	 * action_SaveModifyMapping
	 */
	function action_SaveModifyMapping() {
		$mapping_sources = !empty($_REQUEST['mapping_sources']) ? explode(',', $_REQUEST['mapping_sources']) : array();
		$mapping_values = !empty($_REQUEST['mapping_values']) ? explode(',', $_REQUEST['mapping_values']) : array();

		//Build the source->module->fields mapping
		$source_modules_fields = array();
		foreach($mapping_values as $id) {
			    $parts = explode(':', $id);
			    $key_vals = explode('=', $parts[2]);
			    //Note the strtolwer call... we are lowercasing the key values
			    $source_modules_fields[$parts[0]][$parts[1]][strtolower($key_vals[0])] = $key_vals[1];
		} //foreach

		foreach($mapping_sources as $source_id) {
			    if(empty($source_modules_fields[$source_id])) {
				   $source = SourceFactory::getSource($source_id);
				   $mapping = $source->getMapping();
				   foreach($mapping['beans'] as $module=>$entry) {
			          $source_modules_fields[$source_id][$module] = array();
				   }
			    }
		} //foreach




		require_once('include/connectors/utils/ConnectorUtils.php');
		$source_entries = ConnectorUtils::getConnectors();

		require_once('include/connectors/sources/SourceFactory.php');
		foreach($source_modules_fields as $id=>$mapping_entry) {
			    //Insert the id mapping
			    foreach($mapping_entry as $module=>$entry) {
			    	$mapping_entry[$module]['id'] = 'id';
			    }

			    $source = SourceFactory::getSource($id);
			    $mapping = $source->getMapping();
			    $mapping['beans'] = $mapping_entry;

			    //Now write the new mapping entry to the custom folder
			    $dir = $source_entries[$id]['directory'];
				if(!preg_match('/^custom\//', $dir)) {
				   $dir = 'custom/' . $dir;
				}

			    if(!file_exists("{$dir}")) {
	       		   mkdir_recursive("{$dir}");
	    		}

			    if(!write_array_to_file('mapping', $mapping, "{$dir}/mapping.php")) {
			       $GLOBALS['log']->fatal("Cannot write file {$dir}/mapping.php");
			    }
                $source->saveMappingHook($mapping);
		}

		//Rewrite the metadata files
		ConnectorUtils::updateMetaDataFiles();

	    // BEGIN SUGAR INT
		if(empty($_REQUEST['from_unit_test'])) {
		// END SUGAR INT
        header("Location: index.php?action=ConnectorSettings&module=Connectors");
	    // BEGIN SUGAR INT
		}
		// END SUGAR INT
	}


	function action_RunTest() {
	    $this->view = 'ajax';
	    $source_id = $_REQUEST['source_id'];
	    $source = SourceFactory::getSource($source_id);
	    $properties = array();
	    foreach($_REQUEST as $name=>$value) {
	    	    if(preg_match("/^{$source_id}_(.*?)$/", $name, $matches)) {
	    	       $properties[$matches[1]] = $value;
	    	    }
	    }
	    $source->setProperties($properties);
	    $source->saveConfig();

	    //Call again and call init
	    $source = SourceFactory::getSource($source_id);
	    $source->init();

	    global $mod_strings;

	    try {
		    if($source->isRequiredConfigFieldsForButtonSet() && $source->test()) {
		      echo $mod_strings['LBL_TEST_SOURCE_SUCCESS'];
		    } else {
		      echo $mod_strings['LBL_TEST_SOURCE_FAILED'];
		    }
	    } catch (Exception $ex) {
	    	$GLOBALS['log']->fatal($ex->getMessage());
	    	echo $ex->getMessage();
	    }
	}


	/**
	 * action_RetrieveSources
	 * Returns a JSON encoded format of the Connectors that are configured for the system
	 *
	 */
	function action_RetrieveSources() {
		require_once('include/connectors/utils/ConnectorUtils.php');
		$this->view = 'ajax';
		$sources = ConnectorUtils:: getConnectors();
		$results = array();
		foreach($sources as $id=>$entry) {
			    $results[$id] = !empty($entry['name']) ? $entry['name'] : $id;
		}
	    $json = getJSONobj();
	    echo $json->encode($results);
	}

}
?>