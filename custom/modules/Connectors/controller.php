<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

class ConnectorsController extends SugarController
{

    var $admin_actions = array('ConnectorSettings', 'DisplayProperties', 'MappingProperties', 'ModifyMapping', 'ModifyDisplay', 'ModifyProperties',
        'ModifySearch', 'SearchProperties', 'SourceProperties',
        'SavedModifyDisplay', 'SaveModifyProperties', 'SaveModifySearch');


    function action_SaveModifyDisplay()
    {
        if (empty($_REQUEST['display_sources'])) {
            return;
        }

        require_once('include/connectors/utils/ConnectorUtils.php');
        require_once('include/connectors/sources/SourceFactory.php');

        $connectors = ConnectorUtils::getConnectors();
        $connector_keys = array_keys($connectors);

        $modules_sources = ConnectorUtils::getDisplayConfig();
        if (!is_array($modules_sources)) {
            $modules_sources = (array)$modules_sources;
        }

        $sources = array();
        $values = array();
        $new_modules_sources = array();

        if (!empty($_REQUEST['display_values'])) {
            $display_values = explode(',', $_REQUEST['display_values']);
            foreach ($display_values as $value) {
                $entry = explode(':', $value);
                $mod = get_module_from_singular($entry[1]); // get the internal module name
                $new_modules_sources[$mod][$entry[0]] = $entry[0];
            }
        }

        //These are the sources that were modified.
        //We only update entries for these sources that have been changed
        $display_sources = explode(',', $_REQUEST['display_sources']);
        foreach ($display_sources as $source) {
            $sources[$source] = $source;
        } //foreach

        $removedModules = array();

        //Unset entries that have all sources removed
        foreach ($modules_sources as $module => $source_entries) {
            foreach ($source_entries as $source_id) {
                if (!empty($sources[$source_id]) && empty($new_modules_sources[$module][$source_id])) {
                    unset($modules_sources[$module][$source_id]);
                    $removedModules[$module] = true;
                }
            }
        }
        $removedModules = array_keys($removedModules);
        foreach ($removedModules as $key) {
            if (empty($new_modules_sources[$key])) {
                ConnectorUtils::cleanMetaDataFile($key);
            }
        }

        //Update based on new_modules_sources
        foreach ($new_modules_sources as $module => $enabled_sources) {
            //If the module is not in $modules_sources add it there
            if (empty($modules_sources[$module])) {
                $modules_sources[$module] = $enabled_sources;
            } else {
                foreach ($enabled_sources as $source_id) {
                    if (empty($modules_sources[$module][$source_id])) {
                        $modules_sources[$module][$source_id] = $source_id;
                    }
                } //foreach
            }
        } //foreach

        //Should we just remove entries where all sources are disabled?
        $unset_modules = array();
        foreach ($modules_sources as $module => $mapping) {
            if (empty($mapping)) {
                $unset_modules[] = $module;
            }
        }

        foreach ($unset_modules as $mod) {
            unset($modules_sources[$mod]);
        }

        if (!write_array_to_file('modules_sources', $modules_sources, CONNECTOR_DISPLAY_CONFIG_FILE)) {
            //Log error and return empty array
            $GLOBALS['log']->fatal("Cannot write \$modules_sources to " . CONNECTOR_DISPLAY_CONFIG_FILE);
        }

        $sources_modules = array();
        foreach ($modules_sources as $module => $source_entries) {
            foreach ($source_entries as $id) {
                $sources_modules[$id][$module] = $module;
            }
        }


        //Now update the searchdefs and field mapping entries accordingly
        require('modules/Connectors/metadata/searchdefs.php');
        $originalSearchDefs = $searchdefs;
        $connectorSearchDefs = ConnectorUtils::getSearchDefs();

        $searchdefs = array();
        foreach ($sources_modules as $source_id => $modules) {
            foreach ($modules as $module) {
                $searchdefs[$source_id][$module] = !empty($connectorSearchDefs[$source_id][$module]) ? $connectorSearchDefs[$source_id][$module] : (!empty($originalSearchDefs[$source_id][$module]) ? $originalSearchDefs[$source_id][$module] : array());
            }
        }

        //Write the new searchdefs out
        if (!write_array_to_file('searchdefs', $searchdefs, 'custom/modules/Connectors/metadata/searchdefs.php')) {
            $GLOBALS['log']->fatal("Cannot write file custom/modules/Connectors/metadata/searchdefs.php");
        }

        //Unset the $_SESSION['searchDefs'] variable
        if (isset($_SESSION['searchDefs'])) {
            unset($_SESSION['searchDefs']);
        }


        //Clear mapping file if needed (this happens when all modules are removed from a source
        foreach ($sources as $id) {
            if (empty($sources_modules[$source])) {
                //Now write the new mapping entry to the custom folder
                $dir = $connectors[$id]['directory'];
                if (!preg_match('/^custom\//', $dir)) {
                    $dir = 'custom/' . $dir;
                }

                if (!file_exists("{$dir}")) {
                    mkdir_recursive("{$dir}");
                }

                $fakeMapping = array('beans' => array());
                if (!write_array_to_file('mapping', $fakeMapping, "{$dir}/mapping.php")) {
                    $GLOBALS['log']->fatal("Cannot write file {$dir}/mapping.php");
                }
                $s = SourceFactory::getSource($id);
                $s->saveMappingHook($fakeMapping);
            } //if
        } //foreach


        //Now update the field mapping entries
        foreach ($sources_modules as $id => $modules) {
            $source = SourceFactory::getSource($id);
            $mapping = $source->getMapping();
            $mapped_modules = array_keys($mapping['beans']);

            foreach ($mapped_modules as $module) {
                if (empty($sources_modules[$id][$module])) {
                    unset($mapping['beans'][$module]);
                }
            }


            //Remove modules from the mapping entries
            foreach ($modules as $module) {
                if (empty($mapping['beans'][$module])) {
                    $originalMapping = $source->getOriginalMapping();
                    if (empty($originalMapping['beans'][$module])) {
                        $defs = $source->getFieldDefs();
                        $keys = array_keys($defs);
                        $new_mapping_entry = array();
                        foreach ($keys as $key) {
                            $new_mapping_entry[$key] = '';
                        }
                        $mapping['beans'][$module] = $new_mapping_entry;
                    } else {
                        $mapping['beans'][$module] = $originalMapping['beans'][$module];
                    }
                } //if

            } //foreach

            if ($id == 'ext_rest_twitter' || $id == 'ext_rest_facebook') {


                $full_list = array_keys($mapping['beans']);

                $new_modules = array_diff($full_list, $mapped_modules);

                if (count($new_modules) > 0) {

                    foreach ($new_modules as $module) {

                        $field_name = substr($id, 9) . '_user_c';

                        $bean = BeanFactory::newBean($module);

                        if (!isset($bean->$field_name)) {

                            $this->add_social_field($module, $field_name);

                        }

                    }
                }
                unset($bean);

            }


            //Now write the new mapping entry to the custom folder
            $dir = $connectors[$id]['directory'];
            if (!preg_match('/^custom\//', $dir)) {
                $dir = 'custom/' . $dir;
            }

            if (!file_exists("{$dir}")) {
                mkdir_recursive("{$dir}");
            }

            if (!write_array_to_file('mapping', $mapping, "{$dir}/mapping.php")) {
                $GLOBALS['log']->fatal("Cannot write file {$dir}/mapping.php");
            }
            $source->saveMappingHook($mapping);

        } //foreach

        // save eapm configs
        foreach ($connectors as $connector_name => $data) {
            if (isset($sources[$connector_name]) && !empty($data["eapm"])) {
                // if we touched it AND it has EAPM data
                $connectors[$connector_name]["eapm"]["enabled"] = !empty($_REQUEST[$connector_name . "_external"]);
            }
        }
        ConnectorUtils::saveConnectors($connectors);

        ConnectorUtils::updateMetaDataFiles();
        // BEGIN SUGAR INT
        if (empty($_REQUEST['from_unit_test'])) {
            // END SUGAR INT
            header("Location: index.php?action=ConnectorSettings&module=Connectors");
            // BEGIN SUGAR INT
        }
        // END SUGAR INT
    }

    function add_social_field($module, $field_name)
    {


        $field = array(
            array(
                'name' => $field_name,
                'label' => 'LBL_' . strtoupper($field_name),
                'type' => 'varchar',
                'module' => $module,
                'ext1' => 'LIST',
                'default_value' => '',
                'mass_update' => false,
                'required' => false,
                'reportable' => false,
                'audited' => false,
                'importable' => 'false',
                'duplicate_merge' => false,
            )
        );

        $layout[$module] = $field_name;

        require_once('ModuleInstall/ModuleInstaller.php');
        $moduleInstaller = new ModuleInstaller();
        $moduleInstaller->install_custom_fields($field);
        //$moduleInstaller->addFieldsToLayout($layout);


        $this->create_panel_on_view('detailview', $field, $module, 'LBL_PANEL_SOCIAL_FEED');
        /* now add it to the edit view. */
        $this->create_panel_on_view('editview', $field, $module, 'LBL_PANEL_SOCIAL_FEED');


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
    }


    private function create_panel_on_view($view, $field, $module, $panel_name){
        //require and create object.
        require_once('modules/ModuleBuilder/parsers/ParserFactory.php');
        $parser = ParserFactory::getParser($view, $module);

        if(!array_key_exists( $field['0']['name'],$parser->_fielddefs )){
            //add newly created fields to fielddefs as they wont be there.
            $parser->_fielddefs[ $field['0']['name'] ] = $field['0'];
        }

        if(!array_key_exists( $panel_name, $parser->_viewdefs['panels'] )){
            //create the layout for the row.
            $field_defs = array(0 => $field['0']['name']);

            //add the row to the panel.
            $panel = array( 0 => $field_defs );

            //add the panel to the view.
            $parser->_viewdefs['panels'][ $panel_name ] = $panel;

            //save the panel.

        }else{
            //if the panel already exists we need to push items on to it.
            foreach($parser->_viewdefs['panels'][ $panel_name ] as $row_key => $row){
                foreach($row as $key_field => $single_field){
                    if($single_field == "(empty)"){
                        $parser->_viewdefs['panels'][ $panel_name ][ $row_key ][ $key_field ] = $field['0']['name'];
                    }
                }
            }
        }
        $parser->handleSave(false);
    }
}




