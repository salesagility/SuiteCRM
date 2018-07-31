<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/


$default_modules_sources = array (
  'Accounts' =>
  array (
     'ext_rest_insideview' => 'ext_rest_insideview',
  ),
  'Contacts' =>
  array (
     'ext_rest_insideview' => 'ext_rest_insideview',
  ),
  'Leads' =>
  array (
     'ext_rest_insideview' => 'ext_rest_insideview',
  ),
  'Prospects' =>
  array (

  ),
  'Opportunities' =>
  array (
    'ext_rest_insideview' => 'ext_rest_insideview',
  ),
);

$previous_connectors = array();
if(file_exists('custom/modules/Connectors/metadata/connectors.php')){
    require('custom/modules/Connectors/metadata/connectors.php');

    foreach($connectors as $connector_array){
        $connector_id = $connector_array['id'];
        $previous_connectors[$connector_id] = $connector_id;
    }
}

// Merge in old modules the customer added instead of overriding it completely with defaults
// If they have customized their connectors modules
if(file_exists('custom/modules/Connectors/metadata/display_config.php')){
    require('custom/modules/Connectors/metadata/display_config.php');

    // Remove the default settings from being copied over since they already existed
    foreach($default_modules_sources as $module => $sources){
        foreach($sources as $source_key => $source){
            foreach($previous_connectors as $previous_connector){
                if(in_array($previous_connector, $default_modules_sources[$module])){
                    unset($default_modules_sources[$module][$previous_connector]);
                }
            }
        }
    }

    // Merge in the new connector default settings with the current settings
    if ( isset($modules_sources) && is_array($modules_sources) ) {
        foreach($modules_sources as $module => $sources){
            if(!empty($default_modules_sources[$module])){
                $merged = array_merge($modules_sources[$module], $default_modules_sources[$module]);
                $default_modules_sources[$module] = $merged;
            }
            else{
                $default_modules_sources[$module] = $modules_sources[$module];
            }
        }
    }
}

if(!file_exists('custom/modules/Connectors/metadata')) {
   mkdir_recursive('custom/modules/Connectors/metadata');
}

if(!write_array_to_file('modules_sources', $default_modules_sources, 'custom/modules/Connectors/metadata/display_config.php')) {
   $GLOBALS['log']->fatal('Cannot write file custom/modules/Connectors/metadata/display_config.php');
}

